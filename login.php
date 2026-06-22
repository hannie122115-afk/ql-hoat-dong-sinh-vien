<?php 
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

require_once "config/db.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){

  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $error = [];

  if(empty($email)){
    $error['email'] = 'Vui lòng nhập email đăng nhập.';
  }

  if(empty($password)){
    $error['password'] = 'Vui lòng nhập mật khẩu đăng nhập.';
  }

  if(empty($error['email'])){
    $sql = "SELECT * FROM taikhoandangnhap WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC); // biến này nếu không có sẽ cho ra false

    if($user === false){
      $error['email'] = "Email không tồn tại trên hệ thống!";
    }else{
      if(password_verify($password, $user['MatKhau'])){
        $_SESSION['user_id'] = $user['MaTaiKhoan'];
        $_SESSION['email'] = $user['Email'];
        if((int)$user['Role'] == 0){
          header("Location: user/homepage.php");
          exit;
        } elseif((int)$user['Role'] == 1){
            header("Location: manager/homepage.php");
            exit;
            } else{
                header("Location: admin/homepage.php");
                exit;   
              }
      } elseif(strcmp($password, $user['MatKhau']) == 0){
        if((int)$user['Role'] == 1){
          header("Location: manager/homepage.php");
          exit;
        }elseif((int)$user['Role'] != 1 && (int)$user['Role'] != 0){
          header("Location: admin/homepage.php");
          exit;  
        }
      }else{
        $error['password'] = "Mật khẩu không chính xác. Vui lòng thử lại.";
      }
    }
  }
  
}



?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
              Nếu bạn chưa có tài khoản?
              <b>
                  <a href="login.php">Đăng ký ngay</a>
              </b>
            </div>
        </div>
    </header>

    <div class="register-container">
      <div class="register-describe">
        <?php if(isset($_SESSION['success_message'])){ ?>
          <div class="success-login-message">
            <?= $_SESSION['success_message']; ?>
          </div>
        <?php unset($_SESSION['success_message']); } ?>
        <h1>Đăng nhập</h1>
        <span>Đăng nhập ngay để bắt đầu hành trình của bạn</span>
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

      <div class="login-form register-form">
        <form action="#" method="post">
          <div class="login-form-container ">
            <div class="login-block register-block">
              <div class="login-title-block register-title-block">
                <span>
                  <i class="fa-regular fa-envelope"></i>
                </span>
                <h3>Email</h3>
              </div>
              <div class="login-input-block register-input-block">
                
                <input
                  type="text"
                  name="email"
                  id=""
                  value="<?= htmlspecialchars($email ?? '') ?>"
                  placeholder="Nhập email của bạn"
                />
              </div>
              <?php if(!empty($error['email'])): ?>
              <small style="color: red"> <?= $error['email'] ?> </small>
              <?php endif;?>
            </div>

          <div class="login-block register-block">
            <div class="login-title-block register-title-block">
              <span>
                <i class="fa-regular fa-envelope"></i>
              </span>
              <h3>Mật khẩu</h3>
            </div>
            <div class="login-input-block register-input-block password-block">
              <input type="text" name="password" value="<?= htmlspecialchars($password ?? '') ?>" placeholder="Nhập vào mật khẩu của bạn" class="hidden-password">
                <i class="fa-solid fa-eye toggle-password-icon"></i>
            </div>
            <?php if(!empty($error['password'])): ?>
            <small style="color: red"> <?= $error['password'] ?> </small>
            <?php endif;?>
          </div>

          <div class="login-memory-block">
            <div class="login-right-memory-block">
              <b>
                <a href="#">Quên mật khẩu?</a>
              </b>
            </div>
            <div class="login-left-memory-block">
              <input type="checkbox" name="memory" id="" />
              <span>Ghi nhớ đăng nhập</span>
            </div>
          </div>

          <div class="login-btn register-submit register-btn-submit">
            <input type="submit" value="Đăng nhập" />
          </div>
          </div>
        </form>
      </div>
    </div>
  </body>

    <script src="assets/js/password.js"></script>

</html>
