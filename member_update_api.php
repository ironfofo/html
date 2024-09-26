<?php
//更新會員EMAIL
    //接收json格式
    $data = file_get_contents("php://input", "r");
    $mydata = array();
    $mydata = json_decode($data, true);

    if (isset($mydata["id"]) && isset($mydata["email"])) {
        if ($mydata["id"] != "" && $mydata["email"] != "") {
            $p_id = $mydata["id"];
            $p_email = $mydata["email"];

            require_once("dbtools.php");
            $link = create_connect();

            $sql = "UPDATE member SET Email='$p_email' WHERE id='$p_id'";
            if (execute_sql($link, "testdb", $sql)) {
                
                echo '{"state" : true, "message" : "更新成功"}';
            } else {
                echo '{"state":"false","message":"更新失敗或代碼錯誤"}';
            }
        } else {
            echo '{"state":false,"message":"欄位不得空白"}';
        }
    } else {
        echo '{"state":false,"message":"欄位命名錯誤"}';
    }
?>
