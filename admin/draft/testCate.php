<?php
include('../db/connect.php');
?>

<?php
if (isset($_POST['btnAddCategoryNew'])) {
    $NewCategoryName = $_POST['IpCtgrName'];
    if (!empty($NewCategoryName)) {
        $rowcount = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tablecatrgory"));
        $rowcount++;
        $sql_InsertCTGR = mysqli_query($conn, "INSERT INTO `tablecatrgory`(`categoryID`, `categoryName`) VALUES ('$rowcount','$NewCategoryName')");
    }
} else if (isset($_POST['btnUpdateCategoryNew'])) {
    $idCategoryUpdate = $_POST['idCategoryUpdate'];
    $NewCategoryNameUpdate = $_POST['IpCtgrName'];
    $sql_UpdateNewNameCategory = mysqli_query($conn, "UPDATE `tablecatrgory` SET categoryName = '$NewCategoryNameUpdate' WHERE categoryID = '$idCategoryUpdate'");
} else if (isset($_POST['btnDeleteCategory'])) {
    $idCategoryDelete = $_POST['idCategory'];
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
    <style>
        .form-control[readonly] {
            background-color: unset;
            border: none;
        }
    </style>
</head>

<body>
    <?php include '../admin/adminMenu.php' ?>

    <div class="container text-center m-5">
        <div class="p-3">
            <h2>DANH MỤC SẢN PHẨM</h2>
        </div>
        <div class="row g-0">
            <div class="col-12 col-md-12 col-lg-4 content-firstCategory">
                <div class="p-1">
                    <h4>Thêm danh mục</h4>
                </div>

                <form id="formAddCategory" action="">
                    <div class="form-group">
                        <input type="text" class="form-control" id="IpCtgrName" name="IpCtgrName" value="" placeholder="Nhập tên danh mục...">
                    </div>
                    <div class="form-group text-left ">
                        <input type="submit" class="btn btn-primary" id="btnAddCategoryNew" name="btnAddCategoryNew" value="Thêm danh mục" />
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
                        <tbody class="TableBodyListCategories">
                            <?php
                            $sql_selectCategory = mysqli_query($conn, 'SELECT * from tablecatrgory');
                            while ($row_Categories = mysqli_fetch_array($sql_selectCategory)) {
                            ?>
                                <tr class="rowCategories">
                                    <th class="align-middle orderCTGR" scope="row">1</th>
                                    <td class="align-middle" colspan="2">
                                        <div class="text-left InputCategoryName">
                                            <?php echo $row_Categories['categoryName'] ?>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <form class="formChangeEachCategory">
                                            <div class="row d-grid m-0">
                                                <div class="col-md-6">
                                                    <input type="submit" data-inputName="update" name="btnUpdateCategory" value="Cập nhập" class="col text-center btn btn-primary btn-full" placeholder="Server" aria-label="Server">
                                                    <input type="hidden" name="idCategory" class="idCategoryUPD" value="<?php echo $row_Categories['categoryID'] ?>">
                                                    <input type="hidden" name="statusBtn" value="" class="statusBtn">
                                                    <input type="hidden" name="CategoryName" class="CategoryNameUPD" value="<?php echo $row_Categories['categoryName'] ?>" class="CategoryName">
                                                </div>
                                                <div class="col m-2 m-md-0 d-md-none"></div>
                                                <div class="col-md-6">
                                                    <input type="submit" data-inputName="delete" name="btnDeleteCategory" value="Xoá" class="col text-center btn btn-secondary" placeholder="Username" aria-label="Username">
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
    <!-- <script src="./js/handleAjaxAdmin.js"></script> -->
    <script src="./js/test.js"></script>

</body>

</html>




<!-- bản cũ  -->