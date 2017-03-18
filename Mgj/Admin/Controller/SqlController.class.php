<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/9/20
 * Time: 上午11:56
 */
namespace Admin\Controller;


class SqlController{
    function add(){
        try {
            $servname="192.168.200.54";
            $conninfo=array( "Database"=>"101", "UID"=>"jhg", "PWD"=>"www.xdzms.cn.sq12014");
            $conn=sqlsrv_connect($servname, $conninfo);
            if($conn) echo "conect success";
            else echo "connect failed";
            $sql="select * from Users";
            $db=sqlsrv_query($conn, $sql);
            while($row=sqlsrv_fetch_array($db))
            {
                echo $row["Username"];
            }
        }
        catch (Exception $e){}
    }
}