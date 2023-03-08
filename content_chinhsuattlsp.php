<link type="text/css" rel="stylesheet" href="CSS/ctsp.css">

<body>
	<div class="border">
		<div class="border1" style="padding-bottom: 50px;">
			<main class=container1 style=" margin-left: 30px;	margin-right: 50px	;">
				<?php
				if (isset($_GET['malsp'])) {
					$malsp = $_GET['malsp'];
					$sql = "SELECT * FROM loaisanpham WHERE malsp='$malsp'";
					$result = database::executeQuery($sql);
					$row = mysqli_fetch_array($result);
				?>

					<form id="mainForm" method="post" action="xuly_loaisp.php">
						<h1 style="text-align: center; color: red;font-size: 50px;"><?php echo $row['malsp']; ?></h1>
						<input type="hidden" name="action" value="3">
						<input type="hidden" name="malsp" value="<?php echo $row['malsp']; ?>">
						<span>Tên loại sản phẩm: </span><input type="text" name="tenlsp" style="text-align: center;" value="<?php echo $row['tenlsp']; ?>" required>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<span>Phân loại: </span>
						<select name="phanloai">
							<?php
							$sql = "SELECT DISTINCT phanloai FROM loaisanpham ";
							$result = database::executeQuery($sql);
							while ($row1 = mysqli_fetch_array($result)) {
							?>
								<option value="<?php echo $row1['phanloai'] ?>" <?php if ($row['phanloai'] == $row1['phanloai']) echo "selected"; ?>><?php echo ($row1['phanloai']); ?></option>
							<?php } ?>
						</select>
						<input class="button" type="submit" value="Lưu" style="font-size: 30px; float: right; margin-top: 10px;"><br><br>
					</form>

				<?php
				}
				?>
			</main>
		</div>
	</div>
</body>