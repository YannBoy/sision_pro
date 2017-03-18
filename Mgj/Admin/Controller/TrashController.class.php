<?php
	namespace Admin\Controller;

	class TrashController extends CommonController
	{
		/**
			商品回收浏览
		*/
		public function good()
		{
			$num = !empty($num) ? $num : 10;
			$keyword = I('get.keyword');
			//检测条件是否存在
			if(!empty($keyword)){
				$where['a.goodname'] = array('LIKE', '%'.$keyword.'%');
			}
			$where['a.isdelete'] = array('EQ',1);
			//创建用户模型
			$good = M('goods');
			//获取总数
			$count = $good->alias('a')->where($where)->count();
			//创建分页对象.
			$page = new \Think\Page($count, $num);
			//获得limit参数
			$limit = $page->firstRow.','.$page->listRows;
			//获得当前页码下的用户的数据
			$goods = $good->alias('a')->field('a.*,b.aname')->join('left join feiyue_assortment b on a.asortid=b.asortid')->limit($limit)->where($where)->order('a.id desc')->select();
			//分配变量
			$this->goods = $goods;
			//获取页码字符串
			$pages = $page->show();
			//分配
			$this->pages = $pages;
			$this->num = $num;
			$this->keyword = $keyword;
			//解析模板
			$this->display();
		}

		/**
			商品恢复
		*/
		public function goodedit()
		{
			//获取id
			$id = I('get.id');
			//创建模型
			$goods = M('goods');
			$info = $goods->find($id);
			$arr = array("id"=>$id,"isdelete"=>0);
			$res = $goods->save($arr);
			//删除
			if($res){
				redirect(U('Admin/Goods/index'));
			}else{
				$this->error('删除失败');
			}
		}

		/**
			会员回收浏览
		*/
		public function user()
		{
			$user = M('user');
			$detail = M('user_detail');
			//获取分页框需要显示的数量
			$num = I('get.num');
			$num = !empty($num) ? $num : 5;
			$keyword = I('get.keyword');
			if(!empty($keyword)){
				$where['a.username']=array('LIKE','%'.$keyword .'%');
			}
			$where['isdelete']=array('eq',1);
			//获取总数
			$count = $user->alias('a')->where($where)->count();	//查询满足要求的总记录数
			//创建分页对象
			$page = new \Think\Page($count,$num);
			//获得limit参数
			$limit = $page->firstRow.','.$page->listRows;
			$show = $page->show();
			//获取当前页码下的数据
			$res = $user->alias('a')->field('a.*,b.*')->join('left join feiyue_user_detail b on a.id=b.userid')->order('b.userid desc')->where($where)->limit($limit)->select();
			$this->assign('page',$show);
			$this->assign('data',$res);
			$this->assign('num',$num);
			$this->assign('keyword',$keyword);
			$this->display();
		}
		/**
			会员恢复
		*/
		public function useredit()
		{
			//获取id
			$id = I('get.id');
			//创建模型
			$goods = M('user');
			$info = $goods->find($id);
			$arr = array("id"=>$id,"isdelete"=>0);
			$res = $goods->save($arr);
			//删除
			if($res){
				redirect(U('Admin/User/index'));
			}else{
				$this->error('删除失败');
			}
		}
		/**
			商品分类回收展示
		*/
		public function asort()
		{
			$num = I('get.num');
			$num = empty($num) ? 10 : $num;
			$keyword = I('get.keyword');
			//检查是否存在
			if (!empty($keyword)) {
				$where['a.aname'] = array('Like','%'.$keyword.'%');
			}
			$where['a.isdelete'] = array('EQ',1);
			//获取模型
			$Sort = M('assortment');
			//获取总数
			$count = $Sort->alias('a')->where($where)->count();
			//获取分页对象
			$page = new \Think\Page($count, $num);
			//获取limit参数
			$limit = $page->firstRow.','.$page->listRows;
			$Sorts = $Sort->alias('a')->field('a.*,b.aname as bname,concat(a.path,",",a.asortid) as paths')->join('left join feiyue_assortment b on a.parent=b.asortid')->limit($limit)->order('paths')->where($where)->select();
			foreach ($Sorts as $key => $value) {
				$count = count(explode(',', $value['path']))-1;
				$Sorts[$key]['aname'] = str_repeat('　|--', $count).$value['aname'];
			}
			//分配变量
			$this->Sorts = $Sorts;
			//获取页码字符串
			$pages = $page->show();
			//分配
			$this->pages = $pages;
			$this->num = $num;
			$this->keyword = $keyword;
			//解析模板
			$this->display();
		}
		/**
			商品分类回收处理
		*/
		public function asortedit()
		{
			//获取id
			$id = I('get.asortid');
			//创建模型
			$goods = M('assortment');
			$info = $goods->find($id);
			$arr = array("asortid"=>$id,"isdelete"=>0);
			$res = $goods->save($arr);
			//删除
			if($res){
				redirect(U('Admin/Sort/index'));
			}else{
				$this->error('删除失败');
			}
		}

		/**
			商铺回收浏览
		*/
		public function shop()
		{
			//获取参数
			$num = I('get.num');
			$num = !empty($num) ? $num : 10;
			$keyword = I('get.keyword');
			//检测条件是否存在
			if(!empty($keyword)){
				$where['a.shopname'] = array('LIKE', '%'.$keyword.'%');
			}
			$where['a.isdelete'] = array('EQ',1);
			$shop = M('store_shop');
			//获取总数
			$count = $shop->alias('a')->where($where)->count();
			//创建分页对象.
			$page = new \Think\Page($count, $num);
			//获得limit参数
			$limit = $page->firstRow.','.$page->listRows;
			//获得当前页码下的用户的数据
			$shops = $shop->alias('a')->field('a.*,b.shopname')->join('left join feiyue_store_shop b on a.shopid=b.shopid')->limit($limit)->where($where)->select();
			//分配变量
			//获取页码字符串
			$pages = $page->show();
			//分配
			$this->pages = $pages;
			$this->num = $num;
			$this->keyword = $keyword;
			$this->shops = $shops;
			$this->display();
		}
		/**
			店铺恢复
		*/
		public function shopdelete()
		{
			$good = M('store_shop');
			$goods = $good->find($_GET['id']);
			if($_SESSION['admin']['id'] != $goods['uid']){
				$this->error('你没有权限操作此ID',U('Admin/Shop/index'), 3);
			}
			//获取id
			$id = I('get.id');
			//创建模型
			$goods = M('store_shop');
			$info = $goods->find($id);
			$arr = array("shopid"=>$id,"isdelete"=>0);
			$res = $goods->save($arr);
			//删除
			if($res){
				redirect(U('Admin/Shop/index'));
			}else{
				$this->error('删除失败');
			}
		}	
	}