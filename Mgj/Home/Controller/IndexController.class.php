<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller
{
	public function index()
	{
        $nav = M('const')->where('navigat_flag = 1 and ocode = 330183001')->order('order_num asc')->field('id,const_name')->limit(8)->select();
        $school_d = M('web_news')->where('ocode = 330183001 and (u_type = 1 or u_type = 12 or u_type =13) and state = 1')->order('add_time desc')->field('id,title,add_time')->limit(6)->select();
        $school_10 = M('web_news')->where('ocode = 330183001 and (u_type = 3 or u_type=14 or u_type = 15 or u_type=16 or u_type = 17 or u_type = 31 or u_type = 43) and state = 1')->order('add_time desc')->field('id,title,add_time')->limit(4)->select();
        $school_14 = M('web_news')->where('ocode = 330183001 and u_type = 70 and state = 1')->order('add_time desc')->field('id,title,regtime')->limit(9)->select();
        $school_8 = M('web_news')->where('ocode = 330183001 and (u_type = 6 or u_type = 24 or u_type=25 or u_type=26 or u_type=27 or u_type=28 or u_type=41) and state = 1')->order('add_time desc')->field('id,title,add_time')->limit(8)->select();
        $school_11 = M('web_news')->where('ocode = 330183001 and u_type = 29 and state = 1')->order('add_time desc')->field('id,title,add_time')->limit(8)->select();
        $school_22 = M('web_news')->where('ocode = 330183001 and (u_type = 5 or u_type = 14 or u_type =15 or u_type =16 or u_type=17) and state = 1')->order('add_time desc')->field('id,title,add_time')->limit(5)->select();
        $school_15 = M('web_mien')->where('ocode = 330183001 and u_type = 23 and state = 1')->order('id desc')->field('id,title,regtime,pic_url,imgtime,username')->limit(5)->select();
        $school_16 = M('web_mien')->where('ocode = 330183001 and u_type = 20 and state = 1')->order('id desc')->field('id,title,regtime,pic_url,imgtime,username')->limit(5)->select();
        $this->assign('school_16',$school_16);//名师风采
        $this->assign('school_15',$school_15); //校园之星
        $this->assign('school_22',$school_22);//学生天地
        $this->assign('school_d',$school_d);//校园动态
        $this->assign('school_10',$school_10);//德育园地
        $this->assign('school_14',$school_14);//公告公示
        $this->assign('school_8',$school_8);//党建园地
        $this->assign('school_11',$school_11);//教育科研
        $this->assign('nav',$nav);
        $time = date('Y/m/d');
        $this->assign('date',$time);
		$this->display();
	}

    public function listnav(){
        if($_GET['type'] == 1){
            $model = M('web_mien');
        }else{
            $model = M('web_news');
        }
        $ids = M('const')->where('pid = '.$_GET['id'])->field('id')->select();
        $all_id['0'] = $_GET['id'];
        $i = 1;
        foreach ($ids as $v) {
            $all_id[$i] = $v['id'];
            $i++;
        }
        $all_ids =  implode(',',$all_id);

        $count = $model->where('u_type IN ('.$all_ids.') and state = 1')->count();
        $p = getpage($count,15);

        $navlist = M('const')->where('navigat_flag = 1 and ocode = 330183001')->order('order_num asc')->field('id,const_name')->limit(8)->select();
        $h5 = M('const')->where('id = '.$_GET['id'])->field('const_name')->find();
        $data = $model->where('u_type IN ('.$all_ids.') and state = 1 ')->field('id,title,type')->order('id desc')->limit(6)->select();
        $data_info = $model->where('u_type in ('.$all_ids.') and state = 1')->field('id,title,regtime,type')->order('id desc')->limit(15)->limit($p->firstRow, $p->listRows)->select();
        $this->assign('page', $p->show());
        $this->assign('data_info',$data_info);
        $this->assign('data',$data);
        $this->assign('h5',$h5);
        $this->assign('navlist',$navlist);
        $time = date('Y/m/d');
        $this->assign('date',$time);
        $this->display();
    }

    public function content(){
        if($_GET['type'] == 1){
            $model = M('web_mien');
        }else{
            $model = M('web_news');
        }
        $navlist = M('const')->where('navigat_flag = 1 and ocode = 330183001')->order('order_num asc')->field('id,const_name')->limit(8)->select();
        $content = $model->where('id = '.$_GET['id'].' and ocode = 330183001 and state = 1')->find();
        $allnum = $content['allnum'] + 1;
        $data['id'] = $content['id'];
        $data['allnum'] = $allnum;
        $model->save($data);
        $h5 = M('const')->where('id = '.$content['u_type'].' and ocode = 330183001')->field('const_name')->find();
        $nav = $model->where('u_type = '.$content['u_type'].' and state = 1')->field('title,id,type')->order('ordernum asc')->limit(6)->select();
        $this->assign('nav',$nav);
        $this->assign('navlist',$navlist);
        $this->assign('h5',$h5);
        $this->assign('content',$content);
        $time = date('Y/m/d');
        $this->assign('date',$time);
        $this->display();
    }

    public function addschool_content(){
        //var_dump($_POST);
        $_POST['reg_time'] = date('Y-m-d H:i:s');
        $add = M('content')->add($_POST);
        if($add){
            echo json_encode(array('success'=>true,'msg'=>'ok'));
        } else {
            echo json_encode(array('success'=>false,'msg'=>'no'));
        }
    }

    public function __call($a,$b){
        $this->display('Public/404');
    }






}



