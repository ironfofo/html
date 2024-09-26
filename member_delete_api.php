<?php
//刪除會員
//接收json格式
$data = file_get_contents("php://input", "r");
$mydata = array();
$mydata = json_decode($data, true);

if (isset($mydata["id"])) {
    if ($mydata["id"] != "") {

        $p_id = $mydata["id"];
        $p_email = $mydata["email"];

        require_once("dbtools.php");
        $link = create_connect();

        $sql = "DELETE FROM member WHERE id='$p_id'";
        if(execute_sql($link, "testdb", $sql)){
            echo'{"state":"true","message":"刪除成功"}';
        }else{
            echo'{"state":"false","message":"刪除失敗或代碼錯誤"}';
        }
        mysqli_close($link);
    } else {
        echo '{"state":false,"message":"欄位不得空白"}';
    }
} else {
    echo '{"state":false,"message":"欄位命名錯誤"}';
}
?>