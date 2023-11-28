<?php
include_once 'db/connect.php';
session_start();
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
  <title>
    Electro Store Ecommerce | Home
  </title>
  <!-- Meta tag Keywords -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="UTF-8" />
  <meta name="keywords" content="Electro Store Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
  <script>
    addEventListener(
      "load",
      function() {
        setTimeout(hideURLbar, 0);
      },
      false
    );

    function hideURLbar() {
      window.scrollTo(0, 1);
    }
  </script>
  <!-- //Meta tag Keywords -->


  <!-- Custom-Files -->
  <link href="./css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
  <!-- Bootstrap css -->
  <link rel="stylesheet" href="./css/fontawesome-all.css" />

  <!-- link fontanwesome -->
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/all.css">

  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-solid.css">

  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-regular.css">

  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-light.css">
  <!-- --link fontanwesome -->

  <!-- Font-Awesome-Icons-CSS -->
  <link href="./css/popuo-box.css" rel="stylesheet" type="text/css" media="all" />
  <!-- pop-up-box -->
  <link href="./css/menu.css" rel="stylesheet" type="text/css" media="all" />
  <!-- menu style -->
  <link href="./css/style.css" rel="stylesheet" type="text/css" media="all" />
  <!-- Main css -->
  <!-- toasts css  -->
  <link href="./css/toast.css" rel="stylesheet" type="text/css" media="all" />

  <!-- //Custom-Files -->

  <!-- web fonts -->
  <link href="//fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&amp;subset=latin-ext" rel="stylesheet" />
  <link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet" />
  <!-- //web fonts -->


  <!-- set background image for slider -->
  <style>
    <?php
    $sql_slider_style = mysqli_query($conn, "SELECT * from tableslider WHERE slider_Active = 1 order by slider_ID asc");
    while ($row_slider_style = mysqli_fetch_array($sql_slider_style)) {

    ?>.carousel-item.item<?php echo $row_slider_style['slider_ID']  ?> {
      background: url('./uploads/<?php echo $row_slider_style['slider_Image'] ?>') no-repeat center;
      background-size: cover;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      -ms-background-size: cover;

    }

    <?php

    }


    ?>
  </style>

</head>

