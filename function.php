<?php
//Hàm login sau khi mạng xã hội trả dữ liệu về
function loginFromSocialCallBack($socialUser)
{
    require('database.php');
    $sql = "Select `makh`,`hoten`,`email` from `khachhang` WHERE `email` ='" . $socialUser['email'] . "'";

    $result = database::executeQuery($sql);
    if ($result->num_rows == 0) {
        if($socialUser['email']!=""){
        $sql = "INSERT INTO `khachhang`(`makh`,`hoten`, `email`) VALUES ('" . $socialUser['email'] . "', '" . $socialUser['name'] . "', '" . $socialUser['email'] . "')";
        $result = database::executeQuery($sql);
        }
        if (!$result) {
            echo 'Tài khoản không hợp lệ';
            exit;
        }
        $sql = "Select `makh`,`hoten`,`email` from `khachhang` WHERE `email` ='" . $socialUser['email'] . "'";
        $result = database::executeQuery($sql);
    }

    if ($result->num_rows > 0) {
        $user = mysqli_fetch_assoc($result);
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['name'] = $socialUser['email'];
        $_SESSION['fb'] = false;
        header('Location: index.php');
    }
    else{
        if ($socialUser['email'] == "") {
            header("Location: fb-loi.php");
        }
    }
}
