<?php
    //定義連線
    function create_connect(){
        
        /*
        *此方法與下方$conn一樣，這方法是拆開寫
        $conn=mysqli_connect("local","owner","123456");
        if(!$conn){
            die("連線失敗:".mysqli_connect_error());
        }
        */

        //localhost如用docker 會分外部接線與內部接線sqlsever，記的要改ufw對外部的port
        $conn=mysqli_connect("localhost","owner","123456") or die("連線失敗:".mysqli_connect_error());

        return $conn;
    }

    //連線資料庫
    function execute_sql($link,$database,$sql){
        mysqli_select_db($link,$database) or die("連線資料庫失敗: ".mysqli_error($link));

        $result=mysqli_query($link,$sql);
        return $result;
    }
?>