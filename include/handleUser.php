<?php
include __DIR__ . '/../db/connect.php';

?>

<?php
$checkpass = true;
$checkUser = true;
$keyLogin = "";
$password = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Login'])) {
        $keyLogin = $_POST['loginKey'];
        $password = $_POST['password'];
        $sql_select_UserExist = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tableuser WHERE (username = '$keyLogin' OR email = '$keyLogin') LIMIT 1"));
        if ($sql_select_UserExist != null) {
            $sql_select_UserInfo = mysqli_query($conn, "SELECT * FROM tableuser WHERE (username = '$keyLogin' OR email = '$keyLogin') AND password = md5('$password') LIMIT 1");
            $row_user = mysqli_fetch_assoc($sql_select_UserInfo);
            if (mysqli_num_rows($sql_select_UserInfo) > 0) {
                $_SESSION["keyLogin"] = $keyLogin;
                setcookie("logged_in", "true", time() + 3600, "/");
            } else {
                $checkpass = false;
            }
        } else {
            $checkUser = false;
        }
    }
}

?>