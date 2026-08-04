<?php 
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/db.php";

$sql1 = "SELECT COUNT(MSSV)
        FROM SinhVien";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute();
$student = $stmt1->fetchColumn();

$sql2 = "SELECT COUNT(MaToChuc)
        FROM ToChuc";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute();
$org = $stmt2->fetchColumn();  

$sql3 = "SELECT COUNT(MaHoatDong)
        FROM HoatDong";
$stmt3 = $conn->prepare($sql3);
$stmt3->execute();
$act = $stmt3->fetchColumn();  

$sql4 = "SELECT *
        FROM HocKy
        WHERE ThoiGianBatDau <= NOW()
        AND ThoiGianKetThuc >= NOW()";
$stmt4 = $conn->prepare($sql4);
$stmt4->execute();
$semester = $stmt4->fetch(PDO::FETCH_ASSOC);   





?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="homepage-container">
        <div class="homepage-statistic-block">
            <div class="homepage-statistic-item">
                <div class="homepage-statistic-icon">
                    <i class="fa-solid fa-user-group"></i>
                </div>
                <div class="homepage-statistic-title">
                    <span>Tổng số sinh viên</span>
                    <h3><?= $student ?></h3>
                    <span>Sinh viên</span>
                </div>
            </div>
            <div class="homepage-statistic-item">
                <div class="homepage-statistic-icon">
                    <i class="fa-solid fa-school-flag"></i>
                </div>
                <div class="homepage-statistic-title">
                    <span>Tổng số tổ chức</span>
                    <h3><?= $org ?></h3>
                    <span>Tổ chức</span>
                </div>
            </div>
            <div class="homepage-statistic-item">
                <div class="homepage-statistic-icon">
                    <i class="fa-solid fa-flag"></i>
                </div>
                <div class="homepage-statistic-title">
                    <span>Tổng số hoạt động</span>
                    <h3><?= $act ?></h3>
                    <span>Hoạt động</span>
                </div>
            </div>
            <div class="homepage-statistic-item">
                <div class="homepage-statistic-icon">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
                <div class="homepage-statistic-title">
                    <span>Học kỳ hiện tại</span>
                    <h3><?= $semester['NamHoc'] ?> - HK<?= $semester['NamHoc'] ?></h3>
                    <?php $dateStart = new DateTime($semester['ThoiGianBatDau']); 
                        $dateEnd = new DateTime($semester['ThoiGianKetThuc']); ?>
                    <span>Từ ngày <?= $dateStart->format('d/m/y') ?> đến ngày <?= $dateEnd->format('d/m/y') ?></span>
                </div>
            </div>
        </div>

        <div class="homepage-statistic-chart-container" style="margin-top: 30px; background: #fff; padding: 20px; border-radius: 12px;">
            <h3>Biểu đồ tổ chức</h3>
            <span>Hiển thị số hoạt động của mỗi tổ chức trong kỳ hiện tại</span>
            <div style="position: relative; width: 100%; height: 400px;">
                <canvas id="orgChart"></canvas>
            </div>
        </div>
    </div>



</body>
</html>