<?php
namespace Home\Widget;
use Think\Controller;

class CartWidget extends Controller
{

	/**
	 * 购物车
	 */
	public function indexCart()
	{
		//	判断有没有登录   登陆后查询数据库的购物车表  没有登录 查询session的键值
		if (empty($_SESSION['home']))
		{
			//	没有登录时
			if (empty($_SESSION['cart']))
			{
				$this->cartnum = 0;
				$this->cart = 0;
				$this->display('public:indexCart');
				return;
			}
			$goodid = array_keys($_SESSION['cart']);
			$this->cartnum = array_sum($_SESSION['cart']);

			//	每种商品的数量
			$nums = $_SESSION['cart'];
		}else {
			//	登录后  获得商品id   和数量
			$uid = $_SESSION['home']['id'];
			$cart = M('shop_cart');
			$goodsInCart = $cart->where('userid='.$uid)->select();

			if (empty($goodsInCart)) {
				$this->cartnum = 0;
				$this->cart = 0;
				$this->display('public:indexCart');
				return;
			} else {

				foreach ($goodsInCart as $key => $value) {
					$goodid[] = $value['goodsid'];
				}
			}
		}
		//	查询商品信息
		$goods = M('goods');

		$where['id'] = array('in', $goodid);

		$goodinfo = $goods->where($where)->select();

		foreach ($goodinfo as $key => $value)
		{
			//	将每种商品的数量加如数组
			$goodinfo[$key]['num'] = $nums[$value['id']];
		}

		$this->good = $goodinfo;
		$this->cart = 1;
		$this->display('public:indexCart');
	}

	/**
	 * 	订单地址
	 *		判断该用户是否已经有 地址保存在数据库中
	 */
	public function adress_key ()
	{
		$this->display('public:');
	}









}