<body>


  <?php
  include 'include/header.php';
  include 'include/menu.php';
  include 'include/slider.php';

  if (isset($_GET['manager'])) {
    $manager = $_GET['manager'];
  } else {
    $manager = "";
  }


  if (!empty($manager)) {
    $TitlePage = "";
    if ($manager == "ListCategory" || $manager == 'detailProduct') {
      if (isset($_GET['id'])) {
        $idCT = $_GET['id'];
        $sql_ListCate = mysqli_fetch_assoc(mysqli_query($conn, "SELECT categoryName FROM tablecatrgory WHERE categoryID = '$idCT'"));
        $TitlePage = $sql_ListCate['categoryName'];
      }
    } else {
      $arrayTitle = array(
        "payment" => "thanh toán",
        "news" => "tin tức",
        "contact" => "liên hệ",
        "checkout" => "kiểm tra hàng",
        "shoppingCart" => "Giỏ hàng",
        "terms" => "Điều khoản sử dụng",
        'viewOrder' => 'Xem đơn hàng',
        'help' => 'Hỗ trợ',
        'about' => 'Về chúng tôi',
        'faqs' => 'Câu hỏi thường gặp',
        'privacy' => 'Chính sách bảo mật',
        'search' => 'Tìm kiếm',
        'filter' => 'Kết quả lọc',
        'newproduct' => 'Sản phẩm mới'
      );
      $TitlePage = !empty($arrayTitle[$manager]) ? $arrayTitle[$manager] : '';
    }

  ?>
    <!-- page -->
    <div class="services-breadcrumb">
      <div class="agile_inner_breadcrumb">
        <div class="container">
          <ul class="w3_short">
            <li>
              <a href="index.php">Trang chủ</a>
              <i>|</i>
            </li>
            <li><?php echo $TitlePage; ?></li>
          </ul>
        </div>
      </div>
    </div>
    <!-- //page -->

  <?php
  }


  if ($manager == 'ListCategory') {
    include 'include/ListCategory.php';
  } elseif ($manager == 'detailProduct') {
    include 'include/detailProduct.php';
  } elseif ($manager == 'shoppingCart' || $manager == 'checkout') {
    include 'include/shoppingCart.php';
  } elseif ($manager == 'search') {
    include 'include/search.php';
  } elseif ($manager == 'payment') {
    include 'include/payment.php';
  } elseif ($manager == 'contact') {
    include 'include/contact.php';
  } elseif ($manager == 'news') {
    include 'include/home.php';
  } elseif ($manager == 'terms') {
    include 'include/terms.php';
  } elseif ($manager == 'viewOrder') {
    include 'include/viewOrder.php';
  } elseif ($manager == 'help') {
    include 'include/pageHelp.php';
  } elseif ($manager == 'about') {
    include 'include/pageAboutUs.php';
  } elseif ($manager == 'faqs') {
    include 'include/pageFaqs.php';
  } elseif ($manager == 'privacy') {
    include 'include/pagePrivacy.php';
  } elseif ($manager == 'filter') {
    include 'include/pageFilter.php';
  } elseif ($manager == 'newproduct') {
    include 'include/productNew.php';
  } else {
    include 'include/home.php';
  }

  include 'include/footer.php';

  ?>

  <!-- overlay -->
  <div class="overlay"></div>
  <!-- //overlay -->

  <!-- js-files -->
  <!-- jquery -->
  <script src="./js/jquery-2.2.3.min.js"></script>

  <!-- //jquery -->

  <!-- nav smooth scroll -->
  <script>
    $(document).ready(function() {
      $(".dropdown").hover(
        function() {
          $('.dropdown-menu', this).stop(true, true).slideDown("fast");
          $(this).toggleClass('open');
        },
        function() {
          $('.dropdown-menu', this).stop(true, true).slideUp("fast");
          $(this).toggleClass('open');
        }
      );
    });
  </script>
  <!-- //nav smooth scroll -->

  <!-- popup modal (for location)-->
  <script src="js/jquery.magnific-popup.js"></script>
  <script>
    $(document).ready(function() {
      $('.popup-with-zoom-anim').magnificPopup({
        type: 'inline',
        fixedContentPos: false,
        fixedBgPos: true,
        overflowY: 'auto',
        closeBtnInside: true,
        preloader: false,
        midClick: true,
        removalDelay: 300,
        mainClass: 'my-mfp-zoom-in'
      });
    });
  </script>
  <!-- //popup modal (for location)-->

  <!-- cart-js -->
  <!-- <script src="js/minicart.js"></script> -->

  <!-- <script>
    paypals.minicarts.render(); //use only unique class names other than paypals.minicarts.Also Replace same class name in css and minicart.min.js

    paypals.minicarts.cart.on("checkout", function(evt) {
      var items = this.items(),
        len = items.length,
        total = 0,
        i;

      // Count the number of each item in the cart
      for (i = 0; i < len; i++) {
        total += items[i].get("quantity");
      }

      if (total < 3) {
        alert(
          "The minimum order quantity is 3. Please add more to your shopping cart before checking out"
        );
        evt.preventDefault();
      }
    });
  </script> -->
  <!-- //cart-js -->

  <!-- password-script -->
  <script>
    window.onload = function() {
      document.getElementById("password1").onchange = validatePassword;
      document.getElementById("password2").onchange = validatePassword;
    };

    function validatePassword() {
      var pass2 = document.getElementById("password2").value;
      var pass1 = document.getElementById("password1").value;
      if (pass1 != pass2)
        document
        .getElementById("password2")
        .setCustomValidity("Passwords Don't Match");
      else document.getElementById("password2").setCustomValidity("");
      //empty string means no validation error
    }
  </script>
  <!-- //password-script -->



  <!-- imagezoom -->
  <script src="js/imagezoom.js"></script>
  <!-- //imagezoom -->

  <!-- flexslider -->
  <link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />

  <script src="js/jquery.flexslider.js"></script>

  <script>
    // Can also be used with $(document).ready()
    $(document).ready(function() {
      $('.flexslider').flexslider({
        animation: "slide",
        controlNav: "thumbnails"
      });
    });
  </script>
  <!-- //FlexSlider-->

  <!-- scroll seller -->
  <script src="js/scroll.js"></script>
  <!-- //scroll seller -->

  <!-- smoothscroll -->
  <script src="js/SmoothScroll.min.js"></script>
  <!-- //smoothscroll -->

  <!-- start-smooth-scrolling -->
  <script src="js/move-top.js"></script>
  <script src="js/easing.js"></script>
  <script>
    jQuery(document).ready(function($) {
      $(".scroll").click(function(event) {
        event.preventDefault();

        $("html,body").animate({
            scrollTop: $(this.hash).offset().top,
          },
          1000
        );
      });
    });
  </script>
  <!-- //end-smooth-scrolling -->

  <!-- smooth-scrolling-of-move-up -->
  <script>
    $(document).ready(function() {
      /*
			var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
			};
			*/
      $().UItoTop({
        easingType: "easeOutQuart",
      });
    });
  </script>
  <!-- //smooth-scrolling-of-move-up -->

  <script type="module" src="./js/handleFormAjax.js"></script>
  <script type="module" src="./js/handleFormUser.js"></script>


  <!-- for bootstrap working -->
  <script src="js/bootstrap.js"></script>
  <!-- //for bootstrap working -->
  <!-- //js-files -->

  <script src="./js/index.js"></script>
</body>

</html>