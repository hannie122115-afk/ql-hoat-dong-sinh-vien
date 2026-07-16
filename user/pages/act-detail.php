<?php 
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
require_once "../../config/db.php";
require_once "../auth.php";

// var_dump($_SERVER['REQUEST_METHOD']);
// exit;

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

// echo "<pre>";
// var_dump($actId);
// var_dump($act);
// echo "</pre>";
// exit;

$dateStart = new DateTime($act['ThoiGianBatDau']);
$dateEnd = new DateTime($act['ThoiGianKetThuc']);
$dateCreate = new DateTime($act['NgayTao']);
$dateNow = new DateTime();

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

// var_dump($bonus);
// exit;

$sql4 = "SELECT * 
        FROM DonVi
        WHERE MaDonVi = ?";
$stmt4 = $conn->prepare($sql4);
$stmt4->execute([$org['MaDonVi']]);
$unit = $stmt4->fetch(PDO::FETCH_ASSOC);

$sql5 = "SELECT * 
        FROM CauHoiDangKy
        WHERE MaHoatDong = ?";
$stmt5 = $conn->prepare($sql5);
$stmt5->execute([$actId]);
$questions = $stmt5->fetchAll(PDO::FETCH_ASSOC);
$index = 0;

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $answers = $_POST['answers'] ?? [];
    try{
        $conn->beginTransaction();

        $sql6 = "INSERT INTO DangKy (MSSV, MaHoatDong) VALUES (?, ?)";
        $stmt6 = $conn->prepare($sql6);
        $stmt6->execute([$user['MSSV'], $actId]);
        foreach($answers as $quesId => $answer){
            $sql7 = "INSERT INTO CauTraLoi(MSSV, MaHoatDong, MaCauHoi, NoiDung) VALUES (?, ?, ?, ?)";
            $stmt7 = $conn->prepare($sql7);
            $stmt7->execute([
                $user['MSSV'],
                $actId,
                $quesId, 
                $answer
            ]);
        }
        $conn->commit();
        $_SESSION['success_register_act_message'] = 'Đăng ký hoạt động thành công!';
        echo json_encode([
            "success" => true, 
            "message" => "Đăng ký hoạt động thành công",
            "actCode" => $actId]);
            exit;
        }catch(Exception $e){
            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
            exit;
    }
}

$sql8 = "SELECT *
        FROM DangKy
        WHERE MSSV = ?
        AND MaHoatDong = ?";
$stmt8 = $conn->prepare($sql8);
$stmt8->execute([$user['MSSV'], $actId]);
$isRegistered = $stmt8->fetch(PDO::FETCH_ASSOC);

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
                <button class="act-detail-btn detail-btn">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Chi tiết hoạt động</span>
                </button>
                <?php if($isRegistered): ?>
                    <button class="registered-btn">
                        <span>Đã đăng ký</span>
                    </button>
                <?php elseif($dateNow->format('Y-m-d H:i:s') >= $dateEnd->format('Y-m-d H:i:s') ): ?>
                    <button class=" register-btn">
                        <span>Đã kết thúc</span>
                    </button>
                <?php else: ?>
                    <button class="act-detail-btn register-btn">
                        <i class="fa-solid fa-pen"></i>
                        <span>Đăng ký</span>
                    </button>
                <?php endif; ?>
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

        <div class="act-detail-register act-detail-block" id="act-detail-2">
            <div class="act-detail-register-title">
                <h3>Thông tin đăng ký</h3>
                <span>Vui lòng điền đầy đủ thông tin vào form bên dưới để đăng ký tham gia hoạt động.</span>
            </div>
            <div class="act-detail-register-form">
                <form action="" id="act-register-form">
                    <?php 
                        foreach($questions as $row) {
                        if($row['LoaiCauHoi'] != "custom"){
                            $index++;?>
                    <div class="auto-ques-form">
                        <h4><?= $index ?>. <?=  $row['TenHienThi'] ?></h4>
                        <input type="text" name="answers[<?= $row['MaCauHoi'] ?>]" id="" value="<?= ($row['LoaiCauHoi'] == 'GioiTinh') ? ($user[$row['LoaiCauHoi']] == 0 ? "Nam" : "Nữ") : $user[$row['LoaiCauHoi']] ?>" readonly>
                    </div>
                    <?php } }?>

                    <?php foreach($questions as $row) {
                        if($row['LoaiCauHoi'] == "custom"){
                            $index++;?>
                    <div class="auto-ques-form">
                        <h4><?= $index ?>. <?= $row['TenHienThi'] ?></h4>
                        <input type="text" name="answers[<?= $row['MaCauHoi'] ?>]" id="" >
                    </div>
                    <?php } }?>
                    <div id="register-act-btn">
                        <button type="button" class="register-act-btn" data-id="<?= $act['MaHoatDong'] ?>">Đăng ký</button>
                    </div>
                </form>
                
            </div>
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