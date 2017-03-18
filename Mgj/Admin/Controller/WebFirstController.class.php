<?php
	namespace Admin\Controller;

	class WebFirstController extends CommonController
	{
		public function index()
		{
			$this->lunbo = $this->picInfo();
			$this->display('index');
		}

		/**
		 * 	获取轮播图片
		 */
		public function picInfo()
		{
			$pic = M('web');
			$info = $pic->order('id desc')->select();
			return $info;
		}

		/**
		 * 	图片删除
		 */
		public function picDel ()
		{
			$id = I('get.id');
			$pic = M('web');
			$img = $pic->field('lunbo')->find($id);
			unlink($img);
			$pic->delete($id);
			$this->index();
		}

		public function add ()
		{
			if (isset($_FILES['lunbopic']) && $_FILES['lunbopic']['error'] == 0)
			{
				$path['lunbo'] = $this->picUpload();
				$web = M('web');

				$web->add($path);
			}
			$this->display();
		}

		/**
		 * 	图片上传
		 *
		 */
		public function picUpload ()
		{
			$field = array_keys($_FILES);

			$upload = new \Think\Upload();
			// 实例化上传类
			$upload->maxSize   = 3145728 ;
			// 设置附件上传大小
			$upload->exts      = array('jpg', 'gif', 'png', 'jpeg');
			// 设置附件上传类型
			$upload->savePath  =  '/Uploads/';
			// 设置附件上传目录
			$upload->rootPath  = './Public' ;
			// 上传文件
			$info   =   $upload->upload();
			//拼接图片的路径
			$path = trim($upload->rootPath,'.').$info[$field[0]]['savepath'].$info[$field[0]]['savename'];
			return $path;
		}

		/**
		 * 	首页分区
		 *
		 */
		public function fenQu()
		{
			$fen = M('fenqu');

			$f = $fen->order('id desc')->select();

			$this->f = $f;

			$this->display('fenQu');
		}

		/**
		 * 	分区修改
		 *
		 */
		public function modifyFenQu()
		{

		}

		/**
		 *  分区删除
		 *
		 */
		public function delFenQu()
		{
			$fen = M('fenqu');

			$f = $fen->delete(I('get.id'));

			$this->ajaxReturn($f);
		}


	}