<?php
namespace Admin\Controller;

use Admin\Model\ReportModel;
use Admin\Model\ApiModel;
class ReportController extends CommonController
{
    public $subjectName =array(
        '总分'    => 'total',
        '语文'    => 'chi',
        '英语'    => 'eng',
        '科学'    => 'sec',
        '数学'    => 'math',
        '社会'    => 'soc'
    );
    public function index ()
    {
        $exam = M('juan_scorelistinfo')->select();

        $this->assign('exam',$exam);
        $this->display();

    }

    public function ocode_rep ()
    {
        $type = 'schoolname';
        $subject = 'total';
        $info = new ApiModel();
        $info = $info->imgRepInfo($subject,I('get.id'),$type,I('get.ocode'));
        $i = 0;
        foreach ($info['schoolname'] as $items=>$item) {
            $data[$i]['schoolname'] = $item;
            foreach ($info['info'] as $k=>$v) {
                $data[$i]['schNum'] += $v[$i];
            }
            foreach ($info['info'] as $k=>$v) {
                $data[$i][$k] = sprintf("%.2f",$info['info'][$k][$i]/$data[$i]['schNum']*100);
            }
            $data[$i]['composite'] = sprintf("%.3f",5*$data[$i]['A']/100+4*$data[$i]['B']/100+3*$data[$i]['C']/100
                +2*$data[$i]['D']/100-3*$data[$i]['E']/100);
            $i++;
        }
        $listName = M('rep_examlist')->where('id ='.I('get.id'))->field('name,examtime')->find();
        $this->assign('Exam',$listName);
        $this->assign('info',$data);
        $this->display();

    }


    public function find_reprot()
    {
        $exist = D('User');
        $exist = $exist->get_reprot_info($_GET);
        echo json_encode(array('success'=>true,'all_a'=>$exist['a'],'all_b'=>$exist['b'],'all_c'=>$exist['c'],'all_d'=>$exist['d'],'all_e'=>$exist['e']));
    }
    public function class_rep()
    {
        $type = 'classname';
        $chsub = array_flip($this->subjectName);

        $subject = I('get.subject') ? $subject=I('get.subject') : 'total';
        $chsub = $chsub[$subject];
        $info = new ApiModel();
        $info = $info->imgRepInfo($subject,I('get.id'),$type,I('get.ocode'));
        $i = 0;
        foreach ($info['schoolname'] as $items=>$item) {
            $data[$i]['classname'] = $item;
            foreach ($info['info'] as $k=>$v) {
                $data[$i]['schNum'] += $v[$i];
            }
            foreach ($info['info'] as $k=>$v) {
                $data[$i][$k] = sprintf("%.2f",$info['info'][$k][$i]/$data[$i]['schNum']*100);
            }
            $data[$i]['composite'] = sprintf("%.3f",5*$data[$i]['A']/100+4*$data[$i]['B']/100+3*$data[$i]['C']/100
                +2*$data[$i]['D']/100-3*$data[$i]['E']/100);
            $i++;
        }
        $subjectName =[['key'=>'total','name'=>'总分'],['key'=>'chi','name'=>'语文'],['key'=>'eng','name'=>'英语'],['key'=>'sec','name'=>'科学'],['key'=>'math','name'=>'数学'],['key'=>'soc','name'=>'社会']];
        $this->assign('subname',$subjectName);
        $listName = M('rep_examlist')->where('id ='.I('get.id'))->field('name,examtime')->find();
        $know_w = ['know_id'=>I('get.id'),'sub'=>$subject];
        $know = M('rep_know_divide')->where($know_w)->select();
        $this->assign('know',$know);
        $this->assign('Exam',$listName);
        $this->assign('info',$data);
        $this->assign('chsub',$chsub);
        $this->display();

    }

