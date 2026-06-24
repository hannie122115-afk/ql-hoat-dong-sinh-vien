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

$stmt1 = $conn->prepare("SELECT 
                            hd.*,
                            COUNT(dk.MSSV) AS total
                        FROM HoatDong hd
                        LEFT JOIN DangKy dk
                            ON hd.MaHoatDong = dk.MaHoatDong
                        WHERE hd.MaToChuc = ?
                            AND hd.ThoiGianBatDau > NOW()
                        GROUP BY hd.MaHoatDong");
$stmt1->execute([$org['MaToChuc']]);

$stmt2 = $conn->prepare("SELECT 
                            hd.*,
                            COUNT(dk.MSSV) AS total
                        FROM HoatDong hd
                        LEFT JOIN DangKy dk
                            ON hd.MaHoatDong = dk.MaHoatDong
                        WHERE hd.MaToChuc = ?
                            AND (NOW() BETWEEN hd.ThoiGianBatDau AND hd.ThoiGianKetThuc)
                        GROUP BY hd.MaHoatDong");
$stmt2->execute([$org['MaToChuc']]);

$stmt3 = $conn->prepare("SELECT 
                            hd.*,
                            COUNT(dk.MSSV) AS total
                        FROM HoatDong hd
                        LEFT JOIN DangKy dk
                            ON hd.MaHoatDong = dk.MaHoatDong
                        WHERE hd.MaToChuc = ?
                            AND hd.ThoiGianKetThuc < NOW()
                        GROUP BY hd.MaHoatDong");
$stmt3->execute([$org['MaToChuc']]);




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/card.css">
</head>
<body>
    <h1>ĐÂY LÀ TRANG CHỦ</h1>

    <h1>Xin chào, <?= $org['TenToChuc'] ?>!</h1>
    <div class="container">
        <div class="title-container">
            <i class="fa-regular fa-calendar"></i>
            <h3>Sắp diễn ra</h3>
        </div>
        <div class="card-container">
            <?php $count = 0;
            while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
                $count++;?>
            <div class="card-item <?= $count > 4 ? 'hidden-card-item' : '' ?>">  
                <div class="img-card-item">
                    <img src="<?= $row['HinhAnh'] ?>" alt="">
                </div>
                <div class="title-card-item">
                    <div class="date-card-item">Để ngày z-index cao
                        <?php $dateStart = new DateTime($row['ThoiGianBatDau']); 
                        $dateEnd = new DateTime($row['ThoiGianKetThuc']); ?>
                        <h3><?= $dateStart->format('d'); ?></h3>
                        <span>tháng <?= $dateStart->format('m'); ?></span>
                    </div>
                    <h4><?= $row['TenHoatDong'] ?></h4>
                    <div class="info-card-item">
                        <div class="info-card-item-inside">
                            <i class="fa-regular fa-clock"></i>
                            <span><?= $dateStart->format('H:i'); ?> - <?= $dateEnd->format('H:i'); ?></span>
                        </div>
                        <div class="info-card-item-inside">
                            <i class="fa-solid fa-location-dot"></i>
                            <span><?= $row['DiaDiem'] ?></span>
                        </div>
                        <div class="info-card-item-inside">
                            <i class="fa-solid fa-user-group"></i>
                            <span><?= $row['total'] ?>/<?= $row['SoLuongToiDa']?> đã đăng ký</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="see-all-card-btn">Xem tất cả</div>
    </div>
    <div class="container">
        <div class="title-container">
            <i class="fa-regular fa-calendar"></i>
            <h3>Đang diễn ra</h3>
        </div>
        <div class="card-container">
            <?php $count = 0;
            while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){ 
                $count++; ?>
            <div class="card-item <?= $count > 4 ? 'hidden-card-item' : '' ?>">  
                <div class="img-card-item">
                    <img src="<?= $row['HinhAnh'] ?>" alt="">
                </div>
                <div class="title-card-item">
                    <div class="date-card-item">Để ngày z-index cao
                        <?php $dateStart = new DateTime($row['ThoiGianBatDau']); 
                        $dateEnd = new DateTime($row['ThoiGianKetThuc']); ?>
                        <h3><?= $dateStart->format('d'); ?></h3>
                        <span>tháng <?= $dateStart->format('m'); ?></span>
                    </div>
                    <h4><?= $row['TenHoatDong'] ?></h4>
                    <div class="info-card-item">
                        <div class="info-card-item-inside">
                            <i class="fa-regular fa-clock"></i>
                            <span><?= $dateStart->format('H:i'); ?> - <?= $dateEnd->format('H:i'); ?></span>
                        </div>
                        <div class="info-card-item-inside">
                            <i class="fa-solid fa-location-dot"></i>
                            <span><?= $row['DiaDiem'] ?></span>
                        </div>
                        <div class="info-card-item-inside">
                            <i class="fa-solid fa-user-group"></i>
                            <span><?= $row['total'] ?>/<?= $row['SoLuongToiDa']?> đã đăng ký</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="see-all-card-btn">Xem tất cả</div>
    </div>
    <div class="container">
        <div class="title-container">
            <i class="fa-regular fa-calendar"></i>
            <h3>Đã kết thúc</h3>
        </div>
        <div class="card-container">
            <?php $count = 0;
            while($row = $stmt3->fetch(PDO::FETCH_ASSOC)){ 
                $count++;?>
            <div class="card-item <?= $count > 4 ? 'hidden-card-item' : '' ?>">  
                <div class="img-card-item">
                    <img src="<?= $row['HinhAnh'] ?>" alt="">
                </div>
                <div class="title-card-item">
                    <div class="date-card-item">Để ngày z-index cao
                        <?php $dateStart = new DateTime($row['ThoiGianBatDau']); 
                        $dateEnd = new DateTime($row['ThoiGianKetThuc']); ?>
                        <h3><?= $dateStart->format('d'); ?></h3>
                        <span>tháng <?= $dateStart->format('m'); ?></span>
                    </div>
                    <h4><?= $row['TenHoatDong'] ?></h4>
                    <div class="info-card-item">
                        <div class="info-card-item-inside">
                            <i class="fa-regular fa-clock"></i>
                            <span><?= $dateStart->format('H:i'); ?> - <?= $dateEnd->format('H:i'); ?></span>
                        </div>
                        <div class="info-card-item-inside">
                            <i class="fa-solid fa-location-dot"></i>
                            <span><?= $row['DiaDiem'] ?></span>
                        </div>
                        <div class="info-card-item-inside">
                            <i class="fa-solid fa-user-group"></i>
                            <span><?= $row['total'] ?>/<?= $row['SoLuongToiDa']?> đã đăng ký</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="see-all-card-btn">Xem tất cả</div>
    </div>
</body>
</html>