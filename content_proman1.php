<div class="admin1" style="background-image:url(IMG/white-wallpaper-14.jpg)">
	<div class=content3>
		<div>
			<h1 align="center"> Quản lý danh mục<a href="themloaisp.php" title="Thêm loại sản phẩm"><img src="IMG/add.png"></a></h1>

			<?php
			// Số lượng sản phẩm sắp hết hàng
			$mlsp = "SELECT malsp from loaisanpham";
			$getmlsp1 = database::executeQuery($mlsp);
			$demlsp = 0;
			while ($row2 = mysqli_fetch_array($getmlsp1)) {
				$checklsp1 = "SELECT loaisanpham.malsp,loaisanpham.tenlsp,phanloai FROM sanpham,loaisanpham WHERE sanpham.malsp=loaisanpham.malsp and loaisanpham.malsp='" . $row2['malsp'] . "'";
				$loclsp1 = database::executeQuery($checklsp1);
				if (mysqli_num_rows($loclsp1) == 0) {
					$demlsp += 1;
				}
			}
			?>
			<a align="center" style="width: 100%;">
				<p><span>Loại sản phẩm chưa có hàng: </span><?php echo $demlsp; ?></p>
			</a>

			<div class="loaisp">
				<h3 align="center"><a href="productman1.php?phanloai=Nam">Nam</a></h3>
				<ul>
					<?php
					$sql = "SELECT * FROM loaisanpham WHERE phanloai LIKE N'Nam'";
					$result = database::executeQuery($sql);
					while ($row = mysqli_fetch_array($result)) {
						$sql = "SELECT COUNT('masp') AS tong FROM sanpham WHERE malsp='" . $row['malsp'] . "'";
						$result1 = database::executeQuery($sql);
						$row1 = mysqli_fetch_array($result1);
						echo ("<li><a href='productman1.php?malsp=" . $row['malsp'] . "'><span>" . $row['tenlsp'] . ": </span>" . $row1['tong'] . "</a></li>");
					}
					?>
				</ul>
			</div>
			<div class="loaisp">
				<h3 align="center"><a href="productman1.php?phanloai=Nữ">Nữ</a></h3>
				<ul>
					<?php
					$sql = "SELECT * FROM loaisanpham WHERE phanloai LIKE N'Nữ'";
					$result = database::executeQuery($sql);
					while ($row = mysqli_fetch_array($result)) {
						$sql = "SELECT COUNT('masp') AS tong FROM sanpham WHERE malsp='" . $row['malsp'] . "'";
						$result1 = database::executeQuery($sql);
						$row1 = mysqli_fetch_array($result1);
						echo ("<li><a href='productman1.php?malsp=" . $row['malsp'] . "'><span>" . $row['tenlsp'] . ": </span>" . $row1['tong'] . "</a></li>");
					}
					?>
				</ul>
			</div>
			<div class="loaisp">
				<h3 align="center"><a href="productman1.php?phanloai=Ph">Phụ kiện</a></h3>
				<ul>
					<?php
					$sql = "SELECT * FROM loaisanpham WHERE phanloai LIKE 'P%'";
					$result = database::executeQuery($sql);
					while ($row = mysqli_fetch_array($result)) {
						$sql = "SELECT COUNT('masp') AS tong FROM sanpham WHERE malsp='" . $row['malsp'] . "'";
						$result1 = database::executeQuery($sql);
						$row1 = mysqli_fetch_array($result1);
						echo ("<li><a href='productman1.php?malsp=" . $row['malsp'] . "'><span>" . $row['tenlsp'] . ": </span>" . $row1['tong'] . "</a></li>");
					}
					?>
				</ul>
			</div>
		</div>

		<?php
		$getmlsp = database::executeQuery($mlsp);
		while ($row1 = mysqli_fetch_array($getmlsp)) {
			$checklsp = "SELECT loaisanpham.malsp,loaisanpham.tenlsp,phanloai FROM sanpham,loaisanpham WHERE sanpham.malsp=loaisanpham.malsp and loaisanpham.malsp='" . $row1['malsp'] . "'";
			$loclsp = database::executeQuery($checklsp);
			if (mysqli_num_rows($loclsp) == 0) {
				$sql = "SELECT *from loaisanpham where malsp='" . $row1['malsp'] . "' ";
				$result = database::executeQuery($sql);
				if (mysqli_num_rows($result) > 0) {
		?>
					<div style="clear: both; text-align: center;margin-left: 220px;padding-top: 10px;">
						<table id="het-hang" style="margin:0px">
							<tr style="text-align: center;">
								<td>Mã loại sản phẩm</td>
								<td>Tên loại sản phẩm</td>
								<td>Phân loại</td>
								<td rowspan="2">
									<span style="background:#BF0003;color:#FFFFFF; border: 2px solid #FF1E22;"><a href="themsanpham.php?malsp=<?php echo $row1['malsp'] ?>">Thêm sản phẩm</a> </span>
								</td>
							</tr>
							<?php
							while ($row = mysqli_fetch_array($result)) {
							?>
								<tr>
									<td style="width: 150px;"><?php echo $row['malsp']; ?></td>
									<td style="width: 150px;"><?php echo $row['tenlsp']; ?></td>
									<td style="width: 150px;"><?php echo $row['phanloai']; ?></td>
								</tr>
							<?php 	} ?>
						</table>
					</div>
		<?php }
			}
		}
		?>
	</div>
</div>