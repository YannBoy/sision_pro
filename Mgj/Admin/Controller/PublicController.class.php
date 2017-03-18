<?php
namespace Admin\Controller;
use Think\Controller;
class PublicController extends Controller
{
    function add_group(){
        $data['name'] = $_POST['name'];
        $data['uid'] = $_SESSION['admin']['id'];
        $data['ocode'] = $_SESSION['admin']['school_id'];
        if(M('school_my_group')->add($data)){
            $this->successajax('创建成功');
        }else{
            $this->failajax('创建失败');
        }
    }

    function del_group(){
        if(M('school_my_group')->delete($_POST['id'])){
            $this->successajax('删除成功');
        }else{
            $this->failajax('删除失败');
        }
    }

    function friend_peo(){
        $people  =M('school_my_friend')->where('gid = '.$_GET['id'])->select();
        $this->assign('people',$people);
        $arr = D('User')->get_school_nav();
        $this->assign('data_nav',$arr);
        $this->display('Center:friend_peo');
    }
    function  add_my_peo(){
        if(M('school_my_friend')->add($_POST)){
            $this->successajax('添加成功');
        }else{
            $this->failajax('添加失败');
        }
    }

    function del_my_friend(){
        if(M('school_my_friend')->delete($_POST['id'])){
            $this->successajax('删除成功');
        }else{
            $this->failajax('删除失败');
        }
    }
    function edit_my_friend(){
        $data = M('school_my_friend')->where('id ='.$_POST['id'])->find();
        if($data){
            $this->successajax('',$data);
        }else{
            $this->failajax('失败');
        }
    }
    function edit_my_peo(){
        $id = M('school_my_friend')->save($_POST);
        if($id || $id == 0){
            $this->successajax('修改成功');
        }else{
            $this->failajax('修改失败');
        }
    }

    function get_friend_group(){
        $data = M('school_my_friend')->where('gid = '.$_POST['gid'])->select();
        $this->successajax('',$data);
    }
}