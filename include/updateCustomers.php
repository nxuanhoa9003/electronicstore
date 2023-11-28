<?php
session_start();
include '../db/connect.php';
?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['pay'])) {
        $CustomName = $_POST['fullname'];
        $NumberPhone = $_POST['numberphone'];
        $Email = $_POST['email'];
        $Address = $_POST['address'];
        $Note = $_POST['note'];
        $ModePay = $_POST['modePay'];

        $usercode = base64_decode($_COOKIE['usercode']);


        $rowTblCustomer = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tablecustomer ORDER BY customerID DESC LIMIT 1"));
        $idLastTblCustomer = '';
        if (!empty($rowTblCustomer['customerID'])) {
            $idLastTblCustomer = $rowTblCustomer['customerID'] + 1;
        } else {
            $idLastTblCustomer = 1;
        }

        $sql_queryCustomer = null;
        if ($idLastTblCustomer < 1) {
            $sql_queryCustomer = "INSERT INTO `tablecustomer`(`customerID`, `userCode` , `FullName`, `NumberPhone`, `Email`, `Address`, `Note`, `ModePay`) VALUES ($idLastTblCustomer, '$usercode', '$CustomName','$NumberPhone','$Email','$Address','$Note','$ModePay')";
        } else {
            $sql_queryCustomer = "INSERT INTO `tablecustomer`(`customerID`, `userCode`, `FullName`, `NumberPhone`, `Email`, `Address`, `Note`, `ModePay`) VALUES ('$idLastTblCustomer', '$usercode' ,'$CustomName','$NumberPhone','$Email','$Address','$Note','$ModePay')";
        }
        $sql_Customer = mysqli_query($conn, $sql_queryCustomer);

        if ($sql_Customer) {
            $sql_select_Cutomer = mysqli_query($conn, "SELECT * FROM tablecustomer ORDER BY customerID DESC LIMIT 1");
            $row_Customer = mysqli_fetch_array($sql_select_Cutomer);
            $CustomerID = $row_Customer['customerID'];
            $ItemCode = rand(0, 9999);

            // var_dump($_SESSION['SPC']);

            $sql_queryTblOrder = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tableorder ORDER BY orderID DESC LIMIT 1"));
            $IDOrderNew = null;
            if (!empty($sql_queryTblOrder['orderID'])) {
                $IDOrderNew = $sql_queryTblOrder['orderID'];
            } else {
                $IDOrderNew = 0;
            }

            foreach ($_SESSION['SPC'] as $key => $value) {
                $IDOrderNew++;
                $ProductID = $key;
                $ProductName = $value['name'];
                $Amount = $value['amount'];
                $Price = $value['price'];
                $sql_Product = mysqli_query($conn, "UPDATE tableproducts SET product_Quatity = product_Quatity - '$Amount' WHERE product_ID = '$ProductID'");
                $sql_Order = mysqli_query($conn, "INSERT INTO `tableorder`(`orderID`, `productID`, `productAmount`, `ItemCode`, `customerID`) VALUES ('$IDOrderNew', '$ProductID', '$Amount','$ItemCode', '$CustomerID')");
                $sql_Transaction = mysqli_query($conn, "INSERT INTO `tabletransaction`(`transaction_id`, `product_ID`, `productName`, `customerID`, `amount`, `productPrice` , `transactionCode`) VALUES ('$IDOrderNew', '$ProductID', '$ProductName', '$CustomerID','$Amount', '$Price','$ItemCode')");
                $sql_delete_payOrder = mysqli_query($conn, "DELETE FROM tableshoppingcart WHERE product_ID = '$ProductID'");
            }
        }
    }
}


    // foreach ($_POST as $key => $value) {
    //     echo $key . '=' . $value . '<br />';
    // }
