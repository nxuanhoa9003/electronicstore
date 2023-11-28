<?php
session_start();

if (!isset($_SESSION['adminInfo']['username'])) {
    header('location: ../admin/login.php');
}

if (isset($_GET['status']) && $_GET['status'] == 'logout') {
    unset($_SESSION['adminInfo']['username']);
    header('location: ../admin/login.php');
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

</head>

<body>
    <?php include '../admin/adminMenu.php' ?>

    <script src="../js/jquery-2.2.3.min.js"></script>
    <script src="../js/bootstrap.js"></script>
</body>

</html>