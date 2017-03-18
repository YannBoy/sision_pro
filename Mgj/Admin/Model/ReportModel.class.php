<?php
/**
 * Created by PhpStorm.
 * User: mty
 * Date: 16/10/8
 * Time: 下午2:45
 */

namespace Admin\Model;


class ReportModel
{
    function report_get_info($id){

        $ocode =  M('test_once_reprot_bj')->where("ocode like '".$id['ocode']."_____' ")->field('ocode,course_id')->order('ocode')->select();
        $ocode_list = array();
        foreach ($ocode as $k=>$v){
            $ocode_list[] = $v['ocode'];
        }

        $data['course'] = M('courseinfo')->field('rec_id,course_bh,course_name')->order('rec_id desc')->select();
        $data['ocode_list'] = array_unique($ocode_list);


        return $data;
    }

    function rep_get_info($list){

        $class_bh = $list['class_bh'];

        $class = $this->report_get_info($list)['ocode_list'];
        //var_export($class);
        if($class_bh == '001'){
            $where = " and ocode like '".$list['ocode']."_____'";
            $class_id = array();
            foreach ($class as $v) {
                $class_id[] = substr($v,-5);
            }

            $map['class_bh'] = array('in',$class_id);
            $map['ocode'] = '001';
            $map['area_bh'] = '330183';
            $data['class_count'] = M('classinfo')->where($map)->field('class_name')->select();
            foreach ($data['class_count'] as $k=>$v) {
                $data['class_name'][] = $v['class_name'];
            }


        }else{
            $class_bh = $list['class_bh'];
            $where = 'and ocode = '.$class_bh;
        }
        $exam_id = $list['exam_id'];
        $course_bh = $list['course_bh'];
        //var_export($where);
        $data['text'] = M('courseinfo')->where("course_bh = '$course_bh'")->field('course_name')->find();
        $data['a'] = M('test_once_reprot_bj')->where("course_id = '$course_bh' and grade_name = 'A'".$where)->order('ocode')->field('per_rensun')->select();
        $data['b'] =M('test_once_reprot_bj')->where("course_id = '$course_bh' and grade_name = 'B'".$where)->field('per_rensun')->select();
        $data['c'] =M('test_once_reprot_bj')->where("course_id = '$course_bh' and grade_name = 'C'".$where)->field('per_rensun')->select();
        $data['d'] =M('test_once_reprot_bj')->where("course_id = '$course_bh' and grade_name = 'D'".$where)->field('per_rensun')->select();
        $data['e'] =M('test_once_reprot_bj')->where("course_id = '$course_bh' and grade_name = 'E'".$where)->field('per_rensun')->select();
        if($class_bh !='001' && $list['course_bh'] == 'COURSE_TOTAL'){
            $data['type'] = '1';
            $class_bh = $list['class_bh'];

            $data['ex_a'] = M('test_once_reprot_bj')->where("ocode = '$class_bh' and grade_name = 'A'")->field('per_rensun')->select();
            $data['ex_b'] =M('test_once_reprot_bj')->where("ocode = '$class_bh' and grade_name = 'B'")->field('per_rensun')->select();
            $data['ex_c'] =M('test_once_reprot_bj')->where("ocode = '$class_bh' and grade_name = 'C'")->field('per_rensun')->select();
            $data['ex_d'] =M('test_once_reprot_bj')->where("ocode = '$class_bh' and grade_name = 'D'")->field('per_rensun')->select();
            $data['ex_e'] =M('test_once_reprot_bj')->where("ocode = '$class_bh' and grade_name = 'E'")->field('per_rensun')->select();
            $course_name = M('courseinfo')->field('course_name')->select();
            foreach ($course_name as $k=>$v) {
                $data['course_name'][] = $v['course_name'];
            }


            $con['areaocode'] = substr($class_bh,0,6);
            $con['ocode'] = '005';
            $con['class_bh'] = substr($class_bh,-5);
            //var_export($con);
            $data['exam_info'] = M('juan_scoreinfo')->where($con)->field('stu_name,course_1,course_2,course_3,course_4,course_5,course_6,course_total')->order('course_total desc')->select();
        }
        return $data;
    }

