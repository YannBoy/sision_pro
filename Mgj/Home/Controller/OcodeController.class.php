<?php
namespace Home\Controller;
use Think\Controller;

class OcodeController extends Controller
{
    public function index()
    {

        $A = M('test_once_reprot')->where("ocode = '33108300714' and grade_name = 'A'")->field('percentage,course_name,ocode')->select();
        $B = M('test_once_reprot')->where("ocode = '33108300714' and grade_name = 'B'")->field('percentage')->select();
        $C = M('test_once_reprot')->where("ocode = '33108300714' and grade_name = 'C'")->field('percentage')->select();
        $D = M('test_once_reprot')->where("ocode = '33108300714' and grade_name = 'D'")->field('percentage')->select();
        $E = M('test_once_reprot')->where("ocode = '33108300714' and grade_name = 'E'")->field('percentage')->select();
        foreach($A as $k){
            $course_name[] = $k['course_name'];
        }
        foreach($A as $k){
            $arr_a[] = $k['percentage']*1;
        }
        foreach($B as $k){
            $arr_b[] = $k['percentage']*1;
        }
        foreach($C as $k){
            $arr_c[] = $k['percentage']*1;
        }
        foreach($D as $k){
            $arr_d[] = $k['percentage']*1;
        }
        foreach($E as $k){
            $arr_e[] = $k['percentage']*1;
        }

        echo json_encode(array(
            'success'=>true,
            'msg'=>'',
            'arr_a'=>$arr_a,
            'course_name'=>$course_name,
            'arr_b'=>$arr_b,
            'arr_c'=>$arr_c,
            'arr_d'=>$arr_d,
            'arr_e'=>$arr_e,
            'title' => $A['0']['ocode']
        ));

    }

    public function all(){
        if($_GET['school_name']){
            $school_name = $_GET['school_name'].__;
            $where ="course_id = '$_GET[course_name]' and ocode like '$school_name'";
        } else {
            $where ="reprottype = 'ocode' and course_id = '$_GET[course_name]'";
        }
        $all_as = M('test_once_reprot')->where($where."and grade_name = 'A'")->field('percentage,course_name,ocode')->select();
        $all_bs = M('test_once_reprot')->where($where."and grade_name = 'B'")->field('percentage')->select();
        $all_cs = M('test_once_reprot')->where($where."and grade_name = 'C'")->field('percentage')->select();
        $all_ds = M('test_once_reprot')->where($where."and grade_name = 'D'")->field('percentage')->select();
        $all_es = M('test_once_reprot')->where($where."and grade_name = 'E'")->field('percentage')->select();
        foreach($all_as as $k){
            $ocode[] = $k['ocode'];
        }
        foreach($all_as as $k){
            $all_a[] = $k['percentage']*1;
        }
        //var_dump($all_a);
        foreach($all_bs as $k){
            $all_b[] = $k['percentage']*1;
        }
        foreach($all_cs as $k){
            $all_c[] = $k['percentage']*1;
        }
        foreach($all_ds as $k){
            $all_d[] = $k['percentage']*1;
        }
        foreach($all_es as $k){
            $all_e[] = $k['percentage']*1;
        }


        echo json_encode(array('success'=>true,'ocode'=>$ocode,'all_a'=>$all_a,'all_b'=>$all_b,'all_c'=>$all_c,'all_d'=>$all_d,'all_e'=>$all_e));
    }

}