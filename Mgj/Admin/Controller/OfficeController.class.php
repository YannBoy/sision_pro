<?php
namespace Admin\Controller;

//use Admin\Model\ExcelModel;
use Admin\Model\MessageModel;
//use Think\Crypt\Driver\Think;
//use Think\Model;
use Admin\Model\ApiModel;
class OfficeController extends CommonController
{
    public function school_group(){
        $data = M('schoolgroup')->where('pid = 0 and ocode = '.$_SESSION['admin']['school_id'])->select();
        $this->assign('data',$data);
        $this->display();
    }

    public function group_two(){

        $id = $_GET['id'];
        $map['pid'] = $id;
        $map['ocode'] = $_SESSION['admin']['school_id'];
        $data = M('schoolgroup')->where($map)->field('id,name')->select();
        $this->assign('data',$data);
        $this->assign('id',$id);
        $this->display();
    }

    public function teacher_info(){

        $id = $_GET['id'];
        $data = M('school_oa_tea')->where('gid = '.$id)->select();
        $this->assign('data',$data);
        $this->assign('id',$id);
        $this->display();
    }

    public function oa_file(){
        $teacher = M('schoolgroup')->where('pid = 0 and ocode ='.$_SESSION['admin']['school_id'])->select();
        $this->assign('teacher',$teacher);
        $tel = M('user')->where('id ='.$_SESSION['admin']['id'])->field('username')->find()['username'];
        $data = M('school_people')->where('tel ='.$tel)->field('fid')->select();
        $i = 0;
        foreach($data as $v){
            $map[$i]['id'] = $v['fid'];
            $i++;
        }
        $num = I('get.num');
        $num = !empty($num) ? $num : 10;
        $where['ocode']= $_SESSION['admin']['school_id'];
        $count = M("")->table("feiyue_oa_file as a")->join("feiyue_school_people as b")->where('a.id = b.fid and b.tel ='.$tel.' and a.ocode ='.$_SESSION['admin']['school_id'])->count();
       	//查询满足要求的总记录数
        //创建分页对象
        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();
        $file = M("")->table("feiyue_oa_file as a")
                    ->join("feiyue_school_people as b")
                    ->where('a.id = b.fid and b.tel ='.$tel.' and a.ocode ='.$_SESSION['admin']['school_id'])
                    ->field("a.id,a.title,a.state,a.regtime,b.do_state,a.allnum")->order('id desc')->limit($limit)->select();
        $this->assign('page',$show);
        $this->assign('num',$num);
        $this->assign('file',$file);

        $this->display();
    }

    public function sch_oafile_add(){
        $_POST['ocode'] = $_SESSION['admin']['school_id'];
        $_POST['uid'] = $_SESSION['admin']['id'];
        $id = M('oa_file')->add($_POST);
        if($id){
            $this->successajax('',$id);
        }else{
            $this->failajax('服务器繁忙,请稍后再试');
        }
    }

    public function sch_oafile_write(){
        $id = $_GET['id'];
        $data = M('oa_file')->find($id);
        $file = M('oa_upload_file')->where('file_id ='.$id)->select();
        $this->assign('file',$file);
        $this->assign('data',$data);
        $teacher = M('schoolgroup')->where('pid = 0 and ocode ='.$_SESSION['admin']['school_id'])->select();
        $peo = M('school_people')->where('fid ='.$_GET['id'])->field('name')->select();
        $this->assign('peo',$peo);
        $this->assign('teacher',$teacher);

        $this->display();
    }

    //浏览全部文件
    public function all_file(){
        $num = I('get.num');
        $num = !empty($num) ? $num : 10;
        $keyword = I('get.keyword');
        if(!empty($keyword)){
            $where['title']=array('LIKE','%'.$keyword .'%');

        }
        $where['ocode']= $_SESSION['admin']['school_id'];
        $model = M('oa_file');
        $count = $model->where($where)->count();	//查询满足要求的总记录数
        //创建分页对象
        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();

        $data = M('oa_file')->field('id,state,title,regtime,num1,num2,num3,allnum')->where($where)->order('id desc')->limit($limit)->select();
        $this-> assign('data',$data);
        $this->assign('page',$show);
        $this->assign('num',$num);
        $this->assign('keyword',$keyword);
        $this->display();
    }


