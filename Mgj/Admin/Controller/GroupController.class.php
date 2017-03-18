<?php
	namespace Admin\Controller;

	class GroupController extends CommonController
	{
		/**
			用户权限写入
		**/
		public function add(){
			$rule = M('user_auth_rule');
			$rules = $rule -> select();
            $arr = D('User')->get_school_nav();
            $this->assign('data_nav',$arr);
			$this->assign('rules',$rules);
			$this->display();

		}

		/**
			用户权限添加
		**/
		public function insert(){
			$rule = M('user_auth_rule');
			if($_POST){
				$group = M('user_auth_group');
				$_POST['rules'] = implode(',',$_POST['rules']);
                $_POST['ocode'] = $_SESSION['admin']['school_id'];
				if($group -> create()){
					if($group -> add()){
						echo '<script>alert("用户组添加成功！")</script>';
						$this -> redirect('Group/index');
					}else{
						echo '<script>alert("用户组添加失败！")</script>';
					}
				}
			}
		}

		/**
			用户权限展示
		**/
		public function index(){
			//获取分页框需要显示的数量
			$num = I('get.num');
			$num = !empty($num) ? $num : 5;
			$keyword = I('get.keyword');
			if(!empty($keyword)){
				$where['title']=array('LIKE','%'.$keyword .'%');
			}
			$where['isdelete']=array('eq',0);
            $where['ocode'] = $_SESSION['admin']['school_id'];
			$group = M('user_auth_group');
			$count = $group->where($where)->count();	//查询满足要求的总记录数
			$page = new \Think\Page($count,$num);
			$limit = $page->firstRow.','.$page->listRows;
			$show = $page->show();
			$res = $group->order('id desc')->where($where)->limit($limit)->select();

            $arr = D('User')->get_school_nav();
            $this->assign('data_nav',$arr);
			$this->assign('page',$show);
			$this->assign('res',$res);
			$this->assign('num',$num);
			$this->assign('keyword',$keyword);
			$this->display();
		}

		/**
			用户组的编辑
		**/
		public function edit(){
            $arr = D('User')->get_school_nav();
            $this->assign('data_nav',$arr);
			$id = $_GET['id'];
			$group = M('user_auth_group');
			$rule = M('user_auth_rule');
			$data = $group->find($id);
			$arr = explode(',',$data['rules']);
			$res = $rule->select();
			$this->assign('rules',$res);
			$this->assign('data',$arr);
			$this->assign('res',$data);
			$this->display();
		}

		/**
			用户组的修改
		**/
		public function update(){
			$id = $_POST['id'];
			$_POST['rules'] = implode(',', $_POST['rules']);
			$group = M('user_auth_group');
			$group->create();

			if($group->save()){
				// $this->success('用户组修改成功','Group/index',2);
				echo '<script>alert("用户组修改成功！")</script>';
				$this -> redirect('Group/index');
			}else{
				echo '<script>alert("用户组修改失败！")</script>';
				$this -> redirect('Group/index');
			}
		}

		/**
			用户组的删除
		**/
		public function delete(){
			$id = I('id');
			$group = M('user_auth_group');
			//将用户组的删除字段改为1,则页面不显示
			$arr = array("id"=>$id,"isdelete"=>1);
			$res = $group->save($arr);
			// $res = $group->where("id={$id}")->delete();
			if($res){
				redirect(U('Admin/Group/index'));
			}else{
				redirect(U('Admin/Group/index'));
			}
		}
	}