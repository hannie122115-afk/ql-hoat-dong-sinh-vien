<?php 

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

require_once "../config/db.php";
require_once "auth.php";




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/search.css">

</head>
<body>
    <header>
        <div class="homepage-header">
            <div class="homepage-header-left">
                <div class="homepage-header-logo">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <h2>SAMS</h2>
                </div>
                <div class="homepage-header-tiltle">
                    Hệ thống quản lý hoạt động sinh viên
                </div>
            </div>

            <div class="homepage-search-act">
                <div class="homepage-btn-search-act">
                    <input type="text" name="activity" class="search-input" data-type="activity" id="activity">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <div class="suggest-box"></div>
            </div>

            <div class="homepage-header-left">
                <div class="btn-add-act">
                    <a href="#">
                        <i class="fa-solid fa-plus"></i>
                        <b>Thêm hoạt động</b>
                    </a>
                </div>
                <div class="notify-bell">
                    <i class="fa-regular fa-bell"></i>
                </div>
                <div class="homepage-header-org">
                    <div class="header-org-img">
                        <img src="<?= $org['AnhDaiDien'] ?>" alt="Ảnh đại diện">
                    </div>
                    <div class="header-org-name">
                        <b><?= $org['TenToChuc'] ?></b>
                        <span><?= $unit['TenDonVi'] ?></span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="left-container">
            <div class="left-side">
                <div class="homepage-left-org">
                    <div class="header-org-img">
                        <img src="<?= $org['AnhDaiDien'] ?>" alt="Ảnh đại diện">
                    </div>
                    <div class="header-org-name">
                        <b><?= $org['TenToChuc'] ?></b>
                        <span><?= $unit['TenDonVi'] ?></span>
                    </div>
                </div>
                <div class="navbar">
                    <div class="navbar-item" data-page="dashboard">
                        <i class="fa-solid fa-house"></i>
                        <span>Trang chủ</span>
                    </div>
                    
                    <div class="navbar-item" data-page="created-act">
                        <i class="fa-regular fa-square-plus"></i>
                        <span>Tạo hoạt động</span>
                    </div>

                    <div class="navbar-item" data-page="activity">
                        <i class="fa-solid fa-chart-gantt"></i>
                        <span>Quản lý hoạt động</span>
                    </div>

                    <div class="navbar-item" data-page="statistic">
                        <i class="fa-solid fa-chart-simple"></i>
                        <span>Báo cáo thống kê</span>
                    </div>

                    <div class="navbar-item" data-page="profile">
                        <i class="fa-solid fa-user"></i>
                        <span>Hồ sơ</span>
                    </div>

                    <div class="navbar-item">
                        <a href="../logout.php">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Đăng xuất</span>
                        </a>
                    </div>

                </div>
                <div class="left-side-overview">
                    <h3>Tổng quan</h3>
                    <div class="left-side-overview-item">
                        <i class="fa-regular fa-calendar"></i>
                        <div class="homepage-left-overview-item-amount">
                            <h4><?= $tongSoHD ?></h4>
                            <span>Hoạt động đã tạo</span>
                        </div>
                    </div>
                    
                    <div class="left-side-overview-item">
                        <i class="fa-solid fa-user-group"></i>
                        <div class="homepage-left-overview-item-amount">
                            <h4><?= $tongLuotDK ?></h4>
                            <span>Lượt đăng ký</span>
                        </div>
                    </div>
                    
                    <div class="left-side-overview-item">
                        <i class="fa-regular fa-circle-check"></i>
                        <div class="homepage-left-overview-item-amount">
                            <h4>15</h4>
                            <span>Sinh viên đã tham gia</span>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="right-container">
            
        </div>
    </div>

    <script src="../assets/js/suggest.js"></script>
    <script src="../assets/js/navbar.js"></script>

</body>

</html>