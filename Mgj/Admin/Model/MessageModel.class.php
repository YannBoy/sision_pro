<?php
namespace Admin\Model;
class MessageModel
{
    function get_class($area_bh,$ocode){
        $class = M('classaccessinfo')->where('class_bh ='.$area_bh.$ocode.' and userid ='.$_SESSION['admin']['id'])->find();
        if(count($class) > 0 && $class){
            $class_all = M('classinfo')->where('area_bh = '.$area_bh.' and ocode = '.$ocode)->field('class_name,class_bh')->select();
        } else {
            $where['class_bh'] = array('like', $area_bh.$ocode.'_____');
            $where['userid'] = $_SESSION['admin']['id'];
            $sm_class = M('classaccessinfo')->where($where)->select();
            $i = 0;
            foreach ($sm_class as $v) {
                $class_all[$i]['class_name'] = $v['class_name'];
                $class_all[$i]['class_bh'] = substr($v['class_bh'],-5);
                $i++;
            }
        }

        return $class_all;
    }

    function get_grade($map){
        $class = M('classaccessinfo')->where('class_bh ='.$map['area_bh'].$map['ocode'].' and userid ='.$_SESSION['admin']['id'])->find();
        if(count($class) >0 && $class){
            $class_all = M('classinfo')->where($map)->field('class_name,rec_id')->select();
        }else{
            $where['class_bh'] = array('like', $map['area_bh'].$map['ocode'].'_____');
            $where['userid'] = $_SESSION['admin']['id'];
            $all = M('classaccessinfo')->where($where)->field('class_bh')->select();
            foreach ($all as $v) {
                $all_c[] = substr($v['class_bh'],-5);
            }
            $map['class_bh'] = array('in',$all_c);
            $map['userid'] = $_SESSION['admin']['id'];
            $map['ocode'] = $map['ocode'];
            $map['area_bh'] = $map['area_bh'];
            $class_all = M('classinfo')->where($map)->field('class_name,rec_id')->select();
        }
        return $class_all;
    }

//    function ocode_type(){
//        $area_bh = substr($_SESSION['admin']['school_id'],0,6);
//        $ocode = substr($_SESSION['admin']['school_id'],-3);
//
//        if($type || $type == '1'){
////            $this_class = M('classaccessinfo')->where('userid = '.$_SESSION['admin']['id'])->field('class_bh')->select();
////            foreach ($this_class as $v) {
////                $this_area_bh = substr($v['class_bh'],0,6);
////                $this_ocode  = substr($v['class_bh'],6,3);
////                $new_ocode[] = $this_area_bh.$this_ocode;
////            }
////            $new_ocode = array_unique($new_ocode);
////            var_dump($new_ocode);
////            $manager = M('user')->find($_SESSION['admin']['id']);
////            $data = D('Excel')->school_area($manager);
//        }
//
//
//    }
}