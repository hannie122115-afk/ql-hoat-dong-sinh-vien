 <?php 
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
require_once "../../config/db.php";
require_once "../auth.php";

$sql1 = "SELECT 
            hd.*,
            COUNT(dk.MSSV) AS total
        FROM HoatDong hd
        LEFT JOIN DangKy dk
            ON hd.MaHoatDong = dk.MaHoatDong
        WHERE dk.DaDiemDanh = 0 ";
if(!empty($keyword)){
    $sql1 .= "AND hd.TenHoatDong LIKE ?";
}
$sql1 .= "GROUP BY hd.MaHoatDong";
$stmt1 = $conn->prepare($sql1);
empty($keyword) ? $stmt1->execute() : $stmt1->execute([$search]);

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
    <h1>ĐÂY LÀ TRANG HOẠT ĐỘNG ĐẪ ĐĂNG KÝ</h1>

    <div class="container">
        <div class="title-container">
            <h2>Tạo hoạt động mới</h2>
            <span>Điền đầy đủ thông tin để tạo hoạt động cho sinh viên đăng ký tham gia.</span>
        </div>
        <div class="card-container">
            <?php $count = 0;
            while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
                $count++;?>
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
        </div>
    </div>
</body>
</html>