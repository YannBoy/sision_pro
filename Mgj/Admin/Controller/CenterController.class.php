<?php
namespace Admin\Controller;

class CenterController extends CommonController
{
    Public function center(){
        $managerInfo = M('user a')->join('LEFT JOIN feiyue_user_detail b ON a.id = userid')->where('a.id = '.$_SESSION['admin']['id'])->field('a.*,b.sex,b.rtime')->find();
        $this->assign('managerInfo', $managerInfo);
        $arr = D('User')->get_school_nav();
        $this->assign('data_nav',$arr);
        $this->display();
    }

    function friend(){
        $data = M('school_my_group')->where('uid = '.$_SESSION['admin']['id'])->select();
        $this->assign('data',$data);
        $this->display();
    }

    function mysd(){
        $id = session('admin.id');
        $this->assign('userid',$id);
        $this->display();
    }

    function getFiles($path,$child=false){
        $files=array();
        if(!$child){
            if(is_dir($path)){
                $dp = dir($path);
            }else{
                return null;
            }
            while ($file = $dp ->read()){
                if($file !="." && $file !=".." && is_file($path.$file)){
                    $files[] = $file;
                }
            }
            $dp->close();
        }else{
            $this->scanfiles($files,$path);
        }
        return $files;
    }
}