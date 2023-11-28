<?php
$keychoose = '';
$StringSql = '';
if (isset($_GET['choose'])) {
    $keychoose = $_GET['choose'];

    switch ($keychoose) {
        case 'p1':
            $StringSql = "SELECT * FROM `tableproducts` WHERE product_PromotionalPrice < 5000000";
            break;
        case 'p2':
            $StringSql = "SELECT * FROM `tableproducts` WHERE product_PromotionalPrice >= 5000000 AND product_PromotionalPrice < 7000000";
            break;
        case 'p3':
            $StringSql = "SELECT * FROM `tableproducts` WHERE product_PromotionalPrice >= 7000000 AND product_PromotionalPrice < 10000000";
            break;
        case 'p4':
            $StringSql = "SELECT * FROM `tableproducts` WHERE product_PromotionalPrice >= 10000000 AND product_PromotionalPrice < 15000000";
            break;
        case 'p5':
            $StringSql = "SELECT * FROM `tableproducts` WHERE product_PromotionalPrice >= 15000000";
            break;
        case 'd1':
            $StringSql = "SELECT * FROM `tableproducts` WHERE percent_discounted >= 5 AND percent_discounted < 10";
            break;
        case 'd2':
            $StringSql = "SELECT * FROM `tableproducts` WHERE percent_discounted >= 10 AND percent_discounted < 15";
            break;
        case 'd3':
            $StringSql = "SELECT * FROM `tableproducts` WHERE percent_discounted >= 15 AND percent_discounted < 25";
            break;
        case 'd4':
            $StringSql = "SELECT * FROM `tableproducts` WHERE percent_discounted >= 25 AND percent_discounted < 35";
            break;
        case 'd5':
            $StringSql = "SELECT * FROM `tableproducts` WHERE percent_discounted >= 35";
            break;
    }
}
// SELECT * FROM  tableproducts WHERE product_Name LIKE '%$keysearch%' ORDER BY product_ID  DESC

$sql_ListCate = mysqli_query($conn, $StringSql);
$row_result = mysqli_num_rows(mysqli_query($conn, $StringSql));

?>

