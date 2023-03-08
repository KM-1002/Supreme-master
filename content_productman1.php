<div class="admin1" style="background-image:url(IMG/white-wallpaper-14.jpg)">
	<div class=content3>
		<div>
			<h1 align="center"> Quản lý danh mục hàng <a href="themloaisp.php" title="Thêm loại sản phẩm"><img src="IMG/add.png"></a></h1>
			<div style="clear: both;">
				<table id="het-hang" style="width: 800px; margin-left: 10%; ">
					<tr align="center">
						<td></td>
						<td>Mã loại sản phẩm</td>
						<td>Tên loại sản phẩm</td>
						<td>Phân loại</td>
						<td>Số lượng sản phẩm</td>
					</tr>
					<?php
					$sql = "SELECT loaisanpham.* from loaisanpham";
					if (isset($_GET['malsp'])) {
						$malsp = $_GET['malsp'];
						$slton = "SELECT loaisanpham.*, sanpham.soluongton FROM  loaisanpham INNER JOIN sanpham ON loaisanpham.malsp = sanpham.malsp WHERE loaisanpham.malsp='$malsp' ";
						$sql = "SELECT* FROM loaisanpham where malsp='$malsp'";
					} else {
						if (isset($_GET['phanloai'])) {
							$phanloai = $_GET['phanloai'];
							$sql = "SELECT loaisanpham.*from loaisanpham WHERE loaisanpham.phanloai LIKE N'$phanloai%' ";
							$slton = "SELECT loaisanpham.*, sanpham.soluongton FROM  loaisanpham INNER JOIN sanpham ON loaisanpham.malsp = sanpham.malsp WHERE loaisanpham.phanloai like N'$phanloai' ";
						} else {
							if (isset($_GET['tenlsp'])) {
								$search = $_GET['tenlsp'];
								$sql = $sql . "AND tenlsp LIKE N'$search'";
							}
						}
					}
					if (isset($_POST['malsp'])) {
						$malsp = $_GET['malsp'];
						$sql = "SELECT loaisanpham.*, sanpham.soluongton FROM  loaisanpham INNER JOIN sanpham ON loaisanpham.malsp = sanpham.malsp WHERE loaisanpham.malsp='$malsp' ";
					}
					$lm = '';
					$soluong = 0;
					$result = database::executeQuery($sql);
					while ($row = mysqli_fetch_array($result)) {
					?>
						<tr align="center" id="<?php echo $row['malsp']; ?>">
							<td align="center">
								<a href="chinhsualoaisp.php?malsp=<?php echo $row['malsp']; ?>">Sửa</a>
								<a onClick="delProduct('<?php echo $row['malsp']; ?>','<?php echo $row['tenlsp']; ?>')">Xóa</a>
							</td>
							<td><a href="productman1.php?malsp=<?php echo ($row['malsp']); ?>"><?php echo $row['malsp']; ?></a></td>
							<?php $lm = $row['malsp']; ?>
							<td><a href="productman1.php?malsp=<?php echo ($row['malsp']); ?>"><?php echo $row['tenlsp']; ?></a></td>
							<td><a href="productman1.php?phanloai=<?php echo ($row['phanloai']); ?>"><?php echo $row['phanloai']; ?></a></td>
							<?php
							$slton = "SELECT loaisanpham.*, sanpham.soluongton FROM  loaisanpham INNER JOIN sanpham ON loaisanpham.malsp = sanpham.malsp where loaisanpham.malsp='$lm'";
							$result1 = database::executeQuery($slton);
							while ($row1 = mysqli_fetch_array($result1)) {
								$soluong += $row1['soluongton'];
							} ?>
							<td><a href=""><?php echo $soluong ?></a></td>
							<?php $soluong = 0;
							?>

						</tr>
					<?php 	} ?>
				</table>
			</div>
		</div>
	</div>
	<script>
		<?php
		$manv = $_SESSION['admin'];
		$sql = "SELECT loainv FROM nhanvien WHERE manv='$manv'";
		$result = database::executeQuery($sql);
		$row = mysqli_fetch_array($result);
		$loainv = $row['loainv'];
		if (phanquyen::quanlykh($loainv)) {
		?>

			function delProduct(malsp, tenlsp) {
				var r = confirm("Bạn có chắc chắn muốn xóa " + tenlsp + " không ?");
				if (r === true) {
					$.post("xuly_loaisp.php", {
						"action": 2,
						"malsp": malsp
					}, function(data) {});
					alert("Đã xóa thành công!!!");
					document.getElementById(malsp).style.display = "none";
				}
			}
		<?php	} else { ?>

			function delProduct(masp) {
				alert("Bạn không đủ quyền hạn!!!");
			}
		<?php	} ?>
	</script>