<?php
//會員登入
//接收json格式
$data = file_get_contents("php://input", "r");
$mydata = array();
$mydata = json_decode($data, true);

if (isset($mydata["username"]) && isset($mydata["password"])) {
    if ($mydata["username"] != "" && $mydata["password"] != "") {

        $p_username = $mydata["username"];
        // 使用者輸入的密碼為明碼
        $p_password = $mydata["password"];
        // 載入資料庫連線、執行sql的php檔
        require_once("dbtools.php");
        // 用來定義與資料庫連結
        $link = create_connect();
        // sql指令,尋找使用者名稱、密碼
        $sql = "SELECT Username,Password FROM member WHERE Username = '$p_username'";
        // 執行sql指令並將結果存入$result
        $result = execute_sql($link, "testdb", $sql);


        //1.確認帳號師否存在
        //2.確認帳號是否正確,password_verify()


        // 判斷帳號是否存在
        if (mysqli_num_rows($result) == 1) {

            //如果帳號存在,繼續對比密碼並存入$result
            $row = mysqli_fetch_assoc($result);
            // 將使用者輸入的明碼密碼與資料庫內編碼後的密碼比對並判斷

            if (password_verify($p_password, $row["Password"])) {

                // 密碼比對正確,產生uid並更新資料
                $uid01 = substr(hash('sha256', uniqid(time())), 0, 8);
                $sql = "UPDATE member SET Uid01='$uid01' WHERE Username = '$p_username'";

                // 當uid01更新成功
                if (execute_sql($link, "testdb", $sql)) {

                    $sql = "SELECT Username,Email,Uid01,State,Create_at FROM member WHERE Username = '$p_username'";
                    $result = execute_sql($link, "testdb", $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo '{"state":true,"data":' . json_encode($row) . ',"message":"登入成功"}';
                } else {
                    //uid01更新失敗
                    echo '{"state":false,"message":"uid01更新失敗"}';
                }
            } else {
                echo '{"state":false,"message":"登入失敗1"}';
            }
        } else {
            echo '{"state":false,"message":"登入失敗2"}';
        }
        mysqli_close($link);
    } else {
        echo '{"state":false,"message":"登入失敗3"}';
    }
} else {
    echo '{"state":false,"message":"登入失敗4"}';
}
