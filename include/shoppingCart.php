<?php
$usercode = '';
if (isset($_COOKIE['usercode'])) {
    $usercode = base64_decode($_COOKIE['usercode']);
}
?>

<!-- checkout page -->
<div class="privacy py-sm-5 py-4">
    <div class="container py-xl-4 py-lg-2">
        <!-- tittle heading -->
        <h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
            <span>C</span>heckout
        </h3>


        <!-- //tittle heading -->
        <div class="checkout-right">
            <?php
            $row_NumberOrder = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as NumberOrder FROM tableshoppingcart WHERE userCode = '$usercode'"));
            ?>
            <h4 class="mb-sm-4 mb-3 title-shopping-cart" data-count-product="<?php echo $row_NumberOrder['NumberOrder'] ?>">
                <?php if ($row_NumberOrder > 0) { ?>
                    Your shopping cart contains:
                    <span><?php echo $row_NumberOrder['NumberOrder'] ?></span> Products.
                <?php   } else { ?>
                    Your shopping cart is empty.
                <?php   } ?>

            </h4>
            <div class="table-responsive">
                <table class="timetable_sub">
                    <thead>
                        <tr>
                            <th>Thứ tự</th>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Tên sản phẩm</th>

                            <th>Đơn Giá</th>
                            <th>Số Tiền</th>
                            <th>Xoá</th>
                        </tr>
                    </thead>
                    <tbody class="Tbody_shoppingCart">
                        <?php
                        $sql_getShoppingCart = mysqli_query($conn, "SELECT * FROM tableshoppingcart WHERE userCode = '$usercode'  ORDER BY shoppingCart_id DESC");
                        $i = 0;
                        $wppa = array();
                        while ($row_ShoppingCart = mysqli_fetch_array($sql_getShoppingCart)) {
                            $wppa[$row_ShoppingCart['product_ID']] = array(
                                'id' => $row_ShoppingCart['category_ID'],
                                'amount' =>  $row_ShoppingCart['productQuantity'],
                                'name' => $row_ShoppingCart['productName'],
                                'price' => $row_ShoppingCart['productPrice']
                            );

                        ?>

                            <tr class="rem1 row_cartsp">
                                <td class="invert ordinal"><?php echo ++$i  ?></td>
                                <td class="invert-image">
                                    <a href="?manager=detailProduct&id=<?php echo $row_ShoppingCart['category_ID']  . "&idProduct=";
                                                                        echo $row_ShoppingCart['product_ID'] ?>">
                                        <img src="uploads/<?php echo $row_ShoppingCart['productImage'] ?>" alt="" class="img-responsive" />
                                    </a>
                                </td>
                                <td class="invert">
                                    <div class="btn_quantity">
                                        <form class="formChangeQuantity">
                                            <input type="submit" name="btnQTT" value="-" data-id="<?php echo  $row_ShoppingCart['product_ID']  ?>" class="value-button btnChangeQtt btnDecrease" />
                                            <input type="number" name="productQuantity" value="<?php echo  $row_ShoppingCart['productQuantity']  ?>" readonly class="numberInput" />
                                            <input type="hidden" name="price" value="<?php echo  $row_ShoppingCart['productPrice']  ?>" />
                                            <input type="hidden" name="idProcduct" value="<?php echo  $row_ShoppingCart['product_ID']  ?>" />
                                            <input type="hidden" name="btnAct" class="btnACT" value="">
                                            <input type="submit" name="btnQTT" value="+" data-id="<?php echo  $row_ShoppingCart['product_ID']  ?>" class="value-button btnChangeQtt btnIncrease" />
                                        </form>
                                    </div>


                                </td>
                                <td class="invert"><?php echo $row_ShoppingCart['productName']  ?></td>
                                <td class="invert PriceProduct"><?php echo number_format($row_ShoppingCart['productPrice'], 0, '.', '.') ?></td>
                                <td class="invert total"><?php echo number_format($row_ShoppingCart['total'], 0, '.', '.') ?></td>
                                <td class="invert">
                                    <div class="rem">
                                        <div class="close1">
                                            <form class="formDeleteProduct">
                                                <input type="hidden" name="idProcduct" value="<?php echo  $row_ShoppingCart['product_ID']  ?>" />
                                                <input type="submit" value="" class="btnDeleteProduct">
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        <?php
                        }
                        // storage shopping cart to session
                        $_SESSION['SPC'] =  $wppa;
                        // storage shopping cart to session

                        ?>

                    </tbody>
                    <tr>
                        <td class="totalMoney_title font-weight-bold" colspan="5">Tổng tiền</td>
                        <td class="totalMoney_number" colspan="2">0</td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- run test -->
        <!-- <div class="Test">
        </div> -->
        <!-- run test  -->
        <div class="checkout-left">
            <div class="address_form_agile mt-sm-5 mt-4">
                <h4 class="mb-sm-4 mb-3">Thêm thông tin chi tiết</h4>
                <form id="agileinfo_form" class="creditly-card-form agileinfo_form">
                    <div class="creditly-wrapper wthree, w3_agileits_wrapper">
                        <div class="information-wrapper">

                            <div class="first-row">
                                <div class="controls form-group">
                                    <input class="billing-address-name form-control" type="text" name="fullname" placeholder="Họ và Tên" required="" />
                                </div>
                                <div class="w3_agileits_card_number_grids">
                                    <div class="w3_agileits_card_number_grid_left form-group">
                                        <div class="controls">
                                            <input type="text" class="form-control" placeholder="Số điện thoại" name="numberphone" required="" />
                                        </div>
                                    </div>
                                    <div class="w3_agileits_card_number_grid_right form-group">
                                        <div class="controls">
                                            <input type="text" class="form-control" placeholder="Email" name="email" required="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="controls form-group">
                                    <input type="text" class="form-control" placeholder="Địa chỉ" name="address" required="" />
                                </div>
                                <div class="controls form-group">
                                    <textarea class="form-control" name="note" placeholder="Chú ý" id="" cols="30" rows="3" style="resize: none;"></textarea>
                                </div>
                                <div class="controls form-group">
                                    <select class="option-w3ls" name="modePay">
                                        <option>Phương thức thanh toán</option>
                                        <option value="1">Thanh toán khi giao hàng</option>
                                        <option value="0">Thanh toán qua ATM</option>

                                    </select>
                                </div>
                            </div>
                            <input type="submit" name="pay" id="btn_submit_pay" class="submit check_out btn" value="Thanh Toán" />

                        </div>
                    </div>
                </form>
                <!-- <div class="checkout-right-basket">
                    <a href="payment.html">Make a Payment
                        <span class="far fa-hand-point-right"></span>
                    </a>
                </div> -->
            </div>
        </div>
    </div>
</div>
<!-- //checkout page -->