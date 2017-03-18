<?php
namespace Admin\Controller;
class AreaController extends CommonController{

    public function index(){
        $num = I('get.num');
        $num = !empty($num) ? $num : 10;
        $keyword = I('get.keyword');
        if(!empty($keyword)){
            $where['area_name']=array('LIKE','%'.$keyword .'%');
        }
        $model = M('area');
        $count = $model->where($where)->count();	//查询满足要求的总记录数
        //创建分页对象
        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();
        $data = M('area')->where($where)->limit($limit)->select();
        $arr = D('User')->get_school_nav();
        $this->assign('data_nav',$arr);
        //var_dump($data);
        $this->assign('list',$data);
        $this->assign('page',$show);
        $this->assign('num',$num);
        $this->assign('keyword',$keyword);
        $this->display();
    }
    /*
        地区添加
    */
    public function area_insert(){
        $area_name = M('area')->where(array('area_name'=>$_POST['area_name']))->find();
        $area_bh = M('area')->where(array('area_bh'=>$_POST['area_bh']))->find();
        if($area_name) {
            echo json_encode(array(array('success' =>false,'msg'=>'该地区名称已存在')));
        } else {
            if($area_bh) {
                echo json_encode(array(array('success' =>false,'msg'=>'该地区编号已存在')));
            } else {
                $_POST['reg_time'] = date('Y-m-d');
                $area = M('area')->add($_POST);
                if($area){
                    echo json_encode(array(array('success'=>true,'msg'=>'添加成功')));
                } else {
                    echo json_encode(array(array('success'=>false,'msg'=>'网络异常请稍后再试')));
                }
            }
        }

    }

    public function area_update(){
        $data = M('area')->where(array('rec_id'=>$_POST['rec_id']))->find();
        if($data) echo json_encode(array(array('success'=>true,'list'=>$data)));
    }

    public function area_edit(){
        $area_name = M('area')->where("area_name = '$_POST[area_name]' and rec_id != $_POST[rec_id]")->find();
        $area_bh = M('area')->where("area_bh = $_POST[area_bh] and rec_id != $_POST[rec_id]")->find();
        if($area_name) {
            echo json_encode(array(array('success' =>false,'msg'=>'该地区名称已存在')));
        } else {
            if($area_bh) {
                echo json_encode(array(array('success' =>false,'msg'=>'该地区编号已存在')));
            } else {
                if(M('area')->save($_POST)){
                    echo json_encode(array(array('success'=>true,'msg'=>'修改成功')));
                } else {
                    echo json_encode(array(array('success'=>false,'msg'=>'网络异常请稍后再试')));
                }
            }
        }
    }
    //删除地区
    public function area_del(){
        $model = M('area');
        if($model->delete("$_POST[rec_id]")){
            echo json_encode(array(array('success'=>true,'msg'=>'删除成功')));
        } else {
            echo json_encode(array(array('success'=>false,'msg'=>'网络异常请稍后再试')));
        }
    }

}