    public function ocode_compare(){
        $data = D('User');
        $school = $data->get_compare($_GET);
        foreach ($school['a'] as $v) {
            $arr['a'][] = $v['percentage']*1;
        }
        foreach ($school['b'] as $v) {
            $arr['b'][] = $v['percentage']*1;
        }
        foreach ($school['c'] as $v) {
            $arr['c'][] = $v['percentage']*1;
        }

        foreach ($school['d'] as $v) {
            $arr['d'][] = $v['percentage']*1;
        }
        foreach ($school['e'] as $v) {
            $arr['e'][] = $v['percentage']*1;
        }

        echo json_encode(array('success'=>true,'all_a'=>$arr['a'],'all_b'=>$arr['b'],'all_c'=>$arr['c'],'all_d'=>$arr['d'],'all_e'=>$arr['e']));

    }

    function report(){

        //$exam_con = M('report_exam')->where('ocode = '.$_SESSION['admin']['school_id'])->find($_GET['id']);
        $report_info = new ReportModel();
        $class = $report_info->report_get_info($_GET)['ocode_list'];
       // var_export($class);
        $class_id = array();
        foreach ($class as $v) {
            $class_id[] = substr($v,-5);
        }
        //var_export($class_id);

        $where['class_bh'] = array('in',$class_id);
        $where['ocode'] = substr($_GET['ocode'],-3);
        $where['area_bh'] = substr($_GET['ocode'],0,6);
        $class_info = M('classinfo')->where($where)->field('class_name,area_bh,ocode,class_bh')->select();

        $data = M('test_once_reprot')->where('test_once_bh = '.$_GET['id'])->field('course_name,course_id')->order('course_id desc')->select();
        foreach ($data as $k=>$v) {
            $name[] = $v['course_name'];
            $id[] = $v['course_id'];
        }
        $name = array_values(array_unique($name));
        $id = array_values(array_unique($id));
        $i = 0;

        foreach ($name as $item) {
            $info[$i]['name'] = $name[$i];
            $info[$i]['id'] = $id[$i];
            $i++;
        }
        $this->assign('class_name',$info);
        $this->assign('class_info',$class_info);
        $this->display();
    }

    function report_info(){
        $this->display();
    }

    function oneindex(){
        $this->display('index');
    }



    function call_info()   //联考
    {

        $api = new ApiModel();
        $res = M('rep_examlist')->where('id = '.I('get.id'))->find();
        $res['schoolname']=I('get.schoolname');
        if(I('get.state') == 0)
        {
            $type = 'classname';
        }else
        {
            $type = 'schoolname';
        }
        $this->assign('res',$res);
        $this->assign('chi',$api->call_chi($res,$type,'chi')['info']);
        $this->assign('chi_range',$api->call_chi($res,$type,'chi'));
        $this->assign('math',$api->call_chi($res,$type,'math')['info']);
        $this->assign('math_range',$api->call_chi($res,$type,'math'));
        $this->assign('sec',$api->call_chi($res,$type,'sec')['info']);
        $this->assign('sec_range',$api->call_chi($res,$type,'sec'));
        $this->assign('eng',$api->call_chi($res,$type,'eng')['info']);
        $this->assign('eng_range',$api->call_chi($res,$type,'eng'));
        $this->assign('total',$api->call_chi($res,$type,'total')['info']);
        $this->assign('total_range',$api->call_chi($res,$type,'total'));
        $this->display();
    }




    function createpro()
    {
        $num = I('get.num');
        $num = !empty($num) ? $num : 15;
        $name = I('get.name');
        if(!empty($name)){
            $where['name']=array('LIKE','%'.$name .'%');
        }
        $username = I('get.username');
        if(!empty($username)){
            $where['name']=array('LIKE','%'.$username .'%');
        }
        $type = I('get.state');

        if($type == '0' || $type == '1')
        {
            $where['state']=array('eq',$type);
        }
        //创建分页对象
        $count = M('rep_examlist')->where($where)->count();

        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();
        $exam = M('rep_examlist')->where($where)->limit($limit)->order('examtime desc,id')->select();

        $this->assign('exam',$exam);
        $this->assign('page',$show);
        $this->assign('num',$num);
        $this->assign('name',$name);
        $this->assign('type',$type);
        $this->assign('username',$username);
        $this->display('Report/createpro');
    }

