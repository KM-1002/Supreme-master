<meta charset="UTF-8">
<?php
include  './PHPMailer/src/PHPMailer.php';
include  './PHPMailer/src/Exception.php';
include  './PHPMailer/src/OAuth.php';
include  './PHPMailer/src/POP3.php';
include  './PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
require("database.php");
require("cart.php");
$sql = "";
date_default_timezone_set("Asia/Ho_Chi_Minh");
$mahd = "HD" . date("y") . date("m") . date("d") . date("H") . date("i") . date("s");
if (isset($_POST['makh'])) {
	$makh = $_POST['makh'];
	$sql = "SELECT hoten,diachi,email,sdt FROM khachhang WHERE makh='$makh'";
	$result = database::executeQuery($sql);
	$row = mysqli_fetch_array($result);
	$hoten = $row['hoten'];
	$ngayban = date("Y") . "-" . date("m") . "-" . date("d");
	if (isset($_POST['diachi'])) $diachigiao = $_POST['diachi'];
	else $diachigiao = $row['diachi'];
	$email = $row['email'];
	$sdt = $row['sdt'];
	$tongtien = 0;
	foreach ($_SESSION['cart'] as $masp => $soluong) {
		if (isset($masp)) {
			$sql = "SELECT gia FROM sanpham WHERE masp='$masp'";
			$result = database::executeQuery($sql);
			$row = mysqli_fetch_array($result);
			$gia = $row['gia'];
			$sql = "INSERT INTO cthd (mahd,masp,gia,soluong) VALUES ('$mahd','$masp','$gia','$soluong')";
			database::executeQuery($sql);
			$tongtien += $soluong * $gia;
		}
	}
	$ghichu = $_POST['ghichu'];
	$sql = "INSERT INTO hoadon (mahd,makh,hoten,ngayban,diachigiao,email,sdt,tongtien,ghichu,xacnhan) VALUES ('$mahd','$makh','$hoten','$ngayban','$diachigiao','$email','$sdt','$tongtien','$ghichu','2')";
} else {
	$hoten = $_POST['hoten'];
	$ngayban = date("Y") . "-" . date("m") . "-" . date("d");
	$diachigiao = $_POST['diachi'];
	$email = $_POST['email'];
	$sdt = $_POST['sdt'];
	$tongtien = 0;
	foreach ($_SESSION['cart'] as $masp => $soluong) {
		if (isset($masp)) {
			$sql = "SELECT gia FROM sanpham WHERE masp='$masp'";
			$result = database::executeQuery($sql);
			$row = mysqli_fetch_array($result);
			$gia = $row['gia'];
			$sql = "INSERT INTO cthd (mahd,masp,gia,soluong) VALUES ('$mahd','$masp','$gia','$soluong')";
			database::executeQuery($sql);
			$tongtien += $soluong * $gia;
		}
	}
	$ghichu = $_POST['ghichu'];
	$sql = "INSERT INTO hoadon (mahd,hoten,ngayban,diachigiao,email,sdt,tongtien,ghichu,xacnhan) VALUES ('$mahd','$hoten','$ngayban','$diachigiao','$email','$sdt','$tongtien','$ghichu','1')";
	$mail = new PHPMailer(true);
	try {
		//Server settings
		$mail->isSMTP();                                            //Send using SMTP
		$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		$mail->Username   = 'teoclone264@gmail.com';                     //SMTP username
		$mail->Password   = 'Thinhpro0123';                               //SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
		$mail->CharSet = "UTF-8";
		//Recipients
		$mail->setFrom('from@example.com', 'SUPREME');
		$mail->addAddress($email, 'Thinh pro');               //Name is optional
		$mail->addReplyTo('teoclone264@gmail.com', 'Information');

		$mail->isHTML(true);
		$mail->Subject = $_POST['confirm'];
		$themahd = '<h1 style="text-align:center">B???n v???a ?????t m???t ????n h??ng c???a SUPREME</h1>
		<div>M?? ho?? ????n: ' . $mahd . '</div>';	
		$gettensp = database::executeQuery("SELECT sanpham.tensp,cthd.soluong FROM `cthd`,sanpham WHERE cthd.mahd='" . $mahd . "' and cthd.masp=sanpham.masp");
		$thetensp='';
		while($row1=mysqli_fetch_array($gettensp)){
			$tensp=''; $sl=0; 
			$tensp=$row1['tensp'];
			$sl+=$row1['soluong'];
			$thetensp1 = '<div>T??n s???n ph???m: ' . $tensp . '<i style="float:right; padding-right:840px;font-style: normal;">S??? l?????ng:' . $sl . '</i></div>';
			$thetensp.=$thetensp1;
		}
		$mail->Body    = $themahd .$thetensp.'<div>T???ng ti???n: ' . $tongtien . '</div>
							<div>Click v??o link d?????i ????y ????? x??c nh???n:</div>
							<div>http://localhost/Supreme-master/xacnhandonhang.php?mahd=' . $mahd . '</div>														
							';
		$mail->AltBody = 'jahaha hehe test';

		$mail->send();
		echo 'Vui l??ng check Gmail';
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}
database::executeQuery($sql);
cart::removeAll();
header('Location: cuahang.php');
