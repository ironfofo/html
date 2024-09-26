<?php
//更新圖片
    $data = file_get_contents("php://input", "r");
    $mydata = array();
    $mydata = json_decode($data, true);

    if (isset($_FILES['file']['type']) && $_FILES['file']['type'] !== "") {
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

                $p_id = $_POST["id"];
                $p_photo = $mydata["photo"];

                require_once("dbtools.php");
                $link = create_connect();
                $sql = "UPDATE member SET Photo='$filename' WHERE id='$p_id'";

                if (execute_sql($link, "testdb", $sql)) {
                    //json_encode()已經是json格式
                    echo '{"state":true,"datainfo":' . json_encode($datainfo) . ',"message":"上傳資料庫成功"}';
                } else {
                    echo '{"state":false,"message":"上傳資料庫失敗"}';
                }
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
