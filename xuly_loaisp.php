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
								$maloai = "B" . date("m") . date("d") . date("H") . date("i");
								$phanloai = "Nam";
							} else if ($malsp == "Nữ") {
								$maloai = "G" . date("m") . date("d") . date("H") . date("i");
								$phanloai = "Nữ";
							} else if ($malsp == "Ph") {
								$maloai = "P" . date("m") . date("d") . date("H") . date("i");
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
											alert("Tên loại sản phẩm đã tồn tại");
									<?php } ?>
								}
							</script>
<?php
						}
						break;
					}
				case '2': { // Xóa sản phẩm
						$malsp = $_POST['malsp'];
						product::removeDanhmuc($malsp);
                        header('Location: productman1.php');
						break;
					}
				case '3': { // Chỉnh sửa sản phẩm
						$malsp = $_POST['malsp'];
						$tenlsp = $_POST['tenlsp'];
						$phanloai = $_POST['phanloai'];
						product::updateDanhmuc($malsp, $tenlsp, $phanloai);
						header('Location: productman1.php?malsp='.$malsp);
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