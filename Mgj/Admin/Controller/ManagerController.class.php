<?php
	namespace Admin\Controller;
	use Admin\Model\OaModel;
    use Think\Controller;
	class ManagerController extends Controller
	{

		public function login ()
		{
            //echo phpinfo();
			$this->display();
		}

		function chose_ocode(){
		    $arr = explode(',' , I('post.class_bh'));
            $ocode = $arr['0'];
            $manager = M('user')->where('id = '.$arr['1'])->find();
            if($manager){
                session('admin', array('id' => $manager['id'], 'login' => 1,'school_id'=>$ocode,'tel'=>$manager['username']));
                $data['num1'] = substr($ocode,0,2).'0000';
                $data['num2'] = substr($ocode,0,4).'00';
                $data['num3'] = substr($ocode,0,6);
                $data['school_num'] = substr($ocode,-3);
                $data['id'] = $arr['1'];
                M('user')->save($data);
                $this->successajax();
            }

        }
		public function checkLogin()
		{
			$Admin = M('user');
			$arr['username'] = I('post.username');
			$arr['password'] = md5(I('post.password'));

			$manager = $Admin->where($arr)->find();
            if($manager['vidflag'] == '1'){
                $this->failajax('已被停用,请于管理员联系');
            }

			$Verify = new \Think\Verify();

			$verifyCode = $Verify->check(I('checkCode'));

			if ($manager && $verifyCode) {
                $data = D('Excel')->school_area($manager);

                if(count($data) >= 2){
                    echo json_encode(array(array('success'=>true,'type'=>'1','ocode'=>$data)));
                }else{
                    session('admin', array('id' => $manager['id'], 'login' => 1,'school_id'=>$manager['num3'].$manager['school_num'],'tel'=>$manager['username']));
                    echo json_encode(array(array('success'=>true,'type'=>'0')));
                    return;
                }

//                redirect(U('Admin/Index/index'));


			} elseif (!$verifyCode){
                $this->failajax('验证码错误,请重置验证码');
			} else {
                $this->failajax('密码错误');
			}
		}


		/**
		 *	生成验证码
		 */
		public function verify() {
		    ob_end_clean();
			$Verify = new \Think\Verify();

			$Verify->entry();
		}

		/**
		 *	ajax 验证用户名
		 */
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
		 *		注销
		 *
		 */
		public function lyout ()
		{
			unset($_SESSION['admin']);
			redirect(U('Admin/Manager/login'));
		}

	}