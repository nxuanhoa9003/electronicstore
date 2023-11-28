<?php
include('../db/connect.php');
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
                    <h4>Lịch sử giao dịch</h4>
                </div>

                <div>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th scope="col">Thứ tự</th>
                                <th scope="col">Mã tài khoản</th>
                                <th scope="col">Tên khách hàng</th>
                                <th scope="col">Số điện thoại</th>
                                <th scope="col">Email</th>
                                <th scope="col">Địa chỉ</th>
                                <th scope="col">Ngày mua</th>
                                <th scope="col">Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody class="TableBodyListElements">
                            <?php
                            $sql_QuerytblCustomers = mysqli_query($conn, 'SELECT * from tablecustomer  
                                                                          INNER JOIN tabletransaction 
                                                                          ON tabletransaction.customerID = tablecustomer.customerID 
                                                                          GROUP BY tabletransaction.transactionCode
                                                                          ORDER BY tabletransaction.transaction_id');
                            $i = 0;
                            while ($row_ResultCustomers = mysqli_fetch_array($sql_QuerytblCustomers)) {
                            ?>
                                <tr class="rowElement">
                                    <th class="align-middle orderElement" scope="row"><?php echo ++$i; ?></th>

                                    <td class="align-middle">
                                        <div class="text-center ">
                                            <?php echo $row_ResultCustomers['FullName']; ?>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="text-center ">
                                            <?php echo $row_ResultCustomers['userCode']; ?>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row_ResultCustomers['NumberPhone']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row_ResultCustomers['Email']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row_ResultCustomers['Address']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row_ResultCustomers['transactionDate']; ?>
                                    </td>


                                    <td class="align-middle">
                                        <form class="formChangeEachElement">
                                            <div class="row m-0 d-flex">
                                                <div class="col-12">
                                                    <input type="submit" data-inputName="Btn_show_detail" name="btnShowdetail" value="Xem giao dịch" class="col d-md-block text-center btn btn-primary btn-full" placeholder="Server" aria-label="Server">
                                                    <input type="hidden" name="idElement" class="idElement" value="<?php echo $row_ResultCustomers['transactionCode']; ?>">
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
    <script src="./js/handleCustomers.js"></script>


</body>

</html>