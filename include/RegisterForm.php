<?php
include __DIR__ . '/../db/connect.php';
?>

<?php
$username  = "";
$email = "";
$password = "";
$confirmPassword = "";
$checkUserName = -1;
$checkEmail = -1;
$checkPass = -1;
$checkRules = false;
$countCheck = 0;

if (isset($_POST["username"])) {

    if (!empty($_POST["username"])) {
        $username = $_POST["username"];
        $checkUserName = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tableuser WHERE username = '$username'"));
        $checkUserName === 0 && ++$countCheck;
    }
}
if (isset($_POST["email"])) {
    if (!empty($_POST["email"])) {
        $email = $_POST["email"];
        $checkEmail = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tableuser WHERE email = '$email'"));
        $checkEmail === 0 && ++$countCheck;
    }
}
if (isset($_POST["password"])) {
    if (!empty($_POST["password"])) {
        $password = $_POST["password"];
    }
    if (isset($_POST["confirmPassword"])) {
        if (!empty($_POST["confirmPassword"])) {
            $confirmPassword = $_POST["confirmPassword"];
            $checkPass = $password ===  $confirmPassword ? true : false;
            $checkPass === true && ++$countCheck;
        }
    }
}

if (isset($_POST["rules"])) {
    $checkRules = true;
    $checkRules === true && ++$countCheck;
}

if ($countCheck == 4) {
    // Insert new user to db;
    $selectLastID = mysqli_fetch_assoc(mysqli_query($conn, "SELECT userID FROM  tableuser ORDER BY userID DESC"));
    $ArrayUserCode = mysqli_fetch_all(mysqli_query($conn, "SELECT userCode FROM  tableuser"));
    $idNewUser =  $selectLastID['userID'] + 1;
    $userCode = rand(100, 1000);
    while (in_array($userCode, $ArrayUserCode)) {
        $userCode = rand(100, 1000);
    }
    $queryInsertNewUser = mysqli_query($conn, "INSERT INTO `tableuser`(`userID`, `username`, `email`, `password`, `userCode`)
                                                               VALUES ('$idNewUser', '$username', '$email', md5('" . $password . "'), '$userCode')");
    if ($queryInsertNewUser) {
        setcookie("register", "success", time() + 3600, "/");
    }
}




?>


<!-- register -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Đăng ký</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formRegister">
                    <div class="form-group <?php if ($checkUserName == 0) {
                                                echo "success";
                                            } elseif ($checkUserName > 0) {
                                                echo "error";
                                            } ?> ">
                        <label class="col-form-label">Tên đăng nhập</label>
                        <input type="text" class="form-control Inputcheck" value="<?php echo $username ?>" placeholder="" name="username" required="" />
                        <p class="px-3 mb-0 text-left messageError <?php if ($checkUserName > 0) echo "error" ?>">Tên đăng nhập đã tồn tại</p>
                    </div>
                    <div class="form-group <?php if ($checkEmail == 0) {
                                                echo "success";
                                            } elseif ($checkEmail > 0) {
                                                echo "error";
                                            } ?>">
                        <label class="col-form-label">Email</label>
                        <input type="email" class="form-control Inputcheck" value="<?php echo $email  ?>" placeholder="" name="email" required="" />
                        <p class="px-3 mb-0 text-left messageError <?php if ($checkEmail > 0) echo "error" ?>">Email đã tồn tại</p>
                    </div>
                    <div class="form-group ">
                        <label class="col-form-label">Mật khẩu</label>
                        <input type="password" class="form-control Inputcheck" value="<?php echo $password; ?>" placeholder="" name="password" id="password1" required="" />
                    </div>
                    <div class="form-group <?php if ($checkPass === true) {
                                                echo "success";
                                            } elseif (!$checkPass) {
                                                echo "error";
                                            } ?>">
                        <label class="col-form-label">Nhập lại mật khẩu</label>
                        <input type="password" class="form-control Inputcheck" value="<?php echo $confirmPassword; ?>" placeholder="" name="confirmPassword" id="password2" required="" />
                        <p class="px-3 mb-0 text-left messageError <?php if (!$checkPass) echo "error" ?>">Mật khẩu sai</p>
                    </div>

                    <div class="sub-w3l">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input name="rules" required='' type="checkbox" class="custom-control-input" id="customControlAutosizing2" />
                            <label class="custom-control-label" for="customControlAutosizing2">Tôi chấp nhận các điều khoản & điều kiện</label>
                        </div>
                    </div>
                    <div class="right-w3l">
                        <input type="submit" class="form-control" value="Đăng ký" />
                    </div>
                    <!-- <p class="text-center dont-do mt-3">
                        Bạn đã có tài khoản?
                        <a href="#" data-toggle="modal" data-target="#loginModal">
                            Đăng nhập </a>
                    </p> -->
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