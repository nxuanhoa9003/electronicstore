<?php

$selecOrder = mysqli_query($conn, "SELECT * FROM tableorder AS T1
                                INNER JOIN tableproducts AS T2
                                ON T2.product_ID = T1.productID 
                                INNER JOIN tablecustomer AS T3 
                                ON T1.customerID = T3.customerID");

$statusOrder = array(
    0 => array('stt' => "Đang chờ xử lý", 'text' => "text-danger", "class" => "pending", 'iscancel' => true),
    1 => array('stt' => "Đang giao", 'text' => "text-primary", "class" => "delivering", 'iscancel' => false),
    2 => array('stt' => "Hoàn Thành", 'text' => "text-success", "class" => "complete", 'iscancel' => false),
    3 => array('stt' => "Yêu cầu huỷ", 'text' => "text-muted", "class" => "requestCancle", 'iscancel' => false),
    4 => array('stt' => "Đã huỷ", 'text' => "text-muted", "class" => "cancel", 'iscancel' => false),
);

?>

<div class="container">

    <div class="navbar-inner mt-5">

        <nav class="navbar d-inline-block navbar-expand navbar-light bg-light w-100">

            <ul class="navbar_Order navbar-nav text-center row">
                <li data-status="all" class="active nav-item col">
                    <a class="nav-link" href="#">Tất cả</a>
                </li>

                <li data-status="pending" class="nav-item col">
                    <a class="nav-link" href="#">Đang chờ xử lý</a>
                </li>
                <li data-status="delivering" class="nav-item col">
                    <a class="nav-link" href="#">Đang giao</a>
                </li>
                <li data-status="complete" class="nav-item col">
                    <a class="nav-link" href="#">Hoàn thành</a>
                </li>
                <li data-status="cancel" class="nav-item col">
                    <a class="nav-link" href="#">Đã huỷ</a>
                </li>
            </ul>
        </nav>

    </div>
    <div class="mt-5">
        <table class="table">
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($selecOrder)) {
                ?>
                    <tr class="rowElementView <?php echo $statusOrder[$row['status']]['class'] ?> active">
                        <td class="p-0 d-block">
                            <table class="table">
                                <tr>
                                    <td>
                                        <div class="media">

                                            <img src="<?php
                                                        if (file_exists("./uploads/{$row['image_1']}")) {
                                                            echo "uploads/" . $row['image_1'];
                                                        }
                                                        ?>" class="mr-3 image-product" alt="...">

                                            <div class="media-body">
                                                <div class="d-flex align-items-center">
                                                    <h6 class="mb-1 text-secondary">Mã đơn hàng: <strong><?php echo $row['ItemCode'] ?></strong> </h6>
                                                    <p class="ml-4 mb-1  <?php echo $statusOrder[$row['status']]['text'] ?>"><?php echo $statusOrder[$row['status']]['stt'] ?></p>

                                                </div>
                                                <h5 class="mt-0 text-primary"><?php echo $row['product_Name'] ?></h5>
                                                <p>x<?php echo $row['productAmount'] ?></p>
                                                <div class="text-danger">
                                                    <?php echo number_format($row['product_PromotionalPrice'] * $row['productAmount'], 0, '.', '.') . 'đ' ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center mb-3">
                                            <div class="p-2 text-center">
                                                <a data-codeOrder="<?php echo $row['ItemCode'] ?>" class="address-link " href="#">
                                                    Địa chỉ nhận hàng
                                                </a>
                                            </div>
                                            <?php if ($statusOrder[$row['status']]['iscancel']) { ?>
                                                <div class="p-2 text-center">
                                                    <a data-codeOrder="<?php echo $row['ItemCode'] ?>" data-id="<?php echo $row['orderID'] ?>" href="#" class="cancle-link">
                                                        Huỷ đơn hàng
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-top-0" colspan="2">
                                        <div class="content">
                                            <p>
                                                <span>Người nhận: </span>
                                                <?php echo $row['FullName'] ?>
                                            </p>
                                            <p>
                                                <span>Số điện thoại: </span>
                                                <?php echo $row['NumberPhone'] ?>
                                            </p>
                                            <p>
                                                <span>Địa chỉ: </span>
                                                <?php echo $row['Address'] ?>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>

                    </tr>

                <?php
                }
                ?>
            </tbody>

        </table>



    </div>



</div>