<?php
namespace Home\Controller;
use Admin\Model\MessageModel;
use Think\Controller;

class CommentController extends Controller{

    public function school_get_nav(){
        $map['ocode'] = $_SESSION['admin']['school_id'];
        $map['pid'] = $_POST['id'];
        $data  = M('const')->where($map)->field('id,const_name')->select();
        if($data){
            $this->successajax('',$data);
        }else{
            $this->failajax('服务器不稳定,请稍后再试');
        }
    }

    public function get_content_info(){
        $data = M('web_news')->where('id = '.$_GET['id'])->field('content_info')->find();
        if($data){
            $this->successajax('',$data);
        }else{
            $this->failajax('服务器不稳定,请稍后再试');
        }
    }

    public function school_news_edit(){
        $_POST['uptime'] = date('Y-m-d H:i:s');
        if(M('web_news')->save($_POST)){
            $this->successajax('保存成功');
        }else{
            $this->failajax('保存失败或尚未有修改');
        }
    }

    public function school_webmein_add(){
        $_POST['ocode'] = $_SESSION['admin']['school_id'];
        $_POST['regtime'] = date('Y-m-d H:i:s');
        $userid = $_SESSION['admin']['id'];
        $oper = M('user')->where("id = $userid")->field('relname')->find();
        if($oper['relname'] == ''){
            $oper = '匿名';
        }
        $_POST['oper'] = $oper['relname'];

        if(M('web_mien')->add($_POST)){
            $this->successajax('发布成功');
        }else{
            $this->failajax('服务器繁忙,请稍后再试');
        }
    }

