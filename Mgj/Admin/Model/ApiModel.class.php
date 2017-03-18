<?php
/**
 * Created by PhpStorm.
 * User: mty
 * Date: 16/12/8
 * Time: 上午9:57
 */

namespace Admin\Model;

class ApiModel
{
    function own($ocode,$name)      //教育局自己访问
    {
        $where['state'] = 1;
        $where['data']  = 1;
        $where['ocode']  = $ocode;
        if(!empty($name))
        {
            $where['name'] = array('like','%'.$name.'%');
        }
        $num = I('get.num');
        $num = !empty($num) ? $num : 12;
        $count = M('rep_examlist')->where($where)->count();
        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();
        $res['data'] = M('rep_examlist')->where($where)->field('id,name,username,regtime,examtime,state,share,data')->order('examtime desc')->limit($limit)->select();
        $res['page'] = $show;
        $res['p'] = ceil($count/12);
        return $res;
    }

    function otherSch($res)   //其他学校调用数据
    {
        $where['id'] = array('in',$res);
        $where['state'] = 1;
        $where['data'] =1;
        if(!empty($name))
        {
            $where['name'] = array('like','%'.$name.'%');
        }
        $num = I('get.num');
        $num = !empty($num) ? $num : 12;
        $count = M('rep_examlist')->where($where)->count();
        $page = new \Think\Page($count,$num);
        //获得limit参数
        $limit = $page->firstRow.','.$page->listRows;
        $show = $page->show();
        $res['data'] = M('rep_examlist')->where($where)->field('id,name,username,regtime,examtime,state,share,data')->order('examtime desc')->limit($limit)->select();
        $res['page'] = $show;
        $res['p'] = ceil($count/12);
        return $res;
    }

    function page()
    {

    }



