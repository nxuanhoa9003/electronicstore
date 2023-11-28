<?php
include('../db/connect.php');
?>
<?php

if (isset($_POST['valRadioInput'])) {
    $ValueRadio = $_POST['valRadioInput'];
    $IdOrder = $_POST['IdOrder'];
    if ($ValueRadio == 4) {
        $sqlSelectOrder = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tableorder WHERE orderID = '$IdOrder'"));
        $prodAmount = $sqlSelectOrder['productAmount'];
        $ProductID = $sqlSelectOrder['productID'];
        $sql_Product = mysqli_query($conn, "UPDATE tableproducts SET product_Quatity = product_Quatity + '$prodAmount' WHERE product_ID = '$ProductID'");
    }
    mysqli_query($conn, "UPDATE `tableorder` SET `status`='$ValueRadio' WHERE orderID = $IdOrder");
} else if (isset($_POST['btnDelete'])  && !empty($_POST['btnDelete'])) {
    $IdOrder = $_POST['IdOrder'];
    mysqli_query($conn, "DELETE FROM `tableorder` WHERE orderID = $IdOrder");
}

$StatusOrder = array(
    0 => 'Chưa xử lý',
    1 => 'Đã xử lý',
    2 => 'Đã hoàn thành',
    3 => 'Yêu cầu huỷ',
    4 => 'Đã huỷ'
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />

    <style>
        .form-control[readonly] {
            background-color: unset;
            border: none;
        }
    </style>
</head>

<body>
    <?php include '../admin/dashboard.php' ?>


    <div class="container pageadmin text-center mt-5">
        <div class="p-3">
            <h2></h2>
        </div>
        <div class="row g-0">
            <div class="col-lg-12">
                <div class="p-1 mb-4">
                    <h4>Danh sách đơn hàng</h4>
                </div>

                <div>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th scope="col">Thứ tự</th>
                                <th scope="col">Mã hàng</th>
                                <th scope="col">Tên khách hàng</th>
                                <th scope="col">Số điện thoại</th>
                                <th scope="col">Ngày đặt</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Quản lý</th>
                            </tr>
                        </thead>
                        <tbody class="TableBodyListElements">
                            <?php
                            $sql_QuerytblOrder = mysqli_query($conn, 'SELECT * from tableorder
                            INNER JOIN tableproducts ON tableproducts.product_ID = tableorder.productID
                            INNER JOIN tablecustomer ON tablecustomer.customerID  = tableorder.customerID');
                            $i = 0;
                            while ($row_ResultOrder = mysqli_fetch_array($sql_QuerytblOrder)) {
                            ?>
                                <tr class="rowElement">
                                    <th class="align-middle orderElement" scope="row"><?php echo ++$i; ?></th>

                                    <td class="align-middle">
                                        <div class="text-center ">
                                            <?php echo $row_ResultOrder['ItemCode']; ?>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row_ResultOrder['FullName']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row_ResultOrder['NumberPhone']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row_ResultOrder['orderDate']; ?>
                                    </td>
                                    <td class="align-middle status">
                                        <?php echo $StatusOrder[$row_ResultOrder['status']] ?>
                                    </td>

                                    <td class="align-middle">
                                        <form class="formChangeEachElement">
                                            <div class="row m-0 d-flex">
                                                <div class="col-12 col-lg-7 px-lg-2">
                                                    <input type="submit" data-inputName="Btn_show_detail" name="btnShowdetail" value="Xem chi tiết" class="col d-md-block text-center btn btn-primary btn-full" placeholder="Server" aria-label="Server">
                                                    <input type="hidden" name="idElement" class="idElement" value="<?php echo $row_ResultOrder['orderID']; ?>">
                                                    <input type="hidden" name="statusBtn" value="" class="statusBtn">
                                                </div>
                                                <div class="col col-12 my-2 d-lg-none"></div>
                                                <div class="col-12 col-lg-5">
                                                    <input type="submit" data-inputName="Btn_delete" name="btnDelete" value="Xoá" class="col text-center btn btn-secondary" placeholder="Username" aria-label="Username">
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->
    <div id="modal-detail" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg  modal-dialog-centered">
            <div class="modal-content">
            </div>
        </div>

    </div>



    <script src="./js/handleMenu.js"></script>
    <script src="../js/jquery-2.2.3.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="./js/handleOrders.js"></script>

</body>

</html>