    //资源管理
    public function resources(){
//        require_once(APP_PATH.'getid3/getid3.php');
//        $info = new \getID3();
//        $info =  $info->analyze('Public/Uploads/img/20160918/4406905601474180564.d');
        //var_export($info['fileformat']);
        $subject = M('user')->where('id = '.$_SESSION['admin']['id'])->field('grade')->find()['grade'];
        $this->assign('subject',$subject);
        $num = I('get.num');
        $num = !empty($num) ? $num : 15;
        $keyword = I('get.keyword');
        $username = I('get.username');
        $type = I('get.type1');
        $subject = I('get.subject1');
        if(!empty($keyword)){
            $where['title']=array('LIKE','%'.$keyword .'%');
        }
        if(!empty($username)){
            $where['oper']=array('LIKE','%'.$username .'%');
        }
        if(!empty($type)){
            $where['type'] = $type;
        }
        if(!empty($subject)){
            $where['subject'] = array('LIKE','%'.$subject .'%');
        }
        $where['state'] = '1';
        $where['ocode'] = $_SESSION['admin']['school_id'];
        $count = M('resources')->where($where)->count();
        //创建分页对象
        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();
        $data = M('resources')->where($where )->field('id,type,title,oper,regtime,subject,allnum,uptime,srctitle,old')->order('id desc')->limit($limit)->select();
        $this->assign('username',$username);
        $this->assign('data',$data);
        $this->assign('page',$show);
        $this->assign('num',$num);
        $this->assign('keyword',$keyword);
        $this->assign('subject1',$subject);
        $this->assign('type1',$type);
        $this->display();
    }

    //校内通知
    public function notice(){
        $tel = M('user')->where("id =".$_SESSION['admin']['id'])->field('username')->find()['username'];
//        $notice_id = M('notice_people')->where('tel ='.$tel)->field('notice_id')->select();
//        foreach($notice_id as $v){
//            $id[] = $v['notice_id'];
//        }
//        $where['id'] = array('in',$id);
//        $where['ocode'] = $_SESSION['admin']['school_id'];
//        $num = I('get.num');
//        $num = !empty($num) ? $num : 10;
//        $keyword = I('get.keyword');
//        if(!empty($keyword)){
//            $where['title']=array('LIKE','%'.$keyword .'%');
//        }
//        if(!empty($id)){
//            $count = M('notice')->where($where)->count();
//            //创建分页对象
//            $page = new \Think\Page($count,$num);
//            //获得limit参数
//            $limit = $page->firstRow.','.$page->listRows;
//            $show = $page->show();
//            $notice = M('notice')->where($where)->field('id,title,relname,do_time,allnum')->order('id desc')->limit($limit)->select();
//            $this->assign('notice',$notice);
//            $this->assign('num',$num);
//            $this->assign('page',$show);
//        }

        $not_ids = M('notice_people')->where('tel ='.$tel.' and id >= 327464')->field('notice_id,do_state')->order('notice_id desc')->select();

        foreach ($not_ids as $key => $value) {
            $not_id[] = $value['notice_id'];
            $do_state[] = $value['do_state'];
        }
    
        if($not_id){
            $not_id = array_unique($not_id);

        foreach ($not_id as $k => $v) {
            $not_id[] = $v;
        }
        if($not_id && count($not_id)>0){
            $not_id = implode(',', $not_id);
            $in = ' and a.id in ('.$not_id.')';
          
        }
    
       
        $where['ocode'] = $_SESSION['admin']['school_id'];
        $where['state'] = '1';
        $where['id'] = array('in',$not_id);
        $num = I('get.num');
        $num = !empty($num) ? $num : 10;
        $keyword = I('get.keyword');
        if(!empty($keyword)){
            $where['title']=array('LIKE','%'.$keyword .'%');
        }
        $count = M('notice')->where($where)->count();
        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();
       // $notice = M('notice')->where($where)->field('id,title,relname,do_time,allnum')->order('id desc')->limit($limit)->select();
         $notice = M('notice')->where($where)->field('id,title,relname,do_time,allnum')->order('id desc')->limit($limit)->select();
        $i = 0;
        foreach ($notice  as $key => $value) {
            $notice[$i]['do_state'] = $do_state[$i];
            $i++;
        }

    

        //$notice = M('')->table('feiyue_notice as a,feiyue_notice_people as b')->limit($limit)->select();
        
        $this->assign('notice',$notice);
        $this->assign('num',$num);
        $this->assign('page',$show);
        }
        
        
        $this->display();
    }



