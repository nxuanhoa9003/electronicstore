 <!-- banner -->
 <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
   <!-- Indicators-->
   <ol class="carousel-indicators">
     <?php
      $sql_sliderIndicators = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) from tableslider WHERE slider_Active = 1 order by slider_ID asc"));
      $sql_sliderIndicators = $sql_sliderIndicators[0];
      $i = -1;
      while ($i < $sql_sliderIndicators) {
        $i++;
      ?>
       <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i ?>" <?php if ($i == 0) { ?> class="active" <?php } ?>></li>
     <?php
      }
      ?>
     <!-- <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
     <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
     <li data-target="#carouselExampleIndicators" data-slide-to="3"></li> -->


   </ol>

   <div class="carousel-inner">
     <?php
      $sql_slider = mysqli_query($conn, "SELECT * from tableslider WHERE slider_Active = 1 order by slider_ID asc");
      $temp = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from tableslider WHERE slider_Active = 1 order by slider_ID asc LIMIT 1"));
      while ($row_slider = mysqli_fetch_array($sql_slider)) {
      ?>
       <div class="carousel-item item<?php echo $row_slider['slider_ID'] . ' ';
                                      echo $classActive =  $row_slider['slider_ID'] == $temp['slider_ID'] ? 'active' : "" ?>">

         <div class="container">
           <div class="w3l-space-banner">
             <div class="carousel-caption p-lg-5 p-sm-4 p-3">
               <p>
                 <?php echo $row_slider['slider_Caption1'] ?>
               </p>
               <h3 class="font-weight-bold pt-2 pb-lg-5 pb-4">
                 <?php echo $row_slider['captionHighlights'] ?>
               </h3>
               <a class="button2" href="?manager=ListCategory&id=<?php echo $row_slider['category_ID'] ?>">Shop Now </a>
             </div>
           </div>
         </div>
       </div>
     <?php
      }

      ?>

     <!-- <div class="carousel-item item2">
        <div class="container">
          <div class="w3l-space-banner">
            <div class="carousel-caption p-lg-5 p-sm-4 p-3">
              <p>advanced <span>Wireless</span> earbuds</p>
              <h3 class="font-weight-bold pt-2 pb-lg-5 pb-4">
                Best
                <span>Headphone</span>
              </h3>
              <a class="button2" href="product.html">Shop Now </a>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item item3">
        <div class="container">
          <div class="w3l-space-banner">
            <div class="carousel-caption p-lg-5 p-sm-4 p-3">
              <p>Get flat <span>10%</span> Cashback</p>
              <h3 class="font-weight-bold pt-2 pb-lg-5 pb-4">
                New
                <span>Standard</span>
              </h3>
              <a class="button2" href="product.html">Shop Now </a>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item item4">
        <div class="container">
          <div class="w3l-space-banner">
            <div class="carousel-caption p-lg-5 p-sm-4 p-3">
              <p>Get Now <span>40%</span> Discount</p>
              <h3 class="font-weight-bold pt-2 pb-lg-5 pb-4">
                Today <span>Discount</span>
              </h3>
              <a class="button2" href="product.html">Shop Now </a>
            </div>
          </div>
        </div>
      </div> -->
   </div>
   <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
     <span class="sr-only">Previous</span>
   </a>
   <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
     <span class="carousel-control-next-icon" aria-hidden="true"></span>
     <span class="sr-only">Next</span>
   </a>
 </div>
 <!-- //banner -->