<?php
if (isset($_GET['id']) && isset($_GET['idProduct'])) {
    $idCategory = $_GET['id'];
    $idProduct = $_GET['idProduct'];
} else {
    $idCategory = "";
    $idProduct = "";
}

// get infomation product by id Product
$sql_query = "SELECT * FROM  tableproducts WHERE product_ID = '$idProduct' AND category_ID = '$idCategory'";
// get attributes info  by id product in table tableattributescategory
$sql_query_attributes = mysqli_query($conn, "SELECT attributeName FROM tableattributescategory WHERE categoryID = '$idCategory'");
$result_queryAttribute = mysqli_fetch_assoc($sql_query_attributes);
$arrayAttributesProduct =  explode("--", $result_queryAttribute['attributeName']);

$sql_detail = mysqli_query($conn, $sql_query);

?>

<?php

while ($rowInfoProduct = mysqli_fetch_array($sql_detail)) {
    $arrData = explode('\\---\\', $rowInfoProduct['detailProduct']);
?>
    <!-- Single Page -->
    <div class="banner-bootom-w3-agileits py-5">
        <div class="container py-xl-4 py-lg-2">
            <!-- tittle heading -->
            <h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
                <!-- <span>S</span>ingle
                <span>P</span>age -->
            </h3>
            <!-- //tittle heading -->
            <div class="row">

                <div class="col-lg-5 col-md-8 single-right-left ">
                    <div class="grid images_3_of_2">
                        <div class="flexslider">
                            <ul class="slides">
                                <li data-thumb="<?php
                                                if (file_exists("./images/{$rowInfoProduct['image_1']}")) {
                                                    echo "images/" . $rowInfoProduct['image_1'];
                                                } else if (file_exists("./uploads/{$rowInfoProduct['image_1']}")) {
                                                    echo "uploads/" . $rowInfoProduct['image_1'];
                                                }
                                                ?>">
                                    <div class="thumb-image">
                                        <img src="<?php
                                                    if (file_exists("./images/{$rowInfoProduct['image_1']}")) {
                                                        echo "images/" . $rowInfoProduct['image_1'];
                                                    } else if (file_exists("./uploads/{$rowInfoProduct['image_1']}")) {
                                                        echo "uploads/" . $rowInfoProduct['image_1'];
                                                    }
                                                    ?>" data-imagezoom="true" class="img-fluid" alt="">
                                    </div>
                                </li>
                                <li data-thumb="<?php
                                                if (file_exists("./images/{$rowInfoProduct['image_2']}")) {
                                                    echo "images/" . $rowInfoProduct['image_2'];
                                                } else if (file_exists("./uploads/{$rowInfoProduct['image_2']}")) {
                                                    echo "uploads/" . $rowInfoProduct['image_2'];
                                                }
                                                ?>">
                                    <div class="thumb-image">
                                        <img src="<?php
                                                    if (file_exists("./images/{$rowInfoProduct['image_2']}")) {
                                                        echo "images/" . $rowInfoProduct['image_2'];
                                                    } else if (file_exists("./uploads/{$rowInfoProduct['image_2']}")) {
                                                        echo "uploads/" . $rowInfoProduct['image_2'];
                                                    }
                                                    ?>" data-imagezoom="true" class="img-fluid" alt="">
                                    </div>
                                </li>
                                <li data-thumb="<?php
                                                if (file_exists("./images/{$rowInfoProduct['image_3']}")) {
                                                    echo "images/" . $rowInfoProduct['image_3'];
                                                } else if (file_exists("./uploads/{$rowInfoProduct['image_3']}")) {
                                                    echo "uploads/" . $rowInfoProduct['image_3'];
                                                }
                                                ?>">
                                    <div class="thumb-image">
                                        <img src="<?php
                                                    if (file_exists("./images/{$rowInfoProduct['image_3']}")) {
                                                        echo "images/" . $rowInfoProduct['image_3'];
                                                    } else if (file_exists("./uploads/{$rowInfoProduct['image_3']}")) {
                                                        echo "uploads/" . $rowInfoProduct['image_3'];
                                                    }
                                                    ?>" data-imagezoom="true" class="img-fluid" alt="">
                                    </div>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 single-right-left simpleCart_shelfItem">
                    <h3 class="mb-3"><?php echo $rowInfoProduct['product_Name'] ?></h3>
                    <p class="mb-3">
                        <?php
                        if ($rowInfoProduct['product_Active'] == 1) {
                            if ($rowInfoProduct['product_Quatity'] >= 1) {
                        ?>
                                <span class="item_price"><?php echo number_format($rowInfoProduct['product_PromotionalPrice'], 0, '.', '.') . 'đ' ?></span>
                                <del class="mx-2 font-weight-light"><?php echo number_format($rowInfoProduct['product_Price'], 0, '.', '.') . 'đ' ?></del>
                                <label>Free delivery</label>
                            <?php } else { ?>
                                <span class="status_notification">Hết hàng</span>
                            <?php }
                        } else {
                            ?>
                            <span class="status_notification">Sản phẩm ngừng kinh doanh</span>
                        <?php
                        }
                        ?>

                    </p>
                    <div class="single-infoagile">
                        <ul>
                            <li class="mb-3">
                                Cash on Delivery Eligible.
                            </li>
                            <li class="mb-3">
                                Shipping Speed to Delivery.
                            </li>
                            <li class="mb-3">
                                EMIs from $655/month.
                            </li>
                            <li class="mb-3">
                                Bank OfferExtra 5% off* with Axis Bank Buzz Credit CardT&C
                            </li>
                        </ul>
                    </div>
                    <div class="product-single-w3l">
                        <p class="my-3">
                            <i class="far fa-hand-point-right mr-2"></i>
                            <label>1 Year</label>Manufacturer Warranty
                        </p>
                        <ul class="ListInfoProduct">
                            <?php
                            foreach ($arrayAttributesProduct as $key => $attribute) {
                                if (!empty($arrData[$key])) {
                            ?>

                                    <li class="d-flex align-items-center p-2">
                                        <p class="lileft mr-4"> <?php echo $attribute . ': ' ?></p>
                                        <p class="liright">
                                            <?php echo $arrData[$key] ?>
                                        </p>
                                    </li>
                            <?php
                                }
                            }
                            ?>

                        </ul>
                        <p class="my-sm-4 my-3">
                            <i class="fas fa-retweet mr-3"></i>Net banking & Credit/ Debit/ ATM card
                        </p>
                    </div>
                    <div class="occasion-cart">
                        <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                            <form class="formAddToSPC" action="?manager=shoppingCart" method="post">
                                <fieldset>
                                    <input type="hidden" name="productID" value="<?php echo $rowInfoProduct['product_ID'] ?>" />
                                    <input type="hidden" name="categoryID" value="<?php echo $idCategory ?>" />
                                    <input type="hidden" name="productName" value="<?php echo $rowInfoProduct['product_Name'] ?>" />
                                    <input type="hidden" name="productPrice" value="<?php echo $rowInfoProduct['product_PromotionalPrice'] ?>" />
                                    <input type="hidden" name="productImage" value="<?php echo $rowInfoProduct['image_1'] ?>" />
                                    <input type="hidden" name="productQuantity" value="1" />
                                    <?php
                                    if ($rowInfoProduct['product_Active'] == 1) {
                                        if ($rowInfoProduct['product_Quatity'] >= 1) {
                                    ?>
                                            <input type="submit" name="submitAddSC" value="Thêm vào giỏ hàng" class="button" />
                                    <?php
                                        }
                                    }
                                    ?>

                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php } ?>


<!-- //Single Page -->