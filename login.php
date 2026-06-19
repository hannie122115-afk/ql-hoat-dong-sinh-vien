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
        } else{
          header("Location: admin/homepage.php");
          exit;
        }
      } else{
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
  </head>
  <body>
    <div class="login-container">
      <div class="login-form">
        <form action="#" method="post">
          <div class="login-logo">
            <i class="fa-light fa-user-graduate"></i>
          </div>
          <h1>Đăng nhập</h1>
          <small>Đăng nhập để bắt đầu hành trình của bạn</small>

          <?php if(isset($_SESSION['success_message'])){ ?>
            <div class="success_login_message">
              <?= $_SESSION['success_message']; ?>
            </div>
          <?php unset($_SESSION['success_message']); } ?>

          <div class="login-block">
            <div class="login-title-block">
              <h3>Email</h3>
            </div>
            <div class="login-input-block">
              <span>
                <i class="fa-regular fa-envelope"></i>
              </span>
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

          <div class="login-block">
            <div class="login-title-block">
              <h3>Mật khẩu</h3>
            </div>
            <div class="login-input-block">
              <span>
                <i class="fa-regular fa-envelope"></i>
              </span>
              <input
                type="password"
                name="password"
                id=""
                value="<?= htmlspecialchars($password ?? '') ?>"
                placeholder="Nhập mật khẩu của bạn"
              />
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

          <div class="login-btn">
            <input type="submit" value="Đăng nhập" />
          </div>
        </form>
      </div>
      <div class="register-another">
            <small>hoặc</small>
            <div class="login-google-btn"></div>
            <h3>
                Nếu bạn chưa có tài khoản?
                <a href="">
                    <b>
                        Đăng ký ngay
                    </b>
                </a>
            </h3>
        </div>
    </div>
  </body>
</html>
