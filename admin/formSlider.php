<?php
include "../db/connect.php";
if (isset($_POST['btn'])) {
    if (isset($_POST['update']) and $_POST['btn'] == 'update') {

        $sliderID = $_POST['sliderID'];
        $sqlSelectSliders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM 	tableslider WHERE slider_ID = $sliderID"));
?>
        <form id="formSave" enctype="multipart/form-data">
            <div class="dropdown-divider my-4"></div>
            <div class="form-group">
                <ul class="list-group text-left" id="list-attb-Formadd">
                    <li class="list-group-item p-0">
                        <div class="form-group">
                            <label class="pl-2" for="attrib-1">Tiêu đề 1</label>
                            <input type="text" class="form-control attrib-input" id="attrib-1" name="attrib-1" value="<?php echo $sqlSelectSliders['slider_Caption1'] ?>" placeholder="Nhập tiêu đề thông tin" require="">
                        </div>
                    </li>
                    <li class="list-group-item p-0 mt-2">
                        <div class="form-group">
                            <label class="pl-2" for="attrib-2">Tiêu đề 2</label>
                            <input type="text" class="form-control attrib-input" id="attrib-2" name="attrib-2" value="<?php echo $sqlSelectSliders['slider_Caption2'] ?>" placeholder="Nhập tiêu đề thông tin" require="">
                        </div>
                    </li>

                    <li class="list-group-item p-0 mt-2">
                        <label for="">Chọn chữ nổi bật</label><br>
                        <div class="SelectTextHighLight">
                            <?php

                            $arrCaptionSlider =  explode(" ", $sqlSelectSliders['captionHighlights']);
                            $i = 0;
                            foreach ($arrCaptionSlider as $val) {
                                $i++;
                            ?>
                                <input type="checkbox" id="text<?php echo $i ?>" name="text<?php echo $i ?>" value="<?php echo $val ?>">
                                <label for="text<?php echo $i ?>"><?php echo $val ?></label><br>
                            <?php
                            }
                            ?>
                        </div>
                    </li>
                    <li class="list-group-item p-0 mt-2">
                        <div class="form-group">
                            <label class="pl-2" for="bcg">Chọn ảnh nền</label>
                            <input type="file" id="bcg" class="form-control attrib-input" name="myImage" accept="image/*" require="" />
                        </div>
                    </li>
                    <li class="list-group-item p-0 mt-2">
                        <select id="select-Category" class="custom-select">
                            <option selected>Chọn mặt hàng đính kèm</option>
                            <?php
                            $selectcategory = mysqli_query($conn, "SELECT * FROM tablecatrgory");
                            while ($row = mysqli_fetch_assoc($selectcategory)) {
                            ?>
                                <option value="<?php echo $row['categoryID'] ?>"><?php echo $row['categoryName'] ?></option>

                            <?php
                            }
                            ?>
                        </select>
                    </li>

                </ul>
            </div>
            <div class="form-group text-left ">
                <input type="submit" class="btn btn-primary" id="btnSave" name="btnSave" value="Lưu poster" />
            </div>
        </form>
    <?php
    } elseif (isset($_POST['btn'])) {
    ?>
        <form id="formSave" enctype="multipart/form-data">
            <div class="dropdown-divider my-4"></div>
            <div class="form-group">
                <ul class="list-group text-left" id="list-attb-Formadd">
                    <li class="list-group-item p-0">
                        <div class="form-group">
                            <label class="pl-2" for="attrib-1">Tiêu đề 1</label>
                            <input type="text" class="form-control attrib-input" id="attrib-1" name="attrib-1" value="" placeholder="Nhập tiêu đề thông tin" require="">
                        </div>
                    </li>
                    <li class="list-group-item p-0 mt-2">
                        <div class="form-group">
                            <label class="pl-2" for="attrib-2">Tiêu đề 2</label>
                            <input type="text" class="form-control attrib-input" id="attrib-2" name="attrib-2" value="" placeholder="Nhập tiêu đề thông tin" require="">
                        </div>
                    </li>

                    <li class="list-group-item p-0 mt-2">
                        <label for="">Chọn chữ nổi bật</label><br>
                        <div class="SelectTextHighLight">
                        </div>
                    </li>
                    <li class="list-group-item p-0 mt-2">
                        <div class="form-group">
                            <label class="pl-2" for="bcg">Chọn ảnh nền</label>
                            <input type="file" id="bcg" class="form-control attrib-input" name="myImage" accept="image/*" require="" />
                        </div>
                    </li>
                    <li class="list-group-item p-0 mt-2">
                        <select id="select-Category" class="custom-select">
                            <option selected>Chọn mặt hàng đính kèm</option>
                            <?php
                            $selectcategory = mysqli_query($conn, "SELECT * FROM tablecatrgory");
                            while ($row = mysqli_fetch_assoc($selectcategory)) {
                            ?>
                                <option value="<?php echo $row['categoryID'] ?>"><?php echo $row['categoryName'] ?></option>

                            <?php
                            }
                            ?>
                        </select>
                    </li>

                </ul>
            </div>
            <div class="form-group text-left ">
                <input type="submit" class="btn btn-primary" id="btnSave" name="btnSave" value="Lưu poster" />
            </div>
        </form>
<?php
    }
}

?>