    //校内通知编辑
    public function write_notice(){
        $id = I('get.id/d',0);
        $data = M('notice')->where('id ='.$id)->find();
        $teacher = M('schoolgroup')->where('pid = 0 and ocode ='.session('admin.school_id'))->select();
        $where['file_id'] = $id;
        $file = M('notice_upload_file')->where($where)->field('name,id')->select();
        $peo = M('notice_people')->where('notice_id ='.$id)->field('name')->select();
        $this->assign('peo',$peo);
        $this->assign('file',$file);
        $this->assign('teacher',$teacher);
        $this->assign('data',$data);
        $this->display();
    }

    //校内通知编辑
    public function make_notice(){
        $num = I('get.num');
        $num = !empty($num) ? $num : 10;
        $keyword = I('get.keyword');
        if(!empty($keyword)){
            $where['title']=array('LIKE','%'.$keyword .'%');
        }
        $where['uid'] = $_SESSION['admin']['id'];
        $where['ocode'] = $_SESSION['admin']['school_id'];
        $count = M('notice')->where($where)->count();
        //创建分页对象
        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();
        $notice  = M('notice')->where($where)->field('id,title,relname,do_time,allnum')->limit($limit)->order('id desc')->select();
        $this->assign('notice',$notice);
        $this->assign('page',$show);
        $this->assign('num',$num);
        $this->display();
    }

    public function notice_all(){
        $num = I('get.num');
        $num = !empty($num) ? $num : 10;
        $keyword = I('get.keyword');
        if(!empty($keyword)){
            $where['title']=array('LIKE','%'.$keyword .'%');
        }
        $where['all_people'] = '1';
        $where['ocode'] = $_SESSION['admin']['school_id'];
        $count = M('notice')->where($where)->count();
        //创建分页对象
        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();
        $notice  = M('notice')->where($where)->field('id,title,relname,do_time,allnum')->order('id desc')->limit($limit)->select();
        $this->assign('notice',$notice);
        $this->assign('page',$show);
        $this->assign('num',$num);
        $this->display();
    }

    //短信管理
    public function message(){
        $num = I('get.num');
        $num = !empty($num) ? $num : 20;
        $keyword = I('get.keyword');
        if(!empty($keyword)){
            $where['content']=array('LIKE','%'.$keyword .'%');
        }
        $where['ocode'] = $_SESSION['admin']['school_id'];
        $where['uid'] = $_SESSION['admin']['id'];
        $where['table_name'] = 'message';
        $count = M('message')->where($where)->count();
        //创建分页对象
        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();
        $teacher = M('schoolgroup')->where('pid = 0 and ocode ='.$_SESSION['admin']['school_id'])->select();
        $data = M('message')->where($where)->limit($limit)->select();

        $this->assign('data',$data);
        $this->assign('teacher',$teacher);

        $this->assign('page',$show);
        $this->assign('num',$num);
        $this->display();
    }

    //校内邮件编辑
    public function write_email(){
        $file = M('email_upload_file')->where('file_id = '.$_GET['id'])->field('name,id')->select();
        $data = M('email')->where('id ='.$_GET['id'])->find();
        $teacher = M('schoolgroup')->where('pid = 0 and ocode ='.$_SESSION['admin']['school_id'])->select();
        $peo = M('email_people')->where('notice_id ='.$_GET['id'])->field('name')->select();
        $this->assign('peo',$peo);
        $this->assign('file',$file);
        $this->assign('teacher',$teacher);
        $this->assign('data',$data);
        $this->display();
    }


    public function email(){
        $tel = M('user')->where("id =".$_SESSION['admin']['id'])->field('username')->find()['username'];
        $notice_id = M('email_people')->where('tel ='.$tel.' and ocode = '.$_SESSION['admin']['school_id'])->field('notice_id')->select();
        foreach($notice_id as $v){
            $id[] = $v['notice_id'];
        }
        $num = I('get.num');
        $num = !empty($num) ? $num : 10;
        $keyword = I('get.keyword');
        if(!empty($keyword)){
            $where['title']=array('LIKE','%'.$keyword .'%');
        }
        if(!empty($id)){
            $where['id'] = array('in',$id);
            $count = M('email')->where($where)->count();
            //创建分页对象
            $page = new \Think\Page($count,$num);
            //获得limit参数
            $limit = $page->firstRow.','.$page->listRows;
            $show = $page->show();
            $notice = M('email')->where($where)->field('id,title,relname,do_time,allnum,old')->order('id desc')->limit($limit)->select();
            foreach ($notice as $v) {
                $state[] = $v['id'];
            }
            $map['notice_id'] = array('in',$state);
            $map['tel'] = $_SESSION['admin']['tel'];

            $self_email = M('email_people')->where($map)->field('do_state')->order('id desc')->select();
            $i = 0;
            foreach ($notice as $val) {
                $notice[$i]['do_state'] = $self_email[$i]['do_state'];
                $i++;
            }
            $this->assign('notice',$notice);
            $this->assign('num',$num);
            $this->assign('page',$show);
        }

        $this->display();
    }

