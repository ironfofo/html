<?php
//更新會員Level
    //接收json格式
    $data = file_get_contents("php://input", "r");
    $mydata = array();
    $mydata = json_decode($data, true);

    if (isset($mydata["id"])&&isset($mydata["level"])) {
        if ($mydata["id"] != "" && $mydata["level"] != "") {

            $p_id = $mydata["id"];
            $p_level = $mydata["level"];

            require_once("dbtools.php");
            $link = create_connect();

            $sql = "UPDATE member SET Level='$p_level' WHERE id='$p_id'";
            if(execute_sql($link, "testdb", $sql)){
                echo'{"state":"true","message":"會員等級更新成功"}';
            }else{
                echo'{"state":"false","message":"會員等級更新失敗或代碼錯誤"}';
            }
        
            mysqli_close($link);
        } else {
            echo '{"state":false,"message":"欄位不得空白"}';
        }
    } else {
        echo '{"state":false,"message":"欄位命名錯誤"}';
    }
?>
