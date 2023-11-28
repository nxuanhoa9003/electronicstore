  <!-- navigation -->
  <?php
  $sql_categories  = mysqli_query($conn, "SELECT * FROM tablecatrgory order by categoryID asc");
  ?>

  <div class="navbar-inner">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="agileits-navi_search">
          <select id="agileinfo-nav_search" name="agileinfo_search" class="border" required="">
            <option value="">Danh mục sản phẩm</option>
            <?php
            while ($row_categories = mysqli_fetch_array($sql_categories)) {
            ?>
              <option value="<?php echo $row_categories['categoryID']  ?>"><?php echo $row_categories['categoryName']  ?></option>

            <?php
            }
            ?>
          </select>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto text-center mr-xl-5">

            <?php
            $sql_categories_list  = mysqli_query($conn, "SELECT * FROM tablecatrgory order by categoryID asc LIMIT 4");
            while ($row_categories_list = mysqli_fetch_array($sql_categories_list)) {
            ?>
              <li class="nav-item mr-lg-2 mb-lg-0 mb-2">
                <a class="nav-link" href="?manager=ListCategory&id=<?php echo $row_categories_list['categoryID'] ?>" role="button" aria-haspopup="true" aria-expanded="false">
                  <?php echo $row_categories_list['categoryName'] ?>
                </a>
              </li>
            <?php
            }
            ?>

            <li class="nav-item mr-lg-2 mb-lg-0 mb-2">
              <a class="nav-link" href="?manager=newproduct">Sản phẩm mới
              </a>
            </li>

            <li class="nav-item mr-lg-2 mb-lg-0 mb-2">
              <a class="nav-link" href="?manager=news">Tin tức</a>
            </li>
            <li class="nav-item dropdown mr-lg-2 mb-lg-0 mb-2">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Trang
              </a>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="?manager=checkout">Kiểm tra hàng</a>
                <a class="dropdown-item" href="?manager=payment">Thanh toán</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?manager=contact">Liên hệ</a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
  <!-- //navigation -->