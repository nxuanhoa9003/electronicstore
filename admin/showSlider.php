<?php
include "../db/connect.php";
$selectText = null;
$selectValue = null;
$rowSlider = null;
if (isset($_POST['selectPoster'])) {
    if ($_POST['selectPosterValue'] > 0) {
        $selectText = $_POST['selectPosterText'];
        $selectValue = $_POST['selectPosterValue'];
        $rowSlider = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tableslider WHERE slider_ID = $selectValue"));
        $isActive = $rowSlider['slider_Active'];
    }
}


if (isset($_POST['selectPoster'])) {
    if ($selectValue > 0) {
        $style = "background-image: url('../uploads/" . $rowSlider['slider_Image'] . "')";
?>
        <div class="carousel-item item3 item_temp active" style="<?php echo $style ?>">
            <div class="container">
                <div class="w3l-space-banner">
                    <div class="carousel-caption p-lg-5 p-sm-4 p-3">
                        <p><?php echo $rowSlider['slider_Caption1'] ?></p>
                        <h3 class="font-weight-bold pt-2 pb-lg-5 pb-4">
                            <?php echo $rowSlider['captionHighlights'] ?>
                        </h3>
                        <a class="button2" href="#">Shop Now </a>
                    </div>
                </div>
            </div>
        </div>

        <form id="formchange" action="">
            <div class="form-group text-left mt-3">
                <input type="submit" class="btn btn-primary" id="btnAddNew" name="update" value="Cập nhật" />
                <input type="submit" class="btn btn-primary" id="btnDelete" name="delete" value="Xoá" />
                <?php
                if ($isActive) {
                ?>
                    <input type="submit" class="btn btn-primary float-right" id="btnActive" data-name="hide" name="isactive" value="Ẩn" />
                <?php
                } else {
                ?>
                    <input type="submit" class="btn btn-primary float-right" id="btnActive" data-name="show" name="isactive" value="Hiện" />
                <?php
                }
                ?>
            </div>
        </form>

<?php
    }
}
?>