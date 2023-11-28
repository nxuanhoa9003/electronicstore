<?php
include('../db/connect.php');

?>

<?php
$StrTitleInfo = "";
$path = '../uploads/';

// select id after render title information
if (isset($_POST['idselect'])) {
    $IDElementBig = $_POST['idselect']; // id category
    $sql_queryGetInfoTitleElement = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `tableattributescategory` WHERE `categoryID`='$IDElementBig'"));
    $StrTitleInfo = $sql_queryGetInfoTitleElement['attributeName'];
    if (!empty($StrTitleInfo)) {
        $StrTitleInfo = "Tên sản phẩm--Giá sản phẩm--Phần trăm giảm giá--Số lượng sản phẩm--" . $StrTitleInfo;
    }
    setcookie("data", $StrTitleInfo, time() + 60);
}

if (isset($_POST['statusBtn'])) {
    if ($_POST['statusBtn'] == 'update' && !empty($_POST['idElementUpdate'])) {
        $idElementUpdate = $_POST['idElementUpdate'];
        $idElementBig = $_POST['idTypeCategory'];

        $sql_queryGetInfoTitleElement = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `tableattributescategory` WHERE `categoryID`='$idElementBig'"));

        $dataTitle = "Tên sản phẩm--Giá sản phẩm--Phần trăm giảm giá--Số lượng sản phẩm--" . $sql_queryGetInfoTitleElement['attributeName'] . "--Tải ảnh sản phẩm 1--Tải ảnh sản phẩm 2--Tải ảnh sản phẩm 3";

        $sql_queryGetDataElement = mysqli_fetch_assoc(mysqli_query($conn, "SELECT product_Name, product_Price, percent_discounted, product_Quatity, detailProduct, image_1, image_2, image_3
                                                                        FROM `tableproducts` WHERE product_ID  = $idElementUpdate AND category_ID = '$idElementBig'"));
        $arrData = array();
        foreach ($sql_queryGetDataElement as $key => $value) {
            if ($key == 'detailProduct') {
                $temps = explode("\\---\\", $value);
                foreach ($temps as $temp) {
                    $arrData[] = $temp;
                }
            } else {
                $arrData[] = $value;
            }
        }

        $strData = implode("|--|", $arrData);
        echo $strData;
        setcookie("data1", $dataTitle,  time() + 86400);
        setcookie("data2", $strData,  time() + 86400);
    }
}



if (isset($_POST['btnAddNew']) && $_POST['statusBtn'] == 'add') {
    $Name = $_POST['attrib-1'];
    $Price = $_POST['attrib-2'];
    $PercentDiscount = $_POST['attrib-3'];
    $Quantity = $_POST['attrib-4'];

    $IdCategory = $_POST['IdCategory'];

    $image1 = $_FILES['image-1']['name'];
    $image1_tmp = $_FILES['image-1']['tmp_name'];
    $image2 = $_FILES['image-2']['name'];
    $image2_tmp = $_FILES['image-2']['tmp_name'];
    $image3 = $_FILES['image-3']['name'];
    $image3_tmp = $_FILES['image-3']['tmp_name'];


    $remainingAttributes = preg_grep('/^attrib-([5-9]\d*|\d{2,})$/', array_keys($_POST));

    $strdataColumns = array_reduce($remainingAttributes, function ($prev, $item) {
        return $prev .  "{$_POST[$item]},";
    }, '');
    var_dump($strdataColumns);

    $strdataColumns = trim($strdataColumns, ",");
    $strdataColumns = explode(",", $strdataColumns);
    $strdataColumns = addslashes(implode("\\---\\", $strdataColumns));

    $rowcountTblPrd = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tableproducts"));
    $strqueryTblPrd = "";
    $idPrdtblDt = 0;

    if ($rowcountTblPrd >= 1) {
        $rowcountTblPrd++;
        $sql_queryPrdLast =  mysqli_query($conn, "SELECT * FROM `tableproducts` ORDER BY `product_ID` DESC LIMIT 1");
        $sql_ResultPrdLast = mysqli_fetch_assoc($sql_queryPrdLast);
        $idPrdtblDt = $sql_ResultPrdLast['product_ID'] + 1;
        $strqueryTblPrd = "INSERT INTO `tableproducts`(`product_ID`, `category_ID`, `product_Name`, `product_Price`, `percent_discounted`, `product_Active`, `product_Hot`, `product_Quatity`, `detailProduct`,  `image_1`, `image_2`, `image_3`) 
                                        VALUES        ('$idPrdtblDt',  '$IdCategory', '$Name',        ' $Price',       '$PercentDiscount',   '1',              '0',           ' $Quantity',    '$strdataColumns', '$image1','$image2', '$image3')";
    } else {
        $idPrdtblDt = 1;
        $strqueryTblPrd = "INSERT INTO `tableproducts`(`product_ID`,  `category_ID`, `product_Name`, `product_Price`, `percent_discounted`, `product_Active`, `product_Hot`, `product_Quatity`, `detailProduct`, `image_1`, `image_2`, `image_3`) 
                                        VALUES        ('$idPrdtblDt', '$IdCategory', '$Name',        ' $Price',       '$PercentDiscount',   '1',              '0',           ' $Quantity',      '$strdataColumns','$image1','$image2', '$image3')";
    }

    $product_PromotionalPrice =  $Price - ($Price * ($PercentDiscount / 100));
    if (!empty($strqueryTblPrd)) {
        $sql_InserTblProduct = mysqli_query($conn, $strqueryTblPrd);
        mysqli_query($conn, "UPDATE tableproducts SET product_PromotionalPrice = $product_PromotionalPrice WHERE product_ID = $idPrdtblDt");

        move_uploaded_file($image1_tmp, $path . $image1);
        move_uploaded_file($image2_tmp, $path . $image2);
        move_uploaded_file($image3_tmp, $path . $image3);
    }
} else if (isset($_POST['btnUpdate']) && $_POST['btnUpdate'] == 'true') {

    $Name = $_POST['attrib-1'];
    $Price = $_POST['attrib-2'];
    $PercentDiscount = $_POST['attrib-3'];
    $Quantity = $_POST['attrib-4'];

    $IdCategory = $_POST['IdCategory'];
    $idElementUpdate = $_POST['idElementUpdate'];

    $remainingAttributes = preg_grep('/^attrib-([5-9]\d*|\d{2,})$/', array_keys($_POST));

    $strdataColumns = array_reduce($remainingAttributes, function ($prev, $item) {
        return $prev .  "{$_POST[$item]},";
    }, '');
    $strdataColumns = trim($strdataColumns, ",");
    $strdataColumns = explode(",", $strdataColumns);
    $strdataColumns = addslashes(implode("\\---\\", $strdataColumns));

    $image1 = $image1_tmp = $image2 = $image2_tmp = $image3 = $image3_tmp = null;
    $numberImage = null;

    if ($_FILES['image-1']['error'] == 4 || ($_FILES['image-1']['size'] == 0 && $_FILES['image-1']['error'] == 0)) {
        $sql_queryImg = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image_1 FROM tableproducts WHERE product_ID = $idElementUpdate"));
        $image1 = $sql_queryImg['image_1'];
    } else {
        $numberImage = 1;
        $image1 = $_FILES['image-1']['name'];
        $image1_tmp = $_FILES['image-1']['tmp_name'];
    }

    if ($_FILES['image-2']['error'] == 4 || ($_FILES['image-2']['size'] == 0 && $_FILES['image-2']['error'] == 0)) {
        $sql_queryImg = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image_2 FROM tableproducts WHERE product_ID = $idElementUpdate"));
        $image2 = $sql_queryImg['image_2'];
    } else {
        $numberImage = 2;
        $image2 = $_FILES['image-2']['name'];
        $image2_tmp = $_FILES['image-2']['tmp_name'];
    }

    if ($_FILES['image-3']['error'] == 4 || ($_FILES['image-3']['size'] == 0 && $_FILES['image-3']['error'] == 0)) {
        $sql_queryImg = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image_3 FROM tableproducts WHERE product_ID = $idElementUpdate"));
        $image3 = $sql_queryImg['image_3'];
    } else {
        $numberImage = 3;
        $image3 = $_FILES['image-3']['name'];
        $image3_tmp = $_FILES['image-3']['tmp_name'];
    }


    $sql_deleteRowData = mysqli_query($conn, "DELETE FROM tableproducts WHERE product_ID = $idElementUpdate");
    if ($sql_deleteRowData) {
        $strqueryTblPrd = "INSERT INTO `tableproducts`(`product_ID`, `category_ID`, `product_Name`, `product_Price`, `percent_discounted`, `product_Active`, `product_Hot`, `product_Quatity`, `detailProduct`,  `image_1`, `image_2`, `image_3`) 
                                        VALUES  ('$idElementUpdate',  '$IdCategory', '$Name',        ' $Price',       '$PercentDiscount',   '1',              '0',           ' $Quantity',    '$strdataColumns', '$image1','$image2', '$image3')";

        $sql_InserTblProduct = mysqli_query($conn, $strqueryTblPrd);

        switch ($numberImage) {
            case 1:
                move_uploaded_file($image1_tmp, $path . $image1);
                break;
            case 2:
                move_uploaded_file($image2_tmp, $path . $image2);
                break;
            case 3:
                move_uploaded_file($image3_tmp, $path . $image3);
                break;
        }

        $product_PromotionalPrice =  $Price - ($Price * ($PercentDiscount / 100));
        mysqli_query($conn, "UPDATE tableproducts SET product_PromotionalPrice = $product_PromotionalPrice WHERE product_ID = $idElementUpdate");
    }
} else if (isset($_POST['btnDelete']) && $_POST['btnDelete'] == 'true') {
    $idElementDelete = $_POST['idElementUpdate'];
    $IdCategory = $_POST['idTypeCategory'];

    $sqlqueryImg = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image_1, image_2, image_3 FROM tableproducts WHERE product_ID = $idElementDelete AND 	category_ID = '$IdCategory'"));
    $Img_1 = $sqlqueryImg['image_1'];
    $Img_2 = $sqlqueryImg['image_2'];
    $Img_3 = $sqlqueryImg['image_3'];
    $sql_DeleteDataTblInfoCtgr = mysqli_query($conn, "DELETE FROM `tableproducts` WHERE product_ID = $idElementDelete");
    unlink($path . $Img_1);
    unlink($path . $Img_2);
    unlink($path . $Img_3);
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link href="../css/fontawesome-all-v6.css" rel="stylesheet" type="text/css" media="all" />
    <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
    <style>
        .form-control[readonly] {
            background-color: unset;
            border: none;
        }

        .list-group-item {
            border: none;
        }
    </style>
</head>



<body>
    <?php include '../admin/dashboard.php' ?>

    <div class="container pageadmin text-center mt-5">
        <div class="p-3">
            <h2>Quản lý sản phẩm</h2>
        </div>
        <div class="row g-0 col-12">
            <div class="col-12 content_firstLeft">
                <div class="p-1 mb-3">
                    <h4 class="titleContentForm">Thêm sản phẩm mới</h4>
                </div>
                <!-- option tag -->
                <div class="form-group form-select-wrap active">
                    <form id="form-select" method="" action="">

                        <select id="selecElementParent" class="col custom-select form-select-lg" aria-label="form-select-lg example">
                            <option selected>Chọn loại sản phẩm cần thêm</option>
                            <?php
                            $sql_selectCategories = mysqli_query($conn, "SELECT * FROM tablecatrgory");
                            while ($sql_rowResultCategories = mysqli_fetch_array($sql_selectCategories)) {
                            ?>
                                <option value="<?php echo $sql_rowResultCategories['categoryID'] ?>"><?php echo $sql_rowResultCategories['categoryName'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <p class="px-3 text-left messageError">Chưa chọn loại sản phẩm</p>

                        <div>
                            <input type="hidden" class="idselect" name="idselect" value="">
                            <input class="col btn btn-secondary mt-3" type="submit" value="Chọn" />
                        </div>
                    </form>

                </div>
                <div class="desc">
                    <p>Điền thông tin sản phẩm</p>
                </div>

                <!-- option tag -->
                <div class="form-group containerForm">
                    <!-- <form id="formAdd" method="post" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <ul class="list-group text-left" id="list-attb-Formadd">
                                <li class="list-group-item p-0">
                                    <div class="form-group">
                                        <label class="pl-2" for="attrib-1">Email address</label>
                                        <input type="text" class="form-control attrib-input" id="attrib-1" name="attrib-1" value="" placeholder="Nhập tiêu đề thông tin">

                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="form-group text-left ">
                            <input type="hidden" name="IdCategory" value="" />
                            <input type="submit" class="btn btn-primary" id="btnAddNew" name="btnAddNew" value="Lưu thông tin" />
                        </div>
                    </form> -->
                </div>


            </div>
            <div class="col-12 mt-5">
                <div class="p-1">
                    <h4>Danh sách sản phẩm</h4>
                </div>

                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Thứ tự</th>
                                <th colspan="2" scope="col">Tên sản phẩm</th>
                                <th colspan="1" scope="col">Loại sản phẩm</th>
                                <th colspan="1" scope="col">Giá</th>
                                <th colspan="1" scope="col">Ảnh</th>
                                <!-- <th colspan="1" scope="col">Ngày đăng bán</th> -->
                                <th colspan="1" scope="col">Chỉnh sửa</th>
                            </tr>
                        </thead>
                        <tbody class="TableBodyListElements">
                            <?php
                            $sql_selectProducts = mysqli_query($conn, "SELECT `tableproducts`.`product_ID`, `tableproducts`.`product_Name`, `tableproducts`.`category_ID`, `tableproducts`.`product_Price`, `tableproducts`.`image_1`,  `tablecatrgory`.`categoryName` 
                                                                        FROM `tableproducts`, `tablecatrgory` 
                                                                        WHERE `tableproducts`.`category_ID` = `tablecatrgory`.`categoryID`");
                            while ($row_Products = mysqli_fetch_array($sql_selectProducts)) {
                            ?>
                                <tr class="rowElement">
                                    <th class="align-middle orderElement text-center" scope="row">1</th>
                                    <td class="align-middle w-25" colspan="2">
                                        <div class="text-left elementNameValue">
                                            <?php echo $row_Products['product_Name'] ?>
                                        </div>
                                    </td>
                                    <td class="w-25">
                                        <div class="text-center TypeCategory">
                                            <?php echo $row_Products['categoryName'] ?>
                                        </div>
                                    </td>
                                    <td class="w-25">
                                        <div class="text-center Product_price">
                                            <?php echo number_format($row_Products['product_Price'], 0, '.', '.') . 'đ' ?>
                                        </div>
                                    </td>
                                    <td class="w-25">
                                        <div class="text-center Product_img">
                                            <image class="img-thumbnail" style="border-style: none" src=<?php
                                                                                                        if (file_exists("../images/{$row_Products['image_1']}")) {
                                                                                                            echo "\"../images/{$row_Products['image_1']}\"";
                                                                                                        } else if (file_exists("../uploads/{$row_Products['image_1']}")) {
                                                                                                            echo "\"../uploads/{$row_Products['image_1']}\"";
                                                                                                        }
                                                                                                        ?> alt="" />
                                        </div>
                                    </td>
                                    <!-- <td class="w-25">
                                        <div class="text-left">
                                            20/10/2023
                                        </div>
                                    </td> -->
                                    <td class="align-middle w-50">
                                        <form class="formChangeEachElement">
                                            <div class="row row-cols-2 d-grid m-0">
                                                <div class="col-12">
                                                    <input type="submit" data-inputName="update" name="btnUpdate" value="Cập nhập" class="d-block w-100 text-center btn btn-primary btn-full" placeholder="Server" aria-label="Server">
                                                    <input type="hidden" name="idElementUpdate" class="idElementUpdate" value="<?php echo $row_Products['product_ID'] ?>">
                                                    <input type="hidden" name="idTypeCategory" class="idTypeCategory" value="<?php echo $row_Products['category_ID'] ?>">
                                                    <input type="hidden" name="statusBtn" value="" class="statusBtn">
                                                    <input type="hidden" name="elementName" class="ElementNameUpdate" value="<?php echo $row_Products['categoryName'] ?>">
                                                </div>
                                                <div class="col-12 m-2"></div>

                                                <div class="col-12">
                                                    <input type="submit" data-inputName="delete" name="btnDelete" value="Xoá" class="d-block w-100 text-center btn btn-secondary" placeholder="Username" aria-label="Username">
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script src="../js/jquery-2.2.3.min.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="./js/handleFormAjaxProduct.js"></script>
    <script src="./js/handleMenu.js"></script>



    <script type="text/javascript">

    </script>
</body>


</html>