<?php
	namespace Org\Util;

	/**
	 * 	1. 修改本类中 账号 密码 超时时间 三项属性
	 *
	 * 	2. 实例化本类
	 *
	 * 	3. 使用 setParam()方法  设置参数  setParam()方发需传入一个数组或字符串
	 * 	       数组型参数: 订单号(以order为下标) 及金额(以money为下标)
	 * 	       字符串型参数: 例: order=1234&money=4321
	 *
	 *	4. 使用createPay()方法  跳转页面 进行支付
	 */


	class bankPay {

		//	账号(手机号)
		protected $phone = '12345678901';
		//	密码(md5加密后的)
		protected $mima = '202cb962ac59075b964b07152d234b70';
		//	超时时间
		protected $time = '';
		//	参数设置
		protected $param = '';
		//	资源
		protected $resource;
		//	请求url
		protected $url = 'http://www.bank.com/Home/Order/index';


		/**
		 *	参数设置
		 *
		 * @param	$param	string|array	发送请求时携带的参数
		 * @return  mixed
		 */

		public function setParam($param)
		{
			if (is_string($param))
			{
				parse_str($param, $p);

			} elseif (is_array($param))
			{
				$p = $param;
			}else
			{
				return false;
			}

			$p['phone'] = $this->phone;
			$p['mima']  = $this->mima;

			$this->param = http_build_query($p);
		}

		/**
		 * 	创建支付请求
		 *
		 */
		public function createPay()
		{
			//
			if ($this->testConnect())
			{
				$this->goPay();
			}else
			{
				//	连接不成功
				return false;
			}
		}


		/**
		 * 	测试连接
		 */
		public function testConnect()
		{
			$testRes = $this->getResource(['test'=>'test']);
			return $testRes;
		}

		/**
		 * 	测试成功 执行页面跳转(跳转至支付页面)
		 */
		public function goPay()
		{
			header('Location:'.$this->url.'?'.$this->param);
		}

		/**
		 * 	创建资源(post方式)
		 *
		 */
		public function postResource()
		{
			$this->resource = curl_init($this->url);

			curl_setopt($this->resource, CURLOPT_POSTFIELDS, $this->param);

			$res = curl_exec($this->resource);
			return $res;
		}

		/**
		 * 	创建资源(get方式)
		 * 	@param	$param	string|array	发送请求时携带的参数
		 *  @return boolean
		 */
		public function getResource($param = '')
		{
			if ($param == '')
			{
				$this->resource = curl_init($this->url);

			} elseif (is_string($param))
			{
				$this->resource = curl_init($this->url.'?'.$param);

			} elseif (is_array($param))
			{
				$query = http_build_query($param);
				$this->resource = curl_init($this->url.'?'.$query);
			}

			$this->timeOut();
			$res = curl_exec($this->resource);
			return $res;
		}

		/**
		 * 	超时时间
		 */
		protected function timeOut()
		{
			if (is_numeric($this->time))
			{
				curl_setopt($this->resource, CURLOPT_TIMEOUT, $this->time);
			}
		}
	}