    function call_chi($ls,$type,$class)
    {
        $pid = $ls['id'];
        $where['pid'] = $pid;
        $chi_score = $ls['chi'];          //总分
        $pass = $chi_score*$ls['pass']*0.01;    //及格分
        $excellent = $chi_score*$ls['greate']*0.01;  //优秀分
        $sc = $type;
        if(I('get.state') == 0)
        {
            $where['schoolname'] = $ls['schoolname'];
        }
        $class= $class;
        $allNum =M('school_call')->field("$sc,count(*) as allNum")->group("$sc")->where($where)->select();  //各校总人数
        $allschoolnum = 0;
        foreach ($allNum as $rank=>$ran) {
            $_allNum[$ran[$sc]] = $ran['allnum'];
            $allschoolnum +=$ran['allnum'];  //总人数
        }

        $avg_rank = M('school_call')->field("$sc,avg($class) as chi_avg")->group("$sc")->order("avg($class) desc")->where($where)->select();
        foreach ($avg_rank as $rank=>$ran) {
            $_avg_rank[$ran[$sc]] = $rank+1;
        }//  平均分排名
        $passwhere['pid']=$pid;
        $passwhere[$class] = array('egt',$pass);
        if(I('get.state') == 0) {
            $passwhere['schoolname'] = $ls['schoolname'];
        }
        $passnum = M('school_call')->field("$sc,count(*) as passnum")->group("$sc")->order("avg($class) desc")->where($passwhere)->select();
        foreach ($passnum as $rank=>$ran) {
            $_passnum[$ran[$sc]] = $ran['passnum'];
        }//  及格人数
        foreach ($passnum as $rank=>$ran) {
            $_passrate[$ran[$sc]] =  sprintf("%.2f",($ran['passnum']/$_allNum[$ran[$sc]])*100);
        }//  及格率
        $excellentwhere['pid'] = $pid;
        $excellentwhere[$class] = array('egt',$excellent);
        if(I('get.state') == 0) {
            $excellentwhere['schoolname'] = $ls['schoolname'];
        }
        $excellnum = M('school_call')->field("$sc,count(*) as excellnum")->group("$sc")->where($excellentwhere)->select();
        foreach ($excellnum as $rank=>$ran) {
            $_excellnum[$ran[$sc]] = $ran['excellnum'];
        }//  优秀人数
        foreach ($excellnum as $rank=>$ran) {
            $_excellrank[$ran[$sc]] =  sprintf("%.2f",($ran['excellnum']/$_allNum[$ran[$sc]])*100);
        }//  优秀率


        //后20%人数
        $flootnum = floor($allschoolnum * $ls['bake']*0.01);
        $flootwhere['pid'] = $pid;
        if(I('get.state') == 0) {
            $flootwhere['schoolname'] = $ls['schoolname'];
        }
        $flootfrac = M('school_call')->field("$class")->order("$class")->where($flootwhere)->limit($flootnum,1)->select()[0][$class];  //后20%分数线
        $data['flootuser'] = array(
            'flootnum' => $flootnum,
            'flootfrac' => $flootfrac,
        );
        $flootwhere['pid'] = $pid;
        $flootwhere[$class] = array('elt',$flootfrac);
        if(I('get.state') == 0)
        {
            $flootwhere['schoolname'] = $ls['schoolname'];
        }
        $schflootnum = M('school_call')->field("$sc,count(*) as schflootnum")->group("$sc")->where($flootwhere)->select();
        foreach ($schflootnum as $rank=>$ran) {
            $_schflootnum[$ran[$sc]] = $ran['schflootnum'];
        }//  后20%人数
        foreach ($schflootnum as $rank=>$ran) {
            $_schflootrank[$ran[$sc]] =  sprintf("%.2f",($ran['schflootnum']/$_allNum[$ran[$sc]])*100);
        }//  后20%率

        //前10%人数
        $firstnum = floor($allschoolnum * $ls['front']*0.01);
        $firstwhere['pid'] = $pid;
        if(I('get.state') == 0)
        {
            $firstwhere['schoolname'] = $ls['schoolname'];
        }
        $firstfrac = M('school_call')->field("$class")->order("$class desc")->where($firstwhere)->limit($firstnum,1)->select()[0][$class]; //前10%分数线
        $data['firstuser'] = array(
            'firstnum' => $firstnum,
            'firstfrac' => $firstfrac,
        );

        $flootwhere['pid'] = $pid;
        $flootwhere[$class] = array('egt',$firstfrac);
        if(I('get.state') == 0)
        {
            $flootwhere['schoolname'] = $ls['schoolname'];
        }
        $schfirstnum = M('school_call')->field("$sc,count(*) as schfirstnum")->group("$sc")->where($flootwhere)->select();
        foreach ($schfirstnum as $rank=>$ran) {
            $_schfirstnum[$ran[$sc]] = $ran['schfirstnum'];
        }//     前10%人数
        foreach ($schfirstnum as $rank=>$ran) {
            $_schfirstrank[$ran[$sc]] =  sprintf("%.2f",($ran['schfirstnum']/$_allNum[$ran[$sc]])*100);
        }//  前10%率


        $chi = M('school_call')->group("$sc")->field("count($class) as chi_count,$sc,max($class) as chi_max,min($class) as chi_min,avg($class) as chi_avg")->where($where)->select();
        $sch_avg = $this->sch_avg($chi,$sc);  //平均分标准分
        $great_avg = $this->great_avg($_excellrank,$sc);        //优秀率标准分
        $pass_avg = $this->great_avg($_passrate,$sc);           //及格率
        $first_avg = $this->great_avg($_schfirstrank,$sc);
        $floot_avg = $this->floot_avg($_schflootrank,$sc);
        foreach ($chi as $k=>$v) {
            $data['info'][$v[$sc]] = $v;
            $data['info'][$v[$sc]]['_avg_rank'] = $_avg_rank[$v[$sc]];// 平均分排名
            $data['info'][$v[$sc]]['_passnum'] = $_passnum[$v[$sc]];  //及格人数
            $data['info'][$v[$sc]]['_passrate'] = $_passrate[$v[$sc]];//及格率
            $data['info'][$v[$sc]]['_excellnum'] = $_excellnum[$v[$sc]];  //优秀人数
            $data['info'][$v[$sc]]['_excellrank'] = $_excellrank[$v[$sc]];  //优秀率
            $data['info'][$v[$sc]]['_noexcellrank'] = count($_excellrank) +1;
            $data['info'][$v[$sc]]['_schflootnum'] = $_schflootnum[$v[$sc]];// 后20%人数
            $data['info'][$v[$sc]]['_schflootrank'] = $_schflootrank[$v[$sc]];//后20%率
            $data['info'][$v[$sc]]['_schfirstnum'] = $_schfirstnum[$v[$sc]];// 前10%人数
            $data['info'][$v[$sc]]['_schfirstrank'] = $_schfirstrank[$v[$sc]];//前10%率
            $data['info'][$v[$sc]]['sch_avg'] = $sch_avg[$v[$sc]];
            $data['info'][$v[$sc]]['greate_avg'] = $great_avg[$v[$sc]];
            $data['info'][$v[$sc]]['pass_avg']  = $pass_avg[$v[$sc]];
            $data['info'][$v[$sc]]['first_avg']  = $first_avg[$v[$sc]];
            $data['info'][$v[$sc]]['floot_avg']  = $floot_avg[$v[$sc]];
        }

        foreach ($_passrate as $k=>$v) {
            rsort($_passrate);
            $_pass_rate = array_flip($_passrate);
            $_passrate_[$k] = $_pass_rate[$v]+1;
        }
        foreach ($_excellrank as $k=>$v) {
            rsort($_excellrank);
            $excell_rank = array_flip($_excellrank);
            $_excell_rank[$k] = $excell_rank[$v]+1;
        }
        foreach ($_schflootrank as $k=>$v) {
            rsort($_schflootrank);
            $schfloot_rank = array_flip($_schflootrank);
            $_schfloot_rank[$k] = $schfloot_rank[$v]+1;
        }
        foreach ($_schfirstrank as $k=>$v) {
            rsort($_schfirstrank);
            $schfirst_rank = array_flip($_schfirstrank);
            $_schfirst_rank[$k] = $schfirst_rank[$v] +1;
        }

        foreach ($chi as $k=>$v) {
            $data['info'][$v[$sc]]['_passrate_'] = $_passrate_[$v[$sc]];   //及格率排名
            $data['info'][$v[$sc]]['_excell_rank'] = $_excell_rank[$v[$sc]];  //优秀率排名
            $data['info'][$v[$sc]]['_schfloot_rank'] = $_schfloot_rank[$v[$sc]]; //后20%率排名
            $data['info'][$v[$sc]]['_schfirst_rank'] = $_schfirst_rank[$v[$sc]]; //前10率排名
        }
        $data['chi'] = $ls['chi'];

        return $data;
    }

//    function call_math($res,$type)
//    {
//        $pid = $res['id'];
//        $where['pid'] = $pid;
//        $chi_score = $res['math'];          //总分
//        $pass = $chi_score*$res['pass']*0.01;    //及格分
//        $excellent = $chi_score*$res['greate']*0.01;  //优秀分
//
//        $sc = $type;
//        $class= 'math';
//        $allNum =M('school_call')->field("$sc,count(*) as allNum")->group("$sc")->where($where)->select();  //各校总人数
//
//        $allschoolnum = 0;
//        foreach ($allNum as $rank=>$ran) {
//            $_allNum[$ran[$sc]] = $ran['allnum'];
//            $allschoolnum +=$ran['allnum'];
//        }
//        $flootnum = floor($allschoolnum * $res['bake']*0.01);
//        $firstnum = floor($allschoolnum * $res['front']*0.01);
//        $avg_rank = M('school_call')->field("$sc,avg($class) as chi_avg")->group("$sc")->order("avg($class) desc")->where($where)->select();
//        foreach ($avg_rank as $rank=>$ran) {
//            $_avg_rank[$ran[$sc]] = $rank+1;
//        }//  平均分排名
//        $passwhere['pid']=$pid;
//        $passwhere[$class] = array('egt',$pass);
//        $passnum = M('school_call')->field("$sc,count(*) as passnum")->group("$sc")->order("avg($class) desc")->where($passwhere)->select();
//        foreach ($passnum as $rank=>$ran) {
//            $_passnum[$ran[$sc]] = $ran['passnum'];
//        }//  及格人数
//        foreach ($passnum as $rank=>$ran) {
//            $_passrate[$ran[$sc]] =  sprintf("%.2f",($ran['passnum']/$_allNum[$ran[$sc]])*100);
//        }//  及格率
//        $excellentwhere['pid'] = $pid;
//        $excellentwhere[$class] = array('egt',$excellent);
//        $excellnum = M('school_call')->field("$sc,count(*) as excellnum")->group("$sc")->where($excellentwhere)->select();
//        foreach ($excellnum as $rank=>$ran) {
//            $_excellnum[$ran[$sc]] = $ran['excellnum'];
//        }//  优秀人数
//        foreach ($excellnum as $rank=>$ran) {
//            $_excellrank[$ran[$sc]] =  sprintf("%.2f",($ran['excellnum']/$_allNum[$ran[$sc]])*100);
//        }//  优秀率
//
//
//        //后20%人数
//
//        $flootfrac = M('school_call')->field("$class")->order("$class")->where('pid ='.$pid)->limit($flootnum,1)->select()[0][$class];  //后20%分数线
//        $data['flootuser'] = array(
//            'flootnum' => $flootnum,
//            'flootfrac' => $flootfrac,
//        );
//        $flootwhere['pid'] = $pid;
//        $flootwhere[$class] = array('elt',$flootfrac);
//        $schflootnum = M('school_call')->field("$sc,count(*) as schflootnum")->group("$sc")->where($flootwhere)->select();
//        foreach ($schflootnum as $rank=>$ran) {
//            $_schflootnum[$ran[$sc]] = $ran['schflootnum'];
//        }//  后20%人数
//        foreach ($schflootnum as $rank=>$ran) {
//            $_schflootrank[$ran[$sc]] =  sprintf("%.2f",($ran['schflootnum']/$_allNum[$ran[$sc]])*100);
//        }//  后20%率
//
//        //前10%人数
//
//        $firstfrac = M('school_call')->field("$class")->order("$class desc")->where('pid ='.$pid)->limit($firstnum,1)->select()[0][$class]; //前10%分数线
//        $data['firstuser'] = array(
//            'firstnum' => $firstnum,
//            'firstfrac' => $firstfrac,
//        );
//
//        $firstwhere['pid'] = $pid;
//        $firstwhere[$class] = array('egt',$firstfrac);
//        $schfirstnum = M('school_call')->field("$sc,count(*) as schfirstnum")->group("$sc")->where($firstwhere)->select();
//        foreach ($schfirstnum as $rank=>$ran) {
//            $_schfirstnum[$ran[$sc]] = $ran['schfirstnum'];
//        }//     前10%人数
//        foreach ($schfirstnum as $rank=>$ran) {
//            $_schfirstrank[$ran[$sc]] =  sprintf("%.2f",($ran['schfirstnum']/$_allNum[$ran[$sc]])*100);
//        }//  前10%率
//
//
//        $chi = M('school_call')->group("$sc")->field("count($class) as chi_count,$sc,max($class) as chi_max,min($class) as chi_min,avg($class) as chi_avg")->where($where)->select();
//        $sch_avg = $this->sch_avg($chi,$sc);
//        foreach ($chi as $k=>$v) {
//            $data['info'][$v[$sc]] = $v;
//            $data['info'][$v[$sc]]['_avg_rank'] = $_avg_rank[$v[$sc]];// 平均分排名
//            $data['info'][$v[$sc]]['_passnum'] = $_passnum[$v[$sc]];  //及格人数
//            $data['info'][$v[$sc]]['_passrate'] = $_passrate[$v[$sc]];//及格率
//            $data['info'][$v[$sc]]['_excellnum'] = $_excellnum[$v[$sc]];  //优秀人数
//            $data['info'][$v[$sc]]['_excellrank'] = $_excellrank[$v[$sc]];  //优秀率
//            $data['info'][$v[$sc]]['_noexcellrank'] = count($_excellrank) +1;
//            $data['info'][$v[$sc]]['_schflootnum'] = $_schflootnum[$v[$sc]];// 后20%人数
//            $data['info'][$v[$sc]]['_schflootrank'] = $_schflootrank[$v[$sc]];//后20%率
//            $data['info'][$v[$sc]]['_schfirstnum'] = $_schfirstnum[$v[$sc]];// 前10%人数
//            $data['info'][$v[$sc]]['_schfirstrank'] = $_schfirstrank[$v[$sc]];//前10%率
//            $data['info'][$v[$sc]]['sch_avg'] = $sch_avg[$v[$sc]];
//        }
//
//        foreach ($_passrate as $k=>$v) {
//            rsort($_passrate);
//            $_pass_rate = array_flip($_passrate);
//            $_passrate_[$k] = $_pass_rate[$v]+1;
//        }
//        foreach ($_excellrank as $k=>$v) {
//            rsort($_excellrank);
//            $excell_rank = array_flip($_excellrank);
//            $_excell_rank[$k] = $excell_rank[$v]+1;
//        }
//        foreach ($_schflootrank as $k=>$v) {
//            rsort($_schflootrank);
//            $schfloot_rank = array_flip($_schflootrank);
//            $_schfloot_rank[$k] = $schfloot_rank[$v]+1;
//        }
//        foreach ($_schfirstrank as $k=>$v) {
//            rsort($_schfirstrank);
//            $schfirst_rank = array_flip($_schfirstrank);
//            $_schfirst_rank[$k] = $schfirst_rank[$v] +1;
//        }
//
//
//
//        foreach ($chi as $k=>$v) {
//            $data['info'][$v[$sc]]['_passrate_'] = $_passrate_[$v[$sc]];   //及格率排名
//            $data['info'][$v[$sc]]['_excell_rank'] = $_excell_rank[$v[$sc]];  //优秀率排名
//            $data['info'][$v[$sc]]['_schfloot_rank'] = $_schfloot_rank[$v[$sc]]; //后20%率排名
//            $data['info'][$v[$sc]]['_schfirst_rank'] = $_schfirst_rank[$v[$sc]]; //前10率排名
//
//        }
//        $data['math'] = $res['math'];
//
//        return $data;
//    }
//
//    function call_sec($res,$type)
//    {
//        $pid = $res['id'];
//        $where['pid'] = $pid;
//        $chi_score = $res['sec'];          //总分
//        $pass = $chi_score*$res['pass']*0.01;    //及格分
//        $excellent = $chi_score*$res['greate']*0.01;  //优秀分
//
//        $sc = $type;
//        $class= 'sec';
//        $allNum =M('school_call')->field("$sc,count(*) as allNum")->group("$sc")->where($where)->select();  //各校总人数
//
//        $allschoolnum = 0;
//        foreach ($allNum as $rank=>$ran) {
//            $_allNum[$ran[$sc]] = $ran['allnum'];
//            $allschoolnum +=$ran['allnum'];
//        }
//        $flootnum = floor($allschoolnum * $res['bake']*0.01);
//        $firstnum = floor($allschoolnum * $res['front']*0.01);
//        $avg_rank = M('school_call')->field("$sc,avg($class) as chi_avg")->group("$sc")->order("avg($class) desc")->where($where)->select();
//        foreach ($avg_rank as $rank=>$ran) {
//            $_avg_rank[$ran[$sc]] = $rank+1;
//        }//  平均分排名
//        $passwhere['pid']=$pid;
//        $passwhere[$class] = array('egt',$pass);
//        $passnum = M('school_call')->field("$sc,count(*) as passnum")->group("$sc")->order("avg($class) desc")->where($passwhere)->select();
//        foreach ($passnum as $rank=>$ran) {
//            $_passnum[$ran[$sc]] = $ran['passnum'];
//        }//  及格人数
//        foreach ($passnum as $rank=>$ran) {
//            $_passrate[$ran[$sc]] =  sprintf("%.2f",($ran['passnum']/$_allNum[$ran[$sc]])*100);
//        }//  及格率
//        $excellentwhere['pid'] = $pid;
//        $excellentwhere[$class] = array('egt',$excellent);
//        $excellnum = M('school_call')->field("$sc,count(*) as excellnum")->group("$sc")->where($excellentwhere)->select();
//        foreach ($excellnum as $rank=>$ran) {
//            $_excellnum[$ran[$sc]] = $ran['excellnum'];
//        }//  优秀人数
//        foreach ($excellnum as $rank=>$ran) {
//            $_excellrank[$ran[$sc]] =  sprintf("%.2f",($ran['excellnum']/$_allNum[$ran[$sc]])*100);
//        }//  优秀率
//
//
//        //后20%人数
//        $flootfrac = M('school_call')->field("$class")->order("$class")->where('pid ='.$pid)->limit($flootnum,1)->select()[0][$class];  //后20%分数线
//        $data['flootuser'] = array(
//            'flootnum' => $flootnum,
//            'flootfrac' => $flootfrac,
//        );
//        $flootwhere['pid'] = $pid;
//        $flootwhere[$class] = array('elt',$flootfrac);
//        $schflootnum = M('school_call')->field("$sc,count(*) as schflootnum")->group("$sc")->where($flootwhere)->select();
//        foreach ($schflootnum as $rank=>$ran) {
//            $_schflootnum[$ran[$sc]] = $ran['schflootnum'];
//        }//  后20%人数
//        foreach ($schflootnum as $rank=>$ran) {
//            $_schflootrank[$ran[$sc]] =  sprintf("%.2f",($ran['schflootnum']/$_allNum[$ran[$sc]])*100);
//        }//  后20%率
//
//        //前10%人数
//        $firstfrac = M('school_call')->field("$class")->order("$class desc")->where('pid ='.$pid)->limit($firstnum,1)->select()[0][$class]; //前10%分数线
//        $data['firstuser'] = array(
//            'firstnum' => $firstnum,
//            'firstfrac' => $firstfrac,
//        );
//
//        $firstwhere['pid'] = $pid;
//        $firstwhere[$class] = array('egt',$firstfrac);
//        $schfirstnum = M('school_call')->field("$sc,count(*) as schfirstnum")->group("$sc")->where($firstwhere)->select();
//        foreach ($schfirstnum as $rank=>$ran) {
//            $_schfirstnum[$ran[$sc]] = $ran['schfirstnum'];
//        }//     前10%人数
//        foreach ($schfirstnum as $rank=>$ran) {
//            $_schfirstrank[$ran[$sc]] =  sprintf("%.2f",($ran['schfirstnum']/$_allNum[$ran[$sc]])*100);
//        }//  前10%率
//
//
//        $chi = M('school_call')->group("$sc")->field("count($class) as chi_count,$sc,max($class) as chi_max,min($class) as chi_min,avg($class) as chi_avg")->where($where)->select();
//        $sch_avg = $this->sch_avg($chi,$sc);
//        foreach ($chi as $k=>$v) {
//            $data['info'][$v[$sc]] = $v;
//            $data['info'][$v[$sc]]['_avg_rank'] = $_avg_rank[$v[$sc]];// 平均分排名
//            $data['info'][$v[$sc]]['_passnum'] = $_passnum[$v[$sc]];  //及格人数
//            $data['info'][$v[$sc]]['_passrate'] = $_passrate[$v[$sc]];//及格率
//            $data['info'][$v[$sc]]['_excellnum'] = $_excellnum[$v[$sc]];  //优秀人数
//            $data['info'][$v[$sc]]['_excellrank'] = $_excellrank[$v[$sc]];  //优秀率
//            $data['info'][$v[$sc]]['_noexcellrank'] = count($_excellrank) +1;
//            $data['info'][$v[$sc]]['_schflootnum'] = $_schflootnum[$v[$sc]];// 后20%人数
//            $data['info'][$v[$sc]]['_schflootrank'] = $_schflootrank[$v[$sc]];//后20%率
//            $data['info'][$v[$sc]]['_schfirstnum'] = $_schfirstnum[$v[$sc]];// 前10%人数
//            $data['info'][$v[$sc]]['_schfirstrank'] = $_schfirstrank[$v[$sc]];//前10%率
//            $data['info'][$v[$sc]]['sch_avg'] = $sch_avg[$v[$sc]];
//        }
//
//        foreach ($_passrate as $k=>$v) {
//            rsort($_passrate);
//            $_pass_rate = array_flip($_passrate);
//            $_passrate_[$k] = $_pass_rate[$v]+1;
//        }
//        foreach ($_excellrank as $k=>$v) {
//            rsort($_excellrank);
//            $excell_rank = array_flip($_excellrank);
//            $_excell_rank[$k] = $excell_rank[$v]+1;
//        }
//        foreach ($_schflootrank as $k=>$v) {
//            rsort($_schflootrank);
//            $schfloot_rank = array_flip($_schflootrank);
//            $_schfloot_rank[$k] = $schfloot_rank[$v]+1;
//        }
//        foreach ($_schfirstrank as $k=>$v) {
//            rsort($_schfirstrank);
//            $schfirst_rank = array_flip($_schfirstrank);
//            $_schfirst_rank[$k] = $schfirst_rank[$v] +1;
//        }
//
//
//
//        foreach ($chi as $k=>$v) {
//            $data['info'][$v[$sc]]['_passrate_'] = $_passrate_[$v[$sc]];   //及格率排名
//            $data['info'][$v[$sc]]['_excell_rank'] = $_excell_rank[$v[$sc]];  //优秀率排名
//            $data['info'][$v[$sc]]['_schfloot_rank'] = $_schfloot_rank[$v[$sc]]; //后20%率排名
//            $data['info'][$v[$sc]]['_schfirst_rank'] = $_schfirst_rank[$v[$sc]]; //前10率排名
//        }
//        $data['sec'] = $res['sec'];
//
//        return $data;
//    }
//    function call_eng($res,$type)
//    {
//        $pid = $res['id'];
//        $where['pid'] = $pid;
//        $chi_score = $res['eng'];          //总分
//        $pass = $chi_score*$res['pass']*0.01;    //及格分
//        $excellent = $chi_score*$res['greate']*0.01;  //优秀分
//
//        $sc = $type;
//        $class= 'eng';
//        $allNum =M('school_call')->field("$sc,count(*) as allNum")->group("$sc")->where($where)->select();  //各校总人数
//
//        $allschoolnum = 0;
//        foreach ($allNum as $rank=>$ran) {
//            $_allNum[$ran[$sc]] = $ran['allnum'];
//            $allschoolnum +=$ran['allnum'];
//        }
//        $flootnum = floor($allschoolnum * $res['bake']*0.01);
//        $firstnum = floor($allschoolnum * $res['front']*0.01);
//        $avg_rank = M('school_call')->field("$sc,avg($class) as chi_avg")->group("$sc")->order("avg($class) desc")->where($where)->select();
//        foreach ($avg_rank as $rank=>$ran) {
//            $_avg_rank[$ran[$sc]] = $rank+1;
//        }//  平均分排名
//        $passwhere['pid']=$pid;
//        $passwhere[$class] = array('egt',$pass);
//        $passnum = M('school_call')->field("$sc,count(*) as passnum")->group("$sc")->order("avg($class) desc")->where($passwhere)->select();
//        foreach ($passnum as $rank=>$ran) {
//            $_passnum[$ran[$sc]] = $ran['passnum'];
//        }//  及格人数
//        foreach ($passnum as $rank=>$ran) {
//            $_passrate[$ran[$sc]] =  sprintf("%.2f",($ran['passnum']/$_allNum[$ran[$sc]])*100);
//        }//  及格率
//        $excellentwhere['pid'] = $pid;
//        $excellentwhere[$class] = array('egt',$excellent);
//        $excellnum = M('school_call')->field("$sc,count(*) as excellnum")->group("$sc")->where($excellentwhere)->select();
//        foreach ($excellnum as $rank=>$ran) {
//            $_excellnum[$ran[$sc]] = $ran['excellnum'];
//        }//  优秀人数
//        foreach ($excellnum as $rank=>$ran) {
//            $_excellrank[$ran[$sc]] =  sprintf("%.2f",($ran['excellnum']/$_allNum[$ran[$sc]])*100);
//        }//  优秀率
//
//
//        //后20%人数
//
//        $flootfrac = M('school_call')->field("$class")->order("$class")->where('pid ='.$pid)->limit($flootnum,1)->select()[0][$class];  //后20%分数线
//        $data['flootuser'] = array(
//            'flootnum' => $flootnum,
//            'flootfrac' => $flootfrac,
//        );
//        $flootwhere['pid'] = $pid;
//        $flootwhere[$class] = array('elt',$flootfrac);
//        $schflootnum = M('school_call')->field("$sc,count(*) as schflootnum")->group("$sc")->where($flootwhere)->select();
//        foreach ($schflootnum as $rank=>$ran) {
//            $_schflootnum[$ran[$sc]] = $ran['schflootnum'];
//        }//  后20%人数
//        foreach ($schflootnum as $rank=>$ran) {
//            $_schflootrank[$ran[$sc]] =  sprintf("%.2f",($ran['schflootnum']/$_allNum[$ran[$sc]])*100);
//        }//  后20%率
//
//        //前10%人数
//
//        $firstfrac = M('school_call')->field("$class")->order("$class desc")->where('pid ='.$pid)->limit($firstnum,1)->select()[0][$class]; //前10%分数线
//        $data['firstuser'] = array(
//            'firstnum' => $firstnum,
//            'firstfrac' => $firstfrac,
//        );
//
//        $firstwhere['pid'] = $pid;
//        $firstwhere[$class] = array('egt',$firstfrac);
//        $schfirstnum = M('school_call')->field("$sc,count(*) as schfirstnum")->group("$sc")->where($firstwhere)->select();
//        foreach ($schfirstnum as $rank=>$ran) {
//            $_schfirstnum[$ran[$sc]] = $ran['schfirstnum'];
//        }//     前10%人数
//        foreach ($schfirstnum as $rank=>$ran) {
//            $_schfirstrank[$ran[$sc]] =  sprintf("%.2f",($ran['schfirstnum']/$_allNum[$ran[$sc]])*100);
//        }//  前10%率
//
//
//        $chi = M('school_call')->group("$sc")->field("count($class) as chi_count,$sc,max($class) as chi_max,min($class) as chi_min,avg($class) as chi_avg")->where($where)->select();
//        $sch_avg = $this->sch_avg($chi,$sc);
//        foreach ($chi as $k=>$v) {
//            $data['info'][$v[$sc]] = $v;
//            $data['info'][$v[$sc]]['_avg_rank'] = $_avg_rank[$v[$sc]];// 平均分排名
//            $data['info'][$v[$sc]]['_passnum'] = $_passnum[$v[$sc]];  //及格人数
//            $data['info'][$v[$sc]]['_passrate'] = $_passrate[$v[$sc]];//及格率
//            $data['info'][$v[$sc]]['_excellnum'] = $_excellnum[$v[$sc]];  //优秀人数
//            $data['info'][$v[$sc]]['_excellrank'] = $_excellrank[$v[$sc]];  //优秀率
//            $data['info'][$v[$sc]]['_noexcellrank'] = count($_excellrank) +1;
//            $data['info'][$v[$sc]]['_schflootnum'] = $_schflootnum[$v[$sc]];// 后20%人数
//            $data['info'][$v[$sc]]['_schflootrank'] = $_schflootrank[$v[$sc]];//后20%率
//            $data['info'][$v[$sc]]['_schfirstnum'] = $_schfirstnum[$v[$sc]];// 前10%人数
//            $data['info'][$v[$sc]]['_schfirstrank'] = $_schfirstrank[$v[$sc]];//前10%率
//            $data['info'][$v[$sc]]['sch_avg'] = $sch_avg[$v[$sc]];
//        }
//
//        foreach ($_passrate as $k=>$v) {
//            rsort($_passrate);
//            $_pass_rate = array_flip($_passrate);
//            $_passrate_[$k] = $_pass_rate[$v]+1;
//        }
//        foreach ($_excellrank as $k=>$v) {
//            rsort($_excellrank);
//            $excell_rank = array_flip($_excellrank);
//            $_excell_rank[$k] = $excell_rank[$v]+1;
//        }
//        foreach ($_schflootrank as $k=>$v) {
//            rsort($_schflootrank);
//            $schfloot_rank = array_flip($_schflootrank);
//            $_schfloot_rank[$k] = $schfloot_rank[$v]+1;
//        }
//        foreach ($_schfirstrank as $k=>$v) {
//            rsort($_schfirstrank);
//            $schfirst_rank = array_flip($_schfirstrank);
//            $_schfirst_rank[$k] = $schfirst_rank[$v] +1;
//        }
//
//
//
//        foreach ($chi as $k=>$v) {
//            $data['info'][$v[$sc]]['_passrate_'] = $_passrate_[$v[$sc]];   //及格率排名
//            $data['info'][$v[$sc]]['_excell_rank'] = $_excell_rank[$v[$sc]];  //优秀率排名
//            $data['info'][$v[$sc]]['_schfloot_rank'] = $_schfloot_rank[$v[$sc]]; //后20%率排名
//            $data['info'][$v[$sc]]['_schfirst_rank'] = $_schfirst_rank[$v[$sc]]; //前10率排名
//
//        }
//        $data['eng'] = $res['eng'];
//
//        return $data;
//    }
//
//    function call_total($res,$type)
//    {
//        $pid = $res['id'];
//        $where['pid'] = $pid;
//        $chi_score = $res['total'];          //总分
//        $pass = $chi_score*$res['pass']*0.01;    //及格分
//        $excellent = $chi_score*$res['greate']*0.01;  //优秀分
//
//        $sc = $type;
//        $class= 'total';
//        $allNum =M('school_call')->field("$sc,count(*) as allNum")->group("$sc")->where($where)->select();  //各校总人数
//
//        $allschoolnum = 0;
//        foreach ($allNum as $rank=>$ran) {
//            $_allNum[$ran[$sc]] = $ran['allnum'];
//            $allschoolnum +=$ran['allnum'];
//        }
//        $flootnum = floor($allschoolnum * $res['bake']*0.01);
//        $firstnum = floor($allschoolnum * $res['front']*0.01);
//        $avg_rank = M('school_call')->field("$sc,avg($class) as chi_avg")->group("$sc")->order("avg($class) desc")->where($where)->select();
//        foreach ($avg_rank as $rank=>$ran) {
//            $_avg_rank[$ran[$sc]] = $rank+1;
//        }//  平均分排名
//        $passwhere['pid']=$pid;
//        $passwhere[$class] = array('egt',$pass);
//        $passnum = M('school_call')->field("$sc,count(*) as passnum")->group("$sc")->order("avg($class) desc")->where($passwhere)->select();
//        foreach ($passnum as $rank=>$ran) {
//            $_passnum[$ran[$sc]] = $ran['passnum'];
//        }//  及格人数
//        foreach ($passnum as $rank=>$ran) {
//            $_passrate[$ran[$sc]] =  sprintf("%.2f",($ran['passnum']/$_allNum[$ran[$sc]])*100);
//        }//  及格率
//        $excellentwhere['pid'] = $pid;
//        $excellentwhere[$class] = array('egt',$excellent);
//        $excellnum = M('school_call')->field("$sc,count(*) as excellnum")->group("$sc")->where($excellentwhere)->select();
//        foreach ($excellnum as $rank=>$ran) {
//            $_excellnum[$ran[$sc]] = $ran['excellnum'];
//        }//  优秀人数
//        foreach ($excellnum as $rank=>$ran) {
//            $_excellrank[$ran[$sc]] =  sprintf("%.2f",($ran['excellnum']/$_allNum[$ran[$sc]])*100);
//        }//  优秀率
//
//
//        //后20%人数
//        $flootfrac = M('school_call')->field("$class")->order("$class")->where('pid ='.$pid)->limit($flootnum,1)->select()[0][$class];  //后20%分数线
//        $data['flootuser'] = array(
//            'flootnum' => $flootnum,
//            'flootfrac' => $flootfrac,
//        );
//        $flootwhere['pid'] = $pid;
//        $flootwhere[$class] = array('elt',$flootfrac);
//        $schflootnum = M('school_call')->field("$sc,count(*) as schflootnum")->group("$sc")->where($flootwhere)->select();
//        foreach ($schflootnum as $rank=>$ran) {
//            $_schflootnum[$ran[$sc]] = $ran['schflootnum'];
//        }//  后20%人数
//        foreach ($schflootnum as $rank=>$ran) {
//            $_schflootrank[$ran[$sc]] =  sprintf("%.2f",($ran['schflootnum']/$_allNum[$ran[$sc]])*100);
//        }//  后20%率
//
//        //前10%人数
//
//        $firstfrac = M('school_call')->field("$class")->order("$class desc")->where('pid ='.$pid)->limit($firstnum,1)->select()[0][$class]; //前10%分数线
//        $data['firstuser'] = array(
//            'firstnum' => $firstnum,
//            'firstfrac' => $firstfrac,
//        );
//
//        $firstwhere['pid'] = $pid;
//        $firstwhere[$class] = array('egt',$firstfrac);
//        $schfirstnum = M('school_call')->field("$sc,count(*) as schfirstnum")->group("$sc")->where($firstwhere)->select();
//        foreach ($schfirstnum as $rank=>$ran) {
//            $_schfirstnum[$ran[$sc]] = $ran['schfirstnum'];
//        }//     前10%人数
//        foreach ($schfirstnum as $rank=>$ran) {
//            $_schfirstrank[$ran[$sc]] =  sprintf("%.2f",($ran['schfirstnum']/$_allNum[$ran[$sc]])*100);
//        }//  前10%率
//
//
//        $chi = M('school_call')->group("$sc")->field("count($class) as chi_count,$sc,max($class) as chi_max,min($class) as chi_min,avg($class) as chi_avg")->where($where)->select();
//        $sch_avg = $this->sch_avg($chi,$sc);
//        foreach ($chi as $k=>$v) {
//            $data['info'][$v[$sc]] = $v;
//            $data['info'][$v[$sc]]['_avg_rank'] = $_avg_rank[$v[$sc]];// 平均分排名
//            $data['info'][$v[$sc]]['_passnum'] = $_passnum[$v[$sc]];  //及格人数
//            $data['info'][$v[$sc]]['_passrate'] = $_passrate[$v[$sc]];//及格率
//            $data['info'][$v[$sc]]['_excellnum'] = $_excellnum[$v[$sc]];  //优秀人数
//            $data['info'][$v[$sc]]['_excellrank'] = $_excellrank[$v[$sc]];  //优秀率
//            $data['info'][$v[$sc]]['_noexcellrank'] = count($_excellrank) +1;
//            $data['info'][$v[$sc]]['_schflootnum'] = $_schflootnum[$v[$sc]];// 后20%人数
//            $data['info'][$v[$sc]]['_schflootrank'] = $_schflootrank[$v[$sc]];//后20%率
//            $data['info'][$v[$sc]]['_schfirstnum'] = $_schfirstnum[$v[$sc]];// 前10%人数
//            $data['info'][$v[$sc]]['_schfirstrank'] = $_schfirstrank[$v[$sc]];//前10%率
//            $data['info'][$v[$sc]]['sch_avg'] = $sch_avg[$v[$sc]];
//        }
//
//        foreach ($_passrate as $k=>$v) {
//            rsort($_passrate);
//            $_pass_rate = array_flip($_passrate);
//            $_passrate_[$k] = $_pass_rate[$v]+1;
//        }
//        foreach ($_excellrank as $k=>$v) {
//            rsort($_excellrank);
//            $excell_rank = array_flip($_excellrank);
//            $_excell_rank[$k] = $excell_rank[$v]+1;
//        }
//        foreach ($_schflootrank as $k=>$v) {
//            rsort($_schflootrank);
//            $schfloot_rank = array_flip($_schflootrank);
//            $_schfloot_rank[$k] = $schfloot_rank[$v]+1;
//        }
//        foreach ($_schfirstrank as $k=>$v) {
//            rsort($_schfirstrank);
//            $schfirst_rank = array_flip($_schfirstrank);
//            $_schfirst_rank[$k] = $schfirst_rank[$v] +1;
//        }
//
//
//
//        foreach ($chi as $k=>$v) {
//            $data['info'][$v[$sc]]['_passrate_'] = $_passrate_[$v[$sc]];   //及格率排名
//            $data['info'][$v[$sc]]['_excell_rank'] = $_excell_rank[$v[$sc]];  //优秀率排名
//            $data['info'][$v[$sc]]['_schfloot_rank'] = $_schfloot_rank[$v[$sc]]; //后20%率排名
//            $data['info'][$v[$sc]]['_schfirst_rank'] = $_schfirst_rank[$v[$sc]]; //前10率排名
//
//        }
//        $data['total'] = $res['total'];
//
//        return $data;
//    }
    function sch_avg($chi,$sc)  //标准分
    {
        $sch_avg = 0;
        foreach ($chi as $item=>$items) {
            $sch_avg += $items['chi_avg'];
        }
        $sch_avg = $sch_avg/count($chi); //平均分
        $avgNum = 0;
        foreach ($chi as $item=>$v) {
            $avgNum += pow($v['chi_avg']-$sch_avg,2);
        }
        $avgNum = sqrt($avgNum/count($chi));  //标准差
        foreach ($chi as $item=>$v) {
            $res[$v[$sc]] = sprintf("%.2f",($v['chi_avg']-$sch_avg)/$avgNum);
        }
        return $res;
    }


