<?php
/**
 * Created by PhpStorm.
 * User: mty
 * Date: 2017/3/2
 * Time: 上午10:56
 */

namespace Admin\Controller;
use Carbon\Carbon;
use Think\Controller;

class VisitorController extends Controller
{
    function _initialize()
    {
        $color = M('oa_background')->where('uid ='.$_SESSION['admin']['id'])->find()['color'];
        $this->assign('color',$color);
        $arr = D('User')->get_school_nav();
        $area_bh = substr($_SESSION['admin']['school_id'],0,6);
        $ocode = substr($_SESSION['admin']['school_id'],-3);
        $ocode_name = M('shoollist')->where('area_bh ='.$area_bh.' and ocode ='.$ocode)->field('ocode_name')->find()['ocode_name'];
        $usernav = $this->getUserNav();
        $tel = session('admin.tel');
        $res = 0;
        if(M('user_supuser')->where('uid ='.$tel)->find())
        {
            $res = 1;
        }
        $this->assign('user_sup',$res);
        $this->assign('usernav',$usernav);
        $this->assign('ocode_name',$ocode_name);
        $this->assign('data_nav',$arr);
    }
    /*
     *   请假管理
     */
    function leavel()
    {
        $ocode = substr(session('admin.school_id'),-3);

        if($ocode != '000')
        {
            $where['hosid'] = session('admin.school_id');
        }else{
            $_ocode = substr(session('admin.school_id'),0,6);
            $where['hosid'] = array('like',"$_ocode%");
        }
        $ocode = I('get.vs_ocodename');
        if($ocode) $where['vs_ocodename'] = array('like',"%$ocode%");
        $name = I('get.vs_username');
        if($name) $where['vs_username'] = array('like',"%$name%");
        $starttime = I('get.starttime');
        if($starttime) $where['begintime'] = array('EGT',$starttime);
        if(I('get.endtime')) $where['begintime'] = array('ELT',I('get.endtime'));
        $cond = array(
            'vs_ocodename'  => $ocode,
            'vs_username'   => $name,
            'starttime'     => I('get.starttime'),
            'endtime'       => I('get.endtime')
        );
        $num = 15;
        $count = M('visitstudentevent')->where($where)->count();
        //创建分页对象
        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();
        $data  = M('visitstudentevent')->where($where)->order('rec_id desc')->limit($limit)->select();
        $this->assign('page',$show);
        $this->assign('cond',$cond);
        $this->assign('info',$data);
        $this->display();
    }

    function getUserNav()
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

    /*
     * 平屏公告
     */

    function curevent()
    {
        $ocode = substr(session('admin.school_id'),-3);

        if($ocode != '000')
        {
            $where['hosid'] = session('admin.school_id');
        }else{
            $_ocode = substr(session('admin.school_id'),0,6);
            $where['hosid'] = array('like',"$_ocode%");
        }
        $ocode = I('get.vs_ocodename');
        if($ocode) {
            //$where['vs_ocodename'] = array('like',"%$ocode%");
            $datawhere['ocode_name'] = array('like',"%$ocode%");
            $datas = M('shoollist')->where($datawhere)->find();
            $school_ocode = $datas['area_bh'].$datas['ocode'] ? $datas['area_bh'].$datas['ocode'] : 0000000;
            $where['HosId'] = $school_ocode;
        }
        $starttime = I('get.starttime');
        if($starttime) $where['begintime'] = array('EGT',$starttime);
        if(I('get.endtime')) $where['begintime'] = array('ELT',I('get.endtime'));
        $cond = array(
            'vs_ocodename'  => $ocode,
            'starttime'     => I('get.starttime'),
            'endtime'       => I('get.endtime')
        );
        $num = 15;
        $count = M('visitnotice')->where($where)->count();
        //创建分页对象
        $page = new \Think\Page($count,$num);
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();

        $data = M('visitnotice')->where($where)->limit($limit)->select();
        $this->assign('info',$data);
        $this->assign('page',$show);
        $this->assign('cond',$cond);
        $this->display();
    }

    /*
     * 通行记录
     */
    function curinfo()
    {
        $where['viType'] = 1;
        $where['hosId'] = session('admin.school_id');
        $data = M('visitorsinfo')->where($where)->order('rec_id desc')->select();
        $this->assign('info',$data);
        $this->display();
    }

    /*
     * 重点人员
     */
    function importantpeo()
    {
        $ocode = substr(session('admin.school_id'),-3);

        if($ocode != '000')
        {
            $where['hosid'] = session('admin.school_id');
        }else{
            $_ocode = substr(session('admin.school_id'),0,6);
            $where['hosid'] = array('like',"$_ocode%");
        }
        $ocode = I('get.vs_ocodename');
        if($ocode) {
            //$where['vs_ocodename'] = array('like',"%$ocode%");
            $datawhere['ocode_name'] = array('like',"%$ocode%");
            $datas = M('shoollist')->where($datawhere)->find();
            $school_ocode = $datas['area_bh'].$datas['ocode'] ? $datas['area_bh'].$datas['ocode'] : '0000000';
            $where['HosId'] = $school_ocode;
        }
        $name = I('get.vs_username');
        if($name) $where['SuSuserName'] = array('like',"%$name%");
        $starttime = I('get.starttime');
        if($starttime) $where['regTime'] = array('EGT',$starttime);
        if(I('get.endtime')) $where['regTime'] = array('ELT',I('get.endtime'));
        $cond = array(
            'vs_ocodename'  => $ocode,
            'vs_username'   => $name,
            'starttime'     => I('get.starttime'),
            'endtime'       => I('get.endtime')
        );
        $num = 15;
        $count = M('visitorssususer')->where($where)->count();
        //创建分页对象
        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();
        $data = M('visitorssususer')->where($where)->limit($limit)->select();
        $this->assign('page',$show);
        $this->assign('cond',$cond);
        $show = $page->show();
        $this->assign('info',$data);
        $this->assign('page',$show);
        $this->assign('cond',$cond);
        $this->display();
    }
    /*
     * 添加重点人员
     */
    function addimportantpeo()
    {
        $data = I('post.');
        $data['regTime'] = date('Y-m-d H:i:s');
        $data['HosId'] = session('admin.school_id');
        if(M('visitorssususer')->add($data))
        {
            $this->success('添加成功');
        }else{
            $this->error('添加失败');
        }
    }

    function order()
    {
        $ocode = substr(session('admin.school_id'),-3);
        if($ocode != '000')
        {
            $where['HosId'] = session('admin.school_id');
        }else{
            $_ocode = substr(session('admin.school_id'),0,6);
            $where['HosId'] = array('like',"$_ocode%");
        }
        $ocode = I('get.vs_ocodename');
        if($ocode) {
            //$where['vs_ocodename'] = array('like',"%$ocode%");
            $datawhere['ocode_name'] = array('like',"%$ocode%");
            $datas = M('shoollist')->where($datawhere)->find();
            $school_ocode = $datas['area_bh'].$datas['ocode'] ? $datas['area_bh'].$datas['ocode'] : 0000000;
            $where['HosId'] = $school_ocode;
        }
        $name = I('get.vs_username');
        if($name) $where['username'] = array('like',"%$name%");
        $starttime = I('get.starttime');
        if($starttime) $where['visitdate'] = array('EGT',$starttime);
        if(I('get.endtime')) $where['visitdate'] = array('ELT',I('get.endtime'));
        $cond = array(
            'vs_ocodename'  => $ocode,
            'vs_username'   => $name,
            'starttime'     => I('get.starttime'),
            'endtime'       => I('get.endtime')
        );
        $num = 15;
        $count = M('visityuyue')->where($where)->count();
        //创建分页对象
        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();
        $data = M('visityuyue')->where($where)->limit($limit)->select();
        $this->assign('page',$show);
        $this->assign('cond',$cond);
        $this->assign('info',$data);
        $this->display();
    }

    function visitorinfo()
    {
        $this->display();
    }
    /*
     * 访客记录
     */
    function  visitorlog()
    {

        $where['viType'] = 2;
        $where['hosId'] = session('admin.school_id');
        $data = M('visitorsinfo')->where($where)->order('rec_id desc')->select();
        $this->assign('info',$data);
        $this->display();
    }

    function delete()
    {

        $rec_id = I('post.rec_id',0,'intval');
        $where['rec_id'] = $rec_id;
        $table = I('post.table','','strip_tags');
        $res = M($table)->where($where)->delete();
        if($res)
        {
            echo json_encode(array('success'=>true));
        }else{
            echo json_encode(array('success'=>false));
        }

    }

    function addleavel()
    {
        $this->display();
    }

    function create_leavel()
    {
        if(IS_POST){
            $info = I('post.');
            $info['hosid'] = session('school_id');
            $res = M('visitstudentevent')->add($info);
            if($res)
            {
                $this->success('添加成功','leavel','2');
            }else{
                $this->error('添加失败');
            }
        }
        $this->error('非法请求');
    }

}



