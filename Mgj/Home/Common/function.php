<?php  

//获取商品状态的函数
	function getState($state){
		switch($state){
			case 1:
				return '新品发布';
			case 2:
				return '本季热卖';
			case 3:
				return '热门推荐';
			case 4:
				return '流行热卖';
			case 5:
				return '经典搭配';
			case 6:
				return '2016新款';
			case 7:
				return '暂时下架';
		}
	}
?>