    //校内邮件编辑
    public function make_email(){
        $num = I('get.num');
        $num = !empty($num) ? $num : 10;
        $keyword = I('get.keyword');
        if(!empty($keyword)){
            $where['title']=array('LIKE','%'.$keyword .'%');
        }
        $where['ocode'] = $_SESSION['admin']['school_id'];
        $where['uid'] = $_SESSION['admin']['id'];

        $count = M('email')->where($where)->count();
        //var_export($count);
        //创建分页对象
        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();
        $notice  = M('email')->where($where)->field('id,title,relname,do_time,allnum')->order('id desc')->limit($limit)->select();
        $this->assign('notice',$notice);

        $this->assign('page',$show);
        $this->assign('num',$num);
        $this->display();
    }


    public function email_all(){
       
        $num = I('get.num');
        $num = !empty($num) ? $num : 15;
        $keyword = I('get.keyword');
        if(!empty($keyword)){
            $where['title']=array('LIKE','%'.$keyword .'%');
        }
       
            $where['state'] = '1';
            $where['ocode'] = $_SESSION['admin']['school_id'];
            $count = M('email')->where($where)->count();
            //创建分页对象
            $page = new \Think\Page($count,$num);
            //获得limit参数
            $limit = $page->firstRow.','.$page->listRows;
            $show = $page->show();
            $notice  = M('email')->where($where)->field('id,title,relname,do_time,allnum')->order('id desc')->limit($limit)->select();
            $this->assign('notice',$notice);
            $this->assign('page',$show);
            $this->assign('num',$num);
        

        $this->display();
    }

    public function do_message(){
        $area_bh = substr($_SESSION['admin']['school_id'],0,6);
        $ocode = substr($_SESSION['admin']['school_id'],-3);
        if($_GET['ocode']){
            if(strlen($_GET['ocode']) != 9){
                $this->error('没有权限管理');
            }
            $area_bh = substr($_GET['ocode'],0,6);
            $ocode = substr($_GET['ocode'],-3);
            $err['userid'] = $_SESSION['admin']['id'];
            $err['class_bh'] = array('like',$_GET['ocode'].'%');
            $error = M('classaccessinfo')->where($err)->field('rec_id')->select();
            if(!$error || count($error)==0 ){
                $this->error('没有权限管理');
            }
        }


        $all_ocode = $area_bh.$ocode;
        $ocode_name1 = M('shoollist')->where('area_bh ='.$area_bh.' and ocode ='.$ocode)->field('ocode_name')->find()['ocode_name'];
        $ident = M('school_identity')->where('userid = '.$_SESSION['admin']['id'])->field('identity')->select();
        $relname = M('user')->where('id = '.$_SESSION['admin']['id'])->field('relname')->find()['relname'];
        $class = new MessageModel();
        $class = $class->get_class($area_bh,$ocode);
        //$class = M('classinfo')->where('area_bh = '.$area_bh.' and ocode = '.$ocode)->field('class_name,class_bh')->select();
        $teacher = M('schoolgroup')->where('pid = 0 and ocode ='.$_SESSION['admin']['school_id'])->select();
        $my_friend = M('school_my_group')->where('uid = '.$_SESSION['admin']['id'])->select();
        $type = M('shoollist')->where('area_bh ='.substr($_SESSION['admin']['school_id'],0,6).' and ocode ='.substr($_SESSION['admin']['school_id'],-3))->field('type')->find()['type'];
        if($type || $type == '1'){
            $manager = M('user')->find($_SESSION['admin']['id']);
            $data = D('Excel')->school_area($manager);
            $this->assign('data',$data);
            $this->assign('data1',$data);
        }
      
        $this->assign('name1',$ident);
        $this->assign('name2',$ident);
        $this->assign('name3',$ident);
        $this->assign('all_ocode',$all_ocode);
        $this->assign('ident',$ident);
        $this->assign('ocode_type',$type);
        $this->assign('ocode_name1',$ocode_name1);
        $time = date('Y-m-d h:i:s');
        $this->assign('time',$time);
        $this->assign('my_friend',$my_friend);
        $this->assign('teacher',$teacher);
        $this->assign('class',$class);
        $this->assign('relname',$relname);
        $this->display();
    }

