<?php
namespace Admin\Controller;

class InfoController extends CommonController
{
    public function index(){

        $num = I('get.num');
        $num = !empty($num) ? $num : 10;
        $keyword = I('get.title');
        $state = I('get.state');
        $const_id = I('get.const_id');
        if(!empty($keyword)){
            $where['title']=array('LIKE','%'.$keyword .'%');

        };
        if($state !== "" ){
            $where['state'] = I('get.state');
        };
        if($const_id !== "" ){
            $where['u_type'] = $const_id;
            $const_get = ' and id ='.$const_id;
        };
        $where['ocode'] = $_SESSION['admin']['school_id'];
        $model = M('web_news');
        $count = $model->where($where)->count();	//查询满足要求的总记录数
        //创建分页对象
        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();
        $ocode = $_SESSION['admin']['school_id'];

//        if($keyword || $state !== ""){
//            $school_news = M('web_news')->where($where)->field('id,title,oper,ordernum,regtime,allnum,uptime,state')->limit($limit)->select();
//        }else{
//            $school_news = M('web_news')->where("ocode = $ocode and state = 0")->field('id,title,oper,ordernum,regtime,allnum,uptime,state')->limit($limit)->select();
//        }
        if($keyword || $state !== "" || $const_id !== ''){
            $school_news = M('web_news')->where($where)->field('id,title,oper,ordernum,add_time,allnum,uptime,state')->limit($limit)->order('id desc')->select();
        }else{
            $school_news = M('web_news')->where("ocode = $ocode and state = 0")->field('id,title,oper,ordernum,add_time,allnum,uptime,state')->limit($limit)->order('id desc')->select();
        }
        $const = M('const')->where('ocode = '.$_SESSION['admin']['school_id']." and const_table = 'web_news'" )->field('id,const_name')->select();
        $const_name = M('const')->where('ocode ='.$_SESSION['admin']['school_id'].$const_get)->field('id,const_name')->find();
        //var_dump($const_name);
        $this->assign('const_name',$const_name);
        $this->assign('const',$const);
        $this->assign('school_news',$school_news);
        $this->assign('state',$state);
        $this->assign('page',$show);
        $this->assign('num',$num);
        $this->assign('keyword',$keyword);
        $this->display();
    }

    public function school_nav(){
        $map['ocode'] = $_SESSION['admin']['school_id'];
        $map['pid'] = '0';
        $map['const_table'] = 'web_news';
        $nav_news = M('const')->where($map)->order('order_num')->select();
        $this->assign('nav_news',$nav_news);
        $this->display();
    }

    //二级导航
    public function subordinate(){
        $map['ocode'] = $_SESSION['admin']['school_id'];
        $map['pid'] = $_GET['id'];
        $map['const_table'] = 'web_news';
        $sm_nav = M('const')->where($map)->order('order_num')->select();
        $this->assign('pid',$_GET['id']);
        $this->assign('sm_nav',$sm_nav);
        $this->display();
    }

    public function school_nav_add(){
        if($_POST['pid']){
            $pid = $_POST['pid'];
        }else{
            $pid = '0';
        }
        $data = array(
            'pid' => $pid,
            'ocode' => $_SESSION['admin']['school_id'],
            'const_name' => $_POST['const_name'],
            'const_table'=> 'web_news',
            'navigat_flag' => $_POST['navigat_flag'],
            'order_num' => $_POST['order_num'],
            'regtime' => date('Y-m-d H:i:s')
        );
        if(M('const')->add($data)){
            $this->successajax('添加成功');
        } else {
            $this->failajax('添加失败');
        }
    }


    //修改导航
    public function edit_display(){
        $navigat_flag = M('const')->where('id ='.$_POST['id'])->field('navigat_flag')->find();
        if($navigat_flag['navigat_flag'] == 0){
            $navigat_flag = '1';
            $msg = '隐藏';
        }else{
            $navigat_flag = '0';
            $msg = '显示';
        }
        $map['id'] = $_POST['id'];
        $map['navigat_flag'] = $navigat_flag;
        if(M('const')->save($map)){
            $this->successajax($msg,$map['id']);
        } else {
            $this->failajax('修改失败,请稍后再试!');
        }

    }
    //学校导航删除
    public function school_nav_del(){
        if(M('const')->delete($_POST['id'])){
            $this->successajax();
        }else{
            $this->failsuccess('删除失败,请稍后再试!');
        }
    }

    //学校导航修改弹框信息获取
    public function school_btn_get(){
        $data = M('const')->field('const_name,order_num,id')->find($_POST['id']);
        if($data){
            $this->successajax('',$data);
        }else{
            $this->failajax('获取信息失败,请稍后再试试!');
        }
    }

    //学校导航信息修改
    public function school_btn_edit(){
        if(M('const')->save($_POST)){
            $this->successajax();
        }else{
            $this->failajax('修改失败,请稍后再试!');
        }
    }

    public function add_news(){
        $map['const_table'] = 'web_news';
        $map['pid'] = '0';
        $type = M('const')->where($map)->field('id,const_name')->select();
        $arr = D('User')->get_school_nav();
        $this->assign('type',$type);
        $this->assign('data_nav',$arr);
        $this->display();
    }


