<?php 

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

require_once "../config/db.php";




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/search.css">
    <link rel="stylesheet" href="../assets/css/user-pages.css">
     <!-- <link rel="stylesheet" href="../assets/css/homepage.css"> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.js"></script>




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
                        <input type="text" name="activity" class="search-input homepage-search-input" data-type="activity" id="activity" >
                        <button type="button" id="btn-search-act">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                </div>
                <div class="suggest-box homepage-suggest-box"></div>
            </div>

            <div class="homepage-header-left">
            </div>
        </div>
    </header>

    <div class="container">
        <div class="left-container">
            <div class="left-side">
                <div class="homepage-left-org">
                    <div class="header-org-img">
                        <img src="https://thumbs.dreamstime.com/b/customer-support-service-agent-headset-flat-vector-icon-design-designs-153069456.jpg" alt="Ảnh đại diện">
                    </div>
                    <div class="header-org-name">
                        <b>Nani Hirunkit</b>
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar">
                    <div class="navbar-item" data-page="dashboard">
                        <i class="fa-solid fa-house"></i>
                        <span>Trang chủ</span>
                    </div>
                    
                    <div class="navbar-item" data-page="account">
                        <i class="fa-solid fa-users-gear"></i>
                        <span>Quản lý tài khoản</span>
                    </div>

                    <div class="navbar-item" data-page="semester">
                        <i class="fa-solid fa-school"></i>
                        <span>Quản lý học kỳ</span>
                    </div>
                    <div class="navbar-item">
                        <a href="../logout.php">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Đăng xuất</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <div class="right-container">
            
        </div>
    </div>
    <script src="../assets/js/suggest.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/admin-pages.js"></script>
    
</body>

</html>