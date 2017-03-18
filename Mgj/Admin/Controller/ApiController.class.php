<?php
/**
 * Created by PhpStorm.
 * User: mty
 * Date: 16/12/8
 * Time: 上午9:17
 */

namespace Admin\Controller;
use Think\Controller;
use Admin\Model\ApiModel;
class ApiController extends Controller
{
    public $Tip = array(    //科目
        'chi' => '语文',
        'math' => '数学',
        'sec' => '科学',
        'eng' => '英语',
        'total' => '总分'
    );
    function excelTitle($basics)    //excel  title
    {
        return  $title = ['学校','实考人数','最高分','最低分','平均分','平均分排名','及格人数','及格率','及格率排名','优秀人数','优秀率',
            '优秀率排名',"后$basics[bake]人数","后$basics[bake]%率","后$basics[bake]%率排名","前10%人数","前$basics[front]%率","前$basics[front]%率排名",'',"平均分标准分",'优秀率标准分','及格率标准分',"前$basics[front]%率标准分","后$basics[bake]%率标准分"];
    }

    public $sch_ocode = 330183001;
    function getManyExam()    //联考数据接口
    {
        $schoolname = I('post.schoolname');
        $ocode = session('admin.school_id');
        $state = I('post.state');
        $info = new ApiModel();
        if($state == 1)  //联考
        {
            if($ocode == $this->sch_ocode)
            {
                $info = $info->own($this->sch_ocode,I('post.name'));
            }
            else
            {
                $res = M('rep_many_exam')->where("schoolname = '$schoolname'")->field('pid')->select();
                $res = implode(',',array_column($res,'pid'));
                if(count($res)>0 && $res)
                {
                    $info = $info->otherSch($res,I('get.name'));
                }
            }
        }
        else
        {     //远程接口
            $info = $this->getOncesch($schoolname,I('post.name'));
        }

        echo json_encode($info);

    }

    function manyExamInfo()
    {
        $id = I('get.id');
        $state = I('get.state');
        $schoolname = I('get.schoolname');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://jys.fyedu.org/index.php/Api/call_info?id=$id&state=$state&schoolname=$schoolname");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        $output = explode('<div',$output)[0];
        curl_close($ch);
        $res = json_decode($output,1);

        foreach ($res as $re=>$v) {
            $this->assign($re,$v);
        }

        $area_bh = substr($_SESSION['admin']['school_id'],0,6);
        $ocode = substr($_SESSION['admin']['school_id'],-3);
        $ocode_name = M('shoollist')->where('area_bh ='.$area_bh.' and ocode ='.$ocode)->field('ocode_name')->find()['ocode_name'];
        $this->assign('ocode_name',$ocode_name);
        $arr = D('User')->get_school_nav();
        $this->assign('data_nav',$arr);
        $this->display('Report/call_info');
    }


    function call_info()   //联考
    {
        $api = new ApiModel();
        $res = M('rep_examlist')->where('id = '.I('get.id'))->find();
        $res['schoolname'] = I('get.schoolname');
        if(I('get.state') == 0)
        {
            $type = 'classname';
        }else
        {
            $type = 'schoolname';
        }
        $data = array(
            'res'   => $res,
            'chi'   => $api->call_chi($res,$type,'chi')['info'],
            'chi_range' => $api->call_chi($res,$type,'chi'),
            'math'   => $api->call_chi($res,$type,'math')['info'],
            'math_range' => $api->call_chi($res,$type,'math'),
            'sec'   => $api->call_chi($res,$type,'sec')['info'],
            'sec_range' => $api->call_chi($res,$type,'sec'),
            'eng'   => $api->call_chi($res,$type,'eng')['info'],
            'eng_range' => $api->call_chi($res,$type,'eng'),
            'total'   => $api->call_chi($res,$type,'total')['info'],
            'total_range' => $api->call_chi($res,$type,'total'),
        );
        echo json_encode($data,true);

    }

    function local_call($schoolname)   //联考本地  下载
    {
        $api = new ApiModel();
        $res = M('rep_examlist')->where('id = '.I('get.id'))->find();
        $res['schoolname'] = $schoolname;
        if(I('get.state') == 0)
        {
            $type = 'classname';
        }else
        {
            $type = 'schoolname';
        }
        return  $data = array(
            'res'   => $res,
            'chi'   => $api->call_chi($res,$type,'chi')['info'],
            'chi_range' => $api->call_chi($res,$type,'chi'),
            'math'   => $api->call_chi($res,$type,'math')['info'],
            'math_range' => $api->call_chi($res,$type,'math'),
            'sec'   => $api->call_chi($res,$type,'sec')['info'],
            'sec_range' => $api->call_chi($res,$type,'sec'),
            'eng'   => $api->call_chi($res,$type,'eng')['info'],
            'eng_range' => $api->call_chi($res,$type,'eng'),
            'total'   => $api->call_chi($res,$type,'total')['info'],
            'total_range' => $api->call_chi($res,$type,'total'),
        );


    }

