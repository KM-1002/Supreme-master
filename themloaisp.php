<html>

<head>
	<meta charset="utf-8">
	<title> FASHION</title>
	<link rel="stylesheet" type="text/css" href="CSS/themsp.css">
</head>

<body>
	<form name="checktt" id="checktt" method="POST" action="" onsubmit="return checkname()">
		<div class="login">
			<h2>Thêm Loại Sản Phẩm</h2>
			<input type="hidden" name="action" value="1">
			<span>Tên Loại Sản Phẩm:</span><input name="text_name" style="margin-left: 100px;" id="text_name" placeholder="Nhập tên loại sản phẩm" required type="text"><br>
			<span>Chọn phân loại sản phẩm:</span>
			<select name="malsp" style="margin-left: 50px;">
				<option value="Nam">Nam</option>
				<option value="Nữ">Nữ</option>
				<option value="Ph">Phụ kiện</option>
			</select><br>
			<br>
			<input class="button" type="submit" value="Thêm" name="log">
		</div>
	</form>
</body>

</html>
<?php
session_start();
require("database.php");
require("product.php");
require("phanquyen.php");
if (isset($_SESSION['admin'])) {
	$manv = $_SESSION['admin'];
	$sql = "SELECT loainv FROM nhanvien WHERE manv='$manv'";
	$result = database::executeQuery($sql);
	$row = mysqli_fetch_array($result);
	$loainv = $row['loainv'];
	if (phanquyen::quanlykh($loainv)) {
		if (isset($_POST['action'])) {
			$action = $_POST['action'];
			switch ($action) {
				case '1': { // Thêm sản phẩm
						// Lấy các biến
						if (isset($_POST['log']) == TRUE) {
							date_default_timezone_set("Asia/Ho_Chi_Minh");
							$malsp = $_POST['malsp'];
							if ($malsp == "Nam") {
								$maloai = "B" . date("y").date("m").date("d").date("H").date("i").date("s");
								$phanloai = "Nam";
							} else if ($malsp == "Nữ") {
								$maloai = "G" . date("y").date("m").date("d").date("H").date("i").date("s");
								$phanloai = "Nữ";
							} else if ($malsp == "Ph") {
								$maloai = "P" . date("y").date("m").date("d").date("H").date("i").date("s");
								$phanloai = "Phụ kiện";
							}
							$name = $_POST['text_name'];
							$sql = "SELECT tenlsp FROM loaisanpham WHERE tenlsp like N'$name'";
							$result = database::executeQuery($sql);
?>
							<script>
								function checkname() {
									<?php if (mysqli_num_rows($result) == 0) {
										product::addDanhmuc($maloai, $name, $phanloai);
										header("Location: productman1.php?malsp=".$maloai); ?>
									<?php 	} else {?>
											header("Location: themloaisp.php"); 
									<?php } ?>
								}
							</script>
<?php
						}
						break;
					}
				case '4': { // Nhập thêm hàng
						$masp = $_POST['masp'];
						$sl = $_POST['soluong'];
						$sql = "SELECT soluongton FROM sanpham WHERE masp='$masp'";
						$result = database::executeQuery($sql);
						$row = mysqli_fetch_array($result);
						$sl = $sl + $row['soluongton'];
						product::updateProduct($masp, $sl);
						break;
					}
			}
		}
	} else {
		header("Location: loi.php");
	}
} else {
	header('Location: admin.php');
}
?>