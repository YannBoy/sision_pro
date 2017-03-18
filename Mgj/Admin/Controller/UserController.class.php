<?php
	namespace Admin\Controller;

	class UserController extends CommonController
	{
		/**
			用户信息注册
		**/
		public function add(){
            $model = M('area');
            $arr = D('User')->get_school_nav();
            $this->assign('data_nav',$arr);
            $data = $model->where("area_bh like '__0000'")->select();
            $this->assign('area',$data);
			$this->display();
		}
        public function addteacher(){
            $model = M('area');
            $data = $model->where("area_bh like '__0000'")->select();
            //$course = M('courseinfo')->where("rec_id != 21")->select();
            $course  = M('school_curriculum')->where('ocode = '.$_SESSION['admin']['school_id'])->select();

            //var_dump($course);
            $this->assign('course',$course);
            $this->assign('area',$data);
            $this->display();
        }


		/**
			关联两表添加
		**/
//		public function insert(){
//            if(empty($_POST['username'])) $this->error('手机号不能为空');
//            if(empty($_POST['password'])) $this->error('密码不能为空');
//            $model = M('user');
//            $username = $model->where(array('username'=>$_POST['username']))->find();
//            if($username) $this->error('此号码已存在');
//            if(I('password') != I('repassword')) $this->error('两次密码不一致');
//            $_POST['password'] = md5($_POST['password']);
//            $data = $_POST;
//			$user = M("user");
//			$data['rtime'] = time();
//			//create()创建数据对象，把提交来的数组中的值放入对象的成员属性data中，但数据的下标与表字段名相同的才会放入，默认是得到POST中的值
//			if($user -> create($data)){
//				if($user -> add()){
//					$userid = $user->getlastInsID();
//					$d['userid'] = $userid;
//					$rtime = time();
//					$d['rtime'] = $rtime;
//                    $detail = M('user_detail');
//					if($detail -> create($d)){
//						//像数据库中添加数据
//						$detail -> add();
//                        $_POST['type'] == 0 ? $this -> redirect("User/index") : $this -> redirect("User/teacher");
//					}else{
//						$this->error('添加失败');
//					}
//					//redirect()重定向
//					$this -> redirect("User/index");
//
//				}else{
//					$this->error('添加失败');
//				}
//			}
//		}

        public function add_student(){
            if(empty($_POST['username'])) $this->error('手机号不能为空');
            if(empty($_POST['class_num'])) $this->error('请选择班级');
            $model = M('stuentinfo');
            $username = $model->where(array('STU_MOBILE'=>$_POST['username']))->find();
            if($username) $this->error('此号码已存在');
            $stu_bh = $model->order('REC_ID DESC')->find()['stu_bh'];
            $stu_bh == '' ? $num = '000' : $num = $stu_bh+1;
            if(strlen($num) == 1){
                $num = '00'.$num;
            } elseif(strlen($num) == 2){
                $num = '0'.$num;
            } elseif(strlen($num) == 3){
                $num = $num;
            }
            $data = array(
                'STU_MOBILE'    => $_POST['username'],
                'STU_NAME'      => $_POST['relname'],
                'STU_SEX'       => $_POST['sex'],
                'AREAOCODE'     => $_POST['num3'],
                'OCODE'          => $_POST['school_num'],
                'STU_BANJI'     => $_POST['class_num'],
                'STU_ROLLBH'    => $_POST['STU_ROLLBH'],
                'REG_TIME'      => date('Y-m-d'),
                'STU_BH'        =>  $num,

            );
            $list = $model->add($data) ? $this->success('添加学生成功') : $this->error('添加失败');
        }

		/**
			用户的信息展示(两表关联查询)
		**/
		public function index()
		{
		    $this_sch = M('classaccessinfo')->where('userid = '.$_SESSION['admin']['id'].' and class_bh = '.$_SESSION['admin']['school_id'])->find();
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
            $num = !empty($num) ? $num : 10;
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
            $data = $model->order('STU_ROLLBH desc')->where($where)->limit($limit)->select();
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
			$this->display();
		}

        //已授权用户列表
        public function group_user()
        {
            $user = M('user');
            $detail = M('user_detail');
            //获取分页框需要显示的数量
            $num = I('get.num');
            $num = !empty($num) ? $num : 10;
            $keyword = I('get.keyword');
            if(!empty($keyword)){
                $where['a.relname']=array('LIKE','%'.$keyword .'%');
            }
            $where['a.isdelete']=array('eq',0);
            $first = substr($_SESSION['admin']['school_id'],0,6);
            $foot = substr($_SESSION['admin']['school_id'],-3);
            $where['a.num3'] = $first;
            $where['a.school_num'] = $foot;
            //获取总数
            $count = $user->alias('a')->where($where)->count();	//查询满足要求的总记录数
            //创建分页对象
            $page = new \Think\Page($count,$num);
            //获得limit参数
            $limit = $page->firstRow.','.$page->listRows;
            $show = $page->show();
            //获取当前页码下的数据
            $res = $user->alias('a')->field('a.*,b.*,c.*,d.area_name')
                ->join('left join feiyue_user_detail b on a.id=b.userid')
                ->join('left join feiyue_user_auth_group c on c.id=b.groupid')
                ->join('left join feiyue_area d on a.num3 = d.area_bh')
                ->order('b.userid desc')->where($where)->limit($limit)->order('convert(a.relname using gb2312) ASC')->select();
            $this->assign('page',$show);
            $this->assign('data',$res);
            $this->assign('num',$num);
            $this->assign('keyword',$keyword);
            $this->display();
        }

		/**
			学生详情的编辑
		**/
		public function edit(){
            $id = $_GET['id'];
			$data = M('stuentinfo')->find($_GET['id']);
            $areaocode = substr($data['areaocode'],0,2).'0000';
            $areashi = substr($data['areaocode'],0,4).'00';
            $num['1'] = M()->table('feiyue_stuentinfo a,feiyue_area b')->where("a.rec_id = $id and $areaocode = b.area_bh")->field('b.area_bh,b.area_name')->find();
            $num['2'] = M()->table('feiyue_stuentinfo a,feiyue_area b')->where("a.rec_id = $id and $areashi = b.area_bh")->field('b.area_bh,b.area_name')->find();
            $num['3'] = M()->table('feiyue_stuentinfo a,feiyue_area b')->where("a.rec_id = $id and $data[areaocode] = b.area_bh")->field('b.area_bh,b.area_name')->find();
            $num['4'] = M()->table('feiyue_stuentinfo a,feiyue_shoollist b')->where('a.rec_id = '.$id.' and '.$data['areaocode']. '= b.area_bh')->field('b.ocode,b.ocode_name')->find();
            $num['5'] = M()->table('feiyue_stuentinfo a,feiyue_classinfo b')->where("a.rec_id = $id and $data[stu_banji] = b.class_bh and $data[areaocode] = b.area_bh")->field('b.class_bh,b.class_name')->find();
            $model = M('area');
            $area = $model->where("area_bh like '__0000'")->select();
            $this->assign('area',$area);
            $this->assign('num',$num);
            $this->assign('list',$data);
			$this->display();
		}
        //用户编辑
        public function user_edit(){
            $id = $_GET['id'];
            $data = M('user')->find($_GET['id']);
            $area_name['area1'] = M('area')->where('area_bh = '.substr($_SESSION['admin']['school_id'],0,2).'0000')->field('area_name,area_bh')->find();
            $area_name['area2'] = M('area')->where('area_bh = '.substr($_SESSION['admin']['school_id'],0,4).'00')->field('area_name,area_bh')->find();
            $area_name['area3'] = M('area')->where('area_bh = '.substr($_SESSION['admin']['school_id'],0,6))->field('area_name,area_bh')->find();
            $school_name = M('shoollist')->where('area_bh = '.substr($_SESSION['admin']['school_id'],0,6).' and ocode = '.substr($_SESSION['admin']['school_id'],6,3))->field('ocode_name,ocode')->find();
            $class_name = M('classinfo')->where('area_bh = '.substr($_SESSION['admin']['school_id'],0,6).' and ocode = '.substr($_SESSION['admin']['school_id'],6,3))->field('class_bh,class_name')->select();
            $group = M()->table('feiyue_user_auth_group a,feiyue_user_auth_group_access b')
                        ->where('b.uid = '.$id.' and b.ocode = '.$_SESSION['admin']['school_id'].' and a.ocode = b.ocode and b.group_id = a.id')
                        ->field('a.id,a.title')->find();
            $group_list = M('user_auth_group')->where('ocode ='.$_SESSION['admin']['school_id'])->select();
            $model = M('area');
            $area = $model->where("area_bh like '__0000'")->select();
            $exist = D('User');
            $exist = $exist->get_area($id);
            $this->assign('area_name',$area_name);
            $this->assign('school_name',$school_name);
            $this->assign('class_name',$class_name);
            $this->assign('exist',$exist);
            $this->assign('group',$group);
            $this->assign('area',$area);
            $this->assign('list',$data);
            $this->assign('group_list',$group_list);
            $this->display();
        }

		/**
			学生信息的修改
		**/
        public function update(){

            if(empty($_POST['class_num'])) $this->error('请选择班级');
            $User = M('stuentinfo'); // 实例化User对象
            $data = array(
                'rec_id'    => $_POST['rec_id'],
                'STU_NAME'  =>  $_POST['stu_name'],
                'STU_ROLLBH'    =>  $_POST['stu_rollbh'],
                'AREAOCODE' =>  $_POST['num3'],
                'OCODE' =>  $_POST['school_num'],
                'STU_BANJI' =>  $_POST['class_num'],
                'STU_SEX'   =>  $_POST['stu_sex'],
                'UPDATE_TIME'   =>  date('Y-m-d'),
                'STU_NOTE'  =>  $_POST['stu_note'],
            );
            if($User->save($data)){
                $this->success('修改成功');
            } else {
                $this->error('修改失败');
            }
        }
//		public function update(){
//            var_dump($_POST);
//            exit;
//                $num = M('user');
//                $data = array(
//                    'id' => $_POST['id'],
//                    'num1' => $_POST['num1'],
//                    'num2' => $_POST['num2'],
//                    'num3' => $_POST['num3'],
//                    'school_num'=> $_POST['school_num'],
//                    'class_num' => $_POST['class_num'],
//                    'relname' => $_POST['relname']
//                );
//                $num = $num->save($data);
//
//			$detail = M('user_detail');
//			$userid = $_POST['id'];
//			$result = $detail->where("userid=".$userid)->find();
//			//实例化用户组
//			$group = M('user_auth_group');
//			$g = $group->where("id=".$result['groupid'])->find();
//			//实例化用户组对应表
//			$access = M("user_auth_group_access");
//			$r = $access->where('uid='.$userid)->find();
//			if(!$r){
//				$arr = array("uid"=>$userid,"group_id"=>$_POST['groupid']);
//				$access->add($arr);
//			}else{
//				$arr = array("group_id"=>$_POST['groupid']);
//				$access->where('uid='.$userid)->save($arr);
//			}
//			$detail->create();
//			$res = $detail->where("userid=".I('post.id'))->save();
//			if($res || $num){
//                $_POST['groupid'] == '30' ? $this->success('用户信息修改成功','index') : $this->success('用户信息修改成功','teacher') ;
//			}else{
//                $this->error('用户信息修改失败','index');
//			}
//		}
        //用户

        //用户修改
        public function user_update(){

            $data = array(
                'id'    => $_POST['id'],
                'relname' => $_POST['relname'],
            );
            $group = array(
                'uid' => $_POST['id'],
                'group_id' => $_POST['group_id'],
                'ocode'=>$_SESSION['admin']['school_id']
            );
            $list = array(
                'userid' => $_POST['id'],
                'groupid' => $_POST['group_id'],
            );
            M('user_auth_group_access')->where('uid = '.$_POST['id'].' and ocode = '.$_SESSION['admin']['school_id'])->save($group);
            M('user_detail')->save($list);
            M('user')->save($data);
            $this->success('修改信息成功');


        }
		/**
			用户详情的删除
		**/
		public function delete(){
			$id = $_GET['id'];
			$user = M('user');
			$arr = array("id"=>$id,"isdelete"=>1);
			$res = $user->save($arr);
			if($res){
				redirect(U('Admin/User/group_user'));
			}else{
				redirect(U('Admin/User/group_user'));
			}
		}

        public function stu_del(){
            $id = I('post.id');
            if(M('stuentinfo')->delete($id)){
                $this->successajax('删除成功');
            } else {
                $this->failajax('删除失败,请稍后再试');
            }

        }
            //  省级下拉框
        public  function find_num(){
            $num = substr(($_POST['num_id']),0,2).'__00';
            $no = substr(($_POST['num_id']),0,2).'0000';
            $model = M('area');
            $data = $model->where("area_bh != $no and area_bh like '$num'")->select();

            echo json_encode(array(array('success'=>'true','data'=>$data)));
        }
            //  市级下拉框
        public function find_num2(){
            $num = substr(($_POST['num_id']),0,4).'__';
            $no = substr(($_POST['num_id']),0,4).'00';
            $model = M('area');
            $data = $model->where("area_bh != $no and area_bh like '$num'")->select();
            echo json_encode(array(array('success'=>'true','msg'=>'haode','data'=>$data)));

        }

        //获取学校的下拉框
        public function find_num4(){
            $num = $_POST['num_id'];
            $model = M('shoollist');
            $data = $model->where("area_bh = $num")->select();
            echo json_encode(array(array('success'=>'true','data'=>$data)));
        }

        // 获取班级
        public function find_num5(){
            $num = $_POST['num_id'];
            $model = M('classinfo');
            $data = $model->where("ocode = $num and area_bh = $_POST[ocode]")->select();
            echo json_encode(array(array('success'=>'true','data'=>$data)));
        }

        //教师列表
        public function teacher()
        {
            $user = M('teacherinfo');
            //获取分页框需要显示的数量
            $num = I('get.num');
            $num = !empty($num) ? $num : 10;
            $keyword = I('get.keyword');
            if(!empty($keyword)){
                $where['tea_name']=array('LIKE','%'.$keyword .'%');
            }
            $first = substr($_SESSION['admin']['school_id'],0,6);
            $foot = substr($_SESSION['admin']['school_id'],-3);
            $where['area_bh'] = $first;
            $where['ocode'] = $foot;
            //获取总数
            $count = $user->where($where)->count();	//查询满足要求的总记录数
            //创建分页对象
            $page = new \Think\Page($count,$num);
            //获得limit参数
            $limit = $page->firstRow.','.$page->listRows;
            $show = $page->show();
            //获取当前页码下的数据
//            $res = $user->alias('a')->field('a.*,b.course_name')
//                ->join('left join feiyue_courseinfo b on a.tea_coursebh=b.course_bh')
//                ->order('a.reg_time desc')->where($where)->limit($limit)->select();
            $res = $user->order('convert(tea_name using gb2312) ASC')->where($where)->limit($limit)->select();
            $arr= D('User')->get_school_nav();
            $this->assign('data_nav',$arr);
            $this->assign('page',$show);
            $this->assign('data',$res);
            $this->assign('num',$num);
            $this->assign('keyword',$keyword);
            $this->display();
        }

        public function edit_teacher(){
            $id = $_GET['id'];
            $data = M('teacherinfo')->find($_GET['id']);
            $areaocode = substr($data['area_bh'],0,2).'0000';
            $areashi = substr($data['area_bh'],0,4).'00';
            $area_ocode = $data['area_bh'];
            $num['1'] = M()->table('feiyue_teacherinfo a,feiyue_area b')->where("a.rec_id = $id and $areaocode = b.area_bh")->field('b.area_bh,b.area_name')->find();
            $num['2'] = M()->table('feiyue_teacherinfo a,feiyue_area b')->where("a.rec_id = $id and $areashi = b.area_bh")->field('b.area_bh,b.area_name')->find();
            $num['3'] = M()->table('feiyue_teacherinfo a,feiyue_area b')->where("a.rec_id = $id and $area_ocode = b.area_bh")->field('b.area_bh,b.area_name')->find();
            $num['4'] = M()->table('feiyue_teacherinfo a,feiyue_shoollist b')->where("a.rec_id = $id and '$data[ocode]' = b.ocode and b.area_bh = '$data[area_bh]'")->field('b.ocode,b.ocode_name')->find();
            if($data['tea_classbh']) $num['5'] = M()->table('feiyue_teacherinfo a,feiyue_classinfo b')->where("a.rec_id = $id and $data[tea_classbh] = b.class_bh and $data[area_bh] = b.area_bh and $data[ocode] = b.ocode")->field('b.class_bh,b.class_name')->find();
            $num['6'] = M('teacherinfo')->where('rec_id = '.$id)->field('tea_coursebh')->find();
            $course = M('school_curriculum')->where('ocode = '.$_SESSION['admin']['school_id'])->field('name')->select();
            $arr= D('User')->get_school_nav();
            $this->assign('data_nav',$arr);
            $this->assign('course',$course);
            $model = M('area');
            $area = $model->where("area_bh like '__0000'")->select();
            $this->assign('area',$area);
            $this->assign('num',$num);
            $this->assign('list',$data);
            $this->display();
        }

        //学生转换为用户
        public function stu_add(){
            $id = explode(',',$_POST['id']);
            $model = M('stuentinfo');
            $i = 0;
            foreach($id as $v){
                $list = $model->where(array('rec_id = '.$id[$i].''))->find();
                $data = array(
                    'username' => $list['stu_mobile'],
                    'password' => md5(substr($list['stu_mobile'],-6)),
                    'num1' =>   substr($list['areaocode'],0,2).'0000',
                    'num2' =>   substr($list['areaocode'],0,4).'00',
                    'num3' =>   $list['areaocode'],
                    'school_num' => $list['ocode'],
                    'class_num'  => $list['stu_banji'],
                    'relname'    => $list['stu_name'],
                );
                $res = M('user')->add($data);
                $grounp['uid'] = $res;
                $grounp['group_id'] = '30';
                M(user_auth_group_access)->add($grounp);
                $r['groupid'] = '30';
                $r['userid'] = $res;
                $r['rtime'] = date('Y-m-d');
                M(user_detail)->add($r);
                $state['STATE'] = 1;
                $state['REC_ID'] = $id[$i];
                $model->save($state);
                $i++;
            }
            if ($res){
                echo json_encode(array(array('success'=>true,'msg'=>'转换成功')));
            } else {
                echo json_encode(array(array('success'=>false,'msg'=>'转换失败,请稍后再试')));
            }
        }
        //添加教师
        public function insert_teacher(){
            if(empty($_POST['school_num'])) $this->error('请选择一所学校');
            $tea_mobile = M('user')->where('username = '.$_POST['tea_mobile'])->find();
            if(!empty($tea_mobile)) $this->error('该手机已被注册');
            $model = M('teacherinfo');
            $mobile = $model->where(array('tea_mobile'=>$_POST['tea_mobile']))->find();
            if($mobile) $this->error('此号码已存在');
            $stu_bh = $model->order('REC_ID DESC')->find()['tea_bh'];
            $stu_bh == '' ? $num = '000' : $num = $stu_bh+1;
            if(strlen($num) == 1){
                $num = '00'.$num;
            } elseif(strlen($num) == 2){
                $num = '0'.$num;
            };
            $ocode = $_POST['school_num'];
            if($_POST['class_num']) $ocode = $_POST['class_num'];
            $data = array(
                'tea_mobile' => $_POST['tea_mobile'],
                'tea_bh'  => $num,
                'tea_name' => $_POST['tea_name'],
                'ocode' => $_POST['school_num'],
                'area_bh' => $_POST['num3'],
                'tea_classbh' => $_POST['class_num'],
                'tea_coursebh' =>  $_POST['grade'],
                'reg_time' =>   date('Y-m-d'),

           );
            M('teacherinfo')->add($data) ?$this->success('添加成功') : $this->error('添加失败');
        }


        //转换用户(教师)
        public function adduser_teacher(){
            $id = explode(',',$_POST['id']);
            $model = M('teacherinfo');
            $i = 0;
            foreach($id as $v){
                $list = $model->where(array('rec_id = '.$id[$i].''))->find();
                $data = array(
                    'id'  =>    $list['rec_id'],
                    'username' => $list['tea_mobile'],
                    'password' => md5(substr($list['tea_mobile'],-6)),
                    'num1' =>   substr($list['area_bh'],0,2).'0000',
                    'num2' =>   substr($list['area_bh'],0,4).'00',
                    'num3' =>   $list['area_bh'],
                    'school_num' => $list['ocode'],
                    'class_num'  => $list['tea_classbh'],
                    'relname'    => $list['tea_name'],
                    'grade'     => $list['tea_coursebh']
                );
                $res = M('user')->add($data);
                $grounp['uid'] = $res;
                $grounp['group_id'] = '33';
                $grounp['ocode'] = $_SESSION['admin']['school_id'];
                M(user_auth_group_access)->add($grounp);
                $r['groupid'] = '33';
                $r['userid'] = $res;
                $r['rtime'] = date('Y-m-d');
                M(user_detail)->add($r);
                $state['state'] = 1;
                $state['rec_id'] = $id[$i];
                $model->save($state);
                $i++;
            }
            if ($res){
                $this->successajax('转换成功');
            } else {
                $this->failajax('转换失败,请稍后再试');
            }
        }

        //修改教师信息
        public function update_teacher(){
            if(empty($_POST['school_num'])) $this->error('请选择一所学校');
            $data = array(
                'rec_id' => $_POST['id'],
                'tea_name' => $_POST['tea_name'],
                'tea_coursebh' => $_POST['grade'],
                'tea_jobbh'  => $_POST['tea_jobbh'],
                'tea_depth'  => $_POST['tea_depth'],
                'ocode'     => $_POST['school_num'],
                'tea_classbh' => $_POST['class_num']
            );
            $model = M('teacherinfo');
            if($model->save($data)){
                $this->success('修改成功');
            } else {
                $this->error('修改失败');
            }

        }

        //直接添加用户
        public function admin_adduser(){
            $model = M('area');
            $data = $model->where("area_bh like '__0000'")->select();
            $group_list = M('user_auth_group')->where('ocode ='.$_SESSION['admin']['school_id'])->select();
            $this->assign('group',$group_list);
            $this->assign('area',$data);
            $this->display();
        }

        public function admin_insertuser(){
            $username = M('user')->where(array('username'=>$_POST['username']))->find();
            if($username) $this->error('此号码已存在');
            $_POST['password']= md5(substr($_POST['username'],-6));
            $data  = array(
                'username' => $_POST['username'],
                'relname' => $_POST['relname'],
                'num1' => $_POST['num1'],
                'num2' => $_POST['num2'],
                'num3' => $_POST['num3'],
                'school_num' => $_POST['school_num'],
                'class_num' => $_POST['class_num'],
                'password' => $_POST['password'],
            );
            $res = M('user')->add($data);
            $grounp['uid'] = $res;
            $grounp['group_id'] = $_POST['group_id'];
            M(user_auth_group_access)->add($grounp);
            $r['groupid'] = $_POST['group_id'];
            $r['userid'] = $res;
            M(user_detail)->add($r);
            if($res){
                $this->success('添加成功');
            } else {
                $this->error('添加失败');
            }
        }

        //删除教师
        public function tea_del(){
            $id = I('post.id');
            if(M('teacherinfo')->delete($id)){
                $this->successajax('删除成功');
            } else {
                $this->failajax('删除失败,请稍后再试');
            }
        }

        public function user_quanxian(){
            $data = D('User')->del_user_quanxian($_POST['rec_id']);
            $data ? $this->successajax('删除成功') : $this->failajax('删除失败,请稍后再试');
        }

        //用户区域权限添加
        public function user_add_quanxian(){
            if(!$_POST['ocode']){
                $this->failajax('至少选择一所学校');
                return false;
            }
            $data = D('User')->add_user_quanxian($_POST);
            if($data){
                $this->successajax('添加成功');
            }else{
                $this->failajax('添加失败,请稍后再试');
            }

        }

        public function exam(){
            if($_POST['table'] == 'teacherinfo'){
                $data['rec_id'] = $_POST['id'];
                $data['vidflag'] = $_POST['vidflag'];
            }elseif($_POST['table'] == 'stuentinfo'){
                $data['rec_id'] = $_POST['id'];
                $data['vidflag'] = $_POST['vidflag'];
            }elseif($_POST['table'] == 'user'){
                $data['id'] = $_POST['id'];
                $data['vidflag'] = $_POST['vidflag'];
            }
            M($_POST['table'])->save($data) ? $this->successajax('操作成功') : $this->failajax('网络异常,请稍后再试');
        }

        //用户身份管理
        public function identity(){
            if($_POST['desc'] == 'add'){
                $data['userid'] = $_POST['id'];
                $data['ocode'] = $_SESSION['admin']['school_id'];
                $data['identity'] = $_POST['identity'];
                if(M('school_identity')->add($data)){
                    $tip = M('school_identity')->where('userid = '.$_POST['id'])->field('identity,id')->select();
                    $this->successajax('添加成功',$tip);
                }else{
                    $this->failajax('服务器异常,请稍后再试');
                }
            }elseif($_POST['desc'] == 'del'){
                $del = M('school_identity')->delete($_POST['id']);
                if($del){
                    $tip = M('school_identity')->where('userid = '.$_POST['id'])->field('identity,id')->select();
                    $this->successajax('添加成功',$tip);
                }else{
                    $this->failajax('服务器异常,请稍后再试');
                }
            }
        }


        function edit_user_tel()
        {
            $data['rec_id'] = $_POST['id'];
            $data['STU_MOBILE'] = $_POST['tel'];

            $model = M('stuentinfo')->save($data);
            if($model || $model == 0)
            {
                $this->successajax();
                return;
            }
            $this->failajax();
        }

        function userdetailed()
        {
            $id = I('get.id/d',0);
            $userinfo = M('grow_studentinfo')->where('userid = '.$id)->field('info,pid,uname,toexam_name')->select();
            $grow = M('')->table('feiyue_grow_details as a,feiyue_grow_group as b')
                         ->where('b.ocode = '.session('admin.school_id').' and b.id = a.pid')
                         ->order('b.level desc')
                         ->field('b.title,b.id,a.val')
                         ->select();
            if($grow && count($grow)>0)
            {
                foreach ($grow as $k=>$v) {
                    $tip = explode('|',rtrim($v['val'],"|"));
                    $grow[$k]['val'] = $tip;
                    foreach ($userinfo as $items=>$item) {
                        if($v['id'] == $item['pid'])
                        {
                            $userdetail = explode('|',$item['info']);
                            $arr = [$item['uname'],$item['toexam_name']];
                            $newarr = array_merge($userdetail,$arr);
                            $grow[$k]['info'][] = $newarr;
                        }
                        $grow[$k]['count'] = count($grow[$k]['info'])+1;
                    }
                }
                $this->assign('info',$grow);
            }
            $users = M('stuentinfo')->field('stu_name,id_number,family_name,stu_place')->find($id);

            $this->assign('user',$users);
            $this->display();
        }

	}


















