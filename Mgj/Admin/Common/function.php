<?php


	//获取性别的函数
	function getSex($sex){
		switch($sex){
			case 0:
				return '女';
			case 1:
				return '男';
			case 2:
				return '保密';
		}
	}



	//网站配置开关显示的函数
	function getSwitch($switch){
		switch($switch){
			case 0:
				return '开';
			case 1:
				return '关';
		}

	}

	//图片自定义函数
	function getFileName(){
		return time().rand(1,100200);
	}