    function rep_get_ocodeinfo($list){
        //var_export($list);
        $class_bh = $list['class_bh'];

        $ocode_list = M('test_once_reprot')->field('ocode')->select();
        foreach ($ocode_list as $k=>$v) {
            $oc_list[] = $v['ocode'];
        }
        $data['class_name'] = array_unique($oc_list);

        $course_bh = $list['course_bh'];
        //var_export($where);
        $data['text'] = M('courseinfo')->where("course_bh = '$course_bh'")->field('course_name')->find();
        $data['a'] = M('test_once_reprot')->where("course_id = '$course_bh' and grade_name = 'A'".$where)->order('ocode')->field('per_rensun')->select();
        $data['b'] =M('test_once_reprot')->where("course_id = '$course_bh' and grade_name = 'B'".$where)->field('per_rensun')->select();
        $data['c'] =M('test_once_reprot')->where("course_id = '$course_bh' and grade_name = 'C'".$where)->field('per_rensun')->select();
        $data['d'] =M('test_once_reprot')->where("course_id = '$course_bh' and grade_name = 'D'".$where)->field('per_rensun')->select();
        $data['e'] =M('test_once_reprot')->where("course_id = '$course_bh' and grade_name = 'E'".$where)->field('per_rensun')->select();

        if($class_bh !='001' && $list['course_bh'] == 'course_total'){
            $data['type'] = '1';
            $class_bh = substr($class_bh,0,6).'015'.substr($class_bh,-5);
            $data['ex_a'] = M('test_once_reprot_bj')->where("ocode = '$class_bh' and grade_name = 'A'")->field('per_rensun')->select();
            $data['ex_b'] =M('test_once_reprot_bj')->where("ocode = '$class_bh' and grade_name = 'B'")->field('per_rensun')->select();
            $data['ex_c'] =M('test_once_reprot_bj')->where("ocode = '$class_bh' and grade_name = 'C'")->field('per_rensun')->select();
            $data['ex_d'] =M('test_once_reprot_bj')->where("ocode = '$class_bh' and grade_name = 'D'")->field('per_rensun')->select();
            $data['ex_e'] =M('test_once_reprot_bj')->where("ocode = '$class_bh' and grade_name = 'E'")->field('per_rensun')->select();
            $course_name = M('courseinfo')->field('course_name')->select();
            foreach ($course_name as $k=>$v) {
                $data['course_name'][] = $v['course_name'];
            }


            $con['areaocode'] = substr($class_bh,0,6);
            $con['ocode'] = '015';
            $con['class_bh'] = substr($class_bh,-5);

            $data['exam_info'] = M('juan_scoreinfo')->where($con)->field('stu_name,course_1,course_2,course_3,course_4,course_5,course_6,course_total')->order('course_total desc')->select();
        }
        return $data;
    }


    function getchose($res)
    {
        if($res['share'] == 0)   //未分配过权限
        {
            //1.获取基础数据自带的学校  2.获取全部学校  3.合并 干要干的事
            $result = $this->getHaveSch(I('post.id'),'school_call');
        }
        else
        {    //  已分配过
            $result = $this->getHaveSch(I('post.id'),'rep_many_exam');
        }
        return $result;
    }


    function getHaveSch($id,$table)
    {
        $have = M($table)->where('pid = '.$id)->field('schoolname')->group('schoolname')->select();
        $i = 0;
        foreach ($have as $item=>$v) {
            $_have[] = $v['schoolname'];
            $original[$i]['schoolname'] = $v['schoolname'];
            $original[$i]['share'] = 1;
            $i++;
        }
        $no = M('rep_schoollist')->field('schoolname')->select();
        foreach ($no as $item=>$v) {
            $_no[] = $v['schoolname'];
        }

        $noarray = array_diff($_no,$_have);
        foreach ($noarray as $item=>$v) {
            $data[$i]['schoolname'] = $v;
            $data[$i]['share'] = 0;
            $i++;
        }

        return(array_merge($original,$data));
    }


}