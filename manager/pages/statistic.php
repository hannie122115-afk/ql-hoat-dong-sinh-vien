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

$sql1 = "SELECT COUNT(*) AS actTotal
        FROM HoatDong
        WHERE MaToChuc = ?";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute([$org['MaToChuc']]);
$act = $stmt1->fetchColumn();

$sql2 = "SELECT
            COUNT(CASE WHEN dk.DaDiemDanh = 0 THEN 1 END) AS joined,
            COUNT(CASE WHEN dk.DaDiemDanh = 1 THEN 1 END) AS checked
        FROM DangKy dk
        JOIN HoatDong hd
            ON dk.MaHoatDong = hd.MaHoatDong
        WHERE hd.MaToChuc = ?;";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute([$org['MaToChuc']]);
$sum = $stmt2->fetch(PDO::FETCH_ASSOC);

$sql3 = "SELECT DISTINCT NamHoc
        FROM HocKy";
$stmt3 = $conn->prepare($sql3);
$stmt3->execute();




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
    <h1> ĐÂY LÀ TRANG THỐNG KÊ</h1>

    <div class="statistic-container">
        <div class="statistic-header">
            <div class="statistic-title">
                <h2>Thống kê & báo cáo</h2>
                <span>Tổng quan hoạt động và số liệu của tổ chức</span>
            </div>
            <div class="statistic-dropdown">
                <div class="statistic-dropdown-block" data-type="semester">
                    <span>Học kì</span>
                    <div class="statistic-dropdown-selected">
                        <span class="selected-text" > Chọn học kỳ </span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="statistic-dropdown-menu">
                        <div class="statistic-dropdown-item" data-value="1">HK1</div>
                        <div class="statistic-dropdown-item" data-value="2">HK2</div>
                        <div class="statistic-dropdown-item" data-value="3">HK3</div>
                    </div>
                </div>
                <div class="statistic-dropdown-block" data-type="year">
                    <span>Năm học</span>
                    <div class="statistic-dropdown-selected">
                        <span class="selected-text" > Chọn năm học </span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="statistic-dropdown-menu">
                        <?php while($row = $stmt3->fetch(PDO::FETCH_ASSOC)){ ?>
                        <div class="statistic-dropdown-item" data-value="<?= $row['NamHoc'] ?>"><?= $row['NamHoc'] ?></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="statistic-overview">
            <div class="statistic-overview">
                <div class="statistic-overview-icon">

                </div>
                <div class="statistic-overview-title">
                    <b>Tổng số hoạt động</b>
                    <h3><?= $act ?></h3>
                    <span>Hoạt động đã tạo</span>
                </div>
            </div>
            <div class="statistic-overview">
                <div class="statistic-overview-icon">

                </div>
                <div class="statistic-overview-title">
                    <b>Tổng lượt đăng ký</b>
                    <h3><?= $sum['joined'] ?></h3>
                    <span>Sinh viên đăng ký</span>
                </div>
            </div>
            <div class="statistic-overview">
                <div class="statistic-overview-icon">

                </div>
                <div class="statistic-overview-title">
                    <b>Tổng lượt tham gia</b>
                    <h3><?= $sum['checked'] ?></h3>
                    <span>Sinh viên đã tham gia</span>
                </div>
            </div>
            <div class="statistic-overview">
                <div class="statistic-overview-icon">

                </div>
                <div class="statistic-overview-title">
                    <b>Tỷ lệ tham gia</b>
                    <h3><?= $sum['joined'] > 0 ? round($sum['checked'] / $sum['joined'] * 100, 2) . '%' : '0%' ?></h3>
                    <span>Tham gia / Đăng ký</span>
                </div>
            </div>
        </div>

        <div class="statistic-chart-container" style="margin-top: 30px; background: #fff; padding: 20px; border-radius: 12px;">
            <h3>So sánh lượt đăng ký và điểm danh theo hoạt động</h3>
            <div id="chart-placeholder" >
                Vui lòng chọn học kỳ và năm học để xem biểu đồ thống kê
            </div>
            <div style="position: relative; width: 100%; height: 400px;">
                <canvas id="activityChart"></canvas>
            </div>
        </div>


    </div>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    
</body>
</html>