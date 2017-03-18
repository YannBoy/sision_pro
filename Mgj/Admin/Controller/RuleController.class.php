<?php
	namespace Admin\Controller;
	header('content-type:text/html;charsert="utf-8"');

	class RuleController extends CommonController
	{

		public function add(){
            $arr = D('User')->get_school_nav();
            $this->assign('data_nav',$arr);
			$this->display();
		}

		/**
			规则添加页面
		**/
		public function insert(){
			if($_POST){
				if(!empty($_POST['title'])){
					if(!empty($_POST['name'])){
						$rule = M('user_auth_rule');
						if($rule -> create($_POST)){
							if($rule -> add()){
								echo "<script>alert('规则添加成功!')</script>";
								$this -> redirect('Rule/index');
							}else{
								echo "<script>alert('规则添加失败!')</script>";
							}
						}else{
							echo "<script>alert('规则添加失败!')</script>";
						}
					}else{
						echo "<script>alert('规则不能为空!')</script>";
					}
				}else{
					echo "<script>alert('规则名不能为空!')</script>";
				}
			}
			$this -> display();
		}

		/**
			规则展示页面
		**/
		public function index(){
			//获取分页框需要显示的数量
			$num = I('get.num');
			$num = !empty($num) ? $num : 10;
			$keyword = I('get.keyword');
			if(!empty($keyword)){
				$where['title']=array('LIKE','%'.$keyword .'%');
			}
			$where['isdelete']=array('eq',0);
			$rule = M('user_auth_rule');
			$count = $rule->where($where)->count();	//查询满足要求的总记录数
			$page = new \Think\Page($count,$num);
			$limit = $page->firstRow.','.$page->listRows;
			$show = $page->show();
			$res = $rule->order('id desc')->where($where)->limit($limit)->select();
            $arr = D('User')->get_school_nav();
            $this->assign('data_nav',$arr);
			$this->assign('page',$show);
			$this->assign('res',$res);
			$this->assign('num',$num);
			$this->assign('keyword',$keyword);
			$this->display();
		}

		/**
			规则信息编辑
		**/
		public function edit(){
			$id = I('id');
			$rule = M('user_auth_rule');
			$res = $rule->find($id);
			$this->assign('res',$res);
			$this->display();
		}

		/**
			规则信息修改
		**/
		public function update(){
			// $id = I('id');
			$rule = M('user_auth_rule');
			$res = $rule->save($_POST);
			if($res){
				redirect(U('Admin/Rule/index'));
			}else{
				redirect(U('Admin/Rule/index'));
			}
		}

		/**
			规则删除
		**/
		public function delete(){
			$id = $_GET['id'];
			$rule = M('user_auth_rule');
			$arr = array("id"=>$id,"isdelete"=>1);
			$res = $rule->save($arr);
			if($res){
				redirect(U('Admin/Rule/index'));
			}else{
				redirect(U('Admin/Rule/index'));
			}
		}
	}