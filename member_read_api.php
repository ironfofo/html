<?php
//讀取會員
    require_once("dbtools.php");
    $link = create_connect();
    //遞增ASC 遞減DESC
    $sql = "SELECT id, Username,Email,Uid01 ,State,Level ,Create_at FROM member ORDER BY id DESC";
    $result = execute_sql($link, "testdb", $sql);
    $mydata = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $mydata[] = $row;
    }
    echo '{"state":true,"data":' . json_encode($mydata) . ',"message":"讀取會員資料成功"}';
    mysqli_close($link);
?>