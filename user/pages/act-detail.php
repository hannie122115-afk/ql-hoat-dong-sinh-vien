<?php 
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
require_once "../../config/db.php";
require_once "../auth.php";

$actId = $_GET['id'] ?? '';

$sql1 = "SELECT 
            hd.*,
            COUNT(dk.MSSV) AS total
        FROM HoatDong hd
        LEFT JOIN DangKy dk
            ON hd.MaHoatDong = dk.MaHoatDong
        WHERE hd.MaHoatDong = ?
        GROUP BY hd.MaHoatDong";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute([$actId]);
$act = $stmt1->fetch(PDO::FETCH_ASSOC);

$dateStart = new DateTime($act['ThoiGianBatDau']);
$dateEnd = new DateTime($act['ThoiGianKetThuc']);
$dateCreate = new DateTime($act['NgayTao']);

$sql2 = "SELECT * 
        FROM ToChuc
        WHERE MaToChuc = ?";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute([$act['MaToChuc']]);
$org = $stmt2->fetch(PDO::FETCH_ASSOC);

$sql3 = "SELECT * 
        FROM MucCongDiemRenLuyen
        WHERE MaMucCongDiem = ?";
$stmt3 = $conn->prepare($sql3);
$stmt3->execute([$act['MaMucCongDiem']]);
$bonus = $stmt3->fetch(PDO::FETCH_ASSOC);

$sql4 = "SELECT * 
        FROM DonVi
        WHERE MaDonVi = ?";
$stmt4 = $conn->prepare($sql4);
$stmt4->execute([$org['MaDonVi']]);
$unit = $stmt4->fetch(PDO::FETCH_ASSOC);




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    ĐÂY LÀ TRANG CHI TIẾT HOẠT ĐỘNG 


    <div class="act-detail-container">

        <div class="act-detail-img">
            <img src="<?= $act['AnhBia'] ?>" alt="ảnh bìa" >
            <div class="act-date">
                <span><?= $dateStart->format('d') ?></span>
                <small><?= $dateStart->format('m') ?></small>
            </div>
        </div>

        <div class="act-detail-title">
            <div class="act-detail-title-info">
                <h2><?= $act['TenHoatDong'] ?></h2>
                <span><?= $org['TenToChuc'] ?></span>
            </div>
            
            <div class="act-detail-item">
                <button class="act-detail-btn">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Chi tiết hoạt động</span>
                </button>
                <button class="act-detail-register-btn">
                    <i class="fa-solid fa-pen"></i>
                    <span>Đăng ký</span>
                </button>
            </div>
        </div>

        <div class="act-detail-describe">
            <h3>Chi tiết hoạt động</h3>
            <p><?= $act['NoiDungHD'] ?></p>
        </div>

        <div class="act-detail-info">
            <div class="act-detail-info-item">
                <div class="act-detail-info-right">
                    <i class="fa-solid fa-clock"></i>
                    <span>Thời gian bắt đầu</span>
                </div>
                <div class="act-detail-info-left">
                    <?= $dateStart->format('H:i') ?> , <?= $dateStart->format('d:m:y')?>
                </div>
            </div>

            <div class="act-detail-info-item">
                <div class="act-detail-info-right">
                    <i class="fa-solid fa-clock"></i>
                    <span>Thời gian kết thúc</span>
                </div>
                <div class="act-detail-info-left">
                    <?= $dateEnd->format('H:i') ?> , <?= $dateStart->format('d:m:y')?>
                </div>
            </div>

            <div class="act-detail-info-item">
                <div class="act-detail-info-right">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>Địa điểm</span>
                </div>
                <div class="act-detail-info-left">
                    <?= $act['DiaDiem'] ?>
                </div>
            </div>
            <div class="act-detail-info-item">
                <div class="act-detail-info-right">
                    <i class="fa-solid fa-star"></i>
                    <span>Điểm rèn luyện</span>
                </div>
                <div class="act-detail-info-left">
                    <?= $act['DiemRenLuyen'] ?> điểm
                </div>
            </div>
            <div class="act-detail-info-item">
                <div class="act-detail-info-right">
                    <i class="fa-solid fa-star"></i>
                    <span>Mục cộng điểm</span>
                </div>
                <div class="act-detail-info-left">
                    <?= $bonus['TenMucCongDiem'] ?> 
                </div>
            </div>
            <div class="act-detail-info-item">
                <div class="act-detail-info-right">
                    <i class="fa-solid fa-user-group"></i>
                    <span>Số lượng đã đăng ký</span>
                </div>
                <div class="act-detail-info-left">
                    <?= $act['total'] ?>/<?= $act['SoLuongToiDa']?> sinh viên
                </div>
            </div>
            <div class="act-detail-info-item">
                <div class="act-detail-info-right">
                    <i class="fa-regular fa-building"></i>
                    <span>Đơn vị</span>
                </div>
                <div class="act-detail-info-left">
                    <?= $unit['TenDonVi'] ?>
                </div>
            </div>
            <div class="act-detail-info-item">
                <div class="act-detail-info-right">
                    <i class="fa-solid fa-calendar"></i>
                    <span>Ngày tạo</span>
                </div>
                <div class="act-detail-info-left">
                    <?= $dateCreate->format('d:m:y') ?>
                </div>
            </div>
        </div>

        <!-- <div class="act-detail-rate">
            <h3>Bình luận (so luong de o day)</h3>
            <div class="act-detail-rate-input">
                <div class="avt-rater">
                    Anh dai dien o day
                </div>
                <div class="rate-input">
                    <input type="text" name="" id="">
                </div>
            </div>
            <div class="act-detail-rated">
                <div class="avt-rater">
                    Anh dai dien o day
                </div>
                <div class="info-rating">
                    <h5>Ten nguoi binh luan</h5>
                    <span>noi dung binh luan</span>

                </div>
            </div>

        </div> -->
    </div>
</body>
</html>