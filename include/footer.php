  <!-- footer -->
  <footer>
      <div class="footer-top-first">
          <div class="container py-md-5 py-sm-4 py-3">
              <!-- footer first section -->
              <h2 class="footer-top-head-w3l font-weight-bold mb-2">
                  Electronics :
              </h2>
              <p class="footer-main mb-4">
                  If you're considering a new laptop, looking for a powerful new car
                  stereo or shopping for a new HDTV, we make it easy to find exactly
                  what you need at a price you can afford. We offer Every Day Low
                  Prices on TVs, laptops, cell phones, tablets and iPads, video games,
                  desktop computers, cameras and camcorders, audio, video and more.
              </p>
              <!-- //footer first section -->
              <!-- footer second section -->
              <div class="row w3l-grids-footer border-top border-bottom py-sm-4 py-3">
                  <div class="col-md-4 offer-footer">
                      <div class="row">
                          <div class="col-4 icon-fot">
                              <i class="fas fa-dolly"></i>
                          </div>
                          <div class="col-8 text-form-footer">
                              <h3>Miễn phí vận chuyển</h3>
                              <p>với đơn hàng trên 200k</p>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-4 offer-footer my-md-0 my-4">
                      <div class="row">
                          <div class="col-4 icon-fot">
                              <i class="fas fa-shipping-fast"></i>
                          </div>
                          <div class="col-8 text-form-footer">
                              <h3>Vận chuyển nhanh</h3>
                              <p>toàn quốc</p>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-4 offer-footer">
                      <div class="row">
                          <div class="col-4 icon-fot">
                              <i class="far fa-thumbs-up"></i>
                          </div>
                          <div class="col-8 text-form-footer">
                              <h3>Sự lựa chọn</h3>
                              <p>đáng tin cậy</p>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- //footer second section -->
          </div>
      </div>
      <!-- footer third section -->
      <div class="w3l-middlefooter-sec">
          <div class="container py-md-5 py-sm-4 py-3">
              <div class="row footer-info w3-agileits-info">
                  <!-- footer categories -->
                  <div class="col-md-3 col-sm-6 footer-grids">
                      <h3 class="text-white font-weight-bold mb-3">Categories</h3>
                      <ul>
                          <?php
                            $sql_categories_list  = mysqli_query($conn, "SELECT * FROM tablecatrgory order by categoryID asc LIMIT 6");
                            while ($row_categories_list = mysqli_fetch_array($sql_categories_list)) {
                            ?>
                              <li class="mb-3">
                                  <a href="?manager=ListCategory&id=<?php echo $row_categories_list['categoryID'] ?>"><?php echo $row_categories_list['categoryName'] ?> </a>
                              </li>
                          <?php
                            }
                            ?>

                      </ul>
                  </div>
                  <!-- //footer categories -->
                  <!-- quick links -->
                  <div class="col-md-3 col-sm-6 footer-grids mt-sm-0 mt-4">
                      <h3 class="text-white font-weight-bold mb-3">Quick Links</h3>
                      <ul>
                          <li class="mb-3">
                              <a href="?manager=about">Về chúng tôi</a>
                          </li>
                          <li class="mb-3">
                              <a href="?manager=contact">Liên hệ</a>
                          </li>
                          <li class="mb-3">
                              <a href="?manager=help">Hỗ trợ</a>
                          </li>
                          <li class="mb-3">
                              <a href="?manager=faqs">Câu hỏi thường gặp</a>
                          </li>
                          <li class="mb-3">
                              <a href="?manager=terms">Điều khoản sử dụng</a>
                          </li>
                          <li>
                              <a href="?manager=privacy">Chính sách bảo mật</a>
                          </li>
                      </ul>
                  </div>
                  <div class="col-md-3 col-sm-6 footer-grids mt-md-0 mt-4">
                      <h3 class="text-white font-weight-bold mb-3">Get in Touch</h3>
                      <ul>
                          <li class="mb-3">
                              <i class="fas fa-map-marker"></i> Hà Nội, Việt Nam
                          </li>
                          <li class="mb-3"><i class="fas fa-phone"></i> 0999559999</li>
                          <li class="mb-3">
                              <i class="fas fa-envelope-open"></i>
                              <a href="mailto:example@mail.com">mailsupport@gmail.com</a>
                          </li>
                      </ul>
                  </div>
                  <div class="col-md-3 col-sm-6 footer-grids w3l-agileits mt-md-0 mt-4">
                      <!-- newsletter -->
                      <h3 class="text-white font-weight-bold mb-3">Tin mới</h3>
                      <p class="mb-3">Giao hàng miễn phí cho đơn hàng đầu tiên của bạn!</p>
                      <form action="#" method="post">
                          <div class="form-group">
                              <input type="email" class="form-control" placeholder="Email" name="email" required="" />
                              <input type="submit" value="Go" />
                          </div>
                      </form>
                      <!-- //newsletter -->
                      <!-- social icons -->
                      <div class="footer-grids w3l-socialmk mt-3">
                          <h3 class="text-white font-weight-bold mb-3">Theo dõi chúng tôi</h3>
                          <div class="social">
                              <ul>
                                  <li>
                                      <a class="icon fb" href="#">
                                          <i class="fab fa-facebook-f"></i>
                                      </a>
                                  </li>
                                  <li>
                                      <a class="icon tw" href="#">
                                          <i class="fab fa-twitter"></i>
                                      </a>
                                  </li>
                                  <li>
                                      <a class="icon gp" href="#">
                                          <i class="fab fa-google-plus-g"></i>
                                      </a>
                                  </li>
                              </ul>
                          </div>
                      </div>
                      <!-- //social icons -->
                  </div>
              </div>
              <!-- //quick links -->
          </div>
      </div>
      <!-- //footer third section -->

  </footer>
  <!-- //footer -->
  <!-- copyright -->
  <div class="copy-right py-3">
      <div class="container">
          <p class="text-center text-white">
              © 2023 Electro Store. All rights reserved | Design by
              <a href=""> Ngô Xuân Hoà</a>
          </p>
      </div>
  </div>
  <!-- //copyright -->