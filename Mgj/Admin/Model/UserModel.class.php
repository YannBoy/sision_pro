<?php
namespace Admin\Model;
use Think\Model;
class UserModel extends Model
{
    public function get_area($id){
        $list = M('classaccessinfo');
        $list = $list->where("userid = $id and length(class_bh) = 9")->field('class_bh')->select();
        foreach ($list as $v) {
            $area[] = $v['class_bh'];
        }
        foreach ($area as $v) {
            $class_id = $v.'_____';
            $area_class = M('classaccessinfo')->where("userid = $id and class_bh like '$class_id'")->field('class_bh')->select();
            if(!empty($area_class)){
                foreach ($area_class as $val) {
                    $arr_sm[] = $val;
                }
            }
            $arr[] = $v;
        }
        $all_sm = M('classaccessinfo')->where("userid = $id and length(class_bh) = 14")->field('class_bh')->select();
        $arr3=array();
        if(empty($arr)){
            foreach ($all_sm as $value) {
                $arr3[] = $value;
            }
            foreach ($arr3 as $value) {
                $lis[] = $value['class_bh'];
            }

        }else{
            foreach ($all_sm as $key => $value) {
                if(!in_array($value,$arr_sm)) {
                    $arr3[] = $value;
                }
            }
            foreach ($arr3 as $v) {
                $arr_class[] = $v['class_bh'];
            }
            $lis = array_merge($arr_class,$arr);
        }
        if(!empty($lis)){
            $map['class_bh'] = array('in',$lis);
        }
        $map['userid'] = $id;
        $li = M('classaccessinfo')->where($map)->field('rec_id,class_name,class_bh')->select();
        return $li;
    }

    public function del_user_quanxian($rec_id){
        $id = M('classaccessinfo')->delete($rec_id);
        return $id;
    }

    public function add_user_quanxian($list){
        $ocode_name = M('shoollist')->where("area_bh = $list[area] and ocode = $list[ocode]")->field('ocode_name')->find();
        if($list['ocode_nj']){
            $ocode_nj_name = M('classinfo')->where("ocode = $list[ocode] and class_bh = $list[ocode_nj]")->field('class_name')->find();
        }

        $li['class_name'] = $ocode_name['ocode_name'].$ocode_nj_name['class_name'];
        $li['class_bh'] = $list['area'].$list['ocode'].$list['ocode_nj'];
        $li['userid']  = $list['userid'];
        $li['reg_time'] = date('Y-m-d');
        $data = M('classaccessinfo')->add($li);
        return $data;
    }


    public function get_reprot_info($list){
        $class_id = $list['class_bh'];
        if(strlen($list['class_bh']) == '9'){
            $class_id = $list['class_bh'].'_____';
        }
        $data['a'] = M('test_once_reprot')->where("ocode like '$class_id' and course_id = '$list[course_bh]' and grade_name = 'A'")->field('percentage')->select();
        $data['b'] = M('test_once_reprot')->where("ocode like '$class_id' and course_id = '$list[course_bh]' and grade_name = 'B'")->field('percentage')->select();
        $data['c'] = M('test_once_reprot')->where("ocode like '$class_id' and course_id = '$list[course_bh]' and grade_name = 'C'")->field('percentage')->select();
        $data['d'] = M('test_once_reprot')->where("ocode like '$class_id' and course_id = '$list[course_bh]' and grade_name = 'D'")->field('percentage')->select();
        $data['e'] = M('test_once_reprot')->where("ocode like '$class_id' and course_id = '$list[course_bh]' and grade_name = 'E'")->field('percentage')->select();
        foreach($data['a'] as $v){
            $arr['a'] = $v['percentage']*1;
        }
        foreach($data['b'] as $v){
            $arr['b'] = $v['percentage']*1;
        }
        foreach($data['c'] as $v){
            $arr['c'] = $v['percentage']*1;
        }
        foreach($data['d'] as $v){
            $arr['d'] = $v['percentage']*1;
        }
        foreach($data['e'] as $v){
            $arr['e'] = $v['percentage']*1;
        }
        return $arr;

    }



