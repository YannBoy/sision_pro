<?php
namespace Admin\Model;
use Think\Model;


class ExcelModel extends Model
{

    public function __construct() {
        /*导入phpExcel核心类  */
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Reader.Excel5");
        import("Org.Util.PHPExcel.Reader.Excel2007");
    }

    public function read($filename,$encode='utf-8'){
        $objReader = new \PHPExcel_Reader_Excel2007();
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($filename);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $excelData = array();
            for ($row = 1; $row <= $highestRow; $row++) {
            for ($col = 0; $col < $highestColumnIndex; $col++) {
            $excelData[$row][] =(string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }
        }
        return $excelData;
    }

    public static function reader_excel($excelPath, $allColumn = 0, $sheet = 0) {
        $excel_arr = array();

        //默认用excel2007读取excel,若格式 不对，则用之前的版本进行读取
        $PHPReader = new \PHPExcel_Reader_Excel2007();
        if(!$PHPReader->canRead($excelPath)) {
            $PHPReader = new \PHPExcel_Reader_Excel5();
            if(!$PHPReader->canRead($excelPath)) {
                //返回空的数组
                return $excel_arr;
            }
        }

        //载入excel文件
        $PHPExcel  = new \PHPExcel();
        $PHPExcel  = $PHPReader->load($excelPath);

        //获取工作表总数
        $sheetCount = $PHPExcel->getSheetCount();

        //判断是否超过工作表总数，取最小值
        $sheet = $sheet < $sheetCount ? $sheet : $sheetCount;

        //默认读取excel文件中的第一个工作表
        $currentSheet = $PHPExcel->getSheet($sheet);
        if(empty($allColumn)) {
            //取得最大列号，这里输出的是大写的英文字母，ord()函数将字符转为十进制，65代表A
            $allColumn = ord($currentSheet->getHighestColumn()) - 65 + 1;
        }

        //取得一共多少行
        $allRow = $currentSheet->getHighestRow();

        //从第二行开始输出，因为excel表中第一行为列名
        for($currentRow = 2; $currentRow <= $allRow; $currentRow++) {
            for($currentColumn = 0; $currentColumn <= $allColumn - 1; $currentColumn++) {
                $val = $currentSheet->getCellByColumnAndRow($currentColumn, $currentRow)->getValue();
                $excel_arr[$currentRow - 2][$currentColumn] = $val;
            }
        }

        //返回二维数组
        return $excel_arr;
    }

    function school_area($manager){
        $my_self = $manager['num3'].$manager['school_num'];
        $my_self_name = M('shoollist')->where('area_bh ='.$manager['num3'].' and ocode ='.$manager['school_num'])->field('ocode_name')->find()['ocode_name'];
        $my['class_bh'] = $my_self;
        $my['class_name'] = $my_self_name;
        $ocode = M('classaccessinfo')->where('userid ='.$manager['id'])->field('userid,class_bh,class_name')->select();
        $i = 1;
        $data['0']['class_bh'] = $my_self;
//        $data['0']['class_name'] = $my_self_name;
//        $data['0']['biaoji'] = $manager['id'];
        foreach ($ocode as $v) {
            if($v['class_bh'] != $my_self){
                $data[$i]['class_bh'] = substr($v['class_bh'],0,9);
//                $data[$i]['class_name'] = $v['class_name'];
//                $data[$i]['biaoji'] = $v['userid'];
                $i++;
            }
        }
        foreach ($data as $it) {
            $new_data[] = $it['class_bh'];
        }
        $map = array_unique($new_data);
        $i = 0;
        foreach ($map as $item=>$v) {
            $area_bh = substr($v,0,6);
            $sch = substr($v,-3);
            $new[$i]['class_name'] = M('shoollist')->where('area_bh = '.$area_bh.' and ocode = '.$sch)->field('ocode_name')->find()['ocode_name'];
            $new[$i]['class_bh'] = $v;
            $new[$i]['biaoji'] = $manager['id'];
            $i++;
        }

        return $new;
    }





}