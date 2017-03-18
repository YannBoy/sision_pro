<?php
namespace Admin\Controller;

//学校管理
use PhpParser\Node\Stmt\Global_;

class SchoolController extends CommonController
{
    public function index(){
        $num = I('get.num');
        $num = !empty($num) ? $num : 10;
        $keyword = I('get.keyword');
        if(!empty($keyword)){
            $where['ocode_name']=array('LIKE','%'.$keyword .'%');
        }
        $model = M('shoollist');
        $count = $model->where($where)->count();	//查询满足要求的总记录数
        //创建分页对象
        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();
        $data = M('shoollist')->where($where)->limit($limit)->select();
        $area = M('area')->where("area_bh like '__0000'")->select();
        $arr = D('User')->get_school_nav();
        $this->assign('data_nav',$arr);
        $this->assign('area',$area);
        $this->assign('list',$data);
        $this->assign('page',$show);
        $this->assign('num',$num);
        $this->assign('keyword',$keyword);
        $this->display();
    }
    public function school_add(){

        $ocode_name = M('shoollist')->where(array('ocode_name'=>I('post.ocode_name')))->find();
        if($ocode_name) {
            $this->failajax('该学校名称已存在');
        } else {
            $ocode = M('shoollist')->order('ocode desc')->select()['0'];
            $ocode = $ocode['ocode']+1;
            $num = strlen($ocode);
            if($num == 1){
                $ocode = '00'.$ocode;
            } elseif($num == 2){
                $ocode = '0'.$ocode;
            }
            $school_id = I('post.area_bh','').$ocode;
            $data = array(
                'ocode' => $ocode,
                'ocode_name' => I('post.ocode_name',''),
                'reg_time'  => date('Y-m-d'),
                'area_bh' => I('post.area_bh',''),
            );
            $userid = array(
                'username'  =>$school_id,
                'password'  =>md5(123456),
                'num1'      => substr(I('post.area_bh',''),0,2).'0000',
                'num2'      => substr(I('post.area_bh',''),0,4).'00',
                'num3'      =>I('post.area_bh',''),
                'school_num'    => $ocode,
                'relname'   => $school_id
            );
            $adduserid = M('user')->add($userid);
            M('shoollist')->add($data);
            $group = M('user_auth_group')->find(26);
            $group['ocode'] = $school_id;
            $groups = array(
                'title' => $group['title'],
                'status'=> 1,
                'rules' => $group['rules'],
                'ocode' => $school_id
            );
            $groupid=M('user_auth_group')->add($groups);
            $access = array(
                'uid'   => $adduserid,
                'group_id' => $groupid,
                'ocode' => $school_id
            );
            $schclassinfo = array(
                'userid'    => $adduserid,
                'class_bh'  => $school_id,
                'reg_time'  => date('Y-m-d'),
                'class_name'  => I('post.ocode_name')
            );
            M('user_auth_group_access')->add($access);
            M('classaccessinfo')->add($schclassinfo);
            $this->successajax('添加成功');
        }
    }

    public function school_find(){
        $data = M('shoollist')->where("rec_id = $_POST[rec_id]")->find();
        $area_bh = $data['area_bh'];
        $area_bh1 = substr($area_bh,0,2).'0000';
        $area_bh2 = substr($area_bh,0,4).'00';
        $list1 = M('area')->where("area_bh = $area_bh1")->find();
        $list2 = M('area')->where("area_bh = $area_bh2")->find();
        $list3 = M('area')->where("area_bh = $area_bh")->find();
        $school_name = $data['ocode_name'];
        echo json_encode(array(array('success'=>true,'list1'=>$list1,'list2'=>$list2,'list3'=>$list3,'school_name'=>$school_name)));
    }

    public function school_update(){
        $school_name = M('shoollist')->where("ocode_name = '$_POST[ocode_name]' and rec_id != $_POST[rec_id]")->find();
        if($school_name) {
            $this->failajax('该学校名称已存在');
        } else {
            $data = array(
                'ocode_name' => $_POST['ocode_name'],
                'update_time' => date('Y-m-d'),
                'area_bh' => $_POST['area_bh']
            );
            $res = M('shoollist')->where("rec_id = $_POST[rec_id]")->save($data);
            if ($res){
                $this->successajax('修改成功');
            } else {
                $this->failajax('尚未有修改操作');
            }
        }
    }

    public function school_del(){
        $res = M('shoollist')->where("rec_id = $_POST[rec_id]")->delete();
        if($res){
            $this->successajax('删除成功');
        } else {
            $this->failajax('删除失败');
        }
    }

    //学校所对应的班级
    public function find_class(){
        $where['area_bh']= substr(session('admin.school_id'),0,6);
        $where['ocode'] = substr(session('admin.school_id'),-3);
        $data = M('classinfo')->where($where)->field('rec_id,class_name,class_bh,class_inyear,class_type_bh,iffinsh')->select();
        $year = date('Y');
        $this->assign('ocode',$_GET['area_bh'].$_GET['ocode']);
        $this->assign('year',$year);
        $this->assign('data',$data);
        $this->display('class');
    }

    public function add_class(){
        $area_bh = substr($_POST['ocode'],0,6);
        $class_bh =M('classinfo')->where('area_bh = '.$area_bh.' and class_type_bh ='.$_POST['class_type_bh'])->order('class_bh desc')->field('class_bh')->find()['class_bh'];
        $class_bh = substr($class_bh,-3) + 1;
        $num = strlen($class_bh);
        if($num == 1){
            $class_bh = '00'.$class_bh;
        }
        if($num == 2){
            $class_bh = '0'.$class_bh;
        }
        $class_bh = substr($_POST['class_inyear'],-2).$class_bh;
        $data = array(
            'class_bh' => $class_bh,
            'class_name' => $_POST['class_name'],
            'ocode'     => substr($_POST['ocode'],-3),
            'class_inyear' =>   $_POST['class_inyear'],
            'class_type_bh' => $_POST['class_type_bh'],
            'area_bh'   => $area_bh
        );
        if(M('classinfo')->add($data)){
            $this->successajax('添加成功');
        }else{
            $this->failajax('添加失败');
        }
    }



}