    function exportexcel(){
        $filename = I('get.name');
        $schoolname = I('get.schoolname');
        $id = I('get.id');
        $state = I('get.state');
        if($state == 0)   //   0 - 单校   1-联考
        {
            $class = 'classname';
        }
        else
        {
            $class = 'schoolname';
        }
//        $id = 11;
//        $state = 1;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://jys.fyedu.org/index.php/Api/call_info?id=$id&state=$state&schoolname=$schoolname");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($output,true);
        $tips = $this->Tip;
        $subject = array('chi','math','sec','eng','total');
        $subNum = array_intersect($subject,array_keys($res['res']));
        $basics = M('rep_examlist')->field('front,bake')->find($id);
        $title = $this->excelTitle($basics);
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=".$filename.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
        foreach ($subNum as $subs=>$sub) {
            $i = 0;
            $chipassnum = 0;$chimaxall = '';$chiminall ='';$chiallnum=0;$chiavgall = 0;$chipassrate = 0;$chiexcellnum =0;$chiexcellrank =0;$chiflootnum = 0;$chiflootrank =0;$chifirstnum =0;$chifirstrank=0;$chi_avg='';$chi_pass = '';$chi_excell = '';$chi_floot = '';$chi_first = '';
            echo "\n";
            echo iconv('UTF-8', 'GB2312', $tips[$sub])."\t".$res['res'][$sub].iconv('UTF-8', 'GB2312', '分制')."\t\t";
            echo iconv('UTF-8', 'GB2312', "后$basics[bake]%分数线")."\t".$res[$sub.'_range']['flootuser']['flootfrac']."\t";
            echo iconv('UTF-8', 'GB2312', "后$basics[bake]%总人数")."\t".$res[$sub.'_range']['flootuser']['flootnum']."\t\t";
            echo iconv('UTF-8', 'GB2312', "前$basics[front]%分数线")."\t".$res[$sub.'_range']['firstuser']['firstfrac']."\t" ;
            echo iconv('UTF-8', 'GB2312', "前$basics[front]%总人数")."\t".$res[$sub.'_range']['firstuser']['firstnum']."\t";
            echo "\n";
            foreach ($title as $tel=>$te) {
                echo iconv('UTF-8', 'GB2312', $te)."\t";
            }
            echo "\n";
            foreach ($res[$sub] as $k=>$v) {
                echo iconv('UTF-8', 'GB2312', $v[$class])."\t".$v['chi_count']."\t".$v['chi_max']."\t".$v['chi_min']."\t".sprintf("%.2f",$v['chi_avg']);
                echo "\t".$v['_avg_rank']."\t".$v['_passnum']."\t".$v['_passrate']."%"."\t".$v['_passrate_']."\t".$v['_excellnum'] ;
                echo "\t".$v['_excellrank']."%\t".$v['_excell_rank']."\t".$v['_schflootnum']."\t".$v['_schflootrank'].'%'."\t".$v['_schfloot_rank'];
                echo "\t".$v['_schfirstnum']."\t".$v['_schfirstrank']."%\t".$v['_schfirst_rank']."\t\t".$v['sch_avg']."\t".$v['greate_avg']."\t".$v['pass_avg']."\t".$v['first_avg']."\t".$v['floot_avg'];
                echo "\n";
                $i++;
                $chiallnum += $v['chi_count'];
                $chimaxall .= ','.$v['chi_max'];
                $chiminall .= ','.$v['chi_min'];
                $chiavgall += sprintf("%.2f",$v['chi_avg']);
                $chipassnum += $v['_passnum'];

                $chipassrate += $v['_passrate'];
                $chiexcellnum += $v['_excellnum'];
                $chiexcellrank += $v['_excellrank'];
                $chiflootnum += $v['_schflootnum'];
                $chiflootrank += $v['_schflootrank'];
                $chifirstnum += $v['_schfirstnum'];
                $chifirstrank += $v['_schfirstrank'];

                $chi_avg .= ','.sprintf("%.2f",$v['chi_avg']);
                $chi_pass .= ','.$v['_passrate'];
                $chi_excell .= ','.$v['_excellrank'];
                $chi_floot .= ','.$v['_schflootrank'];
                $chi_first .= ','.$v['_schfirstrank'];
            }

            $chimaxmallstr =  substr($chimaxall,1);
            $chimaxmallstr = explode(',',$chimaxmallstr);
            $chimallstr = max($chimaxmallstr);

            $chiminmallstr =  substr($chiminall,1);
            $chiminmallstr = explode(',',$chiminmallstr);
            $chiminstr = min($chiminmallstr);

            $chi_avg = substr($chi_avg,'1');
            $chi_avg = explode(',',$chi_avg);
            $avg = max($chi_avg)-min($chi_avg);

            $rank = substr($chi_pass,'1');
            $rank = explode(',',$rank);
            $rank = max($rank)-min($rank);

            $good = substr($chi_excell,'1');
            $good = explode(',',$good);
            $good = max($good)-min($good);

            $bake = substr($chi_floot,'1');
            $bake = explode(',',$bake);
            $bake = max($bake)-min($bake);

            $first = substr($chi_first,'1');
            $first = explode(',',$first);
            $first = max($first)-min($first);
            $m = sprintf("%.2f",$chiavgall/$i);
            echo iconv('UTF-8', 'GB2312', '统计')."\t".$chiallnum."\t".$chimallstr."\t".$chiminstr."\t".$m."\t\t".$chipassnum;
            echo "\t". $chipassrate/$i.'%'."\t\t".$chiexcellnum."\t".$chiexcellrank/$i.'%'."\t\t".$chiflootnum."\t".$chiflootrank/$i.'%'."\t" ;
            echo "\t".$chifirstnum."\t".$chifirstrank/$i.'%';
            echo "\n";
            echo iconv('UTF-8', 'GB2312', '极差')."\t\t\t".iconv('UTF-8', 'GB2312', '平均分')."\t".$avg."\t\t";
            echo iconv('UTF-8', 'GB2312', '及格率')."\t".$rank ."%\t\t".iconv('UTF-8', 'GB2312', '优秀率')."\t".$good."%\t\t".iconv('UTF-8', 'GB2312', "后$basics[bake]%人率");
            echo "\t".$bake."%\t\t".iconv('UTF-8', 'GB2312', "前$basics[front]%人率")."\t".$first.'%';
            echo "\n";
        }

    }


