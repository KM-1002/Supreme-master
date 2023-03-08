<div class="admin1" style="background-image:url(IMG/white-wallpaper-14.jpg);padding-bottom: 20px;">
	<div class=content3>
		<form id="loc" action="ordman.php" method="post" style="width: 500px;padding-top: 10px;">
			Từ
			<input class="loc" type="date" name="locngay1" value="<?php if (isset($_POST['locngay1']) && $_POST['locngay1'] != "") echo $_POST['locngay1']; ?>">
			Đến
			<input class="loc" type="date" name="locngay2" value="<?php if (isset($_POST['locngay2']) && $_POST['locngay2'] != "") echo $_POST['locngay2']; ?>">
			<input class="loc" type="submit" value="Lọc" />
			<select class="loc" name="loctt" style="margin-left: 120px;margin-top: 5px;">
				<option value="0">Chọn trạng thái</option>
				<option value="1" <?php if (isset($_POST['loctt']) && $_POST['loctt'] == "1") echo "selected"; ?>>Chưa liên lạc</option>
				<option value="2" <?php if (isset($_POST['loctt']) && $_POST['loctt'] == "2") echo "selected"; ?>>Chưa Giao</option>
				<option value="3" <?php if (isset($_POST['loctt']) && $_POST['loctt'] == "3") echo "selected"; ?>>Đã giao</option>
			</select>
		</form>
		<?php $sql = "SELECT * FROM hoadon ";
		if (isset($_POST['locngay1']) && $_POST['locngay1'] != "") {
			$sql = $sql . "WHERE ngayban >'" . $_POST['locngay1'] . "' ";
			if (isset($_POST['loctt']) && $_POST['loctt'] != "0" && isset($_POST['locngay2']) && $_POST['locngay2'] != "") {
				$sql = " SELECT * FROM hoadon  WHERE hoadon.xacnhan='" . $_POST['loctt'] . "' AND hoadon.ngayban BETWEEN '" . $_POST['locngay1'] . "' AND '" . $_POST['locngay2'] . "'";
			} else if (isset($_POST['loctt']) && $_POST['loctt'] != "0") {
				$sql = $sql . "AND xacnhan='" . $_POST['loctt'] . "' ";
			} else if (isset($_POST['locngay2']) && $_POST['locngay2'] != "") {
				$sql = " SELECT * FROM hoadon  WHERE hoadon.ngayban BETWEEN '" . $_POST['locngay1'] . "' AND '" . $_POST['locngay2'] . "'";
			}
		} else {
			if (isset($_POST['locngay2']) && $_POST['locngay2'] != "" && isset($_POST['loctt']) && $_POST['loctt'] != "0") {
				$sql = $sql . "WHERE ngayban <= '" . $_POST['locngay2'] . "' and  xacnhan='" . $_POST['loctt'] . "' ";
			} else if (isset($_POST['loctt']) && $_POST['loctt'] != "0") {
				$sql = $sql . "WHERE xacnhan='" . $_POST['loctt'] . "' ";
			} else if (isset($_POST['locngay2']) && $_POST['locngay2'] != "") {
				$sql = $sql . "WHERE ngayban <= '" . $_POST['locngay2'] . "' ";
			}
		}
		if (isset($_POST['tien'])) {
			$sql = $sql . "ORDER BY tongtien DESC";
		} else {
			if (isset($_POST['trangthai'])) {
				$sql = $sql . "ORDER BY xacnhan ASC";
			} else {
				$sql = $sql . "ORDER BY mahd DESC";
			}
		}
		$re = database::executeQuery($sql);
		$data = mysqli_num_rows($re) ?>
		<div style="text-align: center; margin-top: 20px;">Tổng số đơn hàng: <?php echo $data ?></div>
		<table style="margin-left: 5px;">
			<tbody>
				<tr>
					<th>Mã hóa đơn</th>
					<th>Họ tên khách hàng</th>
					<th>
						<form action="ordman.php" method="post"><button type="submit"><b>Ngày đặt</b></button></form>
					</th>
					<th>Địa chỉ</th>
					<th>Email</th>
					<th>Số điện thoại</th>
					<th>
						<form action="ordman.php" method="post"><button type="submit" name="tien"><b>Tổng tiền</b></button></form>
					</th>
					<th>Ghi chú</th>
					<th>
						<form action="ordman.php" method="post"><button type="submit" name="trangthai"><b>Trạng thái</b></button></form>
					</th>
				</tr>
				<?php

				$result = database::executeQuery($sql);
				while ($row = mysqli_fetch_array($result)) {
				?>
					<tr style="text-align: center;">
						<td><a href="cthd.php?mahd=<?php echo $row['mahd']; ?>" style="color: black;"><?php echo $row['mahd']; ?></a></td>
						<td><?php if ($row['makh'] !== "") echo ("<b>" . $row['hoten'] . "</b>");
							else echo $row['hoten']; ?>&nbsp;</td>
						<td><?php echo $row['ngayban']; ?></td>
						<td><?php echo $row['diachigiao']; ?></td>
						<td><?php echo $row['email']; ?></td>
						<td><?php echo $row['sdt']; ?></td>
						<td><?php echo $row['tongtien']; ?></td>
						<td><?php echo $row['ghichu']; ?></td>
						<td><input style="width: 100%;" id="<?php echo $row['mahd']; ?>" type="button" value="<?php if ($row['xacnhan'] == "1") echo ("Chưa liên lạc");
																												else if ($row['xacnhan'] == "2") echo ("Chưa giao");
																												else echo ("Đã giao") ?>" <?php if ($row['xacnhan'] == "1") echo ("onClick=\"lienlac('" . $row['mahd'] . "');\"");
																																			else if ($row['xacnhan'] == "2") echo ("onClick=\"dagiao('" . $row['mahd'] . "');\""); ?>></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<script>
		<?php if (phanquyen::quanlyhd($loainv)) { ?>

			function lienlac(mahd) {
				$.post("xuly_hoadon.php", {
					"action": 1,
					"mahd": mahd
				}, function(data) {});
				document.getElementById(mahd).value = "Chưa giao";
				document.getElementById(mahd).onclick = function() {
					dagiao(mahd);
				}
			}

			function dagiao(mahd) {
				$.post("xuly_hoadon.php", {
					"action": 2,
					"mahd": mahd
				}, function(data) {});
				document.getElementById(mahd).value = "Đã giao";
				document.getElementById(mahd).onclick = function() {}
			}
		<?php	} else { ?>

			function lienlac(mahd) {
				alert("Bạn không đủ quyền hạn!!!");
			}

			function dagiao(mahd) {
				alert("Bạn không đủ quyền hạn!!!");
			}
		<?php 	} ?>
	</script>
</div>