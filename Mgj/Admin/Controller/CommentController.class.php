<?php
namespace Admin\Controller;
use Admin\Model;
use Think\Controller;
use Admin\Model\MessageModel;
use Admin\Model\ApiModel;
class CommentController extends Controller
{
    public function _initialize()
    {
        $tel = session('admin.tel');
        $res = 0;
        if(M('user_supuser')->where('uid ='.$tel)->find())
        {
            $res = 1;
        }
        $this->assign('user_sup',$res);
    }
//    function com(){
//        $data = M('user')->field('id')->select();
//        $i = 0;
//        $d = 25569;
//        $t = 24 * 60 * 60;
//        foreach ($data as $item=>$v) {
//
//                $res['uid'] = $v['id'];
//                $res['group_id'] = '33';
//                echo "&nbsp;";
//                $res['ocode'] = '330183001';
//                M('user_auth_group_access')->add($res);
//                echo $v['id'];
//
//
//        }
//
//    }
    function textpng()
    {
        $this->display('Report/textpng');
    }
    function test2()
    {
        $type = 'eng';
        $where['pid'] = 132;
        $where['subtype'] = $type;
        $data = M('rep_subdate')->where($where)->field('subval,id')->select();
        foreach ($data as $k=>$v) {
            $news = explode('|','|'.$v['subval']) ;
            var_export($news);
            $datas = array(
                'subval'    =>substr(implode('|',$news),1),
                'id'        =>$v['id']
            );
            //M('rep_subdate')->save($datas);
        }

    }
    function getexcel()
    {
        $savePath = './Public/Uploads/Excel/';

        import("Common.Org.PHPExcel.Shared.Date");

        $res = new Model\ExcelModel();
        $res = $res->reader_excel($savePath . '332.xlsx');
        foreach ($res as $k=>$v) {
            $username = $v[0];
            $classbh = $v[4];
            $where['STU_NAME'] = $username;
            $where['STU_BANJI'] = array('like',"%$classbh");
            $info = M('stuentinfo')->where($where)->find();
            $info['id_number'] = $v[1];
            $info['family_name'] = $v[3];
            $info['stu_place'] = $v[2];
            //M('stuentinfo')->save($info);
        }

    }


    function date1()
    {
        $type = 'sec';
        $where['pid'] = 132;
        $where['subtype'] = $type;
        $data = M('rep_subdate')->where($where)->field('subval')->select();
        foreach ($data as $k=>$v) {
            $news = explode('|','|'.$v['subval']) ;
            foreach ($news as $items=>$item) {
                if(($item || $item== '0') && $item != '——')
                {
                    $datas[$items][] = $item;
                }
            }
        }
        foreach ($datas as $k=>$v) {
            $info[$k] = max($v);
            $arg[$k] = array_sum($v)/count($v);
        }

        foreach ($info as $k=>$v) {
            $res = $arg[$k]/$info[$k];
            if($res > 0.8)
            {
                $sim1 .= $k.',';
            }elseif ($res >0.6 && $res <= 0.8)
            {
                $sim2 .=$k.',';
            }elseif ($res >0.4 && $res <= 0.6)
            {
                $sim3 .=$k.',';
            }elseif ($res >0.2 && $res <= 0.4)
            {
                $sim4 .=$k.',';
            }else{
                $sim5 .=$k.',';
            }
        }
        $newInfos = array(
            array(
                'pid' =>132,
                'val' =>$sim1,
                'type'=>'sim1',
                'sub'=>$type
            ),
            array(
                'pid' =>132,
                'val' =>$sim2,
                'type'=>'sim2',
                'sub'=>$type
            ),
            array(
                'pid' =>132,
                'val' =>$sim3,
                'type'=>'sim3',
                'sub'=>$type
            ),
            array(
                'pid' =>132,
                'val' =>$sim4,
                'type'=>'sim4',
                'sub'=>$type
            ),
            array(
                'pid' =>132,
                'val' =>$sim5,
                'type'=>'sim5',
                'sub'=>$type
            )
        );
        M('rep_difficulty')->addAll($newInfos);
    }
//    function test22()
//    {
//        $data = M('test')->select();
//        var_export('11');
//
//        foreach ($data as $k=>$v) {
//            $where = array(
//                'schoolname' => $v['ocode'],
//                'username'  => $v['user_name']
//            );
//            $res = M('school_call')->where($where)->find();
//            if($res && count($res)>0)
//            {
//                $new = array(
//                    'total' => $v['total'],
//                    'sec'   => $v['sec'],
//                    'soc'   => $v['soc'],
//                    'chi'   => $v['chi'],
//                    'math'  => $v['math'],
//                    'eng'   => $v['eng'],
//                    'schoolname'  => $v['ocode'],
//                    'pid'   => 133,
//                    'classname' => $res['classname'],
//                    'ocode' => $res['ocode'],
//                    'usernum'   => $res['usernum'],
//                    'username'  => $v['user_name']
//
//                );
//
//               M('school_call')->add($new);
//            }
//
//        }
//
//    }
    public $subjectName =array(
        '语文'    => 'chi',
        '英语'    => 'eng',
        '科学'    => 'sec',
        '数学'    => 'math',
        '社会'    => 'soc',
        '总分'    => 'total',
    );
    public function index()
    {
        $area_bh = substr($_SESSION['admin']['school_id'],0,6);
        $ocode = substr($_SESSION['admin']['school_id'],-3);
        $ocode_name = M('shoollist')->where('area_bh ='.$area_bh.' and ocode ='.$ocode)->field('ocode_name')->find()['ocode_name'];

        $this->assign('ocode_name',$ocode_name);
        $arr = D('User')->get_school_nav();
        $this->assign('data_nav',$arr);
        $id_s = $_SESSION['admin']['school_id'];

        $map['userid'] = $_SESSION['admin']['id'];
        $map['class_bh'] = array('like',$id_s.'%');
        $this_sch = M('classaccessinfo')->where($map)->find();
        $first = substr($_SESSION['admin']['school_id'],0,6);
        $foot = substr($_SESSION['admin']['school_id'],-3);
        if(!$this_sch || count($this_sch) == 0){
            $this->error('没有权限');
            $like['class_bh'] = array('like',$_SESSION['admin']['school_id'].'_____');
            $like['userid'] = $_SESSION['admin']['id'];
            $self_class = M('classaccessinfo')->where($like)->field('class_bh')->select();
            foreach ($self_class as $k=>$v) {
                $my_class[] = substr($v['class_bh'],-5);
            }
            $where['STU_BANJI'] = array('in',$my_class);
            $find_class['area_bh'] = $first;
            $find_class['ocode'] = $foot;
            $find_class['class_bh'] = array('in',$my_class);

            $class_bh1 = M('classinfo')->where($find_class)->field('class_bh,class_name')->select();
        }else{
            $class_bh1 = M('classinfo')->where('area_bh ='.$first.' and ocode = '.$foot)->field('class_bh,class_name')->select();
        }

        $exist = D('User');
        $exist = $exist->get_area($_SESSION['admin']['id']);
        $num = I('get.num');
        $num = !empty($num) ? $num : 50;
        $keyword = I('get.keyword');
        $class_bh = I('get.class_bh');
        if(!empty($keyword)){
            $where['STU_NAME']=array('LIKE','%'.$keyword .'%');
        }
        if(!empty($class_bh)){
            $where['STU_BANJI'] = $class_bh;
        }

        $where['AREAOCODE'] = $first;
        $where['OCODE'] = $foot;
        $model = M('stuentinfo');
        $count = $model->where($where)->count();	//查询满足要求的总记录数
        //创建分页对象
        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();
        //获取当前页码下的数据
        $data = $model->order('STU_BANJI,convert(STU_NAME using gb2312) ASC')->where($where)->limit($limit)->select();
        $i=0;
        foreach ($data as $item) {
            $map['ocode'] = $item['ocode'];
            $map['area_bh'] = $item['areaocode'];
            $map['class_bh'] = $item['stu_banji'];
            $class = M('classinfo')->where($map)->field('class_name')->find()['class_name'];
            $data[$i]['class_name'] = $class;
            $i++;
        }
        $this->assign('count',$count);
        $this->assign('class_bh1',$class_bh1);
        $this->assign('page',$show);
        $this->assign('num',$num);
        $this->assign('keyword',$keyword);
        $this->assign('list',$data);
        $this->display('User/index');
    }


    function excelTime($days, $time=false){
        if(is_numeric($days)){
            //based on 1900-1-1
            $jd = GregorianToJD(1, 1, 1970);
            $gregorian = JDToGregorian($jd+intval($days)-25569);
            $myDate = explode('/',$gregorian);
            $myDateStr = str_pad($myDate[2],4,'0', STR_PAD_LEFT)
                ."-".str_pad($myDate[0],2,'0', STR_PAD_LEFT)
                ."-".str_pad($myDate[1],2,'0', STR_PAD_LEFT)
                .($time?" 00:00:00":'');
            return $myDateStr;
        }
        return $days;
    }

    public function excel(){

        if (!empty ($_FILES ['file_stu'] ['name'])) {
            $tmp_file = $_FILES ['file_stu'] ['tmp_name'];
            $file_types = explode(".", $_FILES ['file_stu'] ['name']);
            $file_type = $file_types [count($file_types) - 1];

            /*判别是不是.xls文件，判别是不是excel文件*/
            if (strtolower($file_type) != "xlsx") {
                $this->error('不是Excel文件，重新上传');
            }

            /*设置上传路径*/
            $savePath = './Public/Uploads/Excel/';


            /*以时间来命名上传的文件*/
            $str = date('Ymdhis');
            $file_name = $str . "." . $file_type;
            /*是否上传成功*/
            if (!copy($tmp_file, $savePath . $file_name)) {
                $this->error('上传失败');
            }
            /*
             *

      *对上传的Excel数据进行处理生成编程数据,这个函数会在下面第三步的ExcelToArray类中

     注意：这里调用执行了第三步类里面的read函数，把Excel转化为数组并返回给$res,再进行数据库写入

    */
            import("Common.Org.PHPExcel.Shared.Date");

            $res = new Model\ExcelModel();
            $res = $res->reader_excel($savePath . $file_name);
            /*对生成的数组进行数据库的写入*/

            foreach ( $res as $k => $v )
            {
                $data = '';
                foreach ($res[0] as $re=>$r) {
                    //var_export($v);
                    if($r){
                        $data  .= $r.":".$v[$re].',';
                    }
                };
                $con['content'] = $v['1'].'家长您好,'.$_POST['tips'].'  '.$v['1']. '的成绩为 '.$data;
                $con['tel'] = $v['0'] ? $v['0'] : 0;
                $con['name'] = $v['1'];
                $con['ocode'] = '330183001';
                $con['uid'] = $_SESSION['admin']['id'];
                $con['sms_type'] = 4;
                $con['sendtime'] = $_POST['send_time'];
                $con['regtime'] = date('Y-m-d H:i:s');
                $result = M ( 'message' )->add ( $con );
                if (! $result)
                {
                    echo ($con[]=$v['1'].'添加失败');
                    echo '&nbsp;';
                }else{

                    echo($con[]=$v['1'].'添加成功,等待发送');
                    echo '&nbsp;';
                }
            }
            echo "<button> <a href='javascript:void(0)'  onclick='window.history.go(-1);'>返回上一页</a></button>";
        }

    }


