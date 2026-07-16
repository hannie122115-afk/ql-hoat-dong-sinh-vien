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
        WHERE hd.MaToChuc = ? ";
if(!empty($keyword)){
    $sql1 .= "AND hd.TenHoatDong LIKE ? ";
}
$sql1 .= "GROUP BY hd.MaHoatDong";
$stmt1 = $conn->prepare($sql1);
empty($keyword) ? $stmt1->execute([$org['MaToChuc']]) : $stmt1->execute([$org['MaToChuc'], $search]);

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
    <h1>ĐÂY LÀ TRANG QUẢN LÝ HOẠT ĐỘNG</h1>
    <div class="management-act-container">
        <div class="management-act-header">
            <div class="management-act-title">
                <h2>Quản lý hoạt động</h2>
                <span>Danh sách các hoạt động do CLB tạo và quản lý</span>
            </div>
            <div class="management-search-act">
                <div class="management-btn-search-act">
                        <input type="text" name="activity" class="search-input" data-type="activity" id="act-management" placeholder="Tìm kiếm hoạt động...">
                        <button type="button" id="btn-search-act-management">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                </div>
                <div class="suggest-box"></div>
            </div>
            <div class="status-act-dropdown">
                <span>Trạng thái</span>
                <div class="status-dropdown">
                    <div class="">Sắp diễn ra</div>
                    <div class="">Đang diễn ra</div>
                    <div class="">Đã kết thúc</div>
                </div>
            </div>
        </div>

        <table class="management-act-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên hoạt động</th>
                    <th>Thời gian diễn ra</th>
                    <th>Địa điểm</th>
                    <th>Số lượng đăng ký</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1; 
                while ($act1 = $stmt1->fetch(PDO::FETCH_ASSOC)):?>
                <tr>
                    <td><?= $stt++ ?></td>
                    <td>
                        <div class="management-act-info">
                            <img src="<?= $act1['AnhBia'] ?>" alt="">
                            <h4><?= $act1['TenHoatDong'] ?></h4>
                        </div>
                    </td>
                    <td>
                        <div class="management-act-time">
                            <?php 
                                $dateStart = new DateTime($act1['ThoiGianBatDau']); 
                                $dateEnd = new DateTime($act1['ThoiGianKetThuc']);
                            ?>
                            <span><?= $dateStart->format('H:i') ?>, <?= $dateStart->format('d/m/Y') ?> - <?= $dateEnd->format('H:i') ?>, <?= $dateEnd->format('d/m/Y') ?></span>
                        </div>
                    </td>
                    <td>
                        <div class="management-act-locate">
                            <i class="fa-solid fa-location-dot"></i>
                            <span><?= $act1['DiaDiem'] ?></span>
                        </div>
                    </td>
                    <td>
                        <div class="management-act-amount">
                            <i class="fa-solid fa-user-group"></i>
                            <span><?= $act1['total'] ?>/<?= $act1['SoLuongToiDa']?></span>
                        </div>
                    </td>
                    <td>
                        <div class="management-act-status">
                            <?php 
                                $currentDate = new DateTime();
                                if($dateStart > $currentDate):
                            ?>
                                <span class="status upcoming">
                                    Sắp diễn ra
                                </span>
                        </div>
                            <?php
                                elseif($dateEnd <= $currentDate):
                            ?>
                                <span class="status running">
                                    Đã kết thúc
                                </span>
                            <?php
                                else:
                            ?>
                                <span class="status finished">
                                    Đang diễn ra
                                </span>
                            <?php endif ?>
                    </td>
                    <td>
                        <button class="edit-management-act-btn row-act-management" data-id="<?= $act1['MaHoatDong'] ?>">
                            Sửa
                        </button>
                        <button class="delete-management-act-btn"  data-id="<?= $act1['MaHoatDong'] ?>">
                            Xóa
                        </button>
                        
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div id="delete-act-modal" class="modal">
            <div class="modal-content">
                <h3>Xác nhận xóa</h3>
                <p id="delete-act-message"></p>
                <div class="model-btn">
                    <button id="btn-cancel-delete-act">Hủy</button>
                    <button id="btn-confirm-delete-act">Xóa</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>