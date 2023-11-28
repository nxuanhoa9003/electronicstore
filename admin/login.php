<?php
session_start();
include('../db/connect.php');
?>
<?php
$check = true;
$userName = "";
$passWord = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['btnLogin'])) {
        $userName = $_POST['username'];
        $passWord = $_POST['password'];
        if (!empty($userName) && !empty($passWord)) {
            $sql_select_Admin = mysqli_query($conn, "SELECT * FROM tableadmin WHERE username = '$userName' AND password = md5('$passWord') LIMIT 1");
            $row_admin = mysqli_fetch_assoc($sql_select_Admin);
            if (mysqli_num_rows($sql_select_Admin) > 0) {
                $adminInfo = array(
                    'username' => $row_admin['adminName']
                );
                $_SESSION['adminInfo'] = $adminInfo;
                header('location: ../admin/dashboard.php');
            } else {
                $check = false;
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link href="../css/fontawesome-all-v6.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="../css/loginadmin.css">

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-10 col-lg-6 col-md-8 login-box mx-auto">
                <div class="col-lg-12 login-user mt-3">
                    <i class="fa fa-user" aria-hidden="true"></i>
                </div>
                <div class="col-lg-12 login-title">
                    ADMIN PANEL
                </div>

                <div class="col-lg-12 login-form">
                    <div class="col-lg-12 login-form mb-5">
                        <form id="fromLogin" action="" method="post">
                            <div class="form-group">
                                <label class="form-control-label">Tên đăng nhập</label>
                                <input type="text" name="username" value="<?php if (!$check) echo $userName ?>" class="form-control">
                                <p class="px-3 mb-0 text-left messageError"></p>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Mật khẩu</label>
                                <input type="password" name="password" value="<?php if (!$check) echo $passWord ?>" class="form-control" i>
                                <p class="px-3 mb-0 text-left messageError"></p>
                            </div>

                            <div class="form-group mb-0">
                                <p class="px-3 mb-2 text-left messageError <?php if (!$check) echo "error" ?>">Tên đăng nhập hoặc mật khẩu sai</p>
                            </div>
                            <div class="form-group mb-0 d-flex justify-content-end">
                                <input type="submit" name="btnLogin" class="btn btn-outline-primary" value="Đăng Nhập" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/jquery-2.2.3.min.js"></script>
    <script src="./js/handleLogin.js"></script>
</body>

</html>