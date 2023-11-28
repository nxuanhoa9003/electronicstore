<?php
include('../db/connect.php');
?>

<?php

if (isset($_POST['btnAddNew']) && $_POST['btnAddNew'] == 'true') {
    $NewCategoryName = $_POST['InputValueNameElement'];
    $idCtgrInfo = null;
    if (!empty($NewCategoryName)) {
        $rowcount = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tablecatrgory"));
        if ($rowcount >= 1) {
            $rowcount++;
            $sql_queryCategoryLast =  mysqli_query($conn, "SELECT * FROM `tablecatrgory` ORDER BY `categoryID` DESC LIMIT 1");
            $sql_ResultCategoryLast = mysqli_fetch_assoc($sql_queryCategoryLast);
            $idCategoryNew = $sql_ResultCategoryLast['categoryID'] + 1;
            $idCtgrInfo =  $idCategoryNew;
            $sql_InsertCTGR = mysqli_query($conn, "INSERT INTO `tablecatrgory`(`categoryID`, `categoryName`) VALUES ('$idCategoryNew','$NewCategoryName')");
        } else {
            $idCtgrInfo =  1;
            $sql_InsertCTGR = mysqli_query($conn, "INSERT INTO `tablecatrgory`(`categoryID`, `categoryName`) VALUES ('$idCtgrInfo','$NewCategoryName')");
        }
        $sql_InsertInforTblCategr = mysqli_query($conn, "INSERT INTO `tableattributescategory`(`orderID`,`categoryID`) VALUES ('$idCtgrInfo', '$idCtgrInfo')");
    }
} else if (isset($_POST['btnUpdate'])) {
    $idCategoryUpdate = $_POST['inputIdElementUpdate'];
    $NewCategoryNameUpdate = $_POST['InputValueNameElement'];
    $sql_UpdateNewNameCategory = mysqli_query($conn, "UPDATE `tablecatrgory` SET categoryName = '$NewCategoryNameUpdate' WHERE categoryID = '$idCategoryUpdate'");
} else if (isset($_POST['btnDelete'])) {
    $idCategoryDelete = $_POST['idElement'];
    $sql_deleteCategory = mysqli_query($conn, "DELETE FROM `tablecatrgory` WHERE categoryID = '$idCategoryDelete'");
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />

    <style>
        .form-control[readonly] {
            background-color: unset;
            border: none;
        }
    </style>
</head>

<body>
    <?php include '../admin/dashboard.php' ?>


    <div class="container pageadmin text-center mt-5">
        <div class="p-3">
            <h2>Danh mục sản phẩm</h2>
        </div>
        <div class="row g-0">
            <div class="col-12 col-md-12 col-lg-4 content_firstLeft">
                <div class="p-1">
                    <h4>Thêm danh mục</h4>
                </div>

                <form id="formAdd">
                    <div class="form-group">
                        <input type="text" class="form-control" id="InputValueNameElement" name="InputValueNameElement" value="" placeholder="Nhập tên danh mục...">
                        <p class="px-3 text-left messageError">Đã có danh mục này</p>
                    </div>
                    <div class="form-group text-left ">
                        <input type="submit" class="btn btn-primary" id="btnAddNew" name="btnAddNew" value="Thêm danh mục" />
                    </div>
                </form>
            </div>
            <div class="col-lg-8 mt-5 mt-lg-0">
                <div class="p-1">
                    <h4>Danh sách danh mục</h4>
                </div>

                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Thứ tự</th>
                                <th colspan="2" scope="col">Tên danh mục</th>
                                <th scope="col">Chỉnh sửa</th>
                            </tr>
                        </thead>
                        <tbody class="TableBodyListElements">
                            <?php
                            $sql_selectCategory = mysqli_query($conn, 'SELECT * from tablecatrgory');
                            while ($row_Categories = mysqli_fetch_array($sql_selectCategory)) {
                            ?>
                                <tr class="rowElement">
                                    <th class="align-middle orderElement" scope="row">1</th>
                                    <td class="align-middle" colspan="2">
                                        <div class="text-left elementNameValue">
                                            <?php echo $row_Categories['categoryName'] ?>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <form class="formChangeEachElement">
                                            <div class="row d-grid m-0">
                                                <div class="col-md-6">
                                                    <input type="submit" data-inputName="update" name="btnUpdate" value="Cập nhập" class="col text-center btn btn-primary btn-full" placeholder="Server" aria-label="Server">
                                                    <input type="hidden" name="idElement" class="idElementUpdate" value="<?php echo $row_Categories['categoryID'] ?>">
                                                    <input type="hidden" name="statusBtn" value="" class="statusBtn">
                                                    <input type="hidden" name="elementName" class="ElementNameUpdate" value="<?php echo $row_Categories['categoryName'] ?>">
                                                </div>
                                                <div class="col my-2 m-md-0 d-md-none"></div>
                                                <div class="col-md-6">
                                                    <input type="submit" data-inputName="delete" name="btnDelete" value="Xoá" class="col text-center btn btn-secondary" placeholder="Username" aria-label="Username">
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
    <script src="./js/handleFormAjaxCategory.js"></script>
    <script src="./js/handleMenu.js"></script>
</body>

</html>