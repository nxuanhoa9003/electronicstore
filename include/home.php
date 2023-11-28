<!-- top Products -->
<div class="ads-grid py-sm-5 py-4">
  <div class="container py-xl-4 py-lg-2">
    <!-- tittle heading -->
    <h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
      <span>S</span>ản <span>P</span>hẩm
    </h3>
    <!-- //tittle heading -->
    <div class="row">
      <!-- product left -->
      <div class="agileinfo-ads-display col-lg-9">
        <div class="wrapper">
          <?php
          $sql_cate_home = mysqli_query($conn, "SELECT * FROM tablecatrgory ORDER BY categoryID DESC");
          while ($row_cate_home = mysqli_fetch_array($sql_cate_home)) {
            $idCategory = $row_cate_home['categoryID'];
          ?>

            <!-- first section -->
            <div class="product-sec1 px-sm-4 px-3 py-sm-5 py-3 mb-4">
              <h3 class="heading-tittle text-center font-italic">
                <?php echo  $row_cate_home['categoryName'] ?>
              </h3>
              <div class="row">
                <?php $sql_product =  mysqli_query($conn, "SELECT * FROM tableproducts WHERE category_ID = {$idCategory} ORDER BY 	product_ID DESC LiMIT 6 "); // get data in table tableproducts
                while ($row_product = mysqli_fetch_array($sql_product)) {

                ?>
                  <div class="col-md-4 product-men mt-5">
                    <div class="men-pro-item simpleCart_shelfItem">
                      <div class="men-thumb-item text-center">
                        <img src="<?php
                                  if (file_exists("./uploads/{$row_product['image_1']}")) {
                                    echo "uploads/" . $row_product['image_1'];
                                  }
                                  ?>" alt="" />
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
                                                              echo $row_product['product_ID'] ?>"> <?php echo $row_product['product_Name'] ?></a>
                        </h4>
                        <div class="info-product-price my-2">
                          <div class="priceOld">
                            <del><?php echo number_format($row_product['product_Price'], 0, '.', '.') . 'đ' ?></del>
                            <span class="percent_discounted"><?php echo '-' . $row_product['percent_discounted'] . '%' ?></span>
                          </div>
                          <span class="item_price"><?php echo number_format($row_product['product_PromotionalPrice'], 0, '.', '.') . 'đ' ?></span>
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
                              <?php
                              if ($row_product['product_Active'] == 1) {
                                if ($row_product['product_Quatity'] >= 1) { ?>
                                  <input type="submit" name="submitAddSC" value="Thêm vào giỏ hàng" class="button col-8 col-sm-6 col-md-12" />
                              <?php }
                              } ?>
                            </fieldset>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php
                }
                ?>

              </div>
              <div class="d-block mt-5">
                <a class="btn btn-light d-block mx-auto col col-8 col-sm-3 text-truncate" role="button" href="?manager=ListCategory&id=<?php echo $row_cate_home['categoryID'] ?>">Xem nhiều hơn</a>
              </div>
            </div>
            <!-- //first section -->
          <?php
          }
          ?>

        </div>
      </div>
      <!-- //product left -->

      <!-- product right -->
      <div class="col-lg-3 mt-lg-0 mt-4 p-lg-0">
        <div class="side-bar p-sm-4 p-3">
          <!-- <div class="search-hotel border-bottom py-2">
            <h3 class="agileits-sear-head mb-3">Tìm kiếm</h3>
            <form action="#" method="post">
              <input type="search" placeholder="Tên sản phẩm..." name="search" required="" />
              <input type="submit" value=" " />
            </form>
          </div> -->
          <!-- price -->
          <div class="range border-bottom py-2">
            <h3 class="agileits-sear-head mb-3">Giá</h3>
            <div class="w3l-range">
              <ul id="price">
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
                  <a href="?manager=filter&choose=d1">5 - 10%</a>
                </li>
                <li>
                  <a href="?manager=filter&choose=d2">10 - 15%</a>
                </li>
                <li>
                  <a href="?manager=filter&choose=d3">15 - 25%</a>
                </li>
                <li>
                  <a href="?manager=filter&choose=d4">25 - 35%</a>
                </li>
                <li>
                  <a href="?manager=filter&choose=d5">Hơn 35%</a>
                </li>
              </ul>
            </div>

          </div>
          <!-- //discounts -->
          <!-- reviews -->
          <div class="customer-rev border-bottom left-side py-2">
            <h3 class="agileits-sear-head mb-3">Customer Review</h3>
            <ul id="reviews">
              <li>
                <a href="#">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <span>5.0</span>
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <span>4.0</span>
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <span>3.0</span>
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>

                  <span>2.0</span>
                </a>
              </li>
            </ul>
          </div>
          <!-- //reviews -->
          <!-- electronics -->
          <div class="left-side border-bottom py-2">
            <h3 class="agileits-sear-head mb-3">Danh mục sản phẩm</h3>
            <ul>
              <?php
              $sql_categories_sliderbar  = mysqli_query($conn, "SELECT * FROM tablecatrgory order by categoryID asc");
              while ($row_categories_sliderbar = mysqli_fetch_array($sql_categories_sliderbar)) {

              ?>
                <li>
                  <a href="?manager=ListCategory&id=<?php echo $row_categories_sliderbar['categoryID'] ?>" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php echo $row_categories_sliderbar['categoryName'] ?>
                  </a>
                </li>

              <?php
              }
              ?>

            </ul>
          </div>
          <!-- //electronics -->

          <!-- best seller -->
          <div class="f-grid py-2">
            <h3 class="agileits-sear-head mb-3">Sản phẩm bán chạy</h3>
            <div class="box-scroll">
              <div class="scroll">
                <?php
                $sql_product_hot  = mysqli_query($conn, "SELECT * FROM tableproducts WHERE product_Hot = 1 order by category_ID desc");
                while ($row_product_hot = mysqli_fetch_array($sql_product_hot)) {
                ?>
                  <div class="row card_product_hot">
                    <div class="col-lg-3 col-sm-2 col-3 left-mar">
                      <img src="images/<?php echo $row_product_hot['image_1'] ?>" alt="" class="img-fluid" />
                    </div>
                    <div class="col-lg-9 col-sm-10 col-9 w3_mvd">
                      <a href="<?php echo '?manager=detailProduct&id=' .  $row_product_hot['category_ID'] . '&idProduct=' .  $row_product_hot['product_ID'] ?>"><?php echo $row_product_hot['product_Name'] ?></a>
                      <br>
                      <del><?php echo number_format($row_product_hot['product_Price'], 0, '.', '.') . 'đ' ?></del>
                      <a href="" class="price-mar"><?php echo number_format($row_product_hot['product_PromotionalPrice'], 0, '.', '.') . 'đ' ?></a>
                    </div>
                  </div>

                <?php

                }
                ?>

              </div>
            </div>
          </div>
          <!-- //best seller -->
        </div>
        <!-- //product right -->
      </div>
    </div>
  </div>
</div>
<!-- //top products -->

<!-- middle section -->
<div class="join-w3l1 py-sm-5 py-4">
  <div class="container py-xl-4 py-lg-2">
    <div class="row">
      <div class="col-lg-6">
        <div class="join-agile text-left p-4">
          <div class="row">
            <div class="col-sm-7 offer-name">
              <h6>Smooth, Rich & Loud Audio</h6>
              <h4 class="mt-2 mb-3">Branded Headphones</h4>
              <p>Sale up to 25% off all in store</p>
            </div>
            <div class="col-sm-5 offerimg-w3l">
              <img src="images/off1.png" alt="" class="img-fluid" />
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 mt-lg-0 mt-5">
        <div class="join-agile text-left p-4">
          <div class="row">
            <div class="col-sm-7 offer-name">
              <h6>A Bigger Phone</h6>
              <h4 class="mt-2 mb-3">Smart Phones 5</h4>
              <p>Free shipping order over $100</p>
            </div>
            <div class="col-sm-5 offerimg-w3l">
              <img src="images/off2.png" alt="" class="img-fluid" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- middle section -->