    public function excel_teacher(){
        if (!empty ($_FILES ['file_stu'] ['name'])) {
            $tmp_file = $_FILES ['file_stu'] ['tmp_name'];
            $file_types = explode(".", $_FILES ['file_stu'] ['name']);
            $file_type = $file_types [count($file_types) - 1];


            /*判别是不是.xls文件，判别是不是excel文件*/
            if (strtolower($file_type) != "xlsx") {
                $this->error('不是Excel文件，重新上传');
            }

            /*设置上传路径*/
            $savePath = './Public/Uploads/Excel/';


            /*以时间来命名上传的文件*/
            $str = date('Ymdhis');
            $file_name = $str . "." . $file_type;
            /*是否上传成功*/
            if (!copy($tmp_file, $savePath . $file_name)) {
                $this->error('上传失败');
            }
            /*

      *对上传的Excel数据进行处理生成编程数据,这个函数会在下面第三步的ExcelToArray类中

     注意：这里调用执行了第三步类里面的read函数，把Excel转化为数组并返回给$res,再进行数据库写入

    */

            $res = new Model\ExcelModel();
            $res = $res->reader_excel($savePath . $file_name);
            $i = 1;
            /*对生成的数组进行数据库的写入*/
            foreach ( $res as $k => $v )
            {
                $data['tea_name'] = $v[0];
                $data['tea_mobile'] = $v[1];
                $data['area_bh'] = 330183;
                $data['ocode'] = $v[2];
                $data['reg_time'] = date('Y-m-d');
                M('teacherinfo')->add($data);
            }
        }

    }

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
        $upload->saveName = mt_rand().$_FILES['Filedata']['name'];
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
        $upload->saveName = mt_rand().$_FILES['Filedata']['name'];
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
        if($data)  $this->successajax('',$data);
    }

    public function get_teacher_group1(){
        $data = M('school_oa_tea')->where('gid = '.$_POST['pid'])->select();
        if($data) $this->successajax('',$data);
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
        if($data['old'] == '1'){
            $path = M('oa_upload_file')->where('file_id = '.$id)->field('srcname')->find();
            $path_r = './Oa_file/filesys/'.$path['srcname'].'/';
            $info=$this->getFiles($path_r);
            $i = 0;
            foreach ($info as $k=>$v) {
                $notice_url[$i]['path'] = iconv('gb2312','utf-8','/Oa_file/filesys/'.$path['srcname'].'/'.$v);
                $notice_url[$i]['name'] = iconv('gb2312','utf-8',$v);
                $i++;
            }

            echo json_encode(array(array('success'=>true,'data'=>$data,'src'=>$notice_url,'old'=>'1')));
        }else{
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
        $userid = session('admin.id');
        $fid = I('post.id/d',0);
        $tel = M('user')->where("id = $userid")->field('username,relname')->find();
        $where = array(
            'tel' =>$tel['username'],
            'fid' =>$fid
        );
        $level = M('school_people')->where($where)->field('level')->find()['level'];
        $level = $level+1;
        $tel = I('post.tel',0);
        $name = I('post.name','');
        $allIds = M('school_people')->where("fid = $fid")->field('tel')->select();
        if($allIds && count($allIds)>0)
        {
            foreach ($allIds as $k=>$v) {
                $shareAll[] = $v['tel'];
            }
        }
        if($tel &&  count($tel)>0)
        {
            $nums = count($tel);
            for($i=0;$i<$nums;$i++)
            {
                $createInfos[$tel[$i]] = $name[$i];
            }
        }
        $newInfo = array_values(array_diff($tel,$shareAll));
        for($i = 0; $i < count($newInfo); $i++){
            $data[$i] = array(
                'tel' =>$newInfo[$i],
                'name'=>$createInfos[$newInfo[$i]],
                'fid'=>$fid,
                'complete'=> '1',
                $data[$i]['level'] = $level
            ) ;
            $te[$i] = array(
                'tel' =>   $newInfo[$i],
                'name'=>   $createInfos[$newInfo[$i]],
                'sendtime'=> date('Y-m-d H:i:s'),
                'regtime'=>  date('Y-m-d H:i:s'),
                'table_id'=> $fid,
                'table_name'=> 'oa_file',
                'sms_type'=>'1',
                'uid'   => session('admin.id'),
                'ocode' => session('admin.school_id'),
                'send_name' => $tel['relname']
            );
        }
        $school_people = M('school_people');
        $message = M('message');
        $school_people->startTrans();   //开启事务
        $res1 = $school_people->addAll($data);
        $res2 = $message->addAll($te);
        if($res1 && $res2)
        {
            $school_people->commit();
            $this->successajax();
        }else{
            $school_people->rollback();
            $this->failajax('网络繁忙');
        }

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
        //$file = end(explode('.', $_FILES['Filedata']['name']));
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     5125728 ;// 设置附件上传大小
        $upload->rootPath  =     './Public/Uploads/img/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        $upload->autoSub  = true;
        $upload->subName  = array('date','Ymd');
        $upload->saveName = '';
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
                'srctitle' => $_FILES['Filedata']['name'],
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
        $data['do_time'] = date('Y-m-d');
        $id = M('email')->add($data);
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
        $notice = M('notice')->field('title,content,allnum,old')->find($_POST['id']);

        $map['id'] = $_POST['id'];
        $map['allnum'] = $notice['allnum'] + 1;
        M('notice')->save($map);
        if($notice['old'] == '1'){
            $path = M('notice_upload_file')->where('file_id ='.$_POST['id'])->field('srcname')->find();
            $path_r = './Oa_file/notice/'.$path['srcname'].'/';
            $info=$this->getFiles($path_r);
            $i = 0;
            foreach ($info as $k=>$v) {
                $notice_url[$i]['path'] = iconv('gb2312','utf-8','/Oa_file/notice/'.$path['srcname'].'/'.$v);
                $notice_url[$i]['name'] = iconv('gb2312','utf-8',$v);
                $i++;
            }

            echo json_encode(array(array('success'=>true,'notice'=>$notice,'file'=>$notice_url,'old'=>'1')));
        }else{
            $file = M('notice_upload_file')->where('file_id ='.$_POST['id'])->field('id,imgtime,name,srcname')->select();
            echo json_encode(array(array('success'=>true,'notice'=>$notice,'file'=>$file)));
        }


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
        $table = I('post.table','');
        $id = I('post.id/d',0);
        if(M($table)->delete($id)){
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
                }else{
                    $send = new ApiModel();
                    $send->sendMsg($allteacher[$i]['tea_mobile'],$_POST['content'].' '.$send_name);
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
                else{
                    $send = new ApiModel();
                    $send->sendMsg($tel[$i],$_POST['content'].' '.$send_name);
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

        $notice = M('email')->field('title,content,allnum,old')->find($_POST['id']);
        if($notice['old'] == '1'){
            $path = M('email_upload_file')->where('file_id = '.$_POST['id'])->field('srcname')->find();
            $path_r = './Oa_file/msg/'.$path['srcname'].'/';
            $info=$this->getFiles($path_r);
            $i = 0;
            foreach ($info as $k=>$v) {
                $file[$i]['path'] = iconv('gb2312','utf-8','/Oa_file/msg/'.$path['srcname'].'/'.$v);
                $file[$i]['name'] = iconv('gb2312','utf-8',$v);
                $i++;
            }
            $old = '1';
        }else{
            $file = M('email_upload_file')->where('file_id ='.$_POST['id'])->field('id,imgtime,name,srcname')->select();
        }
        $map['id'] = $_POST['id'];
        $map['allnum'] = $notice['allnum'] + 1;
        M('email')->save($map);
        echo json_encode(array(array('success'=>true,'notice'=>$notice,'file'=>$file,'old'=>$old)));
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

        $data = M('stuentinfo')->where($map)->field('stu_name,rec_id,vidflag')->order("convert(stu_name using gb2312) ASC")->select();
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
             else
            {
                    $send = new ApiModel();
                    $send->sendMsg($v['stu_mobile'],$_POST['content']. '  ' .$_POST['identity']);
                }
        }
        $this->successajax('发送成功');
    }


    public function get_group_teacher(){
        $data = M('school_oa_tea')->where('gid = '.$_POST['gid'])->field('name,tel')->order("convert(name using gb2312) ASC")->select();

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
            else
            {
                    $send = new ApiModel();
                    $send->sendMsg($v['tel'],$_POST['content'].'  '.$_POST['identity']);
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

    function add_news_people()
    {

        $group_name = M('schoolgroup')->where('id = '.$_POST['group_id'])->find()['name'];
        $res  = array(
            'group_name' => '【'.$group_name.'】',
            'content' => $_POST['content'],
            'start_time' => $_POST['start_time'],
            'end_time'   => $_POST['end_time'],
            'ocode'     => $_SESSION['admin']['school_id'],
            'group_id'  => $_POST['group_id']
        );
        $result = M('school_oa_plan')->add($res);
        if($result)
        {
            $tels = M('school_oa_tea')->where('gid = '.$_POST['group_id'])->field('tel')->select();
            if($tels && count($tels) > 0){
                foreach ($tels as $items=>$item) {
                    $data = array('plan_id'=>$result,'tel'=>$item['tel']);
                    M('school_plan_people')->add($data);
                }
                $this->successajax();
            }
        }
        else
        {
            $this->failajax();
        }

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
            else
            {
                    $send = new ApiModel();
                    $send->sendMsg($item['tel'],$_POST['content']. ' '.$_POST['identity']);
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

/*
 *获取某个目录下所有文件
  *@param $path文件路径
  *@param $child 是否包含对应的目录
 */
    public  function getFiles($path,$child=false){
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

    public function scanfiles(&$files,$path,$childDir=false){
        $dp = dir($path);
        while ($file = $dp ->read()){
            if($file !="." && $file !=".."){
                if(is_file($path.$file)){//当前为文件
                    $files[]= $file;
                }else{//当前为目录
                    $this->scanfiles($files[$file],$path.$file.DIRECTORY_SEPARATOR,$file);
                }
            }
        }
        $dp->close();
    }
    function info_get_teacher(){
        $data = M('teacherinfo')->where('vidflag = 0 and area_bh ='.substr($_SESSION['admin']['school_id'],0,6).' and ocode = '.substr($_SESSION['admin']['school_id'],-3))->field('tea_mobile,tea_name')->select();
        $have = M('school_oa_tea')->where('gid = '.$_POST['gid'])->field('tel')->select();
        foreach ($have as $k=>$v){
            $have_tea[] = $v['tel'];
        }
        $i = 0;
        foreach ($data as $k=>$v) {
            if(in_array($v['tea_mobile'],$have_tea)){
                $then[$i]['tea_mobile'] = $v['tea_mobile'];
                $then[$i]['tea_name'] = $v['tea_name'];
                $then[$i]['state'] = '1';
            }else{
                $then[$i]['tea_mobile'] = $v['tea_mobile'];
                $then[$i]['tea_name'] = $v['tea_name'];
                $then[$i]['state'] = '0';
            }
            $i++;
        }
        $this->successajax('',$then);
    }

    function add_info_teac(){
        $i = 0;
        foreach ($_POST['tel'] as $k=>$v) {
            $data['gid'] = $_POST['gid'];
            $data['tel'] = $_POST['tel'][$i];
            $data['name'] = $_POST['name'][$i];
            M('school_oa_tea')->add($data);
            $i++;
        }
        $this->successajax();
    }

    function rep_select(){
        $rep = new Model\ReportModel();
        $data = $rep->rep_get_info($_POST);
        //var_export($data);
        foreach ($data['a'] as $v) {
            $arr['a'][] = $v['per_rensun']*1;
        }
        foreach ($data['b'] as $v) {
            $arr['b'][] = $v['per_rensun']*1;
        }
        foreach ($data['c'] as $v) {
            $arr['c'][] = $v['per_rensun']*1;
        }

        foreach ($data['d'] as $v) {
            $arr['d'][] = $v['per_rensun']*1;
        }
        foreach ($data['e'] as $v) {
            $arr['e'][] = $v['per_rensun']*1;
        }

        //-------
        foreach ($data['ex_a'] as $v) {
            $arr['ex_a'][] = $v['per_rensun']*1;
        }
        foreach ($data['ex_b'] as $v) {
            $arr['ex_b'][] = $v['per_rensun']*1;
        }
        foreach ($data['ex_c'] as $v) {
            $arr['ex_c'][] = $v['per_rensun']*1;
        }

        foreach ($data['ex_d'] as $v) {
            $arr['ex_d'][] = $v['per_rensun']*1;
        }
        foreach ($data['ex_e'] as $v) {
            $arr['ex_e'][] = $v['per_rensun']*1;
        }

        echo json_encode(array('success'=>true,'all_a'=>$arr['a'],'all_b'=>$arr['b'],'all_c'=>$arr['c'],'all_d'=>$arr['d'],'all_e'=>$arr['e'],'text'=>$data['text'],
            'type'=>$data['type'],'ex_a'=>$arr['ex_a'],'ex_b'=>$arr['ex_b'],'ex_c'=>$arr['ex_c'],'ex_d'=>$arr['ex_d'],'ex_e'=>$arr['ex_e'],'course_name'=>$data['course_name'],'exam_info'=>$data['exam_info'],'class_name'=>$data['class_name']));
    }

    function rep_ocode_select()
    {
        $rep = new Model\ReportModel();
        $data = $rep->rep_get_ocodeinfo($_POST);
        //var_export($data);
        foreach ($data['a'] as $v) {
            $arr['a'][] = $v['per_rensun']*1;
        }
        foreach ($data['b'] as $v) {
            $arr['b'][] = $v['per_rensun']*1;
        }
        foreach ($data['c'] as $v) {
            $arr['c'][] = $v['per_rensun']*1;
        }

        foreach ($data['d'] as $v) {
            $arr['d'][] = $v['per_rensun']*1;
        }
        foreach ($data['e'] as $v) {
            $arr['e'][] = $v['per_rensun']*1;
        }

        //-------
        foreach ($data['ex_a'] as $v) {
            $arr['ex_a'][] = $v['per_rensun']*1;
        }
        foreach ($data['ex_b'] as $v) {
            $arr['ex_b'][] = $v['per_rensun']*1;
        }
        foreach ($data['ex_c'] as $v) {
            $arr['ex_c'][] = $v['per_rensun']*1;
        }

        foreach ($data['ex_d'] as $v) {
            $arr['ex_d'][] = $v['per_rensun']*1;
        }
        foreach ($data['ex_e'] as $v) {
            $arr['ex_e'][] = $v['per_rensun']*1;
        }

        echo json_encode(array('success'=>true,'all_a'=>$arr['a'],'all_b'=>$arr['b'],'all_c'=>$arr['c'],'all_d'=>$arr['d'],'all_e'=>$arr['e'],'text'=>$data['text'],
            'type'=>$data['type'],'ex_a'=>$arr['ex_a'],'ex_b'=>$arr['ex_b'],'ex_c'=>$arr['ex_c'],'ex_d'=>$arr['ex_d'],'ex_e'=>$arr['ex_e'],'course_name'=>$data['course_name'],'exam_info'=>$data['exam_info'],'class_name'=>$data['class_name']));

    }

    //邮箱正则验证
    function email_pre(){
        $email = '1257929956@qq.com';
        $pre_email = '/^([0-9a-zA-Z-_\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i';
        if(preg_match($pre_email,$email)){
            echo 'true';
        }
        else{
            echo 'false';
        }
    }

    function get_myself_plan(){
        //var_export(strtotime(date('Y-m-d')));
        $row = M('user_calendar')->where('uid = '.$_SESSION['admin']['id'].' and type = 0')->select();
        foreach ($row as $k=>$v) {
            $is_allday = $v['allday']==1?true:false;
            $data[] = array(
                'id'    => $v['id'],
                'title' => $v['title'],
                'start' => date('Y-m-d H:i',$v['startdate']),
                'end'   => date('Y-m-d H:i',$v['enddate']),
                'allDay' => $is_allday,
                'color'  => $v['color']
            );

        }
        echo json_encode($data);
    }

    function get_public_plan(){
        $row = M('user_calendar')->where('uid = '.$_SESSION['admin']['id'].' and type = 1')->select();
        foreach ($row as $k=>$v) {
            $is_allday = $v['allday']==1?true:false;
            $data[] = array(
                'id'    => $v['id'],
                'title' => $v['title'],
                'start' => date('Y-m-d H:i',$v['startdate']),
                'end'   => date('Y-m-d H:i',$v['enddate']),
                'allDay' => $is_allday,
                'color'  => $v['color']
            );

        }
        echo json_encode($data);
    }

    //添加个人日常
    function add_self_plan(){
        $title = stripslashes(trim($_POST['title']));//事件内容
        $isallday = $_POST['allday'];//是否是全天事件
        $isend = $_POST['enddate'];//是否有结束时间
        $starttime = trim($_POST['starttime']);//开始日期
        $endtime = trim($_POST['endtime']);//结束日期



        $s_time = $_POST['s_hour'].':'.$_POST['s_minute'].':00';//开始时间
        $e_time = $_POST['e_hour'].':'.$_POST['e_minute'].':00';//结束时间

        if($isallday==1 && $isend==1){
            $starttime = strtotime($starttime);
            $endtime = strtotime($endtime);
        }elseif($isallday==1 && $isend==""){
            $starttime = strtotime($starttime);
        }elseif($isallday=="" && $isend==1){
            $starttime = strtotime($starttime.' '.$s_time);
            $endtime = strtotime($endtime.' '.$e_time);
        }else{
            $starttime = strtotime($starttime.' '.$s_time);
        }
        if($_POST['list'])
        {
            if($_POST['type'] == 1)//发个人
            {
                $peoids = implode(',',$_POST['id']);
                $peoples = M('school_oa_tea')->where('id IN ('.$peoids.')')->field('tel')->select();
                foreach ($peoples as $k=>$v) {
                    $peo_tels[] = $v['tel'];
                }

                $peo_tels = implode(',',$peo_tels);
                $peo_uids = M('user')->where('username IN ('.$peo_tels.')')->field('id')->select();
                foreach ($peo_uids as $its=>$it) {
                    $data = array(
                        'startdate' => $starttime,
                        'enddate'   => $endtime,
                        'title'     => $title,
                        'allday'    => $isallday ? 1 : 0,
                        'uid'       => $it['id'],
                        'type'      => 1,
                        'color'     => 'red'
                    );
                    $model=M('user_calendar')->add($data);
                }
            }
            else   //发群组
            {
                $gids = implode(',',$_POST['id']);
                $tels = M('school_oa_tea')->where('gid IN ('.$gids.')')->field('tel')->select();
                foreach ($tels as $tel=>$te) {
                    $peoples_tel[] = $te['tel'];
                }
                $peoples_tel =  implode(',',array_unique($peoples_tel));
                $peo_uids = M('user')->where('username IN ('.$peoples_tel.')')->field('id')->select();
                foreach ($peo_uids as $its=>$it) {
                    $data = array(
                        'startdate' => $starttime,
                        'enddate'   => $endtime,
                        'title'     => $title,
                        'allday'    => $isallday ? 1 : 0,
                        'uid'       => $it['id'],
                        'type'      => 1,
                        'color'     => 'red'
                    );
                    $model=M('user_calendar')->add($data);
                }

            }
        }else{
            $data = array(
                'startdate' => $starttime,
                'enddate'   => $endtime,
                'title'     => $title,
                'allday'    => $isallday ? 1 : 0,
                'uid'       => $_SESSION['admin']['id'],
                'color'     => 'red'
            );
            $model=M('user_calendar')->add($data);
        }


        $model ? $this->successajax() : $this->failajax();
    }

    function sel_delete(){
        $model = M('user_calendar')->delete($_POST['id']);
        $model ? $this->successajax() : $this->failajax();
    }
    function sel_save_color(){
        $data = array(
            'id' => $_POST['id'],
            'color' => 'green',
        );
        $model = M('user_calendar')->save($data);
        $model || $model ==0 ? $this->successajax() : $this->failajax();
    }

    function sel_save_date(){
        $data = array(
            'id' => I('post.id',0),
            'startdate' => strtotime(I('post.startdate')),
            'enddate'   => strtotime(I('post.enddate'))
        );
        $model = M('user_calendar')->save($data);
        $model || $model ==0 ? $this->successajax() : $this->failajax();
    }

    function sch_update_state(){
        $id = substr(strstr($_POST['id'],'_'),1);
        $state = $_POST['state'];
        if($state == 1){
            $state = '0';
            $msg = "隐藏";
        }else{
            $state = '1';
            $msg = '显示';
        }
        $data = array(
            'state' => $state,
            'id' => $id
        );

        $data = M('oa_admin_news')->save($data);
        if($data){
            $this->successajax($msg,$state);
        }else{
            $this->failajax($msg);
        }
    }
    function sch_delete_list(){
        $id = $_POST['id'];
        M('oa_admin_news')->delete($id) ? $this->successajax() : $this->failajax();
    }

    //日常文件上传
    public function sch_file_add(){
        $file = end(explode('.', $_FILES['Filedata']['name']));
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     5145728 ;// 设置附件上传大小
        $upload->rootPath  =     './Public/Uploads/sch_file/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        $upload->autoSub  = true;
        $upload->subName  = array('date','Ymd');
        $upload->saveName = '';
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息

            $this->failajax($upload->getError());
        }else{// 上传成功
            $this->successajax();
        }
    }
    function add_mkdir_list()
    {
        $uname = M('user')->where('id ='.$_SESSION['admin']['id'])->field('relname')->find()['relname'];
        $data =array(
            'uid' => $_SESSION['admin']['id'],
            'uname' => $uname,
            'file_name' => $_POST['name'],
            'time' => date('Y-m-d'),
            'title' => $_POST['title'],
            'ocode' => $_SESSION['admin']['school_id'],
            'reg'   => date('Ymd')
        );
        M('oa_sch_file')->add($data) ? $this->successajax() : $this->failajax('网络繁忙');
    }


    function sdAdd()
    {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     5145728 ;// 设置附件上传大小
        $upload->rootPath  =     './Oa_file/sd/'; // 设置附件上传根目录
        //$upload->savePath  =     $_SESSION['admin']['id'].'_sd'; // 设置附件上传（子）目录
        $upload->autoSub  = true;
        $upload->subName  =  $_SESSION['admin']['id'].'_sd';
        $upload->saveName = $upload->name;

        $info   =   $upload->upload();

        $info ? $this->successajax()  : $this->failajax();
    }


    function del_sd()
    {
        unlink('./Oa_file/sd/'.$_SESSION['admin']['id'].'_sd/'.$_POST['title']) ? $this->successajax() : $this->failajax('网络繁忙');
    }


    function mkdir_file()
    {
        if(mkdir('./Oa_file/fankui/'.$_POST['name'],'0777'))
        {
            $this->successajax();
        }
        else{
            $this->failajax();
        }
    }

    function get_mkdir()
    {
        $map["file_name"] = $_POST['title'];
        $data = M('oa_sch_file')->where($map)->order('id desc')->select();
        //echo  M('oa_sch_file')->getLastSql();
        $this->successajax('',$data);
    }

    function plan_edit_state()
    {
        if($_POST['state'] == '显示'){
            $data['state'] = 0;
            $name = '隐藏';
        }else{
            $data['state'] = 1;
            $name = '显示';
        }

        $data['id'] = $_POST['id'];
        if(M('school_oa_plan')->save($data)){
            $this->successajax('',$name);
        }

    }


    function getHavenews()
    {
        $data = M('school_oa_plan')->find($_POST['id']);
        if($data && count($data) > 0)
        {
            $this->successajax('',$data);
        }
        else
        {
            $this->failajax();
        }
    }

    function edit_news_true()
    {
        if(M('school_oa_plan')->save($_POST)){
            $this->successajax();
        }
    }

    function sch_edit_con(){
        if(M('oa_admin_news')->save($_POST)){
            $this->successajax();
        }
    }


    public function upcall(){
        if(!I('post.pid')){
            return false;
        }
        if (!empty ($_FILES ['Filedata'] ['name'])) {
            $tmp_file = $_FILES ['Filedata'] ['tmp_name'];
            $file_types = explode(".", $_FILES ['Filedata'] ['name']);
            $file_type = $file_types [count($file_types) - 1];
            /*判别是不是.xls文件，判别是不是excel文件*/
            if (strtolower($file_type) != "xlsx") {
                $this->error('不是Excel文件，重新上传');
            }
            /*设置上传路径*/
            $savePath = './Public/Uploads/Excel/';
            /*以时间来命名上传的文件*/
            $str = date('Ymdhis');
            $file_name = $str . "." . $file_type;
            /*是否上传成功*/
            if (!copy($tmp_file, $savePath . $file_name)) {
                $this->error('上传失败');
            }

            import("Common.Org.PHPExcel.Shared.Date");

            $res = new Model\ExcelModel();
            $res = $res->reader_excel($savePath . $file_name);
            $tipsNum = array_flip($res[0]);
            /*对生成的数组进行数据库的写入*/


            $subname = $this->subjectName;
            foreach ($tipsNum as $k=>$v) {
                if($subname[$k])
                    $sub[$v] = $subname[$k];
            }
//            $tipsNum = array_flip($tips);
            foreach ( $res as $k => $v )
            {
                $data = array();

                foreach ($sub as $sus=>$su) {
                    if($v[$sus] === '')
                    {
                        $key = NULL;
                    }
                    else
                    {
                        $key = $v[$sus];
                    }
                    $data[$su] = $key;
                }

                $data['usernum'] = $v[0];
                $data['username']=$v[1];
                $data['classname'] = $v[2];
                $data['schoolname'] = $v[3];
                $data['ocode']=session('admin.school_id');
                $data['pid'] = I('post.pid');
                if($v[0] !='考号')
                {
                    M ( 'school_call' )->add ( $data );

                }
//                $data = array(
//                    'ocode' => $v[0],
//                    'user_name' =>$v[1],
//                    'chi'   => $v[2],
//                    'math'   => $v[3],
//                    'eng'   => $v[4],
//                    'sec'   => $v[5],
//                    'soc'   => $v[6],
//                    'total'   => $v[7],
//                );
//                M('test')->add($data);

            }
            $bres = array(
                'id'    => I('post.pid'),
                'data'  => 1
            );
            M('rep_examlist')->save($bres);
            $state = M('rep_examlist')->field('state')->find(I('post.pid'));
            if($state['state'] == 1)
            {
                echo I('post.pid');
            }else{
                echo 0;
            }
        }


    }


    function getParamter()
    {
        $res = M('rep_examlist')->find(I('post.id'));
        $res ? $this->successajax('',$res) : $this->failajax('网络繁忙');
    }


    function getParamtershare()
    {
        $res = M('rep_examlist')->find(I('post.id'));
        if($res['data'] == 0){
            echo json_encode(array('success'=>false,'msg'=>'数据暂未上传'));
            return false;
        }
        $rep = new Model\ReportModel();
        $have = $rep->getchose($res);
        echo json_encode(array('success'=>true,'data'=>$res,'have'=>$have));
    }




    function call()
    {
        $area_bh = substr($_SESSION['admin']['school_id'],0,6);
        $ocode = substr($_SESSION['admin']['school_id'],-3);
        $ocode_name = M('shoollist')->where('area_bh ='.$area_bh.' and ocode ='.$ocode)->field('ocode_name')->find()['ocode_name'];
        $this->assign('ocode_name',$ocode_name);
        $arr = D('User')->get_school_nav();

        $num = I('get.num');
        $num = !empty($num) ? $num : 20;


        $where['data']  =1;
        if(!empty(I('get.name')))
        {
            $where['name']=array('LIKE','%'.I('get.name') .'%');
        }
        $count = M('rep_examlist')->where($where)->count();
        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();
        $exam = M('rep_examlist')->where($where)->limit($limit)->order('examtime desc')->select();
        $this->assign('page',$show);

        $this->assign('exam',$exam);
        $this->assign('api',1);
        $usernav = $this->getUserNavs();

        $this->assign('usernav',$usernav);
        $this->assign('state',1);
        $this->assign('type',1);
        $this->assign('data_nav',$arr);
        $this->display('Report/call');

    }

    function createAttach()
    {
        $pid = I('post.pid');
        $where['pid'] = $pid;
        $schname = M('school_call')->where($where)->group('schoolname')->field('schoolname')->select();
        $info = M('rep_examlist')->where('id = '.$pid)->field('examtime,name,userid,username')->find();
        foreach ($schname as $k=>$v) {
            $data[] = array(
                'schoolname' => $v['schoolname'],
                'examtime' => $info['examtime'],
                'name'  => $info['name'].'--'.$v['schoolname'],
                'userid'    => $info['userid'],
                'username'  => $info['username'],
                'pid'   => $pid,
                'state' => 0,
                'data'  => 1,
                'regtime'   => date('Y-m-d H:i:s'),
            );
        }
        $res = M('rep_examlist')->addAll($data);
        $res ? $this->successajax() : $this->failajax('网络繁忙');
    }

    function delexamlist()
    {
        $id = I('post.id');
        $res = M('rep_examlist')->delete($id);
        $res ? $this->successajax() : $this->failajax();
    }

    function imgReport()
    {
        if(I('post.ocode'))
        {
            $type='classname';
        }
        else
        {
            $type = 'schoolname';
        }
        $subject = I('post.sub');
        $chsub = array_flip($this->subjectName);
        $subject = I('post.subject') ? $subject=I('post.subject') : 'total';
        $chsub = $chsub[$subject];
        $listName = M('rep_examlist')->where('id ='.I('post.id'))->field('name')->find();
        $info = new ApiModel();
        $info = $info->imgRepInfo($subject,I('post.id'),$type,I('post.ocode'));
        echo json_encode(array('success'=>true,'info'=>$info,'name'=>$listName,'title'=>$chsub));
    }
    function imgReportdetails()
    {
        if(I('post.ocode'))
        {
            $type='classname';
        }
        else
        {
            $type = 'schoolname';
        }

        $info = new ApiModel();
        $total = $info->imgRepInfo('total',I('post.id'),$type,I('post.ocode'));
        $chi = $info->imgRepInfo('chi',I('post.id'),$type,I('post.ocode'));
        $math = $info->imgRepInfo('math',I('post.id'),$type,I('post.ocode'));
        $eng = $info->imgRepInfo('eng',I('post.id'),$type,I('post.ocode'));
        $sec = $info->imgRepInfo('sec',I('post.id'),$type,I('post.ocode'));
        $soc = $info->imgRepInfo('soc',I('post.id'),$type,I('post.ocode'));
        $data = [A,B,C,D,E];
        foreach ($data as $k=>$v) {
            $news[$v] = [$total['info'][$v][0],$chi['info'][$v][0],$math['info'][$v][0],$eng['info'][$v][0],$sec['info'][$v][0],$soc['info'][$v][0]];
        }
        $schoolname = ['总分','语文','数学','英语','科学','社会'];
        echo json_encode(array('success'=>true,'info'=>$news,'name'=>$schoolname));


    }
    function classimgReportdetails()
    {
        $res = $this->classcompos(I('post.id'),I('post.ocode'),I('post.classname'));
        $data = [A,B,C,D,E];
        foreach ($data as $k=>$v) {
            $datas['news'][$v] = [$res['total']['info'][$v][0],$res['chi']['info'][$v][0],$res['math']['info'][$v][0],$res['eng']['info'][$v][0],$res['sec']['info'][$v][0],$res['soc']['info'][$v][0]];
        }
        $datas['schoolname'] = ['总分','语文','数学','英语','科学','社会'];
        echo json_encode(array('success'=>true,'info'=>$datas['news'],'name'=>$datas['schoolname']));
    }
    function classgetcompos()
    {
        $where = array(
            'pid' => I('post.id'),
            'schoolname' =>I('post.ocode'),
            'classname' => I('post.classname')
        );
        $count = M('school_call')->where($where)->count();
        $res = $this->classcompos(I('post.id'),I('post.ocode'),I('post.classname'));
        foreach ($res as $k=>$v) {
            $data[] = sprintf("%.3f",(5*$v['info']['A'][0]/$count)+4*($v['info']['B'][0]/$count)+3*($v['info']['C'][0]/$count)
                +2*($v['info']['D'][0]/$count)-3*($v['info']['E'][0]/$count))*1;
        }
        echo json_encode(array('success'=>true,'data'=>$data));
    }

    function getclassA()
    {
//        $where = array(
//            'pid' => I('post.id'),
//            'schoolname' =>I('post.ocode'),
//            'classname' => I('post.classname')
//        );
//        $count = M('school_call')->where($where)->count();
        $res = $this->classcompos(I('post.id'),I('post.ocode'),I('post.classname'));
        foreach ($res as $k=>$v) {
            $data[] = $v['info']['A'][0];
        }
        echo json_encode(array('success'=>true,'data'=>$data));
    }
    function getclassE()
    {
//        $where = array(
//            'pid' => I('post.id'),
//            'schoolname' =>I('post.ocode'),
//            'classname' => I('post.classname')
//        );
//        $count = M('school_call')->where($where)->count();
        $res = $this->classcompos(I('post.id'),I('post.ocode'),I('post.classname'));
        foreach ($res as $k=>$v) {
            $data[] = 0-($v['info']['D'][0]+$v['info']['E'][0]);
        }
        echo json_encode(array('success'=>true,'data'=>$data));
    }

    function classcompos($id,$ocode,$classname)
    {
        $type='classname';
        $info = new ApiModel();
        $datas['total'] = $info->imgRepInfo('total',$id,$type,$ocode,$classname);
        $datas['chi'] = $info->imgRepInfo('chi',$id,$type,$ocode,$classname);
        $datas['math'] = $info->imgRepInfo('math',$id,$type,$ocode,$classname);
        $datas['eng'] = $info->imgRepInfo('eng',$id,$type,$ocode,$classname);
        $datas['sec'] = $info->imgRepInfo('sec',$id,$type,$ocode,$classname);
        $datas['soc'] = $info->imgRepInfo('soc',$id,$type,$ocode,$classname);
        return $datas;
    }

    function test()
    {
        $res = new ApiModel();
        $res->test();
    }


    function upcallsub(){
        if(!I('post.pid')){
            return false;
        }
        if(!I('post.key')){
            return false;
        }
        $info = M('rep_examlist')->field('know')->find(I('post.pid'))['know'];
        $know = $info.I('post.key').',';
        $where =array(
            'id' =>I('post.pid'),
            'know'=>$know
        );
        if(!M('rep_examlist')->save($where)){
            return false;
        }
        var_export('111');
        if (!empty ($_FILES ['Filedata'] ['name'])) {
            $tmp_file = $_FILES ['Filedata'] ['tmp_name'];
            $file_types = explode(".", $_FILES ['Filedata'] ['name']);
            $file_type = $file_types [count($file_types) - 1];
            if (strtolower($file_type) != "xlsx") {
                $this->error('不是Excel文件，重新上传');
            }
            $savePath = './Public/Uploads/Excel/';
            $str = date('Ymdhis');
            $file_name = $str . "." . $file_type;
            if (!copy($tmp_file, $savePath . $file_name)) {
                $this->error('上传失败');
            }
            $PHPExcel=new  Model\ExcelModel();
            $PHPReader = new \PHPExcel_Reader_Excel2007();
            if(!$PHPReader->canRead($savePath . $file_name)){
                $PHPReader = new \PHPExcel_Reader_Excel5();
                if(!$PHPReader->canRead($savePath . $file_name)){
                    return false;
                }
            }
            $PHPExcel = $PHPReader->load($savePath . $file_name);
            $currentSheet = $PHPExcel->getSheet(0);
            $allColumn = $currentSheet->getHighestColumn();
            $allRow = $currentSheet->getHighestRow();
            ++$allColumn;
            $arr=array();
            for($currentRow = 3;$currentRow <= $allRow;$currentRow++){
                /**从第A列开始输出*/
                $i=0;
                for($currentColumn = 'A'; $currentColumn !=$allColumn; $currentColumn++){ //大于26列
                    if($i>25){
                        $num =ord($currentColumn)+$i;
                    }else{
                        $num =ord($currentColumn);
                    }
                    // echo $i.$currentColumn; echo "<br>";

                    $val = $currentSheet->getCellByColumnAndRow($num - 65,$currentRow)->getValue(); /*ord()将字符转为十进制数*/


                    /**如果输出汉字有乱码，则需将输出内容用iconv函数进行编码转换，如下将gb2312编码转为utf-8编码输出*/
                    // $arr[$currentRow][]=  iconv('utf-8','gb2312', $val)."＼t";
                    $arr[$currentRow][]=  trim($val);
                    $i++;
                }
            }
            foreach ($arr as $key=>$vals){
                $tmp = '';
                foreach($vals as $v){
                    $tmp .= $v;
                }
                if(!$tmp) unset($arr[$key]);
            }

            foreach ( $arr as $k => $v )
            {
                $data = array();
                $subval = '';
                $i=0;
                foreach ($v as $vals=>$val) {
                    if($i>4)
                    {
                        $subval .= $val.'|';
                    }
                    $i++;
                }
                $data['subval'] = $subval;
                $data['usernum'] = $v[4];
                $data['username']=$v[3];
                $data['classname'] = $v[2];
                $data['schoolname'] = $v[1];
                $data['ocode']=session('admin.school_id');
                $data['pid'] = I('post.pid');
                $data['subtype'] = I('post.key');
                M('rep_subdate')->add($data);
            }

//            $state = M('rep_examlist')->field('state')->find(I('post.pid'));

        }

    }

    function getknowinfo()
    {
        $id = I('post.id');
        $know = M('rep_examlist')->field('know')->find($id);
        $know = rtrim($know['know'],',');
        $data = explode(',',$know);
        $subjectName = $this->subjectName;
        foreach ($subjectName as $k=>$v) {
            if($v != 'total')
            {
                $subname[$k] = $v;
            }
        }
        if($data && count($data)> 0)
        {
            foreach ($subname as $k=>$v) {
                if(in_array($v,$data,true)){
                    $type = 1;
                }else{
                    $type = 0;
                }
                $date[] = array(
                    'key'=>$v,
                    'subname'=> $k,
                    'type'=>$type
                );
            }
        }
        else
        {
            foreach ($subname as $k=>$v) {
                $date[] = array(
                    'key'=>$v,
                    'subname'=> $k,
                    'type'=>0
                );
            }
        }
        echo json_encode(array('success'=>true,'info'=>$date));



    }


    function getknow()
    {
        $id = I('post.id');
        $subjectName = $this->subjectName;
        foreach ($subjectName as $k=>$v) {
            if($v != 'total')
            {
                $subname[$k] = $v;
            }
        }
        $key = I('post.sub') ? I('post.sub') : 'chi';
        foreach ($subname as $k=>$v) {
            if($v == $key)
            {
                $type = 'cho';
            }else{
                $type = 'def';
            }
            $date[] =array(
                'key' => $v,
                'val' => $k,
                'type' => $type
            );
        }
        $where['know_id'] = $id;
        $where['sub'] = $key;
        $info['knowdivide'] = M('rep_know_divide')->where($where)->select();
        $info['subname'] = $date;
        echo json_encode(array('success'=>true,'info'=>$info,'ids'=>$id));

    }


    function setNewKnow()
    {
        $name = explode('|',rtrim(I('post.name'),'|'));
        $keys = explode('|',rtrim(I('post.keys'),'|'));
        $i=0;
        foreach ($name as $vals) {
            $res[] = array(
                'know_id'=>I('post.id'),
                'know_name' => $name[$i],
                'know_keys' => $keys[$i],
                'sub'   => I('post.sub')
            );
            $i++;
        }
        $know = M('rep_know_divide');
        if($res && count($res)>0)
        {
            $del['know_id']=I('post.id');
            $del['sub'] = I('post.sub');
            $know->where($del)->delete();
            if($know->addAll($res))
                $this->successajax();
        }else{
            $this->failajax('网络繁忙,请稍后');
        }

    }


    function get_knowclick()
    {
        $know_id = I('post.know_id');
        $sub = I('post.sub');
        $subval = I('post.subval');
        $schname = I('post.ocode') ? I('post.ocode') : '';

        $where['pid'] = $know_id;
        $where['subtype'] = $sub;
        $type = 'schoolname';
        if($schname)
        {
            $where['schoolname'] = $schname;
            $type = 'classname';
        }
        $data = $this->diseKnow($where,$type,$subval);

        $allnums = 0;
        foreach ($data['info'] as $k=>$v) {
            $nums  = array_sum($v['data']);
            $datas[] = [$v['name'],$nums];
            $allnums = $allnums + $nums;
            $arr_name[] = $v['name'];
            $arr_info[] = $v['data'];
         }
        $tips = $allnums/count($data['info']);

        echo json_encode(array('success'=>true,'infos'=>$datas,'title'=>$data['know'],'tips'=>$tips,'arr_name'=>$arr_name,'arr_info'=>$arr_info));

    }
    function get_knowclicks()
    {
        $wheres['pid'] = I('post.know_id');
        $wheres['sub'] = I('post.sub');
        $wheres['type'] = I('post.tips');

        $diff = M('rep_difficulty')->where($wheres)->field('val')->find();
        $know_id = I('post.know_id');
        $sub = I('post.sub');
        $subval = $diff['val'];
        $schname = I('post.ocode') ? I('post.ocode') : '';
        if(I('post.ocode'))
        {
            $type='classname';
        }else{
            $type = 'schoolname';
        }

        $where['know_id'] = $know_id;
        $where['subtype'] = $sub;
        $count = M('school_call')->where("pid = $know_id and schoolname = '$schname'")->group($type)->select();
        $counts = count($count);
        $type = 'schoolname';
        if($schname)
        {
            $where['schoolname'] = $schname;
            $type = 'classname';
        }
        $data = $this->diseKnow($where,$type,$subval);
        $testnews = [
            'chi' => [16.1,46.5,10.6,1],
            'eng'  => [15.5,20.5,17,5.4,0.18],
            'math' => [28.9,9,5,3],
            'sec'   =>[35,25,21.45,0.45],
            'soc'  => [36,1,10.5,19.5]
        ];
//        $allnums = 0;
//        foreach ($data['info'] as $k=>$v) {
//            $datas[] = [$v['name'],array_sum($v['data'])];
//            $allnums = $allnums + array_sum($v['data']);
//        }
//        $tips = $allnums/count($data['info']);
        $allvals =0 ;
        foreach ($data['info'] as $k=>$v) {
            $nums  = array_sum($v['data']);
            $newsinfo[] = [$v['name'],$nums];
            $allvals = $nums + $allvals;

        }
        $tips =$allvals / $counts;
        echo json_encode(array('success'=>true,'infos'=>$newsinfo,'title'=>$data['know'],'tips'=>$tips,'testnews'=>$testnews));
    }

    function get_knowclickss()
    {
        $wheres['pid'] = I('post.know_id');
        $wheres['sub'] = I('post.sub');
        $wheres['type'] = I('post.tips');

        $diff = M('rep_difficulty')->where($wheres)->field('val')->find();
        $know_id = I('post.know_id');
        $sub = I('post.sub');
        $subval = $diff['val'];
        $schname = I('post.ocode') ? I('post.ocode') : '';
        if(I('post.ocode'))
        {
            $type='classname';
        }else{
            $type = 'schoolname';
        }

        $where['pid'] = $know_id;
        $where['subtype'] = $sub;
        $count = M('school_call')->where("pid = $know_id and schoolname = '$schname'")->group($type)->select();
        $counts = count($count);
        $type = 'schoolname';
        if($schname)
        {
            $where['schoolname'] = $schname;
            $type = 'classname';
        }
        $data = $this->diseKnow($where,$type,$subval);
        $testnews = [
            'chi' => [16.1,46.5,10.6,1],
            'eng'  => [15.5,20.5,17,5.4,0.18],
            'math' => [28.9,9,5,3],
            'sec'   =>[35,25,21.45,0.45],
            'soc'  => [36,1,10.5,19.5]
        ];
//        $allnums = 0;
//        foreach ($data['info'] as $k=>$v) {
//            $datas[] = [$v['name'],array_sum($v['data'])];
//            $allnums = $allnums + array_sum($v['data']);
//        }
//        $tips = $allnums/count($data['info']);
        $allvals =0 ;
        foreach ($data['info'] as $k=>$v) {

            $nums  = array_sum($v['data']);
            $newsinfo[] = [$v['name'],$nums];
        }



        echo json_encode(array('success'=>true,'infos'=>$newsinfo,'testnews'=>$testnews[$sub]));
    }
    function diseKnow($where,$type,$subval)
    {
        $subval = explode(',',$subval);
        $know_sub = $date = M('rep_subdate')->where($where)->field($type)->group($type)->select();
        $date = M('rep_subdate')->where($where)->field('subval,'.$type)->select();
        foreach ($know_sub as $k=>$v) {
            foreach ($date as $vals=>$val) {
                if($v[$type] == $val[$type])
                    $new_know[$val[$type]][] = $val['subval'];
            }
        }
        foreach ($new_know as $k=>$v) {
            $count[$k] = count($v);
        }
        $initial = array();
        foreach ($new_know as $k=>$v) {
            foreach ($v as $item) {
                $items = '|'.$item;
                $frac = explode('|',rtrim($items,'|'));
                foreach ($subval as $item) {
                    $initial[$k][$item] = $frac[$item] + $initial[$k][$item];
                }
            }
        }
        $news = array();
        foreach ($initial as $k=>$v) {
            foreach ($v as $vals=>$val) {
                $ints[$vals] = sprintf("%.2f",$val/$count[$k])*1;
            }
            $news[$k] = $ints;
        }
        $infos =array();
        foreach ($news as $k=>$v) {
            $infos[] = array(
                'name' => $k,
                'data' => array_values($v)
            );
        }
        $datas['info'] = $infos;
        $datas['know'] = $subval;

        return $datas;

    }





        public $allnav  = [9,11,17,23,24,25,26,27,28,30,31,32,33,36];
    function getusernav()
    {
        $id = session('admin.id');
        $usenav = M('user_detail')->field('nav')->find($id)['nav'];
        if($usenav)
        {
            $usenav = explode(',',rtrim($usenav,','));
            $othernav = array_diff($this->allnav,$usenav);
            $othernav = implode(',',$othernav);
            $where['id'] = ['in',$othernav];
            $res = M('nav')->where($where)->field('id,nav_name')->select();
            echo json_encode(array('success'=>true,'info'=>$res));
        }
    }

    function setusernav()
    {
        $id = session('admin.id');
        $model = M('user_detail');
        $usenav = $model->field('nav')->find($id)['nav'];
        $newnav = $usenav.I('post.id').',';
        $arr = ['userid'=>$id,'nav'=>$newnav];
        $res = $model->save($arr);
        if($res)
            echo json_encode(array('success'=>true));
    }

    function delusernav()
    {
        $id = session('admin.id');
        $model = M('user_detail');
        $usenav = $model->field('nav')->find($id)['nav'];
        $newnav =explode(',',rtrim($usenav,','));
        $delarray = [I('post.id')];
        $newnavs =implode(',',array_diff($newnav,$delarray)).',' ;

        $arr = ['userid'=>$id,'nav'=>$newnavs];
        $res = $model->save($arr);
        if($res)
            echo json_encode(array('success'=>true));
    }


    function getUserNavs()
    {
        $uid = session('admin.id');
        $date = M('user_detail')->field('nav')->find($uid)['nav'];
        if($date)
        {
            $date = rtrim($date,',');
            $where['id'] = array('in',$date);
            $navinfo = M('nav')->where($where)->select();
            return $navinfo;
        }

    }


    function bakegetcode(){  //获取验证码
        $code = rand(1000,9999);
        $data = array(
            'tel' => $_POST['tel'],
            'sendtime' => date('Y-m-d H:i:s'),
            'sms_type' => 0,
            'content' => '本次验证码：'.$code.'  请妥善保管。',
            'send_name' => '新登镇中学',
            'regtime' => date('Y-m-d H:i:s')
        );
        $send = new ApiModel();
        $res = $send->sendMsg($_POST['tel'],'本次验证码：'.$code.'  请妥善保管。 ——富阳区教研室OA平台');
        
        $_SESSION[$_POST['tel']] = $code;

        $this->successajax();
    
    }
    function bakeUpdatePwd()
    {
        $code = $_SESSION[$_POST['tel']];

        if($code == $_POST['code']){
            $pwd['password'] = md5($_POST['pwd']);
            $data = M('user')->where('username ='.$_POST['tel'])->save($pwd);
            if($data){
                session($_POST['tel'],null);
                $this->successajax();
            }else{
                $this->failajax('网络繁忙，稍后再试');
            }
        }else{
            $this->failajax('验证码错误');
        }
    }
    function getpdf()
    {
        $csv = $_POST['svg'];
        if ($csv) {
            header('Content-type: text/csv');
            header('Content-disposition: attachment;filename=chart.csv');
            file_put_contents('a.svg',$csv);
        }


        $html = file_get_contents('http://localhost:8088/index.php/Comment/ocode_rep/id/53/state/1.html');
        //引入类库
        Vendor('mpdf.mpdf');
        //设置中文编码

        $mpdf=new \mPDF('zh-cn','A4', 0, '宋体', 0, 0);
        $mpdf->useAdobeCJK = true;
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        exit;

    }

    function ocode_rep()
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
        $this->display('Report/index1');
    }

    public $subjectNames =array(
        '语文'    => 'chi',
        '英语'    => 'eng',
        '科学'    => 'sec',
        '数学'    => 'math',
        '社会'    => 'soc',
    );


    function radar()
    {
        $sub = array_values($this->subjectNames);
        $key = '';
        foreach ($sub as $vals=>$val) {
            $key .= 'sum('.$val.') as '.$val.',count('.$val.') as count'.$val.',';
        }
        $key = rtrim($key,',');
        $id = I('post.id');
        $schoolname = I('post.ocode');
        $classname = I('post.classname');

        $schools = $this->radarsch($id,$schoolname,$sub,$key,'');
        $ocode = $this->radarsch($id,'',$sub,$key,'');
        $class = $this->radarsch($id,$schoolname,$sub,$key,$classname);
        $subname = array_flip($this->subjectNames);
        foreach ($schools as $k=>$v) {
            $names[] = $subname[$k];
            $schrad[] = $v*1;
        }

        foreach ($ocode as $k=>$v) {
            $ocoderad[] = $v*1;
        }

        foreach ($class as $k=>$v) {
            $classrad[] = $v*1;
        }
        echo json_encode(array('success'=>true,'sch'=>$schrad,'ocode'=>$ocoderad,'class'=>$classrad,'subname'=>$names));
    }

    function radarsch($id,$schoolname,$sub,$key,$classname)
    {
        $where['pid'] = $id;
        if($schoolname){
            $where['schoolname'] = $schoolname;
        }
        if($classname) {
            $where['classname'] = $classname;
            $where['schoolname'] =$schoolname;
        }

        $data = M('school_call')->where($where)->field($key)->find();
        foreach ($data as $k=>$v) {
            if(in_array($k,$sub)){
                $info[$k] = $v;
            }else{
                $infocount[$k] = $v;
            }
        }
        foreach ($info as $k=>$v) {
            if($v){
                $schools[$k] = sprintf("%.2f",$v/$infocount['count'.$k]);   //学校
            }
        }
        return $schools;
    }

    /*
     * 班级知识点雷达图
     */
    function division()
    {
        $id = I('post.id');
        $sub=I('post.subject');
        $schoolname = I('post.schoolname');
        $classname = I('post.classname');

        $where['pid'] = $id;
        $divide = M('rep_know_divide')->where("know_id =$id and sub = '$sub'")->select();
        $classnum = $this->getdivision($id,$sub,$schoolname,$classname,$divide);
        $schoolnum = $this->getdivision($id,$sub,$schoolname,'',$divide);
        $ocode = $this->getdivision($id,$sub,'','',$divide);

        echo json_encode(array('success'=>true,'classnum'=>$classnum,'schnum'=>$schoolnum,'ocode'=>$ocode));
    }


    function getdivision($id,$sub,$schoolname,$classname,$divide)
    {
        $where['pid'] = $id;
        $where['subtype'] = $sub;
        if($schoolname){
            $where['schoolname'] = $schoolname;
        }
        if($classname){
            $where['classname'] = $classname;
        }
        $data = M('rep_subdate')->where($where)->field('subval')->select();
        foreach ($data as $k=>$v) {
            $infos[] = explode('|',rtrim('|'.$v['subval'],'|'));
        }
        $rads=[];
        foreach ($divide as $k=>$v) {
            $divs = explode(',',$v['know_keys']);
            foreach ($divs as $vals=>$val) {
                $i=0;
                foreach ($infos as $ms=>$m) {
                    if(is_numeric($m[$val])){
                        $rads[$val] = $m[$val]+$rads[$val];
                        $i++;
                    }
                }
            }
        }
        foreach ($rads as $k=>$v) {
            $radars[$k] = sprintf("%.4f",$v/$i);
        }
        foreach ($divide as $k=>$v) {
            if($v['know_keys']){
                $know = explode(',',$v['know_keys']);
                $date = [];
                foreach ($know as $itms=>$itm) {
                    $date[] = ($radars[$itm])/10;

                }
                $dates[] = $date;
                $namenum[] = explode(',',$v['know_keys']);
            }
            $names[] = $v['know_name'];
        }
        $res['namenum'] = $namenum;
        $res['date'] =$dates;
        $res['names'] = $names;
        return $res;


    }


    function getmathInfos()
    {
        var_export($_POST);
    }


    function composliteAll()
    {
        $type = I('post.ocode') ? $type='classname' : 'schoolname';
        $chsub = array_flip($this->subjectName);
        $subject = I('post.subject') ? $subject=I('post.subject') : 'total';
        $chsub = $chsub[$subject];

        $infofun = new ApiModel();
        $info = $infofun->imgRepInfo($subject,I('post.id'),$type,I('post.ocode'));    //单校的数据
        $allinfocom = $infofun->imgRepInfo($subject,I('post.id'),'schoolname',I('post.ocode'));  //全区的数据
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
        $i = 0;
        foreach ($allinfocom['schoolname'] as $items=>$item) {
            $datacom[$i]['schoolname'] = $item;
            foreach ($allinfocom['info'] as $k=>$v) {
                $datacom[$i]['schNum'] += $v[$i];
            }
            foreach ($allinfocom['info'] as $k=>$v) {
                $datacom[$i][$k] = sprintf("%.2f",$allinfocom['info'][$k][$i]/$datacom[$i]['schNum']*100);
            }
            $datacom[$i]['composite'] = sprintf("%.3f",5*$datacom[$i]['A']/100+4*$datacom[$i]['B']/100+3*$datacom[$i]['C']/100
                +2*$datacom[$i]['D']/100-3*$datacom[$i]['E']/100);
            $i++;
        }
        $schoolcom = $data[0]['composite']*1;   //学校的综合指数
        $areacom = $datacom[0]['composite']*1;  //全区的综合指数
        $allinfos = array();
        foreach ($data as $k=>$v) {
            $allinfos[] = array($v['schoolname'],$v['composite']*1);
            if($v['schoolname'] != '总体情况')
                $sort[$v['composite']*100] = $v['schoolname'];
        }
        krsort($sort);$sortA ='';$sortB = '';
        foreach ($sort as $k=>$v) {
            if($k >= 300)
            {
                $sortA .= $v.'、 ';
            }else{
                $sortB .= $v.'、 ';
            }
        }
        echo json_encode(array('success'=>true,'infos'=>$allinfos,'title'=>$chsub,'good'=>$sortA,'low'=>$sortB,'schcom'=>$schoolcom,'areacom'=>$areacom));

    }

    /**
     *      获取各校的平均分标准分
     */
    function standardScore()
    {
        $id = I('post.id');
        $type = I('post.ocode') ? $type='classname' : 'schoolname';
        $chsub = array_flip($this->subjectName);
        $subject = I('post.subject') ? $subject=I('post.subject') : 'total';
        $chsub = $chsub[$subject];
        $where['pid'] = $id;
        if(I('post.ocode'))  $where['schoolname'] = I('post.ocode');
        if(I('post.classname'))  $where['classname'] = I('post.classname');
        $requert = M('school_call')->field("$type,$subject")->where($where)->order($type)->select();
        $avg = M('school_call')->field("$type")->where('pid = '.$id)->avg($subject);  //平均分
        $arearequert = M('school_call')->field("schoolname,$subject")->where("pid = $id")->order('schoolname')->select();
        $schinfos = $this->getlevel($requert,$subject,$type,$avg);
        $areainfos = $this->getlevel($arearequert,$subject,'schoolname',$avg);
        krsort($schinfos['sort']);
        foreach ($schinfos['sort'] as $k=>$v) {
            if($k >= 5000)
            {
                $sortA .= $v.'、 ';
            }else{
                $sortB .= $v.'、 ';
            }
        }
        echo json_encode(array('success'=>true,'infos'=>$schinfos['infos'],'title'=>$chsub,'good'=>$sortA,'low'=>$sortB,'allnewtips'=>$schinfos['allnewtips'],'areanewtips'=>$areainfos['allnewtips']));


    }
    function getlevel($requert,$subject,$type,$avg) //获取标准分平均分
    {
        $allinfos = array();$allcount =array();$stand=array();
        foreach ($requert as $k=>$v) {
            $allinfos[$v[$type]] = $v[$subject] + $allinfos[$v[$type]];
            $allcount[$v[$type]]++;
        }
        foreach ($allinfos as $k=>$v) {
            $stand[$k] = sprintf("%.3f",$v/$allcount[$k]);
        }
        $totalstand = 0;
        $nums = count($stand);
        foreach ($stand as $k=>$v) {
            $totalstand = pow($v-$avg,2) + $totalstand;
        }
        $totalstand = sprintf("%.3f",sqrt($totalstand/$nums));   //标准差
        $alltips = 0;
        foreach ($stand as $k=>$v) {
            $nesnums = sprintf("%.3f",(($v-$avg) / $totalstand)*100+500)*1;
            $infos[] = array($k,$nesnums);
            $sort[$nesnums*10] = $k;
            $alltips = $alltips + $nesnums;
        }

        $allnewtips = $alltips/$nums;
        $datas = array(
            'infos' => $infos,
            'allnewtips'=> $allnewtips,
            'sort'  => $sort
        );
        return $datas;
    }

    /**
     * 前15%和 后百分之30%
     */
//    function getsomeinfo()
//    {
//        if(I('post.ocode'))
//        {
//            $type='classname';
//        }
//        else
//        {
//            $type = 'schoolname';
//        }
//
//        $subject = I('post.sub');
//        $chsub = array_flip($this->subjectName);
//        $subject = I('post.subject') ? $subject=I('post.subject') : 'total';
//        $chsub = $chsub[$subject];
//        $listName = M('rep_examlist')->where('id ='.I('post.id'))->field('name')->find();
//        $info = new ApiModel();
//        $info = $info->imgRepInfo($subject,I('post.id'),$type,I('post.ocode'));
//        $someA = array_splice($info['info']['A'],1);
//        $someD = array_splice($info['info']['D'],1);
//        $someE = array_splice($info['info']['E'],1);
//        $i =0;
//        foreach ($someD as $item) {
//
//            $someE[$i] =  0-($someD[$i] + $someE[$i]);
//            $i++;
//        }
//        $someall = [$someA,$someE];
//        echo json_encode(array('success'=>true,'title'=>$chsub,'schoolname'=>array_splice($info['schoolname'],1),'infos'=>$someall));
//
//
//    }

    function getsomeinfo()
    {
        if(I('post.ocode'))
        {
            $type='classname';
        }
        else
        {
            $type = 'schoolname';
        }
        $chsub = array_flip($this->subjectName);

        $subject = I('post.subject') ? $subject=I('post.subject') : 'total';
        $chsub = $chsub[$subject];

        $infofun = new ApiModel();
        $info = $infofun->imgRepInfo($subject,I('post.id'),$type,I('post.ocode'));
        $allinfocom = $infofun->imgRepInfo($subject,I('post.id'),'schoolname',I('post.ocode'));  //全区的数据
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

        $i = 0;
        foreach ($allinfocom['schoolname'] as $items=>$item) {
            $datacom[$i]['schoolname'] = $item;
            foreach ($allinfocom['info'] as $k=>$v) {
                $datacom[$i]['schNum'] += $v[$i];
            }
            foreach ($allinfocom['info'] as $k=>$v) {
                $datacom[$i][$k] = sprintf("%.2f",$allinfocom['info'][$k][$i]/$datacom[$i]['schNum']*100);
            }
            $datacom[$i]['composite'] = sprintf("%.3f",5*$datacom[$i]['A']/100+4*$datacom[$i]['B']/100+3*$datacom[$i]['C']/100
                +2*$datacom[$i]['D']/100-3*$datacom[$i]['E']/100);
            $i++;
        }
        foreach ($data as $k=>$v) {
            $name[] = $v['schoolname'];
            $sort[$v['A']*100] = $v['schoolname'];
            $bsort[($v['D']+$v['E'])*100] = $v['schoolname'];
        }
        foreach ($data as $k=>$v) {
            $someall['A'][] = [$v['schoolname'],$v['A']*1];
        }
        foreach ($data as $k=>$v) {
            $someall['B'][] = [$v['schoolname'],$v['A']+$v['B']];
        }

        foreach ($data as $k=>$v) {
            $someall['E'][] = [$v['schoolname'],0-($v['D']+$v['E'])];
        }
        $schrate['A'] = $data[0]['A']*1;
        $schrate['E'] =$data[0]['D']+$data[0]['E'];
        $schrate['B'] = $data[0]['A']+$data[0]['B'];
        $arearate['A'] = $datacom[0]['A']*1;
        $arearate['E']  = $datacom[0]['D']+$datacom[0]['E'];
        $arearate['B'] = $datacom[0]['A']+$datacom[0]['B'];
        krsort($sort);
        ksort($bsort);
        foreach ($sort as $k=>$v) {
            if($v != '总体情况')
            {
                if($k >= 1500){
                    $sortA .= $v.'、 ';
                }else{
                    $sortB .=$v.'、 ';
                }
            }
        }
        foreach ($bsort as $k=>$v) {
            if($v != '总体情况')
            {
                if($k <= 3000){
                    $bsortA .= $v.'、 ';
                }else{
                    $bsortB .=$v.'、 ';
                }
            }
        }
        echo json_encode(array('success'=>true,'title'=>$chsub,'schoolname'=>$name,'infos'=>$someall,'good'=>$sortA,'low'=>$sortB,'bgood'=>$bsortA,'blow'=>$bsortB,'schrate'=>$schrate,'arearate'=>$arearate));


    }
    /**
     * 获取各科的难易度数据
     */
    function getDifficulty()
    {
        $wheres['pid'] = I('post.know_id/d',0);
        $wheres['sub'] = I('post.subject');
        $diff = M('rep_difficulty')->where($wheres)->field('val')->order('id')->select();
        $chsub = array_flip($this->subjectName);
        $subject = I('post.subject') ? $subject=I('post.subject') : 'total';
        $chsub = $chsub[$subject];
        $schname = I('post.ocode') ? I('post.ocode') : '';
        $classname = I('post.classname');
        $new['pid'] = I('post.know_id');
        $new['subtype'] = I('post.subject');
        $sch['pid'] = I('post.know_id');
        $sch['subtype'] = I('post.subject');
        $class['pid'] = I('post.know_id');
        $class['subtype'] = I('post.subject');
        if($schname)
        {
            $sch['schoolname'] = $schname;
        }
        if($classname)
        {
            $class['classname'] = $classname;
        }
        $allocodecount = M('rep_subdate')->where($new)->count();
        $allfraction = M('rep_subdate')->where($new)->field('subval')->select();
        $schcount = M('rep_subdate')->where($sch)->field('subval')->count();
        $schfraction = M('rep_subdate')->where($sch)->field('subval')->select();
        $classcount = M('rep_subdate')->where($class)->field('subval')->count();
        $classfraction = M('rep_subdate')->where($class)->field('subval')->select();

        $thinks = $this->date2(I('post.subject'),I('post.know_id'));
        //全区平均分
        $difftotal['ocode'] = $this->test1($diff,$allfraction,$allocodecount);
        $difftotal['sch'] = $this->test1($diff,$schfraction,$schcount);
        $difftotal['class'] = $this->test1($diff,$classfraction,$classcount);
        $test = $thinks;
        $test1 = $difftotal['ocode']['index'];//区的
        $test2 = $difftotal['sch']['index'];//学校的


        echo json_encode(array('success'=>true,'infos'=>$difftotal,'title'=>$chsub,'name'=>$name,'test'=>$test,'test1'=>$test1,'test2'=>$test2,'test3'=>$test3));


    }

    function test1($diff,$allfraction,$allocodecount)
    {

        foreach ($allfraction as $k=>$v) {
            $allfractions[] = explode('|','|'.$v['subval']);

        }
        foreach ($diff as $k=>$v) {
            $diffs = explode(',',rtrim($v['val'],','));
            foreach ($diffs as $ks=>$vs) {
//                $allocode[$vs] = 0;
                $allocode[$vs] = 0;
                foreach ($allfractions as $its=>$it) {
                    $allocode[$vs] = $it[$vs] +$allocode[$vs];
                }

                $allfrac[$vs] = $allocode[$vs] / $allocodecount;
            }
        }


//        $diffallss['allkeys'][] =ceil(array_sum($allfrac));   //  总分(全部小题)

        foreach ($diff as $k=>$v) {
            $diffs = explode(',',rtrim($v['val'],','));
            $diffalls=0;
            foreach ($diffs as $items=>$item) {
                $diffalls = $allfrac[$item] + $diffalls;
            }
            $diffallss['index'][$k] = $diffalls;
        }


        return $diffallss;
    }

    function date2($sub,$pid)
    {

        $where['pid'] = $pid;
        $where['subtype'] = $sub;
        $data = M('rep_subdate')->where($where)->field('subval')->select();
        foreach ($data as $k=>$v) {
            $news = explode('|','|'.$v['subval']) ;
            foreach ($news as $items=>$item) {
                if(($item || $item== '0') && $item != '——')
                {
                    $datas[$items][] = $item;
                }
            }
        }


        foreach ($datas as $k=>$v) {
            $info[$k] = max($v);
            $arg[$k] = array_sum($v)/count($v);
        }

        $newall['sim1'] = 0;
        $newall['sim2'] = 0;
        $newall['sim3'] = 0;
        $newall['sim4'] = 0;
        $newall['sim5'] = 0;
        foreach ($info as $k=>$v) {
            $res = $arg[$k]/$info[$k];
            if($res > 0.8)
            {
                $newall['sim1'] = $v+$newall['sim1'];
            }elseif ($res >0.6 && $res <= 0.8)
            {
                $newall['sim2'] =$v+$newall['sim2'];
            }elseif ($res >0.4 && $res <= 0.6){
                $newall['sim3'] =$v+$newall['sim3'];
            }elseif($res >0.2 && $res <= 0.4){
                $newall['sim4'] =$v+$newall['sim4'];
            }else{
                $newall['sim5'] =$v+$newall['sim5'];
            }
        }
        return $newall;
    }
    //  -----------------------------grow ------------------------------------

    function setSaveGroup()
    {
        $data['id'] = I('post.id/d',0);
        $title = I('post.title','','strip_tags');
        $group = I('post.group/d',0);
        if($title)
        {
            $data['title'] = $title;
            $data['level'] = $group;
            $res = M('grow_group')->save($data);
            if($res || $res==0) $this->success('修改成功');
        }
        $this->error('模块名不能为空','',1);
    }

    function addGrowDetails()
    {
        $pid = I('post.pid/d',0);
        $val = I('post.val','','strip_tags');
        $where['pid'] = $pid;
        $data = M('grow_details')->where($where)->field('val')->find();
        if($val)
        {
            if($data['val']){
                $vals = $data['val'].$val.'|';
                $infos['val'] = $vals;
                $res = M('grow_details')->where('pid = '.$pid)->save($infos);
            }else{
                $vals = $val.'|';
                $where['val'] = $vals;
                $res = M('grow_details')->add($where);
            }

            if($res) $this->success('添加成功');
        }
        $this->error('添加失败','',1);
    }
    /*
     * 获取模块对应的列
     */
    function getGrowinfos()
    {
        $pid  = I('post.id/d',0,'intval');
        if($pid)
        {
            $userinfo = M()->table('feiyue_grow_studentinfo as a,feiyue_stuentinfo as b')
                           ->where('a.userid = b.rec_id and a.pid ='.$pid)
                            ->field('b.stu_name,a.info,a.uname,a.toexam_name,a.state,a.id')
                            ->select();
            if($userinfo && count($userinfo)>0 ){
                foreach ($userinfo as $k=>$v) {
                    $stuname = [$v['stu_name']];
                    $infos = explode('|',$v['info']);
                    $newarray[] = array_merge($stuname,$infos,[$v['uname'],$v['toexam_name'],'state'=>$v['state'],'id'=>$v['id']]);
                }
            }
            $info = M('grow_details')->where('pid ='. $pid)->find();
            $details = explode('|',rtrim($info['val'],'|')) ;

            echo json_encode(array(array('success'=>true,'data'=>$details,'info'=>$newarray)));
            return;
        }
        $this->failajax();
    }
    /*
     * 获取选择的年级
     */
    function chosegrade()
    {
        if(IS_POST)
        {
            if(I('post.tips',0))
            {
                $ocode = session('admin.school_id');
                $where['area_bh'] = substr($ocode,0,6);
                $where['ocode'] = substr($ocode,6);
                $where['class_type_bh'] = I('post.tips',0);
                $data = M('classinfo')->where($where)->field('class_name,class_bh')->select();
                if($data && count($data)>0) $this->successajax('',$data);
                return ;
            }
        }
        $this->failajax();
    }
    function choseclass()
    {
        if(IS_POST)
        {
            $tips = I('post.tips');
            $ocode = session('admin.school_id');
            if($tips)
            {
                $where['AREAOCODE'] = substr($ocode,0,6);
                $where['OCODE'] = substr($ocode,6);
                $where['STU_BANJI'] = $tips;
                $data = M('stuentinfo')->where($where)->field('stu_name,rec_id')->select();
                if($data && count($data)>0) $this->successajax('',$data);
                return ;
            }
        }
        $this->failajax();
    }
    function growAddInfo()
    {
        $name = M('user')->field('relname')->find(session('admin.id'));
        $uid = I('post.uid');
        $info = I('post.info');
        $userid = explode('|',rtrim($uid,'|'));
        if($userid && count($userid)>0)
        {
            foreach ($userid as $k=>$v) {
                $data[] = array(
                    'userid' => $v,
                    'info'  => substr($info,0,-1),
                    'uid'   => session('admin.id'),
                    'regtime'   => date('Y-m-d H:i:s'),
                    'pid'   => I('post.pid/d',0),
                    'uname' => $name['relname']
                );
            }
            $res = M('grow_studentinfo')->addAll($data);
            if($res) $this->successajax();
            return;
        }
        $this->failajax();
    }

    function setGrowState()
    {
        $id = I('post.id/d',0);
        $model = M('grow_group');
        $data =$model->find($id);
        if($data['state']){
            $data['state'] = 0;
        }else{
            $data['state'] = 1;
        }
        if($model->save($data)){
            $this->successajax('',$data['state']);
        }else{
            $this->failajax();
        }
    }
    function delGrowgroup()
    {
        $id = I('post.id/d',0);
        if($id)
        {
            if(M('grow_group')->delete($id)){
                $this->successajax();
                return;
            }
        }
        $this->failajax();
    }


    function testemail()
    {
        $url = "http://api.sendcloud.net/apiv2/mail/send";
        $post_data = array(
            'apiUser'   => 'Yann_mty_test_yPh5f0',
            'apiKey'    => '',
            'from'      => 'Yann<1257929956@qq.com>',
            'to'        => '1257929956@qq.com',
            'subject'   => '你好',
            'html'      => '1234431'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        print_r($output);
    }










}