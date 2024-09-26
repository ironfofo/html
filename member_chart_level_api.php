<?php

//紀算各level數量
    require_once("dbtools.php");
    $link = create_connect();
    //遞增ASC 遞減DESC
    $sql = "SELECT COUNT(Level) as levelcount,Level as level FROM member GROUP By Level;";
    $result = execute_sql($link, "testdb", $sql);
    $mydata = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $mydata[] = $row;
    }
    echo '{"state":true,"data":' . json_encode($mydata) . ',"message":"讀取會員等級資料成功"}';
    mysqli_close($link);
?>