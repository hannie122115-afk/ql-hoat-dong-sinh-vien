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

$sql1 = "SELECT *
        FROM TaiKhoanDangNhap
        WHERE MaTaiKhoan = ?";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute([$org['MaTaiKhoan']]);
$account = $stmt1->fetch(PDO::FETCH_ASSOC);


if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'change_password'){
    if(ob_get_length()) ob_clean();
    header('Content-Type: application/json; charset=utf-8');

    $currentPassword = $_POST['currentPassword'] ?? '';
    $newPassword     = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin!']);
        exit;
    }

    if (strlen($newPassword) < 6) {
        echo json_encode(['success' => false, 'message' => 'Mật khẩu phải từ 6 ký tự trở lên!']);
        exit;
    } elseif (!preg_match('/[A-Z]/', $newPassword)) {
        echo json_encode(['success' => false, 'message' => 'Mật khẩu phải có ít nhất 1 chữ in hoa!']);
        exit;
    } elseif (!preg_match('/[a-z]/', $newPassword)) {
        echo json_encode(['success' => false, 'message' => 'Mật khẩu phải có ít nhất 1 chữ thường!']);
        exit;
    } elseif (!preg_match('/[0-9]/', $newPassword)) {
        echo json_encode(['success' => false, 'message' => 'Mật khẩu phải có ít nhất 1 số!']);
        exit;
    }

    if ($newPassword !== $confirmPassword) {
        echo json_encode(['success' => false, 'message' => 'Mật khẩu mới và xác nhận mật khẩu không khớp!']);
        exit;
    }

    try{
        $sql1 = "SELECT MatKhau FROM TaiKhoanDangNhap WHERE MaTaiKhoan = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute([$org['MaTaiKhoan']]);
        $account = $stmt1->fetch(PDO::FETCH_ASSOC);

        if (!$account) {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy tài khoản!']);
            exit;
        }

        $isMatch = password_verify($currentPassword, $account['MatKhau']);


        if (!$isMatch) {
            echo json_encode(['success' => false, 'message' => 'Mật khẩu hiện tại không chính xác!']);
            exit;
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql2 = "UPDATE TaiKhoanDangNhap SET MatKhau = ? WHERE MaTaiKhoan = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute([$hashedPassword, $org['MaTaiKhoan']]);

        echo json_encode(['success' => true, 'message' => 'Đổi mật khẩu thành công!']);
        exit;
    }catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()]);
        exit;
    }
    
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    header('Content-Type: application/json');
    try{
        $orgName = trim($_POST['orgName'] ?? $org['TenToChuc']);
        $orgInitName = trim($_POST['orgInitName'] ?? $org['TenVietTat']);
        $unitId = $_POST['unitId'] ?? $unit['MaDonVi'];
        $orgDate = $_POST['orgDate'] ?? $org['NgayThanhLap'];
        $orgDescribe = $_POST['orgDescribe'] ?? $org['MoTa'];


        // Xử lý upload ảnh
        $uploadDir = "../../assets/images/uploads/manager/";
        $dbDir = "../assets/images/uploads/manager/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $pathAvt = $org['AnhDaiDien'];
        if (isset($_FILES["orgAvt"]) && $_FILES["orgAvt"]["error"] === UPLOAD_ERR_OK) {

            $fileName = time() . "_avt_" . basename($_FILES["orgAvt"]["name"]);

            if (move_uploaded_file($_FILES["orgAvt"]["tmp_name"], $uploadDir . $fileName)) {
                $pathAvt = $dbDir . $fileName;
            }
        }

        $sql2 = "UPDATE ToChuc
                SET MaDonVi = ?,
                    TenToChuc = ?,
                    TenVietTat = ?,
                    NgayThanhLap = ?,
                    MoTa = ?,
                    AnhDaiDien = ?
                WHERE MaToChuc = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2 -> execute([$unitId, $orgName, $orgInitName, $orgDate, $orgDescribe, $pathAvt, $org['MaToChuc']]);

        echo json_encode([
            'success' => true,
            'message' => 'Cập nhật thông tin thành công!',
            'newAvt'  => $pathAvt
        ]);
        exit;
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
        ]);
        exit;
    }
}





