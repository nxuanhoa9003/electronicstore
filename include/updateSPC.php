<?php
include '../db/connect.php';
?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userCode = base64_decode($_POST['usercode']);

    // Thêm sản phẩm vào rỏ hàng 
    if (isset($_POST['submitAddSC'])) {

        // productID
        // productName
        // productPrice
        // productImage
        // productQuantity
        $categoryID = $_POST['categoryID'];
        $productID = $_POST['productID'];
        $productName = $_POST['productName'];
        $productPrice = $_POST['productPrice'];
        $productImage = $_POST['productImage'];
        $productQuantity = $_POST['productQuantity'];

        $sql_select_SC = mysqli_query($conn, "SELECT * FROM tableshoppingcart WHERE product_ID = '$productID' AND userCode = '$userCode'");
        $sql_select_SCTemp = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tableshoppingcart ORDER BY shoppingCart_id DESC  LIMIT 1"));
        $count_select_SC = mysqli_num_rows($sql_select_SC);
        $spcID = $sql_select_SCTemp['shoppingCart_id'];

        if ($spcID == null) {
            $spcID = 1;
        } else {
            $spcID++;;
        }
        if ($count_select_SC > 0) {
            // KHI SẢN PHẨM ĐÃ CÓ TRONG RỎ HÀNG
            $row_SCProduct = mysqli_fetch_array($sql_select_SC);
            $productQuantity = $row_SCProduct['productQuantity'];

            $productQuantity = $row_SCProduct['productQuantity'] + 1;
            $sql_querySC = "UPDATE tableshoppingcart SET productQuantity='$productQuantity', total = '$productPrice' * '$productQuantity' WHERE product_ID = '$productID' AND userCode = '$userCode'";
        } else {
            // KHI SẢN PHẨM CHƯA CÓ TRONG RỎ HÀNG
            $sql_querySC =  "INSERT INTO `tableshoppingcart`(`shoppingCart_id`, `category_ID`, `product_ID`, `userCode`, `productName`, `productPrice`, `productImage`, `productQuantity`) VALUES('$spcID', '$categoryID','$productID', '$userCode', '$productName', '$productPrice', '$productImage', '$productQuantity')";
        }

        $sql_ShoppingCart = mysqli_query($conn, $sql_querySC);


        if ($count_select_SC <= 1) {
            // KHI SẢN PHẨM CHƯA CÓ TRONG RỎ HÀNG
            $sql_updateTotal = "UPDATE tableshoppingcart SET total = '$productPrice' * '$productQuantity' WHERE product_ID= '$productID' AND userCode = '$userCode'";
            $sql_ShoppingCart = mysqli_query($conn, $sql_updateTotal);
        }


        if ($sql_ShoppingCart == 0) {
            echo 'BỊ LỖI';
            header('location:index.php?manager=detailProduct&id=' . $categoryID . '&idProduct=' . $productID);
        }
    }



    // update amount product in shopping cart 
    if (isset($_POST['idProcduct']) && isset($_POST['btnAct']) && isset($_POST['productQuantity'])) {
        $IDPrd = $_POST['idProcduct'];
        $rowSPC = mysqli_fetch_assoc(mysqli_query($conn, "SELECT productQuantity FROM tableshoppingcart WHERE product_ID = '$IDPrd' AND userCode = '$userCode'"));

        $PrdQTT = $rowSPC['productQuantity'];
        $PrdPR = $_POST['price'];

        if ($_POST['btnAct'] === 'increase') {
            ++$PrdQTT;
        } elseif ($_POST['btnAct'] === 'decrease') {
            $PrdQTT = ($PrdQTT <= 1) ? 1 : --$PrdQTT;
        }

        $_SESSION['SPC'][$IDPrd]['amount'] = $PrdQTT;

        $sql_qr_up = "UPDATE tableshoppingcart SET productQuantity='$PrdQTT', total = '$PrdPR' * '$PrdQTT' WHERE product_ID = '$IDPrd' AND userCode = '$userCode'";
        $sql_update_QTT_SPcart = mysqli_query($conn, $sql_qr_up);
    }


    // delete product in shopping cart
    if (isset($_POST['IsBtnDelete']) && !empty($_POST['IsBtnDelete']) && isset($_POST['idProcduct'])) {
        $IDPRDELETE = $_POST['idProcduct'];
        $sql_qr_dele = "DELETE FROM tableshoppingcart WHERE product_ID = '$IDPRDELETE' AND userCode = '$userCode'";
        $sql_Delete_Product_SPcart = mysqli_query($conn, $sql_qr_dele);
    }
}


    // foreach ($_POST as $key => $value) {
    //     echo $key . '=' . $value . '<br />';
    // }
