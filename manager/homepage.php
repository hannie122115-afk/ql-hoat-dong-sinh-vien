<?php 
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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
                <input type="text" name="activity" class="search-input" data-type="activity">
                <i class="fa-solid fa-magnifying-glass"></i>
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
                <div class="homepage-header-user">
                    <div class="header-group-img">
                        <img src="" alt="">
                    </div>
                    <div class="header-group-name">
                        <b>name</b>
                        <span>name mini</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="homepage-container">
        <div class="homepage-left-container">
            <div class="homepage-left">
                <div class="homepage-left-group">
                    <div class="header-group-img">
                        <img src="" alt="">
                    </div>
                    <div class="header-group-name">
                        <b>name</b>
                        <span>name mini</span>
                    </div>
                </div>
                <div class="homepage-left-navbar">
                    <div class="homepage-left-navbar-item">
                        <i class="fa-regular fa-house"></i>
                        <span>Trang chủ</span>
                    </div>
                    
                    <div class="homepage-left-navbar-item">
                        <i class="fa-regular fa-square-plus"></i>
                        <span>Tạo hoạt động</span>
                    </div>

                    <div class="homepage-left-navbar-item">
                        <i class="fa-solid fa-chart-gantt"></i>
                        <span>Quản lý hoạt động</span>
                    </div>

                    <div class="homepage-left-navbar-item">
                        <i class="fa-solid fa-chart-simple"></i>
                        <span>Báo cáo thống kê</span>
                    </div>

                    <div class="homepage-left-navbar-item">
                        <i class="fa-solid fa-user"></i>
                        <span>Hồ sơ</span>
                    </div>

                    <div class="homepage-left-navbar-item">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Đăng xuất</span>
                    </div>

                </div>
                <div class="homepage-left-overview">
                    <h3>Tổng quan</h3>
                    <div class="homepage-left-overview-item">
                        <i class="fa-regular fa-calendar"></i>
                        <div class="homepage-left-overview-item-amount">
                            <h4>15</h4>
                            <span>Sự kiện đã tạo</span>
                        </div>
                    </div>
                    
                    <div class="homepage-left-overview-item">
                        <i class="fa-solid fa-user-group"></i>
                        <div class="homepage-left-overview-item-amount">
                            <h4>150</h4>
                            <span>Lượt đăng ký</span>
                        </div>
                    </div>
                    
                    <div class="homepage-left-overview-item">
                        <i class="fa-regular fa-circle-check"></i>
                        <div class="homepage-left-overview-item-amount">
                            <h4>15</h4>
                            <span>Sinh viên đã tham gia</span>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="homepage-right-container">
            <h1>Xin chào, username!</h1>
            <div class="homepage-right-card-box">
                <div class="homepage-right-card-title">
                    <i class="fa-regular fa-calendar"></i>
                    <h3>Sắp diễn ra</h3>
                </div>
                <div class="homepage-right-card-container">
                    <div class="homepage-right-card">  
                        <div class="homepage-right-img-card">
                            <img src="" alt="">
                        </div>
                        <div class="homepage-right-title-card">
                            <div class="homepage-right-date-card">Để ngày z-index cao
                                <h3>ngay</h3>
                                <span>thang may</span>
                            </div>
                            <h4>ten hoat dong</h4>
                            <div class="homepage-right-info-card">
                                <div class="homepage-right-info-card-item">
                                    <i class="fa-regular fa-clock"></i>
                                    <span>gio dien ra</span>
                                </div>
                                <div class="homepage-right-info-card-item">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span>gio dien ra</span>
                                </div>
                                <div class="homepage-right-info-card-item">
                                    <i class="fa-solid fa-user-group"></i>
                                    <span>100/200 nguoi dang ky</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="homepage-right-card-box">
                <div class="homepage-right-card-title">
                    <i class="fa-regular fa-calendar"></i>
                    <h3>Sắp diễn ra</h3>
                </div>
                <div class="homepage-right-card-container">
                    <div class="homepage-right-card">  
                        <div class="homepage-right-img-card">
                            <img src="" alt="">
                        </div>
                        <div class="homepage-right-title-card">
                            <div class="homepage-right-date-card">Để ngày z-index cao
                                <h3>ngay</h3>
                                <span>thang may</span>
                            </div>
                            <h4>ten hoat dong</h4>
                            <div class="homepage-right-info-card">
                                <div class="homepage-right-info-card-item">
                                    <i class="fa-regular fa-clock"></i>
                                    <span>gio dien ra</span>
                                </div>
                                <div class="homepage-right-info-card-item">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span>gio dien ra</span>
                                </div>
                                <div class="homepage-right-info-card-item">
                                    <i class="fa-solid fa-user-group"></i>
                                    <span>100/200 nguoi dang ky</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="homepage-right-card-box">
                <div class="homepage-right-card-title">
                    <i class="fa-regular fa-calendar"></i>
                    <h3>Sắp diễn ra</h3>
                </div>
                <div class="homepage-right-card-container">
                    <div class="homepage-right-card">  
                        <div class="homepage-right-img-card">
                            <img src="" alt="">
                        </div>
                        <div class="homepage-right-title-card">
                            <div class="homepage-right-date-card">Để ngày z-index cao
                                <h3>ngay</h3>
                                <span>thang may</span>
                            </div>
                            <h4>ten hoat dong</h4>
                            <div class="homepage-right-info-card">
                                <div class="homepage-right-info-card-item">
                                    <i class="fa-regular fa-clock"></i>
                                    <span>gio dien ra</span>
                                </div>
                                <div class="homepage-right-info-card-item">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span>gio dien ra</span>
                                </div>
                                <div class="homepage-right-info-card-item">
                                    <i class="fa-solid fa-user-group"></i>
                                    <span>100/200 nguoi dang ky</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>