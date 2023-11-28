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
                setcookie("usr", base64_encode($keyLogin), time() + (86400 * 7), "/");
                setcookie("logged_in", "true", time() + 3600, "/");
                setcookie("usercode", base64_encode($row_user["userCode"]), time() + (86400 * 7), "/");
            } else {

                $checkpass = false;
            }
        } else {
            $checkUser = false;
        }
    }
}

?>

<!-- modals -->
<!-- log in -->

<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">Đăng nhập</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formLogin">
                    <div class="form-group <?php if (!$checkUser) echo "error" ?> ">
                        <label class="col-form-label">Email/Tên đăng nhập</label>
                        <input type="text" class="form-control" value="<?php echo $keyLogin ?>" placeholder="" name="loginKey" required="" />
                        <p class="px-3 mb-0 text-left messageError <?php if (!$checkUser) echo "error" ?>">Không tìm thấy tài khoản này</p>
                    </div>
                    <div class="form-group <?php if (!$checkpass) echo "error" ?>">
                        <label class="col-form-label">Password</label>
                        <input type="password" class="form-control" value="<?php echo $password ?>" placeholder="" name="password" required="" />
                        <p class="px-3 mb-0 text-left messageError <?php if (!$checkpass) echo "error" ?>">Sai mật khẩu</p>
                    </div>

                    <div class="sub-w3l">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" name="rememberacc" class="custom-control-input" id="customControlAutosizing" />
                            <label class="custom-control-label" for="customControlAutosizing">Ghi nhớ tôi</label>
                        </div>
                    </div>

                    <div class="right-w3l">
                        <input type="submit" class="form-control" value="Đăng nhập" />
                    </div>
                    <p class="text-center dont-do mt-3">
                        Bạn chưa có tài khoản?
                        <a href="#" data-toggle="modal" data-target="#registerModal">
                            Đăng ký ngay </a>
                    </p>
                </form>
            </div>
            <div class="wrap_loader">
                <div class="loader">
                    <div class="inner one"></div>
                    <div class="inner two"></div>
                    <div class="inner three"></div>
                </div>
            </div>

        </div>
    </div>
</div>