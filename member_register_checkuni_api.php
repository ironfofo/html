<?php
//會員註冊username是否註冊
    //接收json格式
    $data = file_get_contents("php://input", "r");
    $mydata = array();
    $mydata = json_decode($data, true);

    if (isset($mydata["username"])) {
        if ($mydata["username"] != "") {

            $p_username = $mydata["username"];




            require_once("dbtools.php");
            // 用來定義與資料庫連結
            $link = create_connect();
            $sql = "SELECT * FROM member WHERE Username = '$p_username'";

            $result = execute_sql($link, "testdb", $sql);

            if (mysqli_num_rows($result) == 0) {
                echo '{"state":true,"message":"帳號不存在可以使用"}';
            } else {
                echo '{"state":false,"message":"帳號已存在不得使用"}';
            }
            mysqli_close($link);
        } else {
            echo '{"state":false,"message":"欄位不得空白"}';
        }
    } else {
        echo '{"state":false,"message":"欄位命名錯誤"}';
    }
?>