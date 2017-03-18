<?php
	namespace Home\Controller;
	use Think\Controller;
	class MaintainController extends Controller
	{
//		public function _initialize ()
//		{
//			$this->assign('config', $this->webConfig());
//			$this->assign('flink', $this->freindLink());
//		}
		//网站维护的界面显示
//		public function webDown(){
//			//实例化
//			$configure = M('configure');
//			$id = 1;
//			$res = $configure->where("switch=1")->find($id);
//			$this->display();
//		}

		protected function _empty()
		{
			R('Home/Empty/index');
		}

		/**
		 * 数据分页
		 */
		public function dataPage($count, $num)
		{
			$Page = new \Think\Page($count, $num);

			$data['show'] = $Page->show();
			$data['limit'] = $Page->firstRow.','.$Page->listRows;

			return $data;
		}


		/**
		 * 		配置
		 */
//		public function webConfig()
//		{
//			$config = M('configure');
//			$c = $config->find(1);
//			return $c;
//		}


	}