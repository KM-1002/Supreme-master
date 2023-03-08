<?php
require('database.php');
$user =$_POST['user'];
$pass =$_POST['pass'];
//echo"$user $pass"; 
$sql = "SELECT makh,password FROM khachhang WHERE makh='$user' AND password=md5('$pass')";
$result = database::executeQuery($sql);
if (mysqli_num_rows($result) > 0) {
    session_start();
    $_SESSION['name'] = $user;
    //header('Location: index.php');
    echo 1;
} else {
    echo 2;
}
