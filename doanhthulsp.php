<table style="margin-left: 250px;">
                <tbody>
                    <tr>
                        <th>Mã Loại Sản Phẩm</th>
                        <th>Tên loại sản phẩm</th>
                        <th>Phân loại</th>
                        <th>Số lượng</th>
                        <th>
                            <form action="doanhthu.php" method="post"><button type="submit" name="tien"><b>Tổng tiền</b></button></form>
                        </th>
                    </tr>
                    <?php
                    $sql = "SELECT DISTINCT(sanpham.malsp),loaisanpham.tenlsp,loaisanpham.phanloai FROM `hoadon`,`cthd`,sanpham,loaisanpham WHERE hoadon.mahd=cthd.mahd and cthd.masp=sanpham.masp and sanpham.malsp=loaisanpham.malsp and `hoadon`.`xacnhan` = '3'";
                    if (isset($_POST['locngay1']) && $_POST['locngay1'] != "") {
                        if (isset($_POST['locngay2']) && $_POST['locngay2'] != "") {
                            $sql = $sql . "AND hoadon.ngayban BETWEEN '" . $_POST['locngay1'] . "' AND '" . $_POST['locngay2'] . "' ";
                        } else {
                            $sql = $sql . "AND hoadon.ngayban >= '" . $_POST['locngay1'] . "'";
                        }
                    } else if (isset($_POST['locngay2']) && $_POST['locngay2'] != "") {
                        $sql = $sql . "AND hoadon.ngayban <= '" . $_POST['locngay2'] . "'";
                    }
                    $tongtien = 0;
                    if(isset($_GET['tenlsp'])){
                        $maloai=$_GET['tenlsp'];
                        $sql="SELECT DISTINCT(sanpham.malsp),loaisanpham.tenlsp,loaisanpham.phanloai,sanpham.tensp FROM `hoadon`,`cthd`,sanpham,loaisanpham WHERE hoadon.mahd=cthd.mahd and cthd.masp=sanpham.masp and sanpham.malsp=loaisanpham.malsp and `hoadon`.`xacnhan` = '3' and loaisanpham.malsp ='$maloai'";
                    }
                    $result = database::executeQuery($sql);
                    while ($row = mysqli_fetch_array($result)) {
                        $soluong = 0;
                        $thanhtien = 0;
                    ?>
                        <tr>
                            <td><?php echo $row['malsp']; ?></td>
                            <td><?php echo $row['tenlsp']; ?></td>
                            <td><?php echo $row['phanloai']; ?></td>
                            <?php $malsp = $row['malsp'];
                            $sl = "select  cthd.masp,cthd.gia,cthd.soluong from `cthd`,hoadon,sanpham,loaisanpham WHERE hoadon.mahd=cthd.mahd and cthd.masp=sanpham.masp and sanpham.malsp=loaisanpham.malsp and  hoadon.xacnhan ='3' and loaisanpham.malsp='$malsp'";
                            $r1 = database::executeQuery($sl);
                            while ($row1 = mysqli_fetch_array($r1)) {
                                $soluong += $row1['soluong'];
                                $thanhtien += $row1['gia'] * $row1['soluong'];
                                $tongtien += $row1['gia'] * $row1['soluong'];
                            }
                            ?>
                            <td><?php echo $soluong; ?></td>
                            <td><?php echo $thanhtien; ?></td>
                        </tr>
                    <?php }
                    ?>
                    <tr>
                        <td colspan="1">Tổng doanh thu</td>
                        <td colspan="4"> <?php echo number_format($tongtien) . ' VNĐ <br>'; ?></td>
                    </tr>

                </tbody>
            </table>