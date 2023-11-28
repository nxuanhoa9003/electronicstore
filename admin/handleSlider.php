<?php
include('../db/connect.php');
?>

<?php
$sqlSelectSliders = mysqli_query($conn, "SELECT * FROM 	tableslider");
$path = '../uploads/';
if (isset($_POST['issave'])) {
    $text1 = $_POST['attrib-1'];
    $text2 = $_POST['attrib-2'];
    $textHighLight = $_POST['strHightLight'];
    $categoryID = $_POST['selectCategory'];
    $bcg = $_FILES['myImage']['name'];
    $bcg_tmp = $_FILES['myImage']['tmp_name'];

    $SliderIndex = $_POST['SliderIndex'];

    if ($_POST['update']) {
        mysqli_query($conn, "UPDATE `tableslider`
                            SET slider_Image = '$bcg', slider_Caption1 = '$text1', slider_Caption2 = '$text2', captionHighlights = '$textHighLight', category_ID =  '$categoryID'
                            WHERE slider_ID = '$SliderIndex'");

        move_uploaded_file($bcg_tmp, $path . $bcg);
    } elseif ($_POST['add']) {
        $sqlSliders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tableslider ORDER BY slider_ID DESC LIMIT 1"));
        $sqlSliders = $sqlSliders['slider_ID'];
        if ($sqlSliders > 0) {
            $sqlSliders++;
        } else {
            $sqlSliders = 1;
        }
        mysqli_query($conn, "INSERT INTO `tableslider`(`slider_ID`, `slider_Image`, `slider_Caption1`, `slider_Caption2`, `captionHighlights`, category_ID) 
                                          VALUES      ('$sqlSliders','$bcg',         '$text1',           '$text2',          ' $textHighLight', '$categoryID') ");
        move_uploaded_file($bcg_tmp, $path . $bcg);
    }
}

if (isset($_POST['delete'])) {
    if ($_POST['btn'] == 'delete') {
        $SliderIndex = $_POST['sliderId'];
        $sqlSelecImgSliderdl =  mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM 	tableslider WHERE slider_ID = '$SliderIndex'"));
        $sqlSelecImgSliderdl = $sqlSelecImgSliderdl['slider_Image'];
        mysqli_query($conn, "DELETE FROM `tableslider` WHERE slider_ID = '$SliderIndex'");
        unlink($path . $sqlSelecImgSliderdl);
    }
}

if (isset($_POST['active'])) {
    if ($_POST['btn'] == 'active') {
        $SliderIndex = $_POST['sliderId'];
        $isAcitve = $_POST['isactive'];
        $sqlSelecImgSliderdl =  mysqli_query($conn, "UPDATE tableslider SET slider_Active = '$isAcitve' WHERE slider_ID = '$SliderIndex'");
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Admin</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
    <!-- set background image for slider -->
    <style>
        .carousel-item.item_temp {
            /* background: url('../images/b2.jpg') no-repeat center; */
            background-image: url('../uploads/b2.jpg');
            background-repeat: no-repeat;
            background-position: center;


            background-size: cover;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            -ms-background-size: cover;

        }

        .list-group-item {
            border: none !important;
        }

        .divparent {
            position: relative;
            top: 3.5em;
            margin-top: 2rem;
        }

        #formSave {
            margin-bottom: 100px;
        }
    </style>
</head>

<body>
    <?php include '../admin/dashboard.php' ?>

    <div class="container divparent">
        <div class="p-3 text-center">
            <h2>Poster</h2>
        </div>

        <form id="formSelectPoster" action="">
            <select id="selectPoster" class="custom-select">
                <option value="0">Chọn poster</option>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_assoc($sqlSelectSliders)) {
                    $i++;
                ?>
                    <option value="<?php echo $row['slider_ID'] ?>"><?php echo $i ?></option>

                <?php
                }
                ?>
            </select>
            <div class="form-group text-left mt-3">
                <input type="submit" class="btn btn-primary" id="show" name="show" value="Xem" />
            </div>

        </form>
        <div class="form-group text-left mt-3">
            <input type="submit" class="btn btn-primary" id="btnAdd" name="add" value="Thêm poster" />
        </div>

        <div class="carousel_wrap">
            <?php
            include "../admin/showSlider.php";
            ?>
        </div>


        <div class="form-group containerForm">
            <?php
            include "../admin/formSlider.php";
            ?>
        </div>



    </div>
    <script src="../js/jquery-2.2.3.min.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="./js/handleFormAjaxPoster.js"></script>
    <script src="./js/handleMenu.js"></script>

</body>

</html>