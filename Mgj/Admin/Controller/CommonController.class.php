<?php
	namespace Admin\Controller;
	use Think\Controller;
	class CommonController extends Controller
	{
		public function _initialize()
		{
			if (empty($_SESSION['admin']['login']))
			{
				redirect(U('Admin/Manager/login'));
			}

			$AUTH = new \Think\Auth();
			//类库位置应该位于ThinkPHP\Library\Think\
			if(!$AUTH->check(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME, session('admin.id'))){

			    $this->error('没有权限');
			}
			$tel = session('admin.tel');
            $res = 0;
            if(M('user_supuser')->where('uid ='.$tel)->find())
            {
                $res = 1;
            }
            $this->assign('user_sup',$res);
            $color = M('oa_background')->where('uid ='.$_SESSION['admin']['id'])->find()['color'];
            $this->assign('color',$color);
            $arr = D('User')->get_school_nav();
            $area_bh = substr($_SESSION['admin']['school_id'],0,6);
            $ocode = substr($_SESSION['admin']['school_id'],-3);
            $ocode_name = M('shoollist')->where('area_bh ='.$area_bh.' and ocode ='.$ocode)->field('ocode_name')->find()['ocode_name'];
			$usernav = $this->getUserNav();
            $this->assign('usernav',$usernav);
            $this->assign('ocode_name',$ocode_name);
            $this->assign('data_nav',$arr);
            $this->assign('nav_show',CONTROLLER_NAME);


		}


		function getUserNav()
        {
            $uid = session('admin.id');
            $date = M('user_detail')->field('nav')->find($uid)['nav'];
            if($date)
            {
                $date = rtrim($date,',');
                $where['id'] = array('in',$date);
                $navinfo = M('nav')->where($where)->select();
                return $navinfo;
            }

        }

        











	}