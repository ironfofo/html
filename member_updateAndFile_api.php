<?php
//更新會員email和照片(測試中)
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



    if (isset($_FILES['file']['type']) || $_FILES['file']['type'] !== "") {
        if ($_FILES['file']['type'] == 'image/jpeg' || $_FILES['file']['type'] == 'image/png') {

            //檔案名稱
            $filename = date("YmdHis") . "_" . $_FILES['file']['name'];

            //upload儲存權限要改777
            $location = "upload/" . $filename;

            if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
                //上傳成功
                $datainfo = array();
                $datainfo["原始檔案名稱"] = $_FILES['file']['name'];
                $datainfo["儲存檔案名稱"] = $filename;
                $datainfo["檔案類型"] = $_FILES['file']['type'];
                $datainfo["檔案大小"] = $_FILES['file']['size'];
                $datainfo["error"] = $_FILES['file']['error'];

                require_once("dbtools.php");
                $link = create_connect();
                $sql = "UPDATE member SET Photo='$filename' WHERE id='$p_id'";

                if (execute_sql($link, "testdb", $sql)) {
                    echo '{"state":true,"datainfo":' . json_encode($datainfo) . ',"message":"上傳及資料庫成功"}';
                } else {
                    echo '{"state":true,"message":"上傳及資料庫成功"}';
                }
                mysqli_close($link);
            } else {
                //上傳失敗
                echo '{"state":false,"message":"上傳失敗"}';
            }
        } else {
            echo '{"state":false,"message":"檔案格式不符合規定!"}';
        }
    } else {
        echo '{"state":false","message":"檔案不存在!"}';
    }
?>