<?php

//會員註冊
    //接收json格式
    $data=file_get_contents("php://input", "r");
    $mydata = array();
    $mydata = json_decode($data, true);

    if (isset($mydata["username"]) && isset($mydata["password"]) && isset($mydata["email"]) && isset($mydata["dates"])&& isset($mydata["gender"])&& isset($mydata["phone"])) {
        if ($mydata["username"] != "" && $mydata["password"] != "" && $mydata["email"] != "" && $mydata["dates"] != ""&& $mydata["gender"] != ""&& $mydata["phone"] != "") {
            
            $p_username = $mydata["username"];
            // password_hash("123456",PASSWORD_DEFAULT);
            // $p_password = $mydata["password"];
            $p_password = password_hash($mydata["password"],PASSWORD_DEFAULT);
            $p_email = $mydata["email"];
            $p_dates = $mydata["dates"];
            $p_gender = $mydata["gender"];
            $p_phone = $mydata["phone"];


            //載入dbtools.php
            require_once("dbtools.php");
            // 用來定義與資料庫連結
            $link = create_connect();
            $sql = "INSERT INTO member (Username,Password,Email,Dates,Gender,Phone) VALUES ('$p_username','$p_password','$p_email','$p_dates','$p_gender','$p_phone')";

            //execute_sql執行sql查詢,以boolean呈現
            if (execute_sql($link, "testdb", $sql)) {
                echo '{"state":true,"message":"註冊成功"}';
            } else {
                echo '{"state":false,"message":"註冊失敗和錯誤代碼'.mysqli_error($link).'"}';
            }
            mysqli_close($link);
        } else {
            echo '{"state":false,"message":"欄位不得空白"}';
        }
    } else {
        echo '{"state":false,"message":"欄位命名錯誤"}';
    }
?>
