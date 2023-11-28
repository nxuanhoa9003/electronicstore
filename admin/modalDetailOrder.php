<?php
include('../db/connect.php');
$rowQueryTblOrder = "";
$rowQueryTblProduct = "";
$rowQueryTblCustomer = "";
if (isset($_POST['IdOrder']) && !empty($_POST['IdOrder'])) {
    $idOrderSend = $_POST['IdOrder'];
    $rowQueryTblOrder = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tableorder WHERE orderID = $idOrderSend"));
    $idPrd = $rowQueryTblOrder['productID'];
    $idCustomer = $rowQueryTblOrder['customerID'];
    $rowQueryTblProduct = mysqli_fetch_assoc(mysqli_query($conn, "SELECT product_Name, product_PromotionalPrice FROM tableproducts WHERE product_ID = $idPrd"));
    $rowQueryTblCustomer = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tablecustomer WHERE customerID = $idCustomer"));
}

$arrayStastusOrder = array(
    0 => 'Chưa xử lý',
    1 => 'Đã xử lý',
    2 => 'Đã hoàn thành',
);
?>

<div class="modal-body">
    <table class="table table-bordered m-0">
        <thead>
            <tr>
                <th scope="col">Thứ tự</th>
                <th scope="col">Mã hàng</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Đơn giá</th>
                <th scope="col">Tổng tiền</th>
                <th scope="col">Hình thức thanh toán</th>
                <th scope="col">Địa chỉ giao hàng</th>
                <th scope="col">Ghi chú</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="align-middle">
                    <?php echo $rowQueryTblOrder['orderID'] ?>
                </td>
                <td class="align-middle">
                    <?php echo $rowQueryTblOrder['ItemCode'] ?>
                </td>
                <td class="align-middle">
                    <?php echo $rowQueryTblProduct['product_Name'] ?>
                </td>
                <td class="align-middle">
                    <?php echo $rowQueryTblOrder['productAmount'] ?>
                </td>

                <td class="align-middle">
                    <?php echo number_format($rowQueryTblProduct['product_PromotionalPrice'], 0, '.', '.') ?>
                </td>
                <td class="align-middle">
                    <?php echo number_format(($rowQueryTblOrder['productAmount'] * $rowQueryTblProduct['product_PromotionalPrice']), 0, '.', '.') ?>
                </td>
                <td class="align-middle">
                    <?php
                    if ($rowQueryTblCustomer['ModePay'] == 1) {
                        echo "Thanh toán khi giao hàng";
                    } else {
                        echo "Thanh toán qua ATM";
                    }
                    ?>
                </td>
                <td class="align-middle">
                    <?php echo $rowQueryTblCustomer['Address'] ?>
                </td>
                <td class="align-middle">
                    <?php echo $rowQueryTblCustomer['Note'] ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="modal-footer ">
    <form id="formUpdateOrder">
        <?php
        if ($rowQueryTblOrder['status'] == 3) {
        ?>
            <div class="form-check">
                <input class="inputRadio" type="radio" name="inputRadio" value="4" id="inputRadio1">
                <label class="form-check-label" for="inputRadio1">
                    Xác nhận huỷ
                </label>
            </div>
            <?php
        } elseif ($rowQueryTblOrder['status'] != 4) {
            for ($i = 0; $i < 3; $i++) {
            ?>
                <div class="form-check">
                    <input class="inputRadio" type="radio" name="inputRadio" value="<?php echo $i ?>" id="inputRadio1" <?php if ($rowQueryTblOrder['status'] == $i) echo 'checked'  ?>>
                    <label class="form-check-label" for="inputRadio1">
                        <?php
                        echo $arrayStastusOrder[$i];
                        ?>
                    </label>
                </div>
            <?php
            }
        }
        if ($rowQueryTblOrder['status'] != 4) {
            ?>

            <input class="mt-2 btn btn-primary btn-full" type="submit" name="btnUpdateOrder" value="Cập nhật đơn hàng">
        <?php

        }
        ?>
    </form>
</div>


<!-- <?php
        // if ($rowQueryTblOrder['status'] == 1) {
        ?>
    <div class="form-check">
        <input class="inputRadio" type="radio" name="inputRadio" value="0" id="inputRadio1">
        <label class="form-check-label" for="inputRadio1">
            Chưa xử lý
        </label>
    </div>
    <div class="form-check">
        <input class="inputRadio" type="radio" name="inputRadio" value="1" id="inputRadio2" checked>
        <label class="form-check-label" for="inputRadio2">
            Đã xử lý
        </label>
    </div>
    <div class="form-check">
        <input class="inputRadio" type="radio" name="inputRadio" value="2" id="inputRadio2">
        <label class="form-check-label" for="inputRadio2">
            Đã hoàn thành
        </label>
    </div>
<?php
// } elseif ($rowQueryTblOrder['status'] == 2) {
?>
    <div class="form-check">
        <input class="inputRadio" type="radio" name="inputRadio" value="0" id="inputRadio1">
        <label class="form-check-label" for="inputRadio1">
            Chưa xử lý
        </label>
    </div>
    <div class="form-check">
        <input class="inputRadio" type="radio" name="inputRadio" value="1" id="inputRadio2">
        <label class="form-check-label" for="inputRadio2">
            Đã xử lý
        </label>
    </div>
    <div class="form-check">
        <input class="inputRadio" type="radio" name="inputRadio" value="2" id="inputRadio2" checked>
        <label class="form-check-label" for="inputRadio2">
            Đã hoàn thành
        </label>
    </div>
<?php
// } else {
?>
    <div class="form-check">
        <input class="inputRadio" type="radio" name="inputRadio" value="0" id="inputRadio1" checked>
        <label class="form-check-label" for="inputRadio1">
            Chưa xử lý
        </label>
    </div>
    <div class="form-check">
        <input class="inputRadio" type="radio" name="inputRadio" value="1" id="inputRadio2">
        <label class="form-check-label" for="inputRadio2">
            Đã xử lý
        </label>
    </div>
    <div class="form-check">
        <input class="inputRadio" type="radio" name="inputRadio" value="2" id="inputRadio2">
        <label class="form-check-label" for="inputRadio2">
            Đã hoàn thành
        </label>
    </div>
<?php
// }
?> -->