    function getOncesch($schoolname,$name)
    {
        $where['state'] = 0;
        $where['data']  = 1;
        $where['schoolname'] = $schoolname;
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
        $res['data'] = M('rep_examlist')->where($where)->field('id,name,username,regtime,examtime,state,share,data,pid,schoolname')->order('examtime desc')->limit($limit)->select();
        $res['page'] = $show;
        $res['p'] = ceil($count/12);
        return $res;
    }



    function localexcel(){
        $filename = I('get.name');
        $id = I('get.id');
        $schoolname = I('schoolname');
        $state = I('get.state');
//        $id = 11;
//        $state = 1;
        if($state == 0)   //   0 - 单校   1-联考
        {
            $class = 'classname';
        }
        else
        {
            $class = 'schoolname';
        }
        $res= $this->local_call($schoolname);
        $tips = $this->Tip;
        $subject = array('chi','math','sec','eng','total');
        $subNum = array_intersect($subject,array_keys($res['res']));
        $basics = M('rep_examlist')->field('front,bake')->find($id);
        $title = $this->excelTitle($basics);
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=".$filename.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
        foreach ($subNum as $subs=>$sub) {
            $i = 0;
            $chipassnum = 0;$chimaxall = '';$chiminall ='';$chiallnum=0;$chiavgall = 0;$chipassrate = 0;$chiexcellnum =0;$chiexcellrank =0;$chiflootnum = 0;$chiflootrank =0;$chifirstnum =0;$chifirstrank=0;$chi_avg='';$chi_pass = '';$chi_excell = '';$chi_floot = '';$chi_first = '';
            echo "\n";
            echo iconv('UTF-8', 'GB2312', $tips[$sub])."\t".$res['res'][$sub].iconv('UTF-8', 'GB2312', '分制')."\t\t";
            echo iconv('UTF-8', 'GB2312', "后$basics[bake]%分数线")."\t".$res[$sub.'_range']['flootuser']['flootfrac']."\t";
            echo iconv('UTF-8', 'GB2312', "后$basics[bake]%总人数")."\t".$res[$sub.'_range']['flootuser']['flootnum']."\t\t";
            echo iconv('UTF-8', 'GB2312', "前$basics[front]%分数线")."\t".$res[$sub.'_range']['firstuser']['firstfrac']."\t" ;
            echo iconv('UTF-8', 'GB2312', "前$basics[front]%总人数")."\t".$res[$sub.'_range']['firstuser']['firstnum']."\t";
            echo "\n";
            foreach ($title as $tel=>$te) {
                echo iconv('UTF-8', 'GB2312', $te)."\t";
            }

            echo "\n";
            foreach ($res[$sub] as $k=>$v) {
                echo iconv('UTF-8', 'GB2312', $v[$class])."\t".$v['chi_count']."\t".$v['chi_max']."\t".$v['chi_min']."\t".sprintf("%.2f",$v['chi_avg']);
                echo "\t".$v['_avg_rank']."\t".$v['_passnum']."\t".$v['_passrate']."%"."\t".$v['_passrate_']."\t".$v['_excellnum'] ;
                echo "\t".$v['_excellrank']."%\t".$v['_excell_rank']."\t".$v['_schflootnum']."\t".$v['_schflootrank'].'%'."\t".$v['_schfloot_rank'];
                echo "\t".$v['_schfirstnum']."\t".$v['_schfirstrank']."%\t".$v['_schfirst_rank']."\t\t".$v['sch_avg']."\t".$v['greate_avg']."\t".$v['pass_avg']."\t".$v['first_avg']."\t".$v['floot_avg'];
                echo "\n";
                $i++;
                $chiallnum += $v['chi_count'];
                $chimaxall .= ','.$v['chi_max'];
                $chiminall .= ','.$v['chi_min'];
                $chiavgall += sprintf("%.2f",$v['chi_avg']);
                $chipassnum += $v['_passnum'];

                $chipassrate += $v['_passrate'];
                $chiexcellnum += $v['_excellnum'];
                $chiexcellrank += $v['_excellrank'];
                $chiflootnum += $v['_schflootnum'];
                $chiflootrank += $v['_schflootrank'];
                $chifirstnum += $v['_schfirstnum'];
                $chifirstrank += $v['_schfirstrank'];

                $chi_avg .= ','.sprintf("%.2f",$v['chi_avg']);
                $chi_pass .= ','.$v['_passrate'];
                $chi_excell .= ','.$v['_excellrank'];
                $chi_floot .= ','.$v['_schflootrank'];
                $chi_first .= ','.$v['_schfirstrank'];
            }

            $chimaxmallstr =  substr($chimaxall,1);
            $chimaxmallstr = explode(',',$chimaxmallstr);
            $chimallstr = max($chimaxmallstr);

            $chiminmallstr =  substr($chiminall,1);
            $chiminmallstr = explode(',',$chiminmallstr);
            $chiminstr = min($chiminmallstr);

            $chi_avg = substr($chi_avg,'1');
            $chi_avg = explode(',',$chi_avg);
            $avg = max($chi_avg)-min($chi_avg);

            $rank = substr($chi_pass,'1');
            $rank = explode(',',$rank);
            $rank = max($rank)-min($rank);

            $good = substr($chi_excell,'1');
            $good = explode(',',$good);
            $good = max($good)-min($good);

            $bake = substr($chi_floot,'1');
            $bake = explode(',',$bake);
            $bake = max($bake)-min($bake);

            $first = substr($chi_first,'1');
            $first = explode(',',$first);
            $first = max($first)-min($first);
            $m = sprintf("%.2f",$chiavgall/$i);
            echo iconv('UTF-8', 'GB2312', '统计')."\t".$chiallnum."\t".$chimallstr."\t".$chiminstr."\t".$m."\t\t".$chipassnum;
            echo "\t". $chipassrate/$i.'%'."\t\t".$chiexcellnum."\t".$chiexcellrank/$i.'%'."\t\t".$chiflootnum."\t".$chiflootrank/$i.'%'."\t" ;
            echo "\t".$chifirstnum."\t".$chifirstrank/$i.'%';
            echo "\n";
            echo iconv('UTF-8', 'GB2312', '极差')."\t\t\t".iconv('UTF-8', 'GB2312', '平均分')."\t".$avg."\t\t";
            echo iconv('UTF-8', 'GB2312', '及格率')."\t".$rank ."%\t\t".iconv('UTF-8', 'GB2312', '优秀率')."\t".$good."%\t\t".iconv('UTF-8', 'GB2312', "后$basics[bake]%人率");
            echo "\t".$bake."%\t\t".iconv('UTF-8', 'GB2312', "前$basics[front]%人率")."\t".$first.'%';
            echo "\n";
        }

    }

    





}