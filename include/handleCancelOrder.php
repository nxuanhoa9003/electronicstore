<?php
include '../db/connect.php';
?>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['rqCancle'])) {
        $CodeOrderCancel = $_POST['codeOrder'];
        $IdOrderCancel = $_POST['idOrder'];
        // update status order in table order 
        mysqli_query($conn, "UPDATE tableorder SET `status`= '3' WHERE orderID = '$IdOrderCancel' AND ItemCode = '$CodeOrderCancel'");
        setcookie('rqcc', 'true', time() + 30, "/"); // 86400 = 1 day
    }
}
?>