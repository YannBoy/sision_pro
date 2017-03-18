<?php
namespace Home\Widget;
use Think\Controller;

class CateWidget extends Controller
{
	/**
	 * 购物车
	 */
	public function indexCart()
	{
		$g = new \Home\Controller\CartController();
		//	判断有没有登录   登陆后查询数据库的购物车表  没有登录 查询session的键值
		if (empty($_SESSION['home']))
		{
			//	未登录的
			if ($good = $g->sessionCart())
			{
				$this->good = $good;
				$n = 0;
				foreach ($good as $k => $v)
				{
					$n += $v['num'];
				}
				$this->cartnum = $n;
			} else
			{    //	session  cart 为空
				$this->cartnum = 0;
			}
		} else{
			//	登陆后的
			if ($good = $g->sqlCart())
			{
				$this->good = $good;
				$n = 0;
				foreach ($good as $k => $v)
				{
					$n += $v['num'];
				}
				$this->cartnum = $n;
			}else {
				$this->cartnum = 0;
			}
		}
		$this->display('Public:indexCart');
	}

	public function cart()
	{
		$g = new \Home\Controller\CartController();
		//	判断有没有登录   登陆后查询数据库的购物车表  没有登录 查询session的键值
		if (empty($_SESSION['home']))
		{
			//	未登录的
			if ($good = $g->sessionCart())
			{
				$this->good = $good;
				$n = 0;
				foreach ($good as $k => $v)
				{
					$n += $v['num'];
				}
				$this->cartnum = $n;
			} else
			{    //	session  cart 为空
				$this->cartnum = 0;
			}
		} else{
			//	登陆后的
			if ($good = $g->sqlCart())
			{
				$this->good = $good;
				$n = 0;
				foreach ($good as $k => $v)
				{
					$n += $v['num'];
				}
				$this->cartnum = $n;
			}else {
				$this->cartnum = 0;
			}
		}
		$this->display('Public:cart');
	}

	public function indexlogin()
	{
		if ($_SESSION['home']['id'])
		{
			$this->l = 1;
		}else
		{
			$this->l = 0;
		}

		$this->display('public:login');
	}

	public function indexNavbar ()
	{
		$this->sort = R('Home/Index/parentUrl');
		$this->display('Public:indexNavbar');
	}

	public function details_commont($data)
	{
		$this->comment = $data;
		$this->display('Cate:details_comment');
	}




}