<!-- top Products -->
<div class="ads-grid py-sm-5 py-4">
    <?php
    if ($row_result > 0) {
    ?>
        <div class="container py-xl-4 py-lg-2">
            <!-- tittle heading -->
            <h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
                Kết quả
            </h3>
            <!-- //tittle heading -->
            <div class="row">
                <!-- product left -->
                <div class="agileinfo-ads-display col-lg-9">
                    <div class="wrapper">
                        <!-- first section -->
                        <div class="product-sec1 px-sm-4 px-3 py-sm-5  py-3 mb-4">
                            <div class="row">
                                <?php while ($row_product = mysqli_fetch_array($sql_ListCate)) { ?>
                                    <div class="col-md-4 product-men mt-5">
                                        <div class="men-pro-item simpleCart_shelfItem">
                                            <div class="men-thumb-item text-center">
                                                <img src="<?php
                                                            if (file_exists("./uploads/{$row_product['image_1']}")) {
                                                                echo "uploads/" . $row_product['image_1'];
                                                            }
                                                            ?>" alt="">
                                                <div class="men-cart-pro">
                                                    <div class="inner-men-cart-pro">
                                                        <a href="?manager=detailProduct&id=<?php echo $row_product['category_ID'] . "&idProduct=";
                                                                                            echo $row_product['product_ID'] ?>" class="link-product-add-cart">Quick View</a>
                                                    </div>
                                                </div>
                                                <?php
                                                date_default_timezone_set('Asia/Ho_Chi_Minh');
                                                $produtTime = date("Y-m-d", strtotime($row_product['postTime']));
                                                $currentTime = date("Y-m-d");

                                                $date1 = new DateTime($produtTime);
                                                $date2 = new DateTime($currentTime);

                                                $interval = $date1->diff($date2);
                                                if ($interval->days < 30) {
                                                ?>
                                                    <span class="product-new-top">New</span>
                                                <?php
                                                } ?>
                                            </div>
                                            <div class="item-info-product text-center border-top mt-4">
                                                <h4 class="pt-1 product_Name">
                                                    <a href="?manager=detailProduct&id=<?php echo $row_product['category_ID'] . "&idProduct=";
                                                                                        echo $row_product['product_ID'] ?>"><?php echo $row_product['product_Name'] ?></a>
                                                </h4>
                                                <div class="info-product-price my-2">
                                                    <div class="priceOld">
                                                        <del><?php echo number_format($row_product['product_Price'], 0, '.', '.') . 'đ' ?></del>
                                                        <span class="percent_discounted"><?php echo '-' . $row_product['percent_discounted'] . '%' ?></span>
                                                    </div>
                                                    <span class="item_price"> <?php echo number_format($row_product['product_PromotionalPrice'], 0, '.', '.') . 'đ' ?></span>
                                                </div>
                                                <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                                    <form class="formAddToSPC" action="?manager=shoppingCart" method="post">
                                                        <fieldset>
                                                            <input type="hidden" name="productID" value="<?php echo $row_product['product_ID'] ?>" />
                                                            <input type="hidden" name="categoryID" value="<?php echo $row_product['category_ID'] ?>" />
                                                            <input type="hidden" name="productName" value="<?php echo $row_product['product_Name'] ?>" />
                                                            <input type="hidden" name="productPrice" value="<?php echo $row_product['product_PromotionalPrice'] ?>" />
                                                            <input type="hidden" name="productImage" value="<?php echo $row_product['image_1'] ?>" />
                                                            <input type="hidden" name="productQuantity" value="1" />
                                                            <input type="submit" name="submitAddSC" value="Thêm vào giỏ hàng" class="button" />
                                                        </fieldset>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- //product left -->
                <!-- product right -->
                <div class="col-lg-3 mt-lg-0 mt-4 p-lg-0">
                    <div class="side-bar p-sm-4 p-3">
                        <div class="search-hotel border-bottom py-2">
                            <h3 class="agileits-sear-head mb-3">Brand</h3>
                            <form action="#" method="post">
                                <input type="search" placeholder="Search Brand..." name="search" required="">
                                <input type="submit" value=" ">
                            </form>
                            <div class="left-side py-2">
                                <div class="w3l-range">
                                    <ul>
                                        <li>
                                            <a href="#">Samsung</a>
                                        </li>
                                        <li>
                                            <a href="#">Red Mi</a>
                                        </li>
                                        <li>
                                            <a href="#">Apple</a>
                                        </li>
                                        <li>
                                            <a href="#">Nexus</a>
                                        </li>
                                        <li>
                                            <a href="#">Motorola</a>
                                        </li>
                                        <li>
                                            <a href="#">Micromax</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- price -->
                        <div class="range border-bottom py-2">
                            <h3 class="agileits-sear-head mb-3">Price</h3>
                            <div class="w3l-range">
                                <ul>
                                    <li class="mb-1">
                                        <a href="?manager=filter&choose=p1">Dưới 5 triệu</a>
                                    </li>
                                    <li>
                                        <a href="?manager=filter&choose=p2">5tr - 7tr</a>
                                    </li>
                                    <li class="my-1">
                                        <a href="?manager=filter&choose=p3">7tr - 10tr</a>
                                    </li>
                                    <li>
                                        <a href="?manager=filter&choose=p4">10tr - 15tr</a>
                                    </li>
                                    <li class="mt-1">
                                        <a href="?manager=filter&choose=p5">Trên 15tr</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- //price -->
                        <!-- discounts -->
                        <div class="left-side border-bottom py-2">
                            <h3 class="agileits-sear-head mb-3">Discount</h3>
                            <div class="w3l-range">
                                <ul id="discount">
                                    <li>
                                        <a href="#">5 - 10%</a>
                                    </li>
                                    <li>
                                        <a href="#">10 - 15%</a>
                                    </li>
                                    <li>
                                        <a href="#">15 - 25%</a>
                                    </li>
                                    <li>
                                        <a href="#">25 - 35%</a>
                                    </li>
                                    <li>
                                        <a href="#">Hơn 35%</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- //discounts -->
                        <!-- offers -->
                        <div class="left-side border-bottom py-2">
                            <h3 class="agileits-sear-head mb-3">Offers</h3>
                            <ul>
                                <li>
                                    <input type="checkbox" class="checked">
                                    <span class="span">Exchange Offer</span>
                                </li>
                                <li>
                                    <input type="checkbox" class="checked">
                                    <span class="span">No Cost EMI</span>
                                </li>
                                <li>
                                    <input type="checkbox" class="checked">
                                    <span class="span">Special Price</span>
                                </li>
                            </ul>
                        </div>
                        <!-- //offers -->

                    </div>
                    <!-- //product right -->
                </div>
            </div>
        </div>

    <?php
    } else {
        echo '<h2 class="text-danger text-center">Không có sản phẩm</h2>';
    }
    ?>
</div>


<!-- //top products -->