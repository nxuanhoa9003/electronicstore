<?php
include('../db/connect.php');

if (isset($_POST['transactionCode']) && !empty($_POST['transactionCode'])) {
    $transactionCode = $_POST['transactionCode'];

    $str_sql = "SELECT * FROM tabletransaction AS tbl1
                        INNER JOIN tablecustomer AS tbl2
                        ON tbl1.customerID = tbl2.customerID 
                        WHERE transactionCode = '$transactionCode'
                        ORDER BY tbl1.transactionDate DESC";

    $sql_query = mysqli_query($conn, $str_sql);
}
?>

<div class="modal-body">
    <table class="table table-bordered m-0">
        <thead>
            <tr>
                <th scope="col">Thứ tự</th>
                <th scope="col">Mã giao dịch</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Thanh toán</th>
                <th scope="col">Ngày giao dịch</th>
            </tr>
        </thead>
        <?php
        $i = 0;
        while ($row_transaction = mysqli_fetch_array($sql_query)) {
            ++$i;
        ?>
            <tbody>
                <tr>
                    <td class="align-middle">
                        <?php echo $i ?>
                    </td>
                    <td class="align-middle">
                        <?php echo $row_transaction['transactionCode'] ?>
                    </td>
                    <td class="align-middle">
                        <?php echo $row_transaction['productName'] ?>
                    </td>
                    <td class="align-middle">
                        <?php echo number_format(($row_transaction['amount'] * $row_transaction['productPrice']), 0, '.', '.') ?>
                    </td>

                    <td class="align-middle">
                        <?php echo $row_transaction['transactionDate'] ?>
                    </td>
                </tr>
            </tbody>
        <?php
        }
        ?>
    </table>
</div>