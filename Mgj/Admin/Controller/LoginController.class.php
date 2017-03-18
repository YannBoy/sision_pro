<?php
	namespace Admin\Controller;
	use Think\Controller;

	class LoginController extends Controller
	{
		public function login ()
		{
			$this->display();
		}

		/**
			登录检查
		**/
		public function checkLogin()
		{
			$Admin = M('user');
			$arr['username'] = I('post.username');
			$arr['password'] = md5(I('post.password'));
			$arr['level'] = 0;

			$manager = $Admin->where($arr)->find();
			$Verify = new \Think\Verify();

			$verifyCode = $Verify->check(I('post.checkCode'));

			if ($manager && $verifyCode) {

				$_SESSION['admin']['id'] = $manager['id'];
				$_SESSION['admin']['login'] = 1;
//                $school_num = D('User');
//                $school_num = $school_num->get_school_num($manager['id']);
//                exit;
				header('location:'.U('Admin/Index/index'));
				return;
			} elseif (!$verifyCode){
				$this->error('验证码失败','login',3);
			} else {
				$this->error('密码错误','login',3);
			}
		}


		/**
		 	生成验证码
		**/
		public function verify() {
			$Verify = new \Think\Verify();
			$Verify->entry();
		}

		/**
			ajax 验证用户名
		**/
		public function ajaxCheckName()
		{
			if (IS_AJAX)
			{
				$Admin = M('user');

				$count = $Admin->where($_POST)->count();

				if ($count) {
					$this->ajaxReturn(1);
				} else{
					$this->ajaxReturn(0);
				}
			}
		}


		/**
			注销
		**/
		public function lyout ()
		{
			unset($_SESSION['admin']);
			header('Location:'.U('Admin/Manager/login'));
		}


	}