    public function get_area1($id){
        $list = M('classaccessinfo');
        $list = $list->where("userid = $id and length(class_bh) = 9")->field('class_bh')->select();
        foreach ($list as $v) {
            $area[] = $v['class_bh'];
        }
        foreach ($area as $v) {
            $class_id = $v.'_____';
            $area_class = M('classaccessinfo')->where("userid = $id and class_bh like '$class_id'")->field('class_bh')->select();
            if(!empty($area_class)){
                foreach ($area_class as $val) {
                    $arr_sm[] = $val;
                }
            }
            $arr[] = $v;
        }
        $all_sm = M('classaccessinfo')->where("userid = $id and length(class_bh) = 14")->field('class_bh')->select();
        $arr3=array();
        if(empty($arr)){
            foreach ($all_sm as $value) {
                $arr3[] = $value;
            }
            foreach ($arr3 as $value) {
                $lis[] = $value['class_bh'];
            }

        }else{
            foreach ($all_sm as $key => $value) {
                if(!in_array($value,$arr_sm)) {
                    $arr3[] = $value;
                }
            }
            foreach ($arr3 as $v) {
                $arr_class[] = $v['class_bh'];
            }
        }
        $map['userid'] = $id;
        foreach($list as $v){
            $list_li[] = $v['class_bh'];
        }
        if(!empty($list_li)){
            $map['class_bh'] = array('in',$list_li);
            $li['ocode'] = M('classaccessinfo')->where($map)->field('rec_id,class_name,class_bh')->select();
        }
        foreach($arr3 as $v){
            $class_bh[] = $v['class_bh'];
        }

        if(!empty($class_bh)){
            $map['class_bh'] = array('in',$class_bh);
            $li['class'] = M('classaccessinfo')->where($map)->field('rec_id,class_name,class_bh')->select();
        }
        return $li;
    }


    public function get_compare($ocode){
        $a['ocode'] = array('in',$ocode['ocode']);
        $a['course_id'] = $ocode['course_bh'];
        $a['grade_name'] = "A";
        $b['ocode'] = array('in',$ocode['ocode']);
        $b['grade_name'] = "B";
        $b['course_id'] = $ocode['course_bh'];
        $c['ocode'] = array('in',$ocode['ocode']);
        $c['grade_name'] = "C";
        $c['course_id'] = $ocode['course_bh'];
        $d['ocode'] = array('in',$ocode['ocode']);
        $d['grade_name'] = "D";
        $d['course_id'] = $ocode['course_bh'];
        $e['ocode'] = array('in',$ocode['ocode']);
        $e['grade_name'] = "E";
        $e['course_id'] = $ocode['course_bh'];

        $school['a'] = M('test_once_reprot')->where($a)->field('percentage')->select();
        $school['b'] = M('test_once_reprot')->where($b)->field('percentage')->select();
        $school['c'] = M('test_once_reprot')->where($c)->field('percentage')->select();
        $school['d'] = M('test_once_reprot')->where($d)->field('percentage')->select();
        $school['e'] = M('test_once_reprot')->where($e)->field('percentage')->select();

        return $school;
    }


    public function get_school_num($id){
        $data = M('classaccessinfo')->where('userid = '.$id)->field('class_bh')->select();
        foreach ($data as $v) {
            $arr[] = substr($v['class_bh'],0,9);
        }
        $arr = array_unique($arr);
        $school_num = count($arr);
        return $school_num;
    }

    public function get_school_nav(){
        $data = M('nav_display')->where('school_id = '.$_SESSION['admin']['school_id'])->field('nav_id')->order('nav_id')->select();
        foreach ($data as $v) {
            $nav_name = M('nav')->where('id = '.$v['nav_id'])->field('nav_name')->find()['nav_name'];

            $nav_sm = M('nav')->where('pid = '.$v['nav_id'])->field('nav_name,src')->select();
            foreach ($nav_sm as $v) {
                $arr[$nav_name][] = $v;
            }
        }
        return $arr;
    }






}