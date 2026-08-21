 <?php 
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
require_once "../../config/db.php";
require_once "../auth.php";


$sql3 = "SELECT DISTINCT NamHoc 
        FROM HocKy  
        WHERE ThoiGianBatDau IS NOT NULL
            AND ThoiGianKetThuc IS NOT NULL
        ORDER BY NamHoc DESC";
$stmt3 = $conn->prepare($sql3);
$stmt3->execute();

$sql1 = "SELECT 
            hd.*,
            COUNT(dk.MSSV) AS total
        FROM HoatDong hd
        LEFT JOIN DangKy dk
            ON hd.MaHoatDong = dk.MaHoatDong
        LEFT JOIN HocKy hk
            ON hk.MaHocKy = hd.MaHocKy
        WHERE dk.DaDiemDanh = 0 
        AND dk.MSSV = ?";

$sql1 .= " GROUP BY hd.MaHoatDong ORDER BY hd.ThoiGianBatDau DESC";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute([$user['MSSV']]);

?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/user-pages.css">

</head>
<body>

    <div class="container">
        <div class="profile-user-title registered-header">
            <div >
                <h2>Hoạt động đã đăng ký</h2>
            </div>
            
        </div>
        
        <div class="card-container">
            <?php if ($stmt1->rowCount() > 0): ?>
                <?php 
                while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
                    ?>
                <div class="card-item" data-id="<?= $row['MaHoatDong'] ?>">  
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
            <?php else: ?>
                <div class="empty-state">
                    <i class="fa-solid fa-calendar-xmark"></i>
                    <p>Bạn chưa đăng ký hoạt động nào.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>