    function examcreate()
    {
        $username = M('user')->field('relname')->find(session('admin.id'))['relname'];
        $data = array(
            'name'  => I('post.name'),
            'examtime'  => I('post.exam_time'),
            'state'     => I('post.state'),
            'userid'    => session('admin.id'),
            'ocode'     => session('admin.school_id'),
            'regtime'   => date('Y-m-d H:i:s'),
            'schoolname'=> I('post.schoolname'),
            'username'  => $username
        );
        $res = M('rep_examlist')->add($data);
        $res ? $this->successajax() : $this->failajax('添加失败,稍后再试');
    }

    function saveParameter()
    {
        $res = I('post.');
        $result = M('rep_examlist')->save($res);
        if($result ==1 || $result == 0){
            $this->successajax();
        }else{
            $this->failajax('网络繁忙,稍后再试');
        }
    }

    function delParameter()
    {
        $id = I('post.id');
        $res = M('rep_examlist')->delete($id);
        $delinfo = M('school_call')->where('pid = '.$id)->delete();
        $res ? $this->successajax() : $this->failajax('网络繁忙,稍后再试');
    }

    function delProInfo()
    {
        $res = array(
            'data'  => 0,
            'id'    => I('post.id')
        );
        $m = M('rep_examlist');
        $m->startTrans();   //开启事务
        $res =$m->save($res);
        $del = M('school_call')->where('pid ='.I('post.id'))->delete();
        if($res && $del){
            $m->commit();
            $this->successajax();
        }else{
            $m->rollback();
            $this->failajax('网络繁忙,稍后再试');
        }
    }

    function oneonecall()
    {
        if(I('get.state') == 1)
        {
            $num = I('get.num');
            $num = !empty($num) ? $num : 12;
            $where['state'] = 0;
            $where['data']  = 1;
            $name = I('get.name');
            if(!empty($name)){
                $where['name']=array('LIKE','%'.$name .'%');
            }
            $count = M('rep_examlist')->where($where)->count();

            $page = new \Think\Page($count,$num);
            //获得limit参数
            $limit = $page->firstRow.','.$page->listRows;
            $show = $page->show();
            $exam = M('rep_examlist')->where($where)->order('examtime desc')->limit($limit)->order('examtime desc,id')->select();
            $this->assign('exam',$exam);
            $this->assign('api','1');
            $this->assign('page',$show);
            $this->assign('num',$num);
            $this->assign('setpro','1');
        }
        $this->assign('state',0);

        $this->display();
    }




    function setmanyexam()   //保存联考的权限
    {
        $schoolname = explode(',',rtrim(I('post.sch'),','));
        $i = 0;
        foreach ($schoolname as $item=>$v) {
            $data[$i]['schoolname'] = $v;
            $data[$i]['pid'] = I('post.id');
            $i++;
        }
        $exam  = array('id'=>I('post.id'),'share'=>'1');
        M('rep_examlist')->save($exam);
        $m = M('rep_many_exam');
        $m->startTrans();
        $delOldList = $m->where('pid ='.I('post.id'))->delete();
        $addManyList = M('rep_many_exam')->addAll($data);
        if($delOldList || $addManyList)
        {
            $m->commit();
            $this->successajax();
        }
        else
        {
            $m->rollback();
            $this->failajax('网络繁忙,稍后再试');
        }

    }

    function subinfo()
{
    $type = 'schoolname';
    $chsub = array_flip($this->subjectName);
    $subject = I('get.subject') ? $subject=I('get.subject') : 'total';
    $chsub = $chsub[$subject];
    $info = new ApiModel();
    $info = $info->imgRepInfo($subject,I('get.id'),$type,I('get.ocode'));
    $i = 0;
    foreach ($info['schoolname'] as $items=>$item) {
        $data[$i]['schoolname'] = $item;
        foreach ($info['info'] as $k=>$v) {
            $data[$i]['schNum'] += $v[$i];
        }
        foreach ($info['info'] as $k=>$v) {
            $data[$i][$k] = sprintf("%.2f",$info['info'][$k][$i]/$data[$i]['schNum']*100);
        }
        $data[$i]['composite'] = sprintf("%.3f",5*$data[$i]['A']/100+4*$data[$i]['B']/100+3*$data[$i]['C']/100
            +2*$data[$i]['D']/100-3*$data[$i]['E']/100);
        $i++;
    }
    $listName = M('rep_examlist')->where('id ='.I('get.id'))->field('name,examtime')->find();
    $subjectName =[['key'=>'total','name'=>'总分'],['key'=>'chi','name'=>'语文'],['key'=>'eng','name'=>'英语'],['key'=>'sec','name'=>'科学'],['key'=>'math','name'=>'数学'],['key'=>'soc','name'=>'社会']];
    $know_w = ['know_id'=>I('get.id'),'sub'=>$subject];

    $know = M('rep_know_divide')->where($know_w)->select();

    $this->assign('know',$know);
    $this->assign('subname',$subjectName);
    $this->assign('Exam',$listName);
    $this->assign('info',$data);

    $this->assign('chsub',$chsub);
    $this->display();
}