    function great_avg($avg,$type)   //优秀率标准分
    {
        $sch_avg = 0;
        foreach ($avg as $item) {
            $sch_avg +=$item;
        }
        $sch_avg = $sch_avg/count($avg);   //平均分
        $avgNum = 0;

        foreach ($avg as $item) {
            $avgNum += pow($item-$sch_avg,2);
        }
        $avgNum = sqrt($avgNum/count($avg));  //标准差
        foreach ($avg as $k=>$v) {
            $res[$k]    = sprintf("%.2f",($v-$sch_avg)/$avgNum);
        }
        return $res;
    }
    function floot_avg($avg,$type)   //优秀率标准分
    {
        $sch_avg = 0;
        foreach ($avg as $item) {
            $sch_avg +=  (100-$item);
        }
        $sch_avg = $sch_avg/count($avg);   //平均分
        $avgNum = 0;

        foreach ($avg as $item) {
            $avgNum += pow((100-$item)-$sch_avg,2);
        }
        $avgNum = sqrt($avgNum/count($avg));  //标准差
        foreach ($avg as $k=>$v) {
            $res[$k]    = sprintf("%.2f",((100-$v)-$sch_avg)/$avgNum);
        }
        return $res;
    }

    function sendMsg($tel,$data)
    {
        $token = substr($tel,0,1)+substr($tel,-1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://115.236.100.85:8083?Action=SmsSend&recbh=001&context=$data&mobile=$tel&ocode=00007&checkcode=$token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        curl_close($ch);
    }
    public $reportImg = array(
        'A' => '15',
        'B' => '25',
        'C' => '30',
        'D' => '25',
        'E' => '5'
    );

    function imgRepInfo($sub,$id,$type,$schoolname,$classname)
    {
        $where['pid']= $id;
        $nav['pid'] = $id;
        if($type == 'classname')
        {
            $where['schoolname'] = $schoolname;
            $status = 1;
        }
        if($classname)
        {
            $where['classname'] = $classname;
        }
        $schCount = M('school_call')->where($nav)->count();
        foreach ($this->reportImg as $k=>$v) {
            $level[$k] = round($schCount*$v*0.01);
        }

        $res = array();
        foreach ($this->reportImg as $items=>$item) {
            switch ($items)
            {
                case 'A':
                    $where[$sub] = array('EGT',$this->getFrac($sub,$level[$items],$id,$schoolname,$status));
                    $data[$items] = M('school_call')->field("count(id) as count,$type")->where($where)->group($type)->order($type)->select();
                    foreach ($data[$items] as $item=>$lt) {
                        $res[$lt[$type]][$items] = $lt['count'];
                    }
                    break;
                case 'B':
                    $where[$sub] = array(['LT',$this->getFrac($sub,$level['A'],$id,$schoolname,$status)],['EGT',$this->getFrac($sub,$level['B']+$level['A'],$id,$schoolname,$status)]);
                    $data[$items] = M('school_call')->where($where)->field("count(id) as count,$type")->group($type)->order($type)->select();
                    foreach ($data[$items] as $item=>$lt) {
                        $res[$lt[$type]][$items] = $lt['count'];
                    }
                    break;
                case 'C':
                    $where[$sub] = array(['LT',$this->getFrac($sub,$level['B']+$level['A'],$id,$schoolname,$status)],['EGT',$this->getFrac($sub,$level['C']+$level['B']+$level['A'],$id,$schoolname,$status)]);
                    $data[$items] = M('school_call')->where($where)->field("count(id) as count,$type")->group($type)->order($type)->select();
                    foreach ($data[$items] as $item=>$lt) {
                        $res[$lt[$type]][$items] = $lt['count'];
                    }
                    break;
                case 'D':
                    $where[$sub] = array(['LT',$this->getFrac($sub,$level['C']+$level['B']+$level['A'],$id,$schoolname,$status)],['EGT',$this->getFrac($sub,$level['D']+$level['C']+$level['B']+$level['A'],$id,$schoolname,$status)]);
                    $data[$items] = M('school_call')->where($where)->field("count(id) as count,$type")->group($type)->order($type)->select();
                    foreach ($data[$items] as $item=>$lt) {
                        $res[$lt[$type]][$items] = $lt['count'];
                    }
                    break;
                case 'E':
                    $where[$sub] = array('LT',$this->getFrac($sub,$level['D']+$level['C']+$level['B']+$level['A'],$id,$schoolname,$status));
                    $data[$items] = M('school_call')->where($where)->field("count(id) as count,$type")->group($type)->order($type)->select();
                    foreach ($data[$items] as $item=>$lt) {
                        $res[$lt[$type]][$items] = $lt['count'];
                    }
                    break;
            }
        }


        $schoolname = [];
        $allschool = [];
        foreach ($res as $re=>$le) {
            foreach ($le as $ts=>$t) {
                $allschool['info'][$ts] +=$le[$ts];
            }
            $schoolname[] = $re;
            foreach ($this->reportImg as $item=>$v) {
                $le[$item] ? $nums=$le[$item] : $nums = 0;
                $info[$item][] = $nums*1;
            }
        }
        $allschool['schoolname'] = '总体情况';

        $result['info'] = $info;

        $result['schoolname'] = $schoolname;

        foreach ($allschool['info'] as $k=>$v) {
            array_unshift($result['info'][$k],$v);
        }

        array_unshift($result['schoolname'],$allschool['schoolname']);

        return $result;


    }

    function getFrac($sub,$keys,$id,$schname)
    {
        $where['pid'] = $id;
//        if($schname)
//        {
//            $where['schoolname'] = $schname;
//        }
        $info = M('school_call')->where($where)->field($sub)->order($sub.' desc')->limit($keys,1)->select()[0][$sub];
//        var_export(M('school_call')->getLastSql());
//        echo '<hr>';
        return $info;
    }


    function test()
    {
        $count = 1081;
        $basics = array(
            'A' => round($this->reportImg['A']*$count*0.01),
            'B' => round(($this->reportImg['A']+$this->reportImg['B'])*$count*0.01),
            'C' => round(($this->reportImg['A']+$this->reportImg['B']+$this->reportImg['C'])*$count*0.01),
            'D' => round(($this->reportImg['A']+$this->reportImg['B']+$this->reportImg['C']+$this->reportImg['D'])*$count*0.01),
            'E' => round(($this->reportImg['A']+$this->reportImg['B']+$this->reportImg['C']+$this->reportImg['D']+$this->reportImg['E'])*$count*0.01),
        );
        foreach ($basics as $k=>$v) {
            $this->testFrac('chi',$k,$v);
        }
    }

    function testFrac($sub,$keys,$vals)
    {

        if(count($this->reportImg) == 5)
        {
            var_export($vals);
            if($keys == 'A')   //前n人
            {
                $info = M('school_call')->field($sub)->order($sub.' desc')->limit('162')->select();
            }
            var_export($info);
        }
    }






}