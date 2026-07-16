<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/db.php";
require_once "../auth.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>ĐÂY LÀ TRANG CHI TIẾT HOẠT ĐỘNG</h1>

    <?php if(isset($_SESSION['success_update_act_message'])){ ?>
          <div class="success_update_act_message">
            <?= $_SESSION['success_update_act_message']; ?>
          </div>
        <?php unset($_SESSION['success_update_act_message']); } ?>
</body>
</html>