    function knowledge()
    {
        $num = I('get.num');
        $num = !empty($num) ? $num : 15;
        $name = I('get.name');
        if(!empty($name)){
            $where['name']=array('LIKE','%'.$name .'%');
        }
        $username = I('get.username');
        if(!empty($username)){
            $where['name']=array('LIKE','%'.$username .'%');
        }
        $type = I('get.state');

        if($type == '0' || $type == '1')
        {
            $where['state']=array('eq',$type);
        }
        //创建分页对象
        $count = M('rep_examlist')->where($where)->count();
        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();
        $exam = M('rep_examlist')->where($where)->limit($limit)->order('examtime desc,id')->select();
        $this->assign('exam',$exam);
        $this->assign('page',$show);
        $this->assign('num',$num);
        $this->display();
    }

    function class_info()
    {
        $type = 'classname';
        $chsub = array_flip($this->subjectName);

        $subject = I('get.subject') ? $subject=I('get.subject') : 'total';
        $chsub = $chsub[$subject];
        $info = new ApiModel();
        $info = $info->imgRepInfo($subject,I('get.id'),$type,I('get.ocode'));
        $i = 0;
        foreach ($info['schoolname'] as $items=>$item) {
            $data[$i]['classname'] = $item;
            foreach ($info['info'] as $k=>$v) {
                $data[$i]['schNum'] += $v[$i];
            }
            foreach ($info['info'] as $k=>$v) {
                $data[$i][$k] = sprintf("%.2f",$info['info'][$k][$i]/$data[$i]['schNum']*100);
            }
            $data[$i]['composite'] = sprintf("%.3f",5*$data[$i]['A']/100+4*$data[$i]['B']/100+3*$data[$i]['C']/100
                +2*$data[$i]['D']/100-3*$data[$i]['E']/100);
            $i++;
        }
        $subjectName =[['key'=>'total','name'=>'总分'],['key'=>'chi','name'=>'语文'],['key'=>'eng','name'=>'英语'],['key'=>'sec','name'=>'科学'],['key'=>'math','name'=>'数学'],['key'=>'soc','name'=>'社会']];
        $this->assign('subname',$subjectName);
        $listName = M('rep_examlist')->where('id ='.I('get.id'))->field('name,examtime')->find();
        $know_w = ['know_id'=>I('get.id'),'sub'=>$subject];
        $know = M('rep_know_divide')->where($know_w)->select();

        $stu['pid'] = I('get.id');
        $stu['schoolname'] = I('get.schoolname');
        $stu['classname'] = I('get.classname');

        $students = M('school_call')->where($stu)->select();
        $this->assign('students',$students);
        $this->assign('know',$know);
        $this->assign('Exam',$listName);
        $this->assign('info',$data);
        $this->assign('chsub',$chsub);
        $this->display();
    }

    function student_rep()
    {
        $usernum = I('get.usernum');
        $id =  I('get.id');
        $subjectName =[['key'=>'total','name'=>'总分'],['key'=>'chi','name'=>'语文'],['key'=>'eng','name'=>'英语'],['key'=>'sec','name'=>'科学'],['key'=>'math','name'=>'数学'],['key'=>'soc','name'=>'社会']];
        $this->assign('subname',$subjectName);
        $listName = M('rep_examlist')->where('id ='.$id)->field('name,examtime')->find();
        $listName['username'] = M('school_call')->where('pid ='.$id.' and usernum='.$usernum)->find()['username'];
        $this->assign('Exam',$listName);
        $this->display();
    }



}