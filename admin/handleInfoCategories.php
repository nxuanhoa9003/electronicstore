<?php

include('../db/connect.php');
?>

<?php
function handleColumnTable($connect = null, $idCategory = null, $strDataAttrbs = null, $typebtn = 'add')
{
    $sql_queryTblNameID = mysqli_fetch_assoc(mysqli_query($connect, "SELECT TableName FROM tablecatrgory WHERE categoryID = '$idCategory'"));
    $NameTbl = $sql_queryTblNameID['TableName'];
    $arrColumnData = explode('--', $strDataAttrbs);

    if ($typebtn == 'update' || $typebtn == 'delete') {
        mysqli_query($connect, "CREATE TABLE {$NameTbl}_copy AS SELECT product_ID FROM $NameTbl");
        mysqli_query($connect, "DROP TABLE IF EXISTS `$NameTbl`");
        mysqli_query($connect, "ALTER TABLE {$NameTbl}_copy RENAME TO $NameTbl");
        mysqli_query($connect, "ALTER TABLE $NameTbl ADD PRIMARY KEY (product_ID)");
    }

    if ($typebtn == 'update' || $typebtn == 'add') {
        echo "count = " . count($arrColumnData) . '<br />';
        for ($i = 0; $i < count($arrColumnData); $i++) {
            $ord = $i + 1;
            mysqli_query($connect, "ALTER TABLE $NameTbl ADD columnData_{$ord} varchar(100) NOT NULL");
        }
        mysqli_query($connect, "ALTER TABLE $NameTbl ADD image_1 varchar(100) NOT NULL");
        mysqli_query($connect, "ALTER TABLE $NameTbl ADD image_2 varchar(100) NOT NULL");
        mysqli_query($connect, "ALTER TABLE $NameTbl ADD image_3 varchar(100) NOT NULL");
        // print_r($arrColumnData);
    }
}

if (isset($_POST['btnAddNew']) && $_POST['btnAddNew'] == 'true') {
    $dataAttrbts = $_POST['arrdata'];
    $idCategoryAddInfo = $_POST['IdCategory'];
    $sql_InsertDataTblInfoCtgr = mysqli_query($conn, "INSERT INTO `tableattributescategory`(`orderID`, `categoryID`, `attributeName`) VALUES ('$idCategoryAddInfo','$idCategoryAddInfo','$dataAttrbts')");
} else if (isset($_POST['btnUpdate']) && $_POST['btnUpdate'] == 'true') {
    $dataAttrbts = $_POST['arrdata'];
    $idCategoryAddInfo = $_POST['IdCategory'];
    if (!empty($dataAttrbts)) {
        $sql_UpdateDataTblInfoCtgr = mysqli_query($conn, "UPDATE `tableattributescategory` SET `attributeName`=  '$dataAttrbts' WHERE `categoryID` = '$idCategoryAddInfo'");
    }
} else if (isset($_POST['btnDelete']) && $_POST['btnDelete'] == 'true') {
    $idElement = $_POST['idElement'];
    $sql_DeleteDataTblInfoCtgr = mysqli_query($conn, "DELETE FROM `tableattributescategory` WHERE `categoryID` = '$idElement'");
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
            <h2>Thông tin danh mục</h2>
        </div>
        <div class="row g-0">
            <div class="col-12 col-md-12 col-lg-4 content_firstLeft">
                <div class="p-1 mb-2">
                    <h4 class="titleContentForm">Thêm thông tin danh mục</h4>
                </div>

                <!-- option tag -->
                <div class="form-group form-select-wrap active">
                    <select id="selecElementParent" class="col custom-select form-select-lg" aria-label="form-select-lg example">
                        <option selected>Chọn loại danh mục cần thêm</option>
                        <?php
                        $sql_selectCategories = mysqli_query($conn, "SELECT * FROM tablecatrgory");
                        while ($sql_rowResultCategories = mysqli_fetch_array($sql_selectCategories)) {
                        ?>
                            <option value="<?php echo $sql_rowResultCategories['categoryID'] ?>"><?php echo $sql_rowResultCategories['categoryName'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <p class="px-3 text-left messageError">Chưa chọn loại danh mục</p>
                </div>
                <!-- option tag -->

                <div class="form-group containerForm">
                </div>


            </div>
            <div class="col-lg-8 mt-5 mt-lg-0">
                <div class="p-1">
                    <h4>Danh sách thông tin danh mục</h4>
                </div>

                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Thứ tự</th>
                                <th colspan="2" scope="col">Tên danh mục</th>
                                <th colspan="2" scope="col">Thông tin danh mục</th>
                                <th scope="col">Chỉnh sửa</th>
                            </tr>
                        </thead>
                        <tbody class="TableBodyListElements">
                            <?php
                            $sql_selectCategory = mysqli_query($conn, 'SELECT * from tablecatrgory INNER JOIN tableattributescategory ON tablecatrgory.categoryID = tableattributescategory.categoryID ORDER BY tablecatrgory.categoryID ASC');
                            while ($row_Categories = mysqli_fetch_array($sql_selectCategory)) {
                            ?>
                                <tr class="rowElement">
                                    <th class="align-middle orderElement" scope="row">1</th>
                                    <td class="align-middle" colspan="2">
                                        <div class="text-left elementNameValue">
                                            <?php echo $row_Categories['categoryName'] ?>
                                        </div>
                                    </td>
                                    <td class="align-middle" colspan="2">
                                        <ul class="list-group list_infoCtg text-left">
                                            <?php
                                            if (!empty($row_Categories['attributeName'])) {
                                                $dataAttributes = $row_Categories['attributeName'];
                                                $arrAttributes = explode("--", $dataAttributes);
                                                foreach ($arrAttributes as $key => $value) {
                                                    echo '<li class="list-group-item">' . '<span class="mr-1">' . ($key + 1) . '</span>' . ': ' . $value . '</li>';
                                                }
                                            }
                                            ?>
                                        </ul>

                                    </td>
                                    <td class="align-middle">
                                        <form class="formChangeEachElement">
                                            <div class="row d-grid m-0">
                                                <div class="col-12">
                                                    <input type="submit" data-inputName="update" name="btnUpdate" value="Cập nhập" class="col text-center btn btn-primary btn-full" placeholder="Server" aria-label="Server">
                                                    <input type="hidden" name="idElement" class="idElementUpdate" value="<?php echo $row_Categories['categoryID'] ?>">
                                                    <input type="hidden" name="statusBtn" value="" class="statusBtn">
                                                    <input type="hidden" name="elementName" class="ElementNameUpdate" value="<?php echo $row_Categories['categoryName'] ?>">
                                                </div>
                                                <div class="col m-2"></div>
                                                <div class="col-12">
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
    <script src="./js/handleFormAjaxInfoCategory.js"></script>
    <script src="./js/handleMenu.js"></script>
</body>

</html>