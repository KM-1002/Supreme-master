<div class="admin1" style="background-image:url(IMG/white-wallpaper-14.jpg)">
<div class=content3>
	<h1 align="center">LỊCH SỬ ĐẶT HÀNG</h1>
	<form id="loc" action="lichsu.php" method="post">
		<input class="loc" type="date" name="locngay" value="<?php if(isset($_POST['locngay']) && $_POST['locngay']!="") echo $_POST['locngay'];?>">
		<select class="loc" name="loctt">
			<option value="0" >Chọn trạng thái hóa đơn</option>
			<option value="1" <?php if(isset($_POST['loctt']) && $_POST['loctt']=="1") echo "selected";?>>Chưa liên lạc</option>
			<option value="2" <?php if(isset($_POST['loctt']) && $_POST['loctt']=="2") echo "selected";?>>Chưa giao</option>
			<option value="3" <?php if(isset($_POST['loctt']) && $_POST['loctt']=="3") echo "selected";?>>Đã giao</option>
		</select>
			<input class="loc" type="submit" value="Lọc" >
	</form>
	
	<table  style="margin-left: 70px;">
		<tbody>
			<tr>
				<th style="padding: 5px;">Mã hóa đơn</th>
				<th style="padding: 5px;">Họ tên khách hàng</th>
				<th style="padding: 5px;"><form action="lichsu.php" method="post"><button type="submit"><b>Ngày đặt</b></button></form></th>
				<th style="padding: 5px;">Địa chỉ</th>
				<th style="padding: 5px;">Email</th>
				<th style="padding: 5px;">Số điện thoại</th>
				<th style="padding: 5px;"><form action="lichsu.php" method="post"><button type="submit" name="tien"><b>Tổng tiền</b></button></form></th>
				<th style="padding: 5px;">Ghi chú</th>
				<th style="padding: 5px;"><b>Trạng thái</b></th>
			</tr>
<?php
$makh=$_SESSION['name'];
$sql = "SELECT * FROM hoadon WHERE makh='".$makh."'";
if(isset($_POST['locngay']) && $_POST['locngay']!="") {
	$sql = $sql."and ngayban='".$_POST['locngay']."' ";
	if(isset($_POST['loctt']) && $_POST['loctt']!="0"){
		$sql = $sql." AND xacnhan='".$_POST['loctt']."' ";
	}
} else {
	if(isset($_POST['loctt']) && $_POST['loctt']!="0"){
		$sql = "SELECT * FROM hoadon where makh='".$makh."' and xacnhan='".$_POST['loctt']."' ";
	}
}
if(isset($_POST['tien'])){
	$sql = $sql."ORDER BY tongtien DESC";
} else {
	if(isset($_POST['trangthai'])){
		$sql = $sql."ORDER BY xacnhan ASC";
	} else {
		$sql = $sql."ORDER BY mahd DESC";
	}
}
$result = database::executeQuery($sql);
while($row=mysqli_fetch_array($result)) {
?>
			<tr>
				<td><a href="cthd.php?mahd=<?php echo $row['mahd'];?>" style="color: black;"><?php echo $row['mahd'];?></a></td>
				<td><?php if($row['makh']!=="") echo("<b>".$row['hoten']."</b>"); else echo $row['hoten'];?>&nbsp;</td>
				<td><?php echo $row['ngayban']; ?></td>
				<td><?php echo $row['diachigiao'];?></td>
				<td><?php echo $row['email'];?></td>
				<td><?php echo $row['sdt'];?></td>
				<td><?php echo $row['tongtien'];?></td>	
				<td><?php echo $row['ghichu'];?></td>
				<td><input style="width: 100%;" id="<?php echo $row['mahd'];?>" type="button" value="<?php if($row['xacnhan']=="1") echo("Chưa liên lạc"); else if($row['xacnhan']=="2") echo("Chưa giao"); else echo("Đã giao")?>"></td>

							</tr>
<?php } ?>
		</tbody>
	</table>
</div>

</div>