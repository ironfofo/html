<?php
//更新會員狀態state
    //接收json格式
    $data = file_get_contents("php://input", "r");
    $mydata = array();
    $mydata = json_decode($data, true);

    if (isset($mydata["id"])&&isset($mydata["state"])) {
        if ($mydata["id"] != "" && $mydata["state"] != "") {

            $p_id = $mydata["id"];
            $p_state = $mydata["state"];

            require_once("dbtools.php");
            $link = create_connect();

            $sql = "UPDATE member SET state='$p_state' WHERE id='$p_id'";
            if(execute_sql($link, "testdb", $sql)){
                echo'{"state":"true","message":"會員狀態更新成功"}';
            }else{
                echo'{"state":"false","message":"會員狀態更新失敗或代碼錯誤"}';
            }
        
            mysqli_close($link);
        } else {
            echo '{"state":false,"message":"欄位不得空白"}';
        }
    } else {
        echo '{"state":false,"message":"欄位命名錯誤"}';
    }
?>
