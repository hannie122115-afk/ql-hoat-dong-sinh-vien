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

$actId = $_GET['id'] ?? '';
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$search = "%$keyword%";
$status = $_GET['status'] ?? '';

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
$dateNow = new DateTime();

$sql2 = "SELECT * 
        FROM MucCongDiemRenLuyen
        WHERE MaMucCongDiem = ?";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute([$act['MaMucCongDiem']]);
$bonus = $stmt2->fetch(PDO::FETCH_ASSOC);

// $sql3 = "SELECT *
//         FROM DangKy dk, SinhVien sv, Nganh n, DonVi dv
//         WHERE dk.MSSV = sv.MSSV
//         AND sv.MaNganh = n.MaNganh
//         AND sv.MaDonVi = dv.MaDonVi
//         AND dk.MaHoatDong = ?";
// $params = [$actId];
// if(!empty($keyword)){
//     $sql3 .= " AND (sv.MSSV LIKE ? OR sv.HoTen LIKE ?)";
//     $params[] = $search;
//     $params[] = $search;
// }
// if($status == "registering"){
//     $sql3 .= " AND dk.DaDiemDanh = 0";
// } elseif($status == "checked"){
//     $sql3 .= " AND dk.DaDiemDanh = 1";
// }

// $stmt3 = $conn->prepare($sql3);
// $stmt3->execute($params);

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
    <h1>ĐÂY LÀ TRANG CHI TIẾT HOẠT ĐỘNG</h1>

    <?php if(isset($_SESSION['success_update_act_message'])){ ?>
        <div class="success_update_act_message">
            <?= $_SESSION['success_update_act_message']; ?>
        </div>
    <?php unset($_SESSION['success_update_act_message']); } ?>

    <div class="act-detail-container" id="act-detail-container" data-id="<?= $actId ?>">

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
                <button class="act-detail-btn detail-btn">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Chi tiết hoạt động</span>
                </button>
                <button class="act-detail-btn list-register-btn">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Danh sách sinh viên</span>
                </button>
                <button class="act-detail-btn take-attendance-btn">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Điểm danh</span>
                </button>
                
            </div>
            
            <?php if(isset($_SESSION['success_register_act_message'])){ ?>
                <div class="success_register_act_message">
                    <?= $_SESSION['success_register_act_message']; ?>
                </div>
            <?php unset($_SESSION['success_register_act_message']); } ?>
            
        </div>

        <div class="act-detail-describe act-detail-block active" id="act-detail-1" >
            <h3>Chi tiết hoạt động</h3>
            <p><?= $act['NoiDungHD'] ?></p>
            <h3>Đối tượng tham gia</h3>
            <p><?= $act['DoiTuongThamGia'] ?></p>
        </div>

        <!-- Danh sach sv -->
        <div class="act-detail-list act-detail-block" id="act-detail-2">
            <h1>DANH SÁCH SINH VIÊN</h1>
            <div class="student-list-header">
                <div class="management-search-act">
                    <div class="student-btn-search-act">
                        <input type="text" name="student" class="search-input" data-type="student" id="act-student" placeholder="Tìm kiếm sinh viên..." value="<?= htmlspecialchars($keyword) ?>">
                        <button type="button" id="btn-search-act-student">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                    <div class="suggest-box"></div>
                </div>
                <div class="status-student-dropdown">
                    <span>Trạng thái</span>
                    <div class="status-dropdown-selected">
                        <span id="selected-status">
                            <?=
                            match($status){
                                'registering' => 'Đã đăng ký',
                                'checked' => 'Đã điểm danh',
                                default => 'Tất cả'
                            }
                            ?>
                        </span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>

                    <div class="status-dropdown-menu">
                        <div class="status-option" data-status="">Tất cả</div>
                        <div class="status-option" data-status="registering">Đã đăng ký</div>
                        <div class="status-option" data-status="checked">Đã điểm danh</div>
                    </div>
                </div>
            </div>
            <table class="student-act-table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã số sinh viên</th>
                        <th>Họ tên</th>
                        <th>Ngành</th>
                        <th>Khóa</th>
                        <th>Đơn vị</th>
                        <th>Trạng thái</th>
                        <th>Thời gian đăng ký</th>
                    </tr>
                </thead>
                <tbody id="student-list-body">
                <?php include "student-list.php" ?>
                </tbody>
            </table>
        </div>

        <!-- Diem danh -->
        <div class="act-detail-take-attendance act-detail-block" id="act-detail-3">
            <h2>DIEM DANH</h2>
            <div class="qr-code">
                <img src="<?= $act['LinkQr'] ?>" alt="Mã qr">
            </div>
            <button class="btn-close-form" data-formid="<?= $act['MaForm'] ?>">
                Đóng form
            </button>
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

    </div>
</body>
</html>