?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="profile-org-container">
        <div class="profile-org-title">
            <h2>Hồ sơ</h2>
            <span>Quản lý thông tin tổ chức của bạn.</span>
        </div>
        <div class="profile-org-block">
            <form action="" method="post" id="profileForm">
                <div class="profile-org-item">
                    <h3>Ảnh đại diện</h3>
                    <div class="profile-org-avt">
                        <img id="profile-avt-img" src="<?=  $org['AnhDaiDien'] ?>" alt="Ảnh đại diện tổ chức">
                    </div>
                    <div>
                        <i class="fa-solid fa-rotate"></i>
                        Thay đổi ảnh 
                        <input type="file" name="orgAvt" id="profile-avt-input">
                    </div>
                </div>

                <div class="profile-org-item">
                    <h3>Thông tin câu lạc bộ</h3>
                    <div class="org-info-block">
                        <div class="org-info-item">
                            <h4>Tên tổ chức</h4>
                            <input type="text" name="orgName" id="" value="<?= htmlspecialchars($org['TenToChuc']) ?>">
                        </div>

                        <div class="org-info-item">
                            <h4>Tên viết tắt</h4>
                            <div class="org-info-item-input">
                                <input type="text" name="orgInitName" id="" value="<?= htmlspecialchars($org['TenVietTat']) ?>">
                            </div>
                        </div>

                        <!-- <div class="org-info-item">
                            <h4>Email</h4>
                            <div class="org-info-item-input">
                                <input type="text" name="orgEmail" id="" value="<?= htmlspecialchars($account['Email']) ?>">
                            </div>
                        </div> -->

                        <div class="org-info-item ">
                            <h4>Đơn vị quản lý</h4>
                            <div class="org-info-item-input">
                                <input type="text" class="search-input" data-type="unit" data-value="profile" value="<?= htmlspecialchars($unit['TenDonVi']) ?>" id="unit">
                                <input type="hidden" value="<?= htmlspecialchars($unit['MaDonVi']) ?>" id="unitId" name="unitId">
                            </div>
                            <div class="suggest-box org-unit-suggest-box"></div>
                        </div>

                        <div class="org-info-item">
                            <h4>Ngày thành lập</h4>
                            <div class="org-info-item-input">
                                <input type="date" name="orgDate" id="" value="<?= htmlspecialchars($org['NgayThanhLap']) ?>">
                            </div>
                        </div>

                        <div class="org-info-item">
                            <h4>Mô tả</h4>
                            <div class="org-info-item-textarea">
                                <textarea name="orgDescribe" id=""> <?= htmlspecialchars($org['MoTa']) ?></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit">
                        <i class="fa-solid fa-check"></i>
                        Lưu 
                    </button>
                </div>
            </form>

            <div class="profile-bottom-wrapper">
                <div class="profile-org-item">
                    <h3>Đổi mật khẩu</h3>
                    <form action="" id="changePasswordForm">
                        <div class="org-password">
                            <div class="org-password-item password-block">
                                <h4>Mật khẩu hiện tại</h4>
                                <div class="org-password-item-input">
                                    <input type="text" name="currentPassword" class="hidden-password">
                                    <i class="fa-solid fa-eye toggle-password-icon"></i>
                                </div>
                            </div>

                            <div class="org-password-item password-block">
                                <h4>Mật khẩu mới</h4>
                                <div class="org-password-item-input">
                                    <input type="text" name="newPassword" class="hidden-password">
                                    <i class="fa-solid fa-eye toggle-password-icon"></i>
                                </div>
                                <!-- <span>Mật khẩu phải có ít nhất 6 ký tự, ít nhất 1 ký tự in hoa, 1 ký tự thường và 1 số.</span> -->
                            </div>

                            <div class="org-password-item password-block">
                                <h4>Xác nhận mật khẩu mới</h4>
                                <div class="org-password-item-input">
                                    <input type="text" name="confirmPassword" class="hidden-password">
                                    <i class="fa-solid fa-eye toggle-password-icon"></i>
                                </div>
                            </div>
                            <button type="submit" >
                                <i class="fa-solid fa-key"></i> Đổi mật khẩu
                            </button>
                        </div>
                    </form>
                </div>

                <div class="profile-org-item">
                    <h3>Thông tin tài khoản</h3>
                    <div class="org-info-account">
                        <div class="org-info-account-item">
                            <div class="org-info-account-title">
                                <i class="fa-solid fa-user"></i>
                                <h4>Email đăng nhập</h4>
                            </div>
                            <div class="org-info-account-value">
                                <?= $account['Email'] ?>
                            </div>
                        </div>

                        <div class="org-info-account-item">
                            <div class="org-info-account-title">
                                <i class="fa-solid fa-calendar-day"></i>
                                <h4>Vai trò</h4>
                            </div>
                            <div class="org-info-account-value">
                                Người quản trị
                            </div>
                        </div>

                        <div class="org-info-account-item">
                            <div class="org-info-account-title">
                                <i class="fa-solid fa-circle-dot"></i>
                                <h4>Trạng thái</h4>
                            </div>
                            <div class="org-info-account-value org-info-account-value-status">
                                Đang hoạt động
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>