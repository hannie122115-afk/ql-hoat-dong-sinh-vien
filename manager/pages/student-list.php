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

$sql3 = "SELECT *
        FROM DangKy dk, SinhVien sv, Nganh n, DonVi dv
        WHERE dk.MSSV = sv.MSSV
        AND sv.MaNganh = n.MaNganh
        AND sv.MaDonVi = dv.MaDonVi
        AND dk.MaHoatDong = ?";
$params = [$actId];
if(!empty($keyword)){
    $sql3 .= " AND (sv.MSSV LIKE ? OR sv.HoTen LIKE ?)";
    $params[] = $search;
    $params[] = $search;
}
if($status == "registering"){
    $sql3 .= " AND dk.DaDiemDanh = 0";
} elseif($status == "checked"){
    $sql3 .= " AND dk.DaDiemDanh = 1";
}
$sql3 .= " ORDER BY dk.ThoiGianDangKy DESC";

$stmt3 = $conn->prepare($sql3);
$stmt3->execute($params);
$sql3 = "SELECT *
        FROM DangKy dk, SinhVien sv, Nganh n, DonVi dv
        WHERE dk.MSSV = sv.MSSV
        AND sv.MaNganh = n.MaNganh
        AND sv.MaDonVi = dv.MaDonVi
        AND dk.MaHoatDong = ?";
$params = [$actId];
if(!empty($keyword)){
    $sql3 .= " AND (sv.MSSV LIKE ? OR sv.HoTen LIKE ?)";
    $params[] = $search;
    $params[] = $search;
}
if($status == "registering"){
    $sql3 .= " AND dk.DaDiemDanh = 0";
} elseif($status == "checked"){
    $sql3 .= " AND dk.DaDiemDanh = 1";
}

$stmt3 = $conn->prepare($sql3);
$stmt3->execute($params);
?>

<?php $stt = 1; 
while ($student = $stmt3->fetch(PDO::FETCH_ASSOC)):?>
<tr>
    <td><?= $stt++ ?></td>
    <td>
        <div class="student-act-id">
            <span><?= $student['MSSV'] ?></span>
        </div>
    </td>
    <td>
        <div class="student-act-name">
            <span><?= $student['HoTen'] ?></span>
        </div>
    </td>
    <td>
        <div class="student-act-class">
            <span><?= $student['TenNganh'] ?></span>
        </div>
    </td>
    <td>
        <div class="student-act-year">
            <span><?= $student['Khoa'] ?></span>
        </div>
    </td>
    <td>
        <div class="student-act-unit">
            <span><?= $student['Khoa'] ?></span>
        </div>
    </td>
    <td>
        <div class="student-act-status">
            <?php 
                if($student['DaDiemDanh'] == 0):
            ?>
                <span class="status registering">
                    Đã đăng ký
                </span>
        </div>
            <?php
                else:
            ?>
                <span class="status checked">
                    Đã điểm danh
                </span>
            <?php endif ?>
    </td>
    <td>
        <?php $dateRegistered = new DateTime($student['ThoiGianDangKy']); ?>
        <div class="student-act-year">
            <span><?= $dateRegistered->format('H:i') ?>, <?= $dateRegistered->format('d/m/Y') ?> </span>
        </div>
    </td>
</tr>
<?php endwhile; ?>