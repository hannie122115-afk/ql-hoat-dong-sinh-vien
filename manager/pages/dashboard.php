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

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$search = "%$keyword%";

$sql1 = "SELECT 
            hd.*,
            COUNT(dk.MSSV) AS total
        FROM HoatDong hd
        LEFT JOIN DangKy dk
            ON hd.MaHoatDong = dk.MaHoatDong
        WHERE hd.MaToChuc = ?
            AND hd.ThoiGianBatDau > NOW() ";
if(!empty($keyword)){
    $sql1 .= "AND hd.TenHoatDong LIKE ?";
}
$sql1 .= "GROUP BY hd.MaHoatDong";
$stmt1 = $conn->prepare($sql1);
empty($keyword) ? $stmt1->execute([$org['MaToChuc']]) : $stmt1->execute([$org['MaToChuc'], $search]);

$sql2 = "SELECT 
            hd.*,
            COUNT(dk.MSSV) AS total
        FROM HoatDong hd
        LEFT JOIN DangKy dk
            ON hd.MaHoatDong = dk.MaHoatDong
        WHERE hd.MaToChuc = ?
            AND (NOW() BETWEEN hd.ThoiGianBatDau AND hd.ThoiGianKetThuc) ";
if(!empty($keyword)){
    $sql2 .= "AND hd.TenHoatDong LIKE ?";
}
$sql2 .= "GROUP BY hd.MaHoatDong";
$stmt2 = $conn->prepare($sql2);
empty($keyword) ? $stmt2->execute([$org['MaToChuc']]) : $stmt2->execute([$org['MaToChuc'], $search]);

$sql3 = "SELECT 
            hd.*,
            COUNT(dk.MSSV) AS total
        FROM HoatDong hd
        LEFT JOIN DangKy dk
            ON hd.MaHoatDong = dk.MaHoatDong
        WHERE hd.MaToChuc = ?
            AND hd.ThoiGianKetThuc < NOW() ";
if(!empty($keyword)){
    $sql3 .= "AND hd.TenHoatDong LIKE ?";
}
$sql3 .= "GROUP BY hd.MaHoatDong";
$stmt3 = $conn->prepare($sql3);
empty($keyword) ? $stmt3->execute([$org['MaToChuc']]) : $stmt3->execute([$org['MaToChuc'], $search]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/manager-pages.css">
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
            <div class="card-item <?= $count > 4 ? 'hidden-card-item' : '' ?>" data-id="<?= $row['MaHoatDong'] ?>">  
                <div class="img-card-item">
                    <img src="<?= $row['AnhAvt'] ?>" alt="">
                </div>
                <div class="title-card-item">
                    <div class="date-card-item">
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
            <div class="card-item <?= $count > 4 ? 'hidden-card-item' : '' ?>" data-id="<?= $row['MaHoatDong'] ?>">  
                <div class="img-card-item">
                    <img src="<?= $row['AnhAvt'] ?>" alt="">
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
            <div class="card-item <?= $count > 4 ? 'hidden-card-item' : '' ?>" data-id="<?= $row['MaHoatDong'] ?>">  
                <div class="img-card-item">
                    <img src="<?= $row['AnhAvt'] ?>" alt="">
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

    <!-- <script src="../assets/js/manager-pages.js"></script> -->

</body>
</html>