    public function school_news_save(){
        $userid = $_SESSION['admin']['id'];
        $oper = M('user')->where("id = $userid")->field('relname')->find();
        if($oper['relname'] == ''){
            $oper = '匿名';
        }
        $_POST['ocode'] = $_SESSION['admin']['school_id'];
        $_POST['oper'] = $oper['relname'];
        $_POST['regtime'] = date('Y-m-d H:i:s');
    
        if(M('web_news')->add($_POST)){
            $this->successajax('发布成功');
        }else{
            $this->failajax('服务器繁忙,请稍后再试');
        }

    }

    public function web_news(){
        $arr = D('User')->get_school_nav();
        $data = M('web_news')->where('id = '.$_GET['id'])->find();
        $this->assign('data',$data);
        $this->assign('data_nav',$arr);
        $this->display();
    }

    public function school_news_del(){
        if(M('web_news')->delete($_POST['id'])){
            $this->successajax();
        }else{
            $this->failajax('服务器繁忙,请稍后再试');
        }
    }

    public function good_user(){
        $arr = D('User')->get_school_nav();
        $num = I('get.num');
        $num = !empty($num) ? $num : 5;
        $keyword = I('get.title');
        $state = I('get.state');
        if(!empty($keyword)){
            $where['title']=array('LIKE','%'.$keyword .'%');

        }
        if($state !== "" ){
            $where['state'] = I('get.state');
        };
        $where['ocode'] = $_SESSION['admin']['school_id'];
        $model = M('web_mien');
        $count = $model->where($where)->count();	//查询满足要求的总记录数
        //创建分页对象
        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();

        $ocode = $_SESSION['admin']['school_id'];
        if($keyword || $state !== ""){
            $school_mien = M('web_mien')->where($where)->field('id,title,pic_url,oper,ordernum,regtime,allnum,uptime,imgtime,username,state')->limit($limit)->select();
        }else{
            $school_mien = M('web_mien')->where("ocode = $ocode and state = 0")->field('id,title,pic_url,oper,ordernum,regtime,allnum,uptime,imgtime,username,state')->limit($limit)->select();
        }
        $this->assign('school_mien',$school_mien);
        $this->assign('state',$state);
        $this->assign('page',$show);
        $this->assign('num',$num);
        $this->assign('keyword',$keyword);
        $this->assign('data_nav',$arr);
        $this->display();
    }

    public function good_user_add(){
        $arr = D('User')->get_school_nav();
        $map['ocode'] = $_SESSION['admin']['school_id'];
        $map['const_table'] = 'web_mien';
        $u_type = M('const')->where($map)->field('id,const_name')->select();
        $this->assign('u_type',$u_type);
        $this->assign('data_nav',$arr);
        $this->display();
    }

    public function web_mienedit_view(){
        $arr = D('User')->get_school_nav();
        $data = M('web_mien')->where('id = '.$_GET['id'])->find();
        $this->assign('data',$data);
        $this->assign('data_nav',$arr);
        $this->display();
    }

    public function school_mien_del(){
        if(M('web_mien')->delete($_POST['id'])){
            $this->successajax();
        }else{
            $this->failajax('服务器繁忙,请稍后再试');
        }
    }


    public function school_img(){
        $num = I('get.num');
        $map['ocode'] = $_SESSION['admin']['school_id'];
        $num = !empty($num) ? $num : 5;
        $model = M('web_pic');
        $count = $model->where($map)->count();	//查询满足要求的总记录数
        //创建分页对象
        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();

        $arr = D('User')->get_school_nav();

        $data = M('web_pic')->where($map)->limit($limit)->select();
        $this->assign('page',$show);
        $this->assign('num',$num);
        $this->assign('data',$data);
        $this->assign('data_nav',$arr);
        $this->display();
    }

    public function Uploads_img(){
        $file = end(explode('.', $_FILES['Filedata']['name']));
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './'; // 设置附件上传根目录
        $upload->savePath  =     'Public/Uploads/sch_face/'; // 设置附件上传（子）目录
        $upload->autoSub  = true;
        $upload->subName  = array('date','Ymd');
        $upload->saveName = mt_rand().time();
        $_FILES['save_name'] =  $upload->saveName;


        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            var_dump($upload->getError());
        }else{// 上传成功
            $userid = $_SESSION['admin']['id'];
            $oper = M('user')->where("id = $userid")->field('relname')->find();
            if($oper['relname'] == ''){
                $oper = '匿名';
            }
            $data['oper'] = $oper['relname'];
            $data['ocode'] = $_SESSION['admin']['school_id'];
            $data['show'] = '1';
            $data['regtime'] = date('Y-m-d H:i:s');
            $data['pic_url'] = $_FILES['save_name'].'.'.$file;
            $data['imgtime'] = date('Ymd');
            M('web_pic')->add($data);
        }
    }


    public function exam(){
        M('web_news')->save($_POST) ? $this->successajax('审核成功') : $this->failajax('网络异常,请稍后再试');
    }
    public function exam_people(){
        M('web_mien')->save($_POST) ? $this->successajax('审核成功') : $this->failajax('网络异常,请稍后再试');
    }


}