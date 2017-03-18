<?php
/**
 * Created by PhpStorm.
 * User: mty
 * Date: 2017/3/9
 * Time: 下午1:06
 */
namespace Admin\Controller;

class GrowController extends CommonController
{
    public function index()
    {
        $where['ocode'] = session('admin.school_id');
        $data = M('grow_group')->where($where)->order('level desc')->select();
        $this->assign('info',$data);
        $this->display();
    }

    public function addNewGrow()
    {
        $data['ocode'] = session('admin.school_id');
        $title = I('post.title','','strip_tags');
        $data['level'] = I('post.level/d',0);
        $data['state'] = I('post.state/d',0);
        if($title)
        {
            $data['title'] = $title;
            $res = M('grow_group')->add($data);
            if($res) $this->success('添加成功');
        }
        $this->error('模块名不能为空','',1);

    }

    function addGroupdetails()
    {
        $id = I('get.id/d',0);
        $data = M('grow_group')->find($id);
        $infos = M('grow_details')->where('pid = '.$id)->field('val')->find();
        $vals = explode('|',rtrim($infos['val'],'|')) ;
        foreach ($vals as $k=>$v) {
            if($v){
                $news[] = array(
                    'val'=>$v,
                    'key'=>$k
                );
            }
        }
        $this->assign('news',$news);
        $this->assign('info',$data);
        $this->display();
    }
    function record()  //档案记录
    {
        $ocode = session('admin.school_id');
        $where['ocode'] = $ocode;
        $data = M('grow_group')->where($where)->order('level desc,id desc')->select();
        $this->assign('info',$data);
        $this->display('Grow/record');
    }

    function setGrowinfo()
    {
        $name = M('user')->field('relname')->find(session('admin.id'));
        $type = I('post.val','');
        $where['id'] = I('post.id/d',0);
        if($type && $type =='growInto')  //审核通过
        {
            $where['state'] = 1;
            $where['toexam_id'] = session('admin.id');
            $where['toexam_name'] = $name['relname'];
            $res = M('grow_studentinfo')->save($where);
        }elseif ($type && $type='growOut'){  //审核失败
            $res = M('grow_studentinfo')->where($where)->delete();
        }
        if($res)
        {
            $this->successajax('',$name['relname']);
            return;
        } else{
            $this->failajax();
        }
    }
}