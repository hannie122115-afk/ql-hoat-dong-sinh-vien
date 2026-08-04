<?php 
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/db.php";



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý hoạt động</title>
</head>
<body>
    <div class="account-container">
        <div class="account-title">
                <h2>Quản lý tài khoản</h2>
                <span>Quản lý và cấp tài khoản cho tổ chức và người dùng</span>
            </div>
    </div>

</body>
</html>