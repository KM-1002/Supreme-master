<style>
    tr th {
        padding: 5px;
        text-align: center;
    }

    tr {
        padding: 5px;
        text-align: center;
    }

    td {
        padding-left: 5px;
        padding-right: 5px;
    }
</style>
<div class="admin1" style="background-image:url(IMG/white-wallpaper-14.jpg)">
    <div class=content3>
        <h1 align="center"><a href="doanhthu.php">THỐNG KÊ DOANH THU</a></h1>
        <form id="loc" action="doanhthu.php" method="post" style="width: 500px;">
            Từ
            <input class="loc" type="date" name="locngay1" value="<?php if (isset($_POST['locngay1']) && $_POST['locngay1'] != "") echo $_POST['locngay1']; ?>">
            Đến
            <input class="loc" type="date" name="locngay2" value="<?php if (isset($_POST['locngay2']) && $_POST['locngay2'] != "") echo $_POST['locngay2']; ?>">
            <input class="loc" type="submit" value="Lọc" />
            <select class="loc" name="loctt" style="margin-left: 120px;margin-top: 5px;">
                <option value="0" >Chọn loại thống kê</option>
                <option value="1" <?php if (isset($_POST['loctt']) && $_POST['loctt'] == "1") echo "selected"; ?>>Theo sản phẩm</option>
                <option value="2" <?php if (isset($_POST['loctt']) && $_POST['loctt'] == "2") echo "selected"; ?>>Theo loại sản phẩm</option>
            </select>
        </form>
        <?php
        if (isset($_POST['loctt'])&& $_POST['loctt']!='0') {
            if ($_POST['loctt'] == '2') {
                include './doanhthulsp.php';
            }
            else{
                header('Location: doanhthu.php');
            }
        } else { ?>
            <table style="margin-left: 250px;">
                <tbody>
                    <tr>
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Tên loại sản phẩm</th>
                        <th>Số lượng</th>
                        <th>
                            <form action="doanhthu.php" method="post"><button type="submit" name="tien"><b>Tổng tiền</b></button></form>
                        </th>
                    </tr>
                    <?php
                    $sql = "SELECT DISTINCT(`cthd`.`masp`),`sanpham`.`tensp`,loaisanpham.tenlsp,loaisanpham.phanloai FROM `hoadon`,`cthd`,sanpham,loaisanpham WHERE hoadon.mahd=cthd.mahd and cthd.masp=sanpham.masp and sanpham.malsp=loaisanpham.malsp and `hoadon`.`xacnhan` = '3'";
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
                    $result = database::executeQuery($sql);
                    while ($row = mysqli_fetch_array($result)) {
                        $soluong = 0;
                        $thanhtien = 0;
                    ?>
                        <tr>
                            <td><a href="sanpham.php?masp=<?php echo $row['masp'] ?>"><?php echo $row['masp']; ?></a></td>
                            <td><a href=""><?php echo $row['tensp']; ?></a></td>
                            <td><a href=""><?php echo ($row['tenlsp'] . " - " . $row['phanloai']); ?></a></td>
                            <?php $masp = $row['masp'];
                            $sl = "select  cthd.masp,cthd.gia,cthd.soluong from `cthd`,hoadon WHERE hoadon.mahd=cthd.mahd and  hoadon.xacnhan ='3' and cthd.masp='$masp'";
                            $r1 = database::executeQuery($sl);
                            while ($row1 = mysqli_fetch_array($r1)) {
                                $soluong += $row1['soluong'];
                                $thanhtien += $row1['gia'] * $row1['soluong'];
                                $tongtien += $row1['gia'] * $row1['soluong'];
                            }
                            ?>
                            <td><a href=""><?php echo $soluong; ?></a></td>
                            <td><a href=""><?php echo $thanhtien; ?></a></td>
                        </tr>
                    <?php }
                    ?>
                    <tr>
                        <td colspan="1">Tổng doanh thu</td>
                        <td colspan="4"> <?php echo number_format($tongtien) . ' VNĐ <br>'; ?></td>
                    </tr>

                </tbody>
            </table>
        <?php } ?>
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
        <?php    } else { ?>

            function lienlac(mahd) {
                alert("Bạn không đủ quyền hạn!!!");
            }

            function dagiao(mahd) {
                alert("Bạn không đủ quyền hạn!!!");
            }
        <?php     } ?>
    </script>
</div>