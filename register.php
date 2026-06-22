<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

require_once "config/db.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $fullname = $_POST['fullname'] ?? '';
    $mssv = $_POST['mssv'] ?? '';
    $unit = $_POST['unit'] ?? '';
    $class = $_POST['class'] ?? '';
    $year = $_POST['year'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $birth = $_POST['birth'] ?? '';
    $tel = $_POST['tel'] ?? '';

    if(empty($fullname)){
        $error['fullname'] = "Họ tên không được để trống!";
    }

    if(empty($mssv)){
        $error['mssv'] = "Mã số sinh viên không được để trống!";
    }

    if(empty($email)){
        $error['email'] = "Email không được để trống!";
    }

    if (empty($password)) {
        $error['password'] = "Mật khẩu không được để trống!";
    } elseif (strlen($password) < 6) {
        $error['password'] = "Mật khẩu phải từ 6 ký tự trở lên!";
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $error['password'] = "Mật khẩu phải có ít nhất 1 chữ in hoa!";
    } elseif (!preg_match('/[a-z]/', $password)) {
        $error['password'] = "Mật khẩu phải có ít nhất 1 chữ thường!";
    } elseif (!preg_match('/[0-9]/', $password)) {
        $error['password'] = "Mật khẩu phải có ít nhất 1 số!";
    }

    if(empty($password_confirm) || ($password !== $password_confirm)){
        $error['password_confirm'] = "Mật khẩu xác nhận không khớp!";
    }

    if(empty($unit)){
        $error['unit'] = "Tên đơn vị không được để trống!";
    }

    if(empty($class)){
        $error['class'] = "Ngành không được để trống!";
    }
    
    if(empty($year)){
        $error['year'] = "Khóa không được để trống!";
    }

    if(empty($error)){

        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        try{
            $conn->beginTransaction();

            $sql1 = "INSERT INTO taikhoandangnhap (Email, MatKhau) VALUES (?, ?)";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->execute([$email, $password_hashed]);

            $userId = $conn->lastInsertId();

            $sql2 = "INSERT INTO sinhvien (MSSV, MaTaiKhoan, MaNghanh, HoTen, GioiTinh, NgaySinh, SoDienThoai) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute([$mssv, $userId, $class, $fullname, $gender, $birth, $tel]);

            $conn->commit();
            $_SESSION['success_message'] = "Đăng ký thành công! Vui lòng đăng nhập.";
            header("Location: Login.php");
            exit;
                
        }catch(PDOException $e){
            $conn->rollBack();
            echo "Lỗi đăng ký: " . $e->getMessage();
        }
    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/search.css">
    <link rel="stylesheet" href="assets/css/register.css">
</head>
<body>
    <header>
        <div class="register-header">
            <div class="register-header-left">
                <div class="register-header-logo">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <h2>SAMS</h2>
                </div>
                <div class="register-header-tiltle">
                    Hệ thống quản lý hoạt động sinh viên
                </div>
            </div>

            <div class="register-header-right">
                Bạn đã có tài khoản?
                <b>
                    <a href="login.php">Đăng nhập</a>
                </b>
            </div>
        </div>
    </header>
    
    <div class="register-container">
        <div class="register-describe">
            <h1>Đăng ký tài khoản</h1>
            <span>Tạo tài khoản để bắt đầu hành trình tham gia các hoạt động và sự kiện dành cho sinh viên.</span>
            <div class="register-describe-block">

                <div class="register-describe-item">
                    <div class="register-describe-logo">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <div class="register-describe-title">
                        <h3>Kết nối</h3>
                        <span>Kết nối với cộng đồng sinh viên năng động</span>
                    </div>
                </div>
                
                <div class="register-describe-item">
                    <div class="register-describe-logo">
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                    <div class="register-describe-title">
                        <h3>Tham gia</h3>
                        <span>Tham gia các hoạt động sự kiện bổ ích</span>
                    </div>
                </div>

                <div class="register-describe-item">
                    <div class="register-describe-logo">
                        <i class="fa-solid fa-chart-simple"></i>
                    </div>
                    <div class="register-describe-title">
                        <h3>Phát triển</h3>
                        <span>Phát triển kỹ năng và tích lũy kinh nghiệm</span>
                    </div>
                </div>

            </div>
        </div>
        <div class="register-form">
            <form action="#" method="post">
                 <div class="register-form-container">
                    <div class="register-block">
                        <div class="register-title-block">
                            <span>
                                <i class="fa-regular fa-user"></i>
                            </span>
                            <h3>Họ và tên</h3>
                        </div>
                        <div class="register-input-block">
                            <input type="text" name="fullname" id="" value="<?= htmlspecialchars($fullname ?? '') ?>" placeholder="Nhập họ và tên của bạn">
                        </div>
                        <?php if(!empty($error['fullname'])): ?>
                            <small style="color:red;">
                                <?= $error['fullname'] ?>
                            </small>
                        <?php endif;?>
                    </div>
                
                    <div class="register-block">
                        <div class="register-title-block">
                            <span>
                                <i class="fa-regular fa-address-card"></i>
                            </span>
                            <h3>Mã số sinh viên</h3>
                        </div>
                        <div class="register-input-block">
                            <input type="text" name="mssv" value="<?= htmlspecialchars($mssv ?? '') ?>" id="" placeholder="Nhập mã số sinh viên">
                        </div>
                        <?php if(!empty($error['mssv'])): ?>
                            <small style="color:red;">
                                <?= $error['mssv'] ?>
                            </small>
                        <?php endif; ?>
                    </div>
                    
                    <div class="register-block">
                        <div class="register-title-block">
                            <span>
                                <i class="fa-regular fa-building"></i>
                            </span>
                            <h3>Đơn vị</h3>
                        </div>
                        <div class="register-input-block ">
                            <input type="text" name="unit" class="search-input" data-type="unit" value="<?= htmlspecialchars($unit ?? '') ?>" id="unit" placeholder="Gõ tên đơn vị để tìm kiếm và chọn">
                            
                        </div>
                        <div class="suggest-box"></div>
                        <?php if(!empty($error['unit'])): ?>
                            <small style="color:red">
                                <?= $error['unit'] ?>
                            </small>
                        <?php endif; ?>
                    </div>
                    
                    <div class="register-block">
                        <div class="register-title-block">
                            <span>
                                <i class="fa-regular fa-object-group"></i>
                            </span>
                            <h3>Ngành</h3>
                        </div>
                        <div class="register-input-block register-class-search">
                            <input type="text" name="class" class="search-input" data-type="class" value="<?= htmlspecialchars($class ?? '') ?>" id="" placeholder="Gõ tên ngành để tìm kiếm và chọn">
                            
                        </div>
                        <div class="suggest-box"></div>
                        <?php if(!empty($error['class'])): ?>
                            <small style="color:red">
                                <?= $error['class'] ?>
                            </small>
                        <?php endif; ?>
                    </div>
                    
                    <div class="register-block">
                        <div class="register-title-block">
                            <span>
                                <i class="fa-solid fa-graduation-cap"></i>
                            </span>
                            <h3>Khóa</h3>
                        </div>
                        <div class="register-input-block">
                            <input type="text" name="year" value="<?= htmlspecialchars($year ?? '') ?>" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Vui lòng nhập định dạng số">
                        </div>
                        <?php if(!empty($error['year'])): ?>
                            <small style="color:red">
                                <?= $error['year'] ?>
                            </small>
                        <?php endif; ?>
                    </div>
                    
                    <div class="register-block">
                        <div class="register-title-block">
                            <span>
                                <i class="fa-solid fa-mars-and-venus"></i>
                            </span>
                            <h3>Giới tính</h3>
                        </div>
                        <div class="register-input-block register-gender ">
                            <div class="register-input-gender">
                                <input type="radio" name="gender" id="" value="male" checked> Nam
                            </div>
                            <div class="register-input-gender">
                                <input type="radio" name="gender" id="" value="female"> Nữ
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="register-block">
                        <div class="register-title-block">
                            <span>
                                <i class="fa-regular fa-calendar"></i>
                            </span>
                            <h3>Ngày sinh</h3>
                        </div>
                        <div class="register-input-block register-birth">
                            <input type="date" name="birth" value="<?= htmlspecialchars($birth ?? '') ?>" id="" >
                            <!-- <i class="fa-regular fa-calendar"></i> -->
                        </div>
                        <?php if(!empty($error['birth'])): ?>
                            <small style="color:red">
                                <?= $error['birth'] ?>
                            </small>
                        <?php endif; ?>
                    </div>
                    
                    <div class="register-block">
                        <div class="register-title-block">
                            <span>
                                <i class="fa-solid fa-mobile-screen"></i>
                            </span>
                            <h3>Số điện thoại</h3>
                        </div>
                        <div class="register-input-block">
                            <input type="tel" name="tel" id="" value="<?= htmlspecialchars($tel ?? '') ?>" placeholder="Nhập vào số điện thọai của bạn" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength='12'>
                        </div>
                        <?php if(!empty($error['tel'])): ?>
                            <small style="color:red">
                                <?= $error['tel'] ?>
                            </small>
                        <?php endif; ?>
                    </div>
                    
                    <div class="register-block register-block-email">
                        <div class="register-title-block">
                            <span>
                                <i class="fa-regular fa-envelope"></i>
                            </span>
                            <h3>Email</h3>
                        </div>
                        <div class="register-input-block">
                            <input type="email" name="email" id="" value="<?= htmlspecialchars($email ?? '') ?>" placeholder="Nhập vào email của bạn">
                        </div>
                        <?php if(!empty($error['email'])): ?>
                            <small style="color:red">
                                <?= $error['email'] ?>
                            </small>
                        <?php endif; ?>
                    </div>
                    
                    <div class="register-block">
                        <div class="register-title-block">
                            <span>
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <h3>Mật khẩu</h3>
                        </div>
                        <div class="register-input-block password-block">
                            <input type="text" name="password" value="<?= htmlspecialchars($password ?? '') ?>" placeholder="Nhập vào mật khẩu của bạn" class="hidden-password">
                            <i class="fa-solid fa-eye toggle-password-icon"></i>
                        </div>
                        <small>Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.</small>
                        <?php if(!empty($error['password'])): ?>
                            <small style="color:red">
                                <?= $error['password'] ?>
                            </small>
                        <?php endif; ?>
                    </div>
                    
                    <div class="register-block">
                        <div class="register-title-block">
                            <span>
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <h3>Xác nhận mật khẩu</h3>
                        </div>
                        <div class="register-input-block password-block">
                            <input type="text" name="password_confirm" value="<?= htmlspecialchars($password_confirm ?? '') ?>" placeholder="Nhập lại mật khẩu của bạn một lần nữa" class="hidden-password">
                            <i class="fa-solid fa-eye toggle-password-icon"></i>
                        </div>
                        <?php if(!empty($error['password_confirm'])): ?>
                            <small style="color:red">
                                <?= $error['password_confirm'] ?>
                            </small>
                        <?php endif; ?>
                    </div>
                    
                    <div class="register-submit">
                        <div class="register-btn-submit">
                            <input type="submit" value="Đăng ký tài khoản">
                        </div>
                        <span>Bằng việc đăng ký, bạn đồng ý với 
                            <b><a href="#">Điều khoản sử dụng</a></b>
                            và 
                            <b><a href="#">Chính sách bảo mật</a></b>
                            của chúng tôi.
                        </span>
                    </div>
                 </div>
            </form>
        </div>
    </div>

    <script src="assets/js/suggest.js"></script>
    <script src="assets/js/password.js"></script>
</body>
</html>