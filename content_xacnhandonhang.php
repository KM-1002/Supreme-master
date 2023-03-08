<?php
if (isset($_GET['mahd'])) {
    $mahd = $_GET['mahd'];
    $sql = "UPDATE hoadon SET xacnhan='2' WHERE mahd='$mahd'";
    database::executeQuery($sql);
} else {
    header('Location: index.php');
}
?>
<h1 style="text-align: center;">Xác nhận đơn hàng thành công</h1>
<div style="clear: both;">
    <table id="het-hang" style="width: 700px; margin-left: 400px; text-align: center;">
        <tr>
            <td>Mã hoá đơn</td>
            <td>Tên sản phẩm</td>
            <td>Số lượng </td>
            <td>Ghi chú</td>
        </tr>
        <?php
        $sql = "SELECT cthd.mahd,sanpham.tensp,cthd.soluong from cthd,sanpham where cthd.masp=sanpham.masp and mahd='$mahd'";
        $sql1 = "SELECT tongtien,ghichu from hoadon where mahd='$mahd'";
        $result = database::executeQuery($sql);
        $result1 = database::executeQuery($sql1);
        $row1 = mysqli_fetch_array($result1);
        while ($row = mysqli_fetch_array($result)) {
        ?>
            <tr>
                <td><?php echo $row['mahd']; ?></td>
                <td><?php echo $row['tensp']; ?></td>
                <td><?php echo $row['soluong']; ?></td>
                <td rowspan="1"><?php echo $row1['ghichu']; ?></td>
            </tr>
        <?php     }
        ?>
        <tr><td>Tổng tiền</td>
        <td colspan="3"><?php echo $row1['tongtien'];?></td>
    </tr>
    </table>
</div>
<div style="margin-top: 10px;"><a style="text-align: center;color: blue;margin-left: 650px;" href="cuahang.php">Quay lại trang cửa hàng</a></div>