<?php
namespace Admin\Controller;

class IndexController extends CommonController
{
    public function index ()
    {
        $admin = M('user');
        $id = $_SESSION['admin']['id'];
        $managerInfo = $admin->find($id);

        $file_count = M('school_people')->where('tel = '.$managerInfo['username'].' and do_state = 1 and ocode = '.$_SESSION['admin']['school_id'].' and id >156939')->count();
        $notice_count = M('notice_people')->where('tel = '.$managerInfo['username'].' and do_state = 1 and ocode = '.$_SESSION['admin']['school_id'].' and id > 327464')->count();
        $email_count = M('email_people')->where('tel = '.$managerInfo['username'].' and do_state = 1 and ocode ='.$_SESSION['admin']['school_id'])->count();

//        $plan = M('school_oa_plan')->where('tel ='.$_SESSION['admin']['tel'].' and ocode = '.$_SESSION['admin']['school_id'].' and state = 0')->select();
//        foreach ($plan as $v) {
//            $time = strtotime($v['end_time']);
//            if($time >= strtotime(date('Y-m-d'))){
//                $plan_end[] = $v;
//            }
//        }
        //var_export($_SESSION['admin']);
        $user_tels = M('school_plan_people')->where('tel = '.$_SESSION['admin']['tel'])->select();
        foreach ($user_tels as $user_tel=>$v) {
            $u_id[] = $v['plan_id'];
        }
        if($u_id && count($u_id) > 0){
            $_GET['first'] ? $ftime =$_GET['first'] : $ftime=$this->time()['first'];
            $_GET['footer'] ? $ltime =$_GET['footer'] : $ltime=$this->time()['footer'];
           
            $map['start_time'] = array(array('egt',$ftime),array('elt',$ltime));

            $plan_list = M('school_oa_plan')->where($map)->select();
        }

        $_GET['first'] ? $week['first'] =$_GET['first'] : $week['first']=$this->time()['first'];
        $_GET['footer'] ? $week['footer'] =$_GET['footer'] : $week['footer']=$this->time()['footer'];
        $groups = M('schoolgroup')->where('pid = 69 and ocode = '.$_SESSION['admin']['school_id'])->select();
        $this->assign('groups',$groups);
        $files = $this->find_file();
        $this->assign('files',$files);
        $this->assign('sel_files',$files);
        $sch_info = M('oa_admin_news')->where('state = 1')->order('startTime desc')->limit('10')->select();
        $sch_info_admin = M('oa_admin_news')->order('id desc')->select();
        $this->assign('sch_info_admin',$sch_info_admin);
        $this->assign('sch_info',$sch_info);
        $this->assign('plan',$plan_list);
        $this->assign('email_count',$email_count);
        $this->assign('notice_count',$notice_count);
        $this->assign('file_count',$file_count);
        $this->assign('managerInfo', $managerInfo);
        $this->assign('weektime',$week);
        $arr = D('User')->get_school_nav();
        $this->assign('data_nav',$arr);
        //  加载 后台首页
        $this->display();

    }


    function find_file()
    {
        $dir = "./Oa_file/fankui/";  // 文件夹的名称
        if (is_dir($dir)){
            if ($dh = opendir($dir)){
                while (($file = readdir($dh)) !== false){
                    if($file !== '.' && $file !== '..'){
                        $files[] = $file;
                    }
                }
                closedir($dh);
                return $files;
            }
        }
    }
    function time(){
        $year = date("Y");
        $month = date("m");
        $day = date('w');
        $nowMonthDay = date("t");

        $firstday = date('d') - $day;
        if(substr($firstday,0,1) == "-"){
            $firstMonth = $month - 1;
            $lastMonthDay = date("t",$firstMonth);
            $firstday = $lastMonthDay - substr($firstday,1);
            $time_1 = strtotime($year."-".$firstMonth."-".$firstday);
        }else{
            $time_1 = strtotime($year."-".$month."-".$firstday);
        }

        $lastday = date('d') + (7 - $day);
        if($lastday > $nowMonthDay){
            $lastday = $lastday - $nowMonthDay;
            $lastMonth = $month + 1;
            $time_2 = strtotime($year."-".$lastMonth."-".$lastday);
        }else{
            $time_2 = strtotime($year."-".$month."-".$lastday);
        }
        $time['first'] = date("Y-m-d",$time_1 );
        $time['footer'] = date("Y-m-d",$time_2);

        return $time;
    }



}