    public function fileUpload(){
        $file = end(explode('.', $_FILES['img']['name']));
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Public/Uploads/img/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        $upload->autoSub  = true;
        $upload->subName  = array('date','Ymd');
        $upload->saveName = mt_rand().time();
        $_FILES['save_name'] =  $upload->saveName;
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            $data['id'] = $_POST['id'];
            $data['pic_url'] = $_FILES['save_name'].'.'.$file;
            $data['imgtime'] = date('Ymd');
            M('web_mien')->save($data);
            $this->success('上传成功','','1');
        }
    }

    public function school_gooduser_del(){
        $map['id'] = $_POST['id'];
        $map['pic_url'] = '';

        $data = M('web_mien')->where('id ='.$_POST['id'])->find();
        $file ='/var/www/project/Public/Uploads/img/'.$data['imgtime'].'/'.$data['pic_url'];
        unlink($file);

        if(M('web_mien')->save($map)){
            $this->successajax();
        }else {
            $this->failajax('服务器繁忙请稍后再试');
        }
    }

    public function get_miencontent_info(){
        $data = M('web_mien')->where('id = '.$_GET['id'])->field('content_info')->find();
        if($data){
            $this->successajax('',$data);
        }else{
            $this->failajax('服务器不稳定,请稍后再试');
        }
    }

    public function school_mien_edit(){
        $_POST['uptime'] = date('Y-m-d H:i:s');
        if(M('web_mien')->save($_POST)){
            $this->successajax('保存成功');
        }else{
            $this->failajax('保存失败或尚未有修改');
        }
    }

    public function eidt_pic_show(){
        $show = M('web_pic')->where('id ='.$_POST['id'])->field('show')->find();
        if($show['show'] == 0){
            $show = '1';
            $msg = '隐藏';
        }else{
            $show = '0';
            $msg = '显示';
        }
        $map['id'] = $_POST['id'];
        $map['show'] = $show;
        $map['uptime'] = date('Y-m-d H:i:s');
        if(M('web_pic')->save($map)){
            $this->successajax($msg,$map['id']);
        } else {
            $this->failajax('修改失败,请稍后再试!');
        }
    }

    public function pic_del(){
        $model = M('web_pic');
        $pic = $model->field('pic_url,imgtime')->find($_POST['id']);
        $file ='/var/www/project/Public/Uploads/schooluser/'.$pic['imgtime'].'/'.$pic['pic_url'];
        //&& unlink($file)
        if($model->delete($_POST['id']) ){
            $this->successajax('ok');
        } else{
            $this->failajax('服务器不稳定,请稍后再试');
        }
    }

    public function sch_group_add(){
        $data = array(
            'ocode' => $_SESSION['admin']['school_id'],
            'name' => $_POST['name'],
        );
        $data['pid'] = '0';
        if($_POST['id']){
            $data['pid'] = $_POST['id'];
        }
        M('schoolgroup')->add($data) ? $this->successajax() : $this->failajax('服务器繁忙,请稍后再试');
    }

    public function group_del(){
        $data = M('schoolgroup')->where('pid = '.$_POST['id'])->select();
        if(count($data)){
            $this->failajax('删除失败,请先删除下级分类');
        }else{
            M('schoolgroup')->delete($_POST['id']) ? $this->successajax() : $this->failsuccess('服务器繁忙就稍后再试');

        }
    }

    public function get_sch_info(){
        $data = M('schoolgroup')->find($_POST['id']);
        if($data) {
            $this->successajax('', $data);
        }else{
            $this->failajax('服务器繁忙,请稍后再试!');
        }
    }

    public function sch_group_edit(){
        $data['id'] = $_POST['id'];
        $data['name'] = $_POST['name'];
        if(M('schoolgroup')->save($data)){
            $this->successajax();
        }else{
            $this->failajax('服务器繁忙,请稍后再试');
        }
    }

    public function sch_teacher_add(){
        $where['tea_name'] = $_POST['name'];
        $where['tea_mobile'] = $_POST['tel'];
        $teacher = M('teacherinfo')->where($where)->find();
        $tea = M('school_oa_tea')->where('gid ='.$_POST['gid'].' and tel ='.$_POST['tel'])->find();
        if($tea){
            $this->failajax('小组已存在该用户');
            exit;
        }
        if($teacher){
            M('school_oa_tea')->add($_POST);
            $this->successajax();
        }else{
            $this->failajax('注册用户内暂无改用户');
        }
    }

    public function get_teacher_info(){
        $data = M('school_oa_tea')->find($_POST['id']);
        if($data) {
            $this->successajax('', $data);
        }else{
            $this->failajax('服务器繁忙,请稍后再试!');
        }
    }

    public function sch_teacher_edit(){
        $data['id'] = $_POST['id'];
        $data['name'] = $_POST['name'];
        $data['tel'] = $_POST['tel'];
        if(M('school_oa_tea')->save($data)){
            $this->successajax();
        }else{
            $this->failajax('服务器繁忙,请稍后再试');
        }
    }

    public function school_teacher_del(){
        if(M('school_oa_tea')->delete($_POST['id'])){
            $this->successajax();
        }else{
            $this->failajax('服务器繁忙请稍后再试');
        }
    }

    public function notice_upload_file(){
        $file = end(explode('.', $_FILES['Filedata']['name']));
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->rootPath  =     './Public/Uploads/img/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        $upload->autoSub  = true;
        $upload->subName  = array('date','Ymd');
        $upload->saveName = '';
        $upload->saveName = mt_rand().time();
        $_FILES['save_name'] =  $upload->saveName;
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            $data =array(
                'file_id' => $_POST['id'],
                'imgtime' => date('Ymd'),
                'srcname' => $_FILES['save_name'].'.'.$file,
                'name'    => $_FILES['Filedata']['name'],
            );
            M('notice_upload_file')->add($data);

        }
    }

    public function email_upload_file(){
        $file = end(explode('.', $_FILES['Filedata']['name']));
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->rootPath  =     './Public/Uploads/img/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        $upload->autoSub  = true;
        $upload->subName  = array('date','Ymd');
        $upload->saveName = '';
        $upload->saveName = mt_rand().time();
        $_FILES['save_name'] =  $upload->saveName;
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            $data =array(
                'file_id' => $_POST['id'],
                'imgtime' => date('Ymd'),
                'srcname' => $_FILES['save_name'].'.'.$file,
                'name'    => $_FILES['Filedata']['name'],
            );
            M('email_upload_file')->add($data);

        }
    }

    public function oa_upload_file(){
        $file = end(explode('.', $_FILES['Filedata']['name']));
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->rootPath  =     './Public/Uploads/img/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        $upload->autoSub  = true;
        $upload->subName  = array('date','Ymd');
        $upload->saveName = '';
        $upload->saveName = mt_rand().time();
        $_FILES['save_name'] =  $upload->saveName;
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            $data =array(
                'file_id' => $_POST['id'],
                'imgtime' => date('Ymd'),
                'srcname' => $_FILES['save_name'].'.'.$file,
                'name'    => $_FILES['Filedata']['name'],
            );
            M('oa_upload_file')->add($data);

        }
    }

    public function sch_oainfo_add(){
        $map = M('oa_upload_file')->where('file_id ='.$_POST['file_id'])->select();
        if($map){
            $this->successajax('',$map);
        }else{
            $this->failajax('暂无附件');
        }
    }

    public function get_teacher_group(){
        $data = M('schoolgroup')->where('pid = '.$_POST['pid'].' and ocode = '.$_SESSION['admin']['school_id'])->select();
        $data ? $this->successajax('',$data) : $this->failajax('服务器繁忙,请稍后再试');
    }

    public function get_teacher_group1(){
        $data = M('school_oa_tea')->where('gid = '.$_POST['pid'])->select();
        $data ? $this->successajax('',$data) : $this->failajax('服务器繁忙,请稍后再试');
    }


    public function sch_oafile_edit(){
        M('message')->where("table_name = 'oa_file' and table_id =".$_POST['id'])->delete();
        M('school_people')->where('fid ='.$_POST['id'])->delete();
        $tel = $_POST['tel'];
        $name = $_POST['name'];
        if($_POST['name']['0'] == '0'){
            $all_people = '1';
        }else{
            $all_people = '0';
        }
        if(empty($_POST['tel_state'])){
            $_POST['tel_state'] = '0';
        }
        $file = array(
            'id'    =>  $_POST['id'],
            'title' =>  $_POST['title'],
            'stat'  =>  $_POST['state'],
            'num1'  =>  $_POST['num1'],
            'num2'  =>  $_POST['num2'],
            'num3'  =>  $_POST['num3'],
            'regtime'   =>  $_POST['regtime'],
            'content'   =>  $_POST['content'],
            'all_people' => $all_people,
            'tel_state' => $_POST['tel_state']
        );
        M('oa_file')->save($file);
        $oper = M('user')->where("id =".$_SESSION['admin']['id'])->field('username,relname')->find();
        $map = array(
            'tel' => $oper['username'],
            'name'=> $oper['relname'],
            'time'=> $_POST['regtime'],
            'fid' => $_POST['id'],
            'complete' => '1',
            'level' => '0',
            'tel_state' => $_POST['tel_state'],
            'ocode' => $_SESSION['admin']['school_id']
        );
        M('school_people')->add($map);

        if($_POST['name']['0'] == '0'){
            $first = substr($_SESSION['admin']['school_id'],0,6);
            $foot = substr($_SESSION['admin']['school_id'],-3);
            $allteacher = M('teacherinfo')->where('area_bh ='.$first.' and ocode ='.$foot)->field('tea_name,tea_mobile')->select();
            for($i = 0; $i < count($allteacher); $i++){
                $data[$i]['tel'] = $allteacher[$i]['tea_mobile'];
                $data[$i]['name'] = $allteacher[$i]['tea_name'];
                $data[$i]['time'] = $_POST['regtime'];
                $data[$i]['fid'] = $_POST['id'];
                $data[$i]['tel_state'] = $_POST['tel_state'];
                $data[$i]['ocode'] = $_SESSION['admin']['school_id'];
                if(!M('school_people')->add($data[$i])){
                    $this->failajax('服务器繁忙请稍后再试');
                    exit;
                }
                $tel[$i]['tel'] = $allteacher[$i]['tea_mobile'];
                $tel[$i]['name'] = $allteacher[$i]['tea_name'];
                $tel[$i]['sendtime'] = $_POST['regtime'];
                $tel[$i]['regtime'] = date('Y-m-d H:i:s');
                $tel[$i]['table_id'] = $_POST['id'];
                $tel[$i]['table_name'] = 'oa_file';
                $tel[$i]['sms_type'] = '1';
                $tel[$i]['uid'] = $_SESSION['admin']['id'];
                $tel[$i]['ocode'] = $_SESSION['admin']['school_id'];
                $tel[$i]['send_name'] = $oper['relname'];
                M('message')->add($tel[$i]);
            }
        }else {
            for ($i = 0; $i < count($tel); $i++) {
                $data[$i]['tel'] = $tel[$i];
                $data[$i]['name'] = $name[$i];
                $data[$i]['time'] = $_POST['regtime'];
                $data[$i]['fid'] = $_POST['id'];
                $data[$i]['complete'] = '1';
                $data[$i]['tel_state'] = $_POST['tel_state'];
                $data[$i]['ocode'] = $_SESSION['admin']['school_id'];
                if (!M('school_people')->add($data[$i])) {
                    $this->failajax('服务器繁忙请稍后再试');
                    exit;
                }
                $te[$i]['tel'] = $tel[$i];
                $te[$i]['name'] = $name[$i];
                $te[$i]['sendtime'] = $_POST['regtime'];
                $te[$i]['regtime'] = date('Y-m-d H:i:s');
                $te[$i]['table_id'] = $_POST['id'];
                $te[$i]['table_name'] = 'oa_file';
                $te[$i]['sms_type'] = '1';
                $te[$i]['uid'] = $_SESSION['admin']['id'];
                $te[$i]['ocode'] = $_SESSION['admin']['school_id'];
                $te[$i]['send_name'] = $oper['relname'];
                M('message')->add($te[$i]);
            }
        }
        $this->successajax();
    }

    public function get_file_info(){
        $id = I('get.id');
        $allnum = M('oa_file')->field('allnum')->find($id)['allnum'];
        $allnum = $allnum+1;
        $info = array(
            'id' => $id,
            'allnum' => $allnum
        );

        M('oa_file')->save($info);
        $data = M('oa_file')->find($id);
        $file = M('oa_upload_file')->where('file_id = '.$id)->select();
        $i = 0;
        foreach ($file as $v) {
            $src[$i]['src'] = $v['imgtime'];
            $src[$i]['name'] = $v['name'];
            $src[$i]['srcname'] = $v['srcname'];
            $i++;
        }
        if($data){
            echo json_encode(array(array('success'=>true,'data'=>$data,'src'=>$src)));
        }else{
            $this->failajax('服务器繁忙,请稍后再试');
        }
    }

    //获取签约流转的人
    public function get_share_people(){
        $data = M('school_people')->where('fid ='.$_POST['id'])->order('level asc')->select();
        $uid = M('oa_file')->field('uid')->find($_POST['id']);
        $oper = M('user')->where("id =".$_SESSION['admin']['id'])->field('username,relname')->find();
        $level = M('school_people')->where('fid ='.$_POST['id'].' and tel ='.$oper['username'])->field('level')->find();

        if($data){
            echo json_encode(array(array('success'=>true,'data'=>$data,'uid'=>$uid['uid'],'level'=>$level['level'],'uname'=>$oper['username'])));
        }else{
            $this->failajax('网络繁忙');
        }
    }

    public function share_people(){
        $tel = M('user')->where("id =".$_SESSION['admin']['id'])->field('username,relname')->find();
        $level = M('school_people')->where('tel ='.$tel['username'].' and fid = '.$_POST['id'])->field('level')->find()['level'];
        $level = $level+1;
        $tel = $_POST['tel'];
        $name = $_POST['name'];

        for($i = 0; $i < count($tel); $i++){
            $data[$i]['tel'] = $tel[$i];
            $data[$i]['name'] = $name[$i];
            $data[$i]['fid'] = $_POST['id'];
            $data[$i]['complete'] = '1';
            $data[$i]['level'] = $level;
            if(!M('school_people')->add($data[$i])){
                $this->failajax('服务器繁忙请稍后再试');
                exit;
            }
            $te[$i]['tel'] = $tel[$i];
            $te[$i]['name'] = $name[$i];
            $te[$i]['sendtime'] = date('Y-m-d H:i:s');
            $te[$i]['regtime'] = date('Y-m-d H:i:s');
            $te[$i]['table_id'] = $_POST['id'];
            $te[$i]['table_name'] = 'oa_file';
            $te[$i]['sms_type'] = '1';
            $te[$i]['uid'] = $_SESSION['admin']['id'];
            $te[$i]['ocode'] = $_SESSION['admin']['school_id'];
            $te[$i]['send_name'] = $tel['relname'];
            M('message')->add($te[$i]);
        }
        $this->successajax();

    }
    public function edit_describe(){
        $tel = M('user')->where("id =".$_SESSION['admin']['id'])->field('username')->find()['username'];
        $id = M('school_people')->where('tel ='.$tel.' and fid = '.$_POST['id'])->field('id')->find()['id'];
        $data = array(
            'id' => $id,
            'describe'=>$_POST['describe'],
            'dotime' => date('Y-m-d H:i:s'),
            'do_state' => '0',
        );
        if(M('school_people')->save($data)){
            $this->successajax('填写成功');
        }else{
            $this->failajax('尚未修改成功');
        }

    }

    //上传资源文件
    public function add_resources(){
        $file = end(explode('.', $_FILES['Filedata']['name']));
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->rootPath  =     './Public/Uploads/img/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        $upload->autoSub  = true;
        $upload->subName  = array('date','Ymd');
        $upload->saveName = '';
        $upload->saveName = mt_rand().time();
        $_FILES['save_name'] =  $upload->saveName;
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            $data =array(
                'uid' => $_SESSION['admin']['id'],
                'regtime' => date('Ymd'),
                'uptime' => date('Y-m-d H:i:s'),
                'size' => $_FILES['Filedata']['size'],
                'title' => $_FILES['Filedata']['name'],
                'srctitle' => $_FILES['save_name'].'.'.$file,
                'ocode' => $_SESSION['admin']['school_id']
            );
            M('resources')->add($data);
        }
    }

    public function get_res_info(){
        //$oper = M('user')->where("id =".$_SESSION['admin']['id'])->field('relname')->find()['relname'];
        $data = M('resources')->where('state = 0 and uid ='.$_SESSION['admin']['id'].' and ocode ='.$_SESSION['admin']['school_id'])->field('id,uptime,size,title,srctitle')->select();
        $this->successajax('',$data);
    }

    public function file_tijiao(){
        $data = M('resources')->field('title,id')->find($_POST['id']);
        if($data){
            $this->successajax('',$data);
        }else{
            $this->failajax('服务器繁忙,请稍后再试');
        }
    }

    public function file_up(){
        $_POST['state'] = 1;
        $_POST['oper'] = M('user')->where("id =".$_SESSION['admin']['id'])->field('relname')->find()['relname'];
        $_POST['ocode'] = $_SESSION['admin']['school_id'];
        $data = M('resources')->save($_POST);
        if($data){
            $this->successajax('提交成功');
        }else {
            $this->failajax('服务器繁忙,请稍后再试');
        }
    }

    public function notice_new(){
        $_POST['do_time'] = date('Y-m-d');
        $id = M('notice')->add($_POST);
        if($id){
            $this->successajax('',$id);
        }else{
            $this->failajax('服务器繁忙,请稍后再试');
        }
    }
    public function email_new(){
        $id = M('email')->add($_POST);
        if($id){
            $this->successajax('',$id);
        }else{
            $this->failajax('服务器繁忙,请稍后再试');
        }
    }
    public function notice_file(){
        $file = M('notice_upload_file')->where('file_id ='.$_POST['file_id'])->field('name,id')->select();
        $this->successajax('',$file);
    }
    public function email_file(){
        $file = M('email_upload_file')->where('file_id ='.$_POST['file_id'])->field('name,id')->select();
        $this->successajax('',$file);
    }

    public function notice_add(){
        M('message')->where("table_name = 'notice' and table_id =".$_POST['id'])->delete();
        M('notice_people')->where('notice_id ='.$_POST['id'])->delete();
        $_POST['tel_state'] ? $tel_state = $_POST['tel_state'] : $tel_state = '0';
        $relname = M('user')->where("id =".$_SESSION['admin']['id'])->field('relname')->find()['relname'];
        if($_POST['name']['0'] == '0'){
            $all_people = '1';
        }else{
            $all_people = '0';
        }
        $info = array(
            'id' => $_POST['id'],
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'do_time' => $_POST['regtime'],
            'tel_state' => $tel_state,
            'ocode' => $_SESSION['admin']['school_id'],
            'state' => '1',
            'uid'   => $_SESSION['admin']['id'],
            'relname' => $relname,
            'all_people' => $all_people
        );
        $info_save = M('notice')->save($info);
        if($_POST['name']['0'] == '0'){
            $first = substr($_SESSION['admin']['school_id'],0,6);
            $foot = substr($_SESSION['admin']['school_id'],-3);
            $allteacher = M('teacherinfo')->where('area_bh ='.$first.' and ocode ='.$foot)->field('tea_name,tea_mobile')->select();
            for($i = 0; $i < count($allteacher); $i++){
                $data[$i]['tel'] = $allteacher[$i]['tea_mobile'];
                $data[$i]['name'] = $allteacher[$i]['tea_name'];
                $data[$i]['do_time'] = $_POST['regtime'];
                $data[$i]['regtime'] = date('Y-m-d');
                $data[$i]['notice_id'] = $_POST['id'];
                $data[$i]['tel_state'] = $tel_state;
                $data[$i]['ocode'] = $_SESSION['admin']['school_id'];
                if(!M('notice_people')->add($data[$i])){
                    $this->failajax('服务器繁忙请稍后再试');
                    exit;
                }
                if($_POST['tel_state'] == '1'){
                    $tel[$i]['tel'] = $allteacher[$i]['tea_mobile'];
                    $tel[$i]['name'] = $allteacher[$i]['tea_name'];
                    $tel[$i]['sendtime'] = $_POST['regtime'];
                    $tel[$i]['regtime'] = date('Y-m-d H:i:s');
                    $tel[$i]['table_id'] = $_POST['id'];
                    $tel[$i]['table_name'] = 'notice';
                    $tel[$i]['sms_type'] = '1';
                    $tel[$i]['uid'] = $_SESSION['admin']['id'];
                    $tel[$i]['ocode'] = $_SESSION['admin']['school_id'];
                    $tel[$i]['send_name'] = $relname;
                    M('message')->add($tel[$i]);
                }

            }
        }else{
            $tel = $_POST['tel'];
            $name = $_POST['name'];

            for($i = 0; $i < count($tel); $i++){
                $data[$i]['tel'] = $tel[$i];
                $data[$i]['name'] = $name[$i];
                $data[$i]['notice_id'] = $_POST['id'];
                $data[$i]['tel_state'] = $tel_state;
                $data[$i]['do_time'] = $_POST['regtime'];
                $data[$i]['regtime'] = date('Y-m-d');
                $data[$i]['ocode'] = $_SESSION['admin']['school_id'];
                if(!M('notice_people')->add($data[$i])){
                    $this->failajax('服务器繁忙请稍后再试');
                    exit;
                }
                if($_POST['tel_state'] == '1'){
                    $te[$i]['tel'] = $tel[$i];
                    $te[$i]['name'] = $name[$i];
                    $te[$i]['sendtime'] = $_POST['regtime'];
                    $te[$i]['regtime'] = date('Y-m-d H:i:s');
                    $te[$i]['table_id'] = $_POST['id'];
                    $te[$i]['table_name'] = 'notice';
                    $te[$i]['sms_type'] = '1';
                    $te[$i]['uid'] = $_SESSION['admin']['id'];
                    $te[$i]['ocode'] = $_SESSION['admin']['school_id'];
                    $te[$i]['send_name'] = $relname;
                    M('message')->add($te[$i]);
                }

            }
        }
        $this->successajax('');
    }

    public function email_add(){
        M('message')->where("table_name = 'email' and table_id =".$_POST['id'])->delete();
        M('email_people')->where('notice_id ='.$_POST['id'])->delete();
        $_POST['tel_state'] ? $tel_state = $_POST['tel_state'] : $tel_state = '0';
        $relname = M('user')->where("id =".$_SESSION['admin']['id'])->field('relname')->find()['relname'];
        if($_POST['name']['0'] == '0'){
            $all_people = '1';
        }else{
            $all_people = '0';
        };
        $info = array(
            'id' => $_POST['id'],
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'do_time' => $_POST['regtime'],
            'tel_state' => $tel_state,
            'ocode' => $_SESSION['admin']['school_id'],
            'state' => '1',
            'uid'   => $_SESSION['admin']['id'],
            'relname' => $relname,
            'all_people' => $all_people
        );
        $info_save = M('email')->save($info);
        if($_POST['name']['0'] == '0'){
            $first = substr($_SESSION['admin']['school_id'],0,6);
            $foot = substr($_SESSION['admin']['school_id'],-3);
            $allteacher = M('teacherinfo')->where('area_bh ='.$first.' and ocode ='.$foot)->field('tea_name,tea_mobile')->select();
            for($i = 0; $i < count($allteacher); $i++){
                $data[$i]['tel'] = $allteacher[$i]['tea_mobile'];
                $data[$i]['name'] = $allteacher[$i]['tea_name'];
                $data[$i]['do_time'] = $_POST['regtime'];
                $data[$i]['regtime'] = date('Y-m-d');
                $data[$i]['notice_id'] = $_POST['id'];
                $data[$i]['tel_state'] = $tel_state;
                $data[$i]['ocode'] = $_SESSION['admin']['school_id'];
                if(!M('email_people')->add($data[$i])){
                    $this->failajax('服务器繁忙请稍后再试');
                    exit;
                }
                if($_POST['tel_state'] == '1'){
                    $tel[$i]['tel'] = $allteacher[$i]['tea_mobile'];
                    $tel[$i]['name'] = $allteacher[$i]['tea_name'];
                    $tel[$i]['sendtime'] = $_POST['regtime'];
                    $tel[$i]['regtime'] = date('Y-m-d H:i:s');
                    $tel[$i]['table_id'] = $_POST['id'];
                    $tel[$i]['table_name'] = 'email';
                    $tel[$i]['sms_type'] = '1';
                    $tel[$i]['uid'] = $_SESSION['admin']['id'];
                    $tel[$i]['ocode'] = $_SESSION['admin']['school_id'];
                    $tel[$i]['send_name'] = $relname;
                    M('message')->add($tel[$i]);
                }

            }
        }else{
            $tel = $_POST['tel'];
            $name = $_POST['name'];

            for($i = 0; $i < count($tel); $i++){
                $data[$i]['tel'] = $tel[$i];
                $data[$i]['name'] = $name[$i];
                $data[$i]['notice_id'] = $_POST['id'];
                $data[$i]['tel_state'] = $tel_state;
                $data[$i]['do_time'] = $_POST['regtime'];
                $data[$i]['regtime'] = date('Y-m-d');
                $data[$i]['ocode'] = $_SESSION['admin']['school_id'];
                if(!M('email_people')->add($data[$i])){
                    $this->failajax('服务器繁忙请稍后再试');
                    exit;
                }
                if($_POST['tel_state'] == '1'){
                    $te[$i]['tel'] = $tel[$i];
                    $te[$i]['name'] = $name[$i];
                    $te[$i]['sendtime'] = $_POST['regtime'];
                    $te[$i]['regtime'] = date('Y-m-d H:i:s');
                    $te[$i]['table_id'] = $_POST['id'];
                    $te[$i]['table_name'] = 'email';
                    $te[$i]['sms_type'] = '1';
                    $te[$i]['uid'] = $_SESSION['admin']['id'];
                    $te[$i]['ocode'] = $_SESSION['admin']['school_id'];
                    $te[$i]['send_name'] = $relname;
                    M('message')->add($te[$i]);
                }

            }
        }
        $this->successajax('');
    }

    public function get_notice_info(){
        $data['do_state'] = '0';
        $tel = M('user')->where('id = '.$_SESSION['admin']['id'])->field('username')->find()['username'];

        M('notice_people')->where('notice_id = '.$_POST['id'].' and tel = '.$tel)->save($data);
        $notice = M('notice')->field('title,content,allnum')->find($_POST['id']);
        $map['id'] = $_POST['id'];
        $map['allnum'] = $notice['allnum'] + 1;
        M('notice')->save($map);
        $file = M('notice_upload_file')->where('file_id ='.$_POST['id'])->field('id,imgtime,name,srcname')->select();
        echo json_encode(array(array('success'=>true,'notice'=>$notice,'file'=>$file)));
    }

    public function del_notice(){
        $del = M('notice_people')->where('notice_id ='.$_POST['id'])->delete();
        $delete = M('notice')->where('id = '.$_POST['id'])->delete();
        $this->successajax('删除成功');
    }

    public function file_shachu(){
        if(M('resources')->delete($_POST['id'])){
            $this->successajax('删除成功');
        }else{
            $this->failajax('删除失败,稍后再试');
        }
    }
    public function oa_file_del(){
        if(M('resources')->delete($_POST['id'])){
            $this->successajax('删除成功');
        }else{
            $this->failajax('删除失败,稍后再试');
        }
    }

    public function add_message(){
        $send_name = M('user')->where("id =".$_SESSION['admin']['id'])->field('relname')->find()['relname'];
        if($_POST['name']['0'] == '0'){
            $first = substr($_SESSION['admin']['school_id'],0,6);
            $foot = substr($_SESSION['admin']['school_id'],-3);
            $allteacher = M('teacherinfo')->where('area_bh ='.$first.' and ocode ='.$foot)->field('tea_name,tea_mobile')->select();
            for($i = 0; $i < count($allteacher); $i++){
                $data[$i]['tel'] = $allteacher[$i]['tea_mobile'];
                $data[$i]['name'] = $allteacher[$i]['tea_name'];
                $data[$i]['content'] = $_POST['content'];
                $data[$i]['regtime'] = date('Y-m-d H:i:s');
                $data[$i]['sendtime'] = $_POST['regtime'];
                $data[$i]['uid'] = $_SESSION['admin']['id'];
                $data[$i]['ocode'] = $_SESSION['admin']['school_id'];
                $data[$i]['sms_type'] = '0';
                $data[$i]['table_name'] = 'message';
                $data[$i]['send_name'] = $send_name;
                if(!M('message')->add($data[$i])){
                    $this->failajax('服务器繁忙请稍后再试');
                    exit;
                }
            }
        }else{
            $tel = $_POST['tel'];
            $name = $_POST['name'];
            for($i = 0; $i < count($tel); $i++){
                $data[$i]['tel'] = $tel[$i];
                $data[$i]['name'] = $name[$i];
                $data[$i]['content'] = $_POST['content'];
                $data[$i]['regtime'] = date('Y-m-d H:i:s');
                $data[$i]['sendtime'] = $_POST['regtime'];
                $data[$i]['table_name'] = 'message';
                $data[$i]['uid'] = $_SESSION['admin']['id'];
                $data[$i]['ocode'] = $_SESSION['admin']['school_id'];
                $data[$i]['sms_type'] = '0';
                $data[$i]['send_name'] = $send_name;
                if(!M('message')->add($data[$i])){
                    $this->failajax('服务器繁忙请稍后再试');
                    exit;
                }
            }

        }
        $this->successajax('发送成功');
    }

    public function email_file_del(){
        if(M('email_upload_file')->delete($_POST['id'])){
            $this->successajax('删除成功');
        }else{
            $this->failajax('删除失败,稍后再试');
        }
    }

    public function get_email_info(){
        $data['do_state'] = '0';
        $tel = M('user')->where('id = '.$_SESSION['admin']['id'])->field('username')->find()['username'];

        M('email_people')->where('notice_id = '.$_POST['id'].' and tel = '.$tel)->save($data);
        $notice = M('email')->field('title,content,allnum')->find($_POST['id']);
        $map['id'] = $_POST['id'];
        $map['allnum'] = $notice['allnum'] + 1;
        M('email')->save($map);
        $file = M('email_upload_file')->where('file_id ='.$_POST['id'])->field('id,imgtime,name,srcname')->select();
        echo json_encode(array(array('success'=>true,'notice'=>$notice,'file'=>$file)));
    }

    public function get_identity(){
        $tip = M('school_identity')->where('userid ='.$_POST['id'])->field('id,identity')->select();
        if($tip){
            $this->successajax('',$tip);
        }
    }

    public function get_passwd(){
        $where['id'] = $_SESSION['admin']['id'];
        $where['password'] = md5($_POST['password']);
        $data = M('user')->where($where)->field('id')->find();
        $data ? $this->successajax('11') : $this->failajax('网络繁忙');
    }

    public function edit_passwd(){
        $pwd = M('user')->where('id ='.$_SESSION['admin']['id'])->field('password')->find()['password'];
        $password = md5($_POST['password']);
        if($pwd == $password){
            $data['id'] = $_SESSION['admin']['id'];
            $data['password'] = md5($_POST['passwd']);
            if(M('user')->save($data)){
                unset($_SESSION['admin']);
                $this->successajax();
            }else{
                $this->failajax('网络不稳定,请稍后再试');
            }

        }else{
            $this->failajax('原密码不正确,请重新输入');
        }
    }

    public function class_find_update(){
        $data = M('classinfo')->field('class_name,rec_id,class_type_bh')->find($_POST['rec_id']);
        if($data){
            $this->successajax('',$data);
        } else {
            $this->failajax('查询失败,请稍后再试');
        }
    }

    public function class_update_button(){
        $save = M('classinfo')->save($_POST);
        if(false !== $save || 0 !== $save){
            $this->successajax('修改成功');
        }else{
            $this->failajax('修改失败');
        }
    }

    public function class_del_id(){
        if(M('classinfo')->delete($_POST['rec_id'])){
            $this->successajax('删除成功');
        }else{
            $this->failajax('删除失败');
        }
    }

    public function classinfo(){

        $map['OCODE'] = substr($_SESSION['admin']['school_id'],-3);
        $map['AREA_BH'] = substr($_SESSION['admin']['school_id'],0,6);
        if($_GET['ocode_id']){
            if(!strlen($_GET['ocode_id']) == 9){
                $this->failajax('请重新加载');
            }
            $map['OCODE'] = substr($_GET['ocode_id'],-3);
            $map['AREA_BH'] = substr($_GET['ocode_id'],0,6);
        }
        $map['STU_BANJI'] = $_POST['class_bh'];

        $data = M('stuentinfo')->where($map)->field('stu_name,rec_id,vidflag')->select();
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
        }
        $this->successajax('发送成功');

    }


    public function classinfo1(){
        $map['ocode'] = substr($_SESSION['admin']['school_id'],-3);
        $map['area_bh'] = substr($_SESSION['admin']['school_id'],0,6);
        if($_GET['ocode_id']){
            if(!strlen($_GET['ocode_id']) == 9){
                $this->failajax('请重新加载');
            }
            $map['ocode'] = substr($_GET['ocode_id'],-3);
            $map['area_bh'] = substr($_GET['ocode_id'],0,6);
        }
        $map['class_inyear'] = $_POST['class_inyear'];
        $class = new MessageModel();
        $data = $class->get_grade($map);
        $this->successajax('',$data);
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
        }
        $this->successajax('发送成功');
    }


    public function get_group_teacher(){
        $data = M('school_oa_tea')->where('gid = '.$_POST['gid'])->field('name,tel')->select();
        $this->successajax('',$data);
    }

    public function all_send2(){

        $i = 0;
        foreach ($_POST['tel'] as $v) {
            if($_POST['tel'][$i] != ""){
                $data[$i]['tel'] = $_POST['tel'][$i];
                $data[$i]['name'] = $_POST['name'][$i];

            }
            $i++;
        }
        foreach ($data as $v) {
            $data = array(
                'name'  => $v['name'],
                'tel'   => $v['tel'],
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
        }
        $this->successajax('发送成功');

    }


    public function set_body_color(){
        $color = M('oa_background')->where('uid ='.$_SESSION['admin']['id'])->find();
        $data['uid'] = $_SESSION['admin']['id'];
        $data['color'] = $_POST['color'];
        if($color){
            M('oa_background')->where('uid ='.$data['uid'])->save($data);
        }else{
            M('oa_background')->add($data);
        }
        $this->successajax();
    }

    public function get_news_people(){
        if($_POST['type'] == '1'){
            $data = M('schoolgroup')->where('pid != 0 and ocode ='.$_SESSION['admin']['school_id'])->select();
        }else if($_POST['type'] == '2'){
            $data = M('schoolgroup')->where('pid = 0 and ocode ='.$_SESSION['admin']['school_id'])->select();
        }
        $this->successajax('',$data);
    }

    public function choice(){
        //var_dump($_POST);
        $arr = explode(',',$_POST['id']);
        $pid = $arr['1'];
        $id = $arr['0'];
        if($pid == '0'){
            $data = M('schoolgroup')->where('pid = '.$id)->select();
            $this->successajax('',$data);
        }else{

            $data = M('school_oa_tea')->where('gid = '.$id)->select();
            $type = '1';
            echo json_encode(array(array('success'=>true,'data'=>$data,'type'=>$type)));
        }

    }

    public function add_news_people(){
        if($_POST['type'] == '1'){ //发个人
            $map['id'] = array('in',$_POST['id']);
            $peo = M('school_oa_tea')->where($map)->field('name,tel')->select();
            foreach($peo as $v){
                $data = array(
                    'content'       => $_POST['content'],
                    'start_time'    => $_POST['start_time'],
                    'end_time'      => $_POST['end_time'],
                    'tel'           => $v['tel'],
                    'username'      => $v['name'],
                    'ocode'         => $_SESSION['admin']['school_id']
                );
                if(!M('school_oa_plan')->add($data)){
                    $this->failajax();
                    return false;
                }
            }
        }else{
            $map['gid'] = array('in',$_POST['id']);
            $peo = M('school_oa_tea')->where($map)->field('name,tel')->select();
            foreach($peo as $v){
                $data = array(
                    'content'       => $_POST['content'],
                    'start_time'    => $_POST['start_time'],
                    'end_time'      => $_POST['end_time'],
                    'tel'           => $v['tel'],
                    'username'      => $v['name'],
                    'ocode'         => $_SESSION['admin']['school_id']
                );
                if(!M('school_oa_plan')->add($data)){
                    $this->failajax();
                    return false;
                }
            }
        }
        $this->successajax();
    }


    public function plan_success(){
        $data['state'] = '1';
        $data['id'] = $_POST['id'];
        $data['do_time'] = date('Y-m-d H:i:s');
        if(M('school_oa_plan')->save($data)){
            $this->successajax();
        }

    }

    function all_send3(){
        $map['id'] = array('in',$_POST['id']);
        $friend = M('school_my_friend')->where($map)->select();
        foreach ($friend as $item) {
            $data = array(
                'name'  => $item['name'],
                'tel'   => $item['tel'],
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
        }
        $this->successajax('发送成功');
    }

    function del_news(){
        if(M('school_oa_plan')->delete($_POST['id']))
        {
            $this->successajax();
        }
        else
        {
            $this->failajax('服务器繁忙,请稍后再试');
        }
    }




}