    public function set_news(){
        $data = M('school_oa_plan')->where('ocode ='.$_SESSION['admin']['school_id'])->order('id desc')->select();
        $this->successajax('',$data);
    }

        //发送短信
    public function one_send(){
        $map['rec_id'] = array('in',$_POST['id']);
        $peo = M('stuentinfo')->where($map)->field('stu_name,stu_mobile')->select();
        foreach ($peo as $v) {
            $data = array(
                'name'  => $v['stu_name'],
                'tel'   => $v['stu_mobile'],
                'table_name'    => 'message',
                'content'   => $_POST['content'],
                'sendtime'  =>  $_POST['regtime'],
                'uid'   => $_SESSION['admin']['id'],
                'ocode' => $_SESSION['admin']['school_id'],
                'send_name' => $_POST['identity'],
                'sms_type'  => '0',
                'regtime'   => date('Y-m-d H:i:s')
            );
            if(!M('message')->add($data)){
                $this->failajax('发送失败');
                return false;
            }
            else
            {
                $send = new ApiModel();
                $send->sendMsg($v['stu_mobile'],$_POST['content'].' '.$_POST['identity']);
            }
        }
        $this->successajax('发送成功');

    }

       public function all_send(){
        $map['OCODE'] = substr($_SESSION['admin']['school_id'],-3);
        $map['AREAOCODE'] = substr($_SESSION['admin']['school_id'],0,6);
        $class['rec_id'] = array('in',$_POST['id']);
        $class_bh = M('classinfo')->where($class)->field('class_bh')->select();
        foreach ($class_bh as $v) {
            $class_bh1[] = $v['class_bh'];
        }
        $map['STU_BANJI'] = array('in',$class_bh1);
        $map['get_group_teacher'] = '0';
        $ope = M('stuentinfo')->where($map)->field('stu_name,stu_mobile')->select();
        foreach ($ope as $v) {
            $data = array(
                'name'  => $v['stu_name'],
                'tel'   => $v['stu_mobile'],
                'table_name'    => 'message',
                'content'   => $_POST['content'],
                'sendtime'  =>  $_POST['regtime'],
                'uid'   => $_SESSION['admin']['id'],
                'ocode' => $_SESSION['admin']['school_id'],
                'send_name' => $_POST['identity'],
                'sms_type'  => '0',
                'regtime'   => date('Y-m-d H:i:s')
            );
            if(!M('message')->add($data)){
                $this->failajax('发送失败');
                return false;
            }
            else
            {
                $send = new ApiModel();
                $send->sendMsg($v['stu_mobile'],$_POST['content'].' '.$_POST['identity']);
            }
        }
        $this->successajax('发送成功');
    }


     function sch_add_admin_info(){
        $res = M('user')->where('id = '.$_SESSION['admin']['id'])->field('relname')->find();
        $_POST['uname'] = $res['relname'];
        $_POST['uid'] = $_SESSION['admin']['id'];
        $_POST['regTime'] = date('Y-m-d H:i:s');

        M('oa_admin_news')->add($_POST) ? $this->successajax() : $this->failajax();
    }

    function sch_set(){
        $this->successajax();
    }
    function sch_file(){
        $this->successajax();
    }
    function delWorkFile()
    {
        $id = I('post.id/d',0);
        $model = M('oa_sch_file');
        if(IS_POST && $id){
            $data = $model->find($id);
            $path = $data['reg'].'/'.$data['title'];
            $file = './Public/Uploads/sch_file/'.$path;
            if($model->delete($id))
            {
                unlink($file);
                $this->successajax();
            }else{
                $this->failajax();
            }
        }

    }
    function delSchFile()
    {
        if(I('post.name',''))
        {
            $path = './Oa_file/fankui/'.I('post.name','');
            $res = $this->deleteAll($path);
            if($res)
            {
                $this->successajax();
            }else{
                $this->failajax();
            }
        }
    }
    function deleteAll($path) {
        $op = dir($path);
        while(false != ($item = $op->read())) {
            if($item == '.' || $item == '..') {
                continue;
            }
            unlink($op->path.'/'.$item);
        }
        return rmdir($path);
    }

}