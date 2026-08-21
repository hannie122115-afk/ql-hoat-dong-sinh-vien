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

$semester = $_GET['semester'] ?? '';
$year = $_GET['year'] ?? '';

$sql4 = "SELECT *
        FROM TaiKhoanDangNhap
        WHERE MaTaiKhoan = ?";
$stmt4 = $conn->prepare($sql4);
$stmt4->execute([$user['MaTaiKhoan']]);
$account = $stmt4->fetch(PDO::FETCH_ASSOC);

$sql3 = "SELECT DISTINCT NamHoc
        FROM HocKy
        WHERE ThoiGianBatDau IS NOT NULL
            AND ThoiGianKetThuc IS NOT NULL";
$stmt3 = $conn->prepare($sql3);
$stmt3->execute();


$stmt5 = null;
$totalPoint = 0;

if (!empty($semester) && !empty($year)) {

    $sql5 = "SELECT
            m.MaMucCongDiem,
            m.TenMucCongDiem,
            m.DiemToiDa,
            COALESCE(SUM(c.DiemNhanDuoc), 0) AS TongDiem
        FROM MucCongDiemRenLuyen m
        LEFT JOIN ChiTietDiemRenLuyen c
            ON c.MaMucCongDiem = m.MaMucCongDiem
            AND c.MSSV = ?
            AND c.MaHocKy IN (
                SELECT MaHocKy
                FROM HocKy
                WHERE HocKy = ?
                AND NamHoc = ?
            )
        WHERE m.MaMucCongDiem <> '00'
        GROUP BY
            m.MaMucCongDiem,
            m.TenMucCongDiem,
            m.DiemToiDa
        ORDER BY m.MaMucCongDiem";        
    $stmt5 = $conn->prepare($sql5);
    $stmt5->execute([
        $user['MSSV'],
        $semester,
        $year
    ]);

    $sqlTotal = "SELECT SUM(LEAST(TongDiem, DiemToiDa)) AS TongCong
                FROM (
                    SELECT
                        c.MaMucCongDiem,
                        SUM(c.DiemNhanDuoc) AS TongDiem,
                        m.DiemToiDa
                    FROM ChiTietDiemRenLuyen c
                    JOIN HocKy hk
                        ON c.MaHocKy = hk.MaHocKy
                    JOIN MucCongDiemRenLuyen m
                        ON m.MaMucCongDiem = c.MaMucCongDiem
                    WHERE c.MSSV = ?
                        AND hk.HocKy = ?
                        AND hk.NamHoc = ?
                    GROUP BY
                        c.MaMucCongDiem,
                        m.DiemToiDa
                ) AS temp;";
    $stmtTotal = $conn->prepare($sqlTotal);
    $stmtTotal->execute([
        $user['MSSV'],
        $semester,
        $year
    ]);
    $totalPoint = $stmtTotal->fetch(PDO::FETCH_ASSOC)['TongCong'] ?? 0;
}



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

    if ($newPassword !== $confirmPassword) {
        echo json_encode(['success' => false, 'message' => 'Mật khẩu mới và xác nhận mật khẩu không khớp!']);
        exit;
    }

    if (strlen($newPassword) < 6) {
        echo json_encode(['success' => false, 'message' => 'Mật khẩu mới phải có ít nhất 6 ký tự!']);
        exit;
    }

    try{
        $sql1 = "SELECT MatKhau FROM TaiKhoanDangNhap WHERE MaTaiKhoan = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute([$user['MaTaiKhoan']]);
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
        $stmt2->execute([$hashedPassword, $user['MaTaiKhoan']]);

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
        $userName = trim($_POST['userName'] ?? $user['HoTen']);
        $userGender = trim($_POST['userGender'] ?? $user['GioiTinh']);
        $userTel = trim($_POST['userTel'] ?? $user['SoDienThoai']);
        $userBirth = trim($_POST['userBirth'] ?? $user['NgaySinh']);
        // $userName = trim($_POST['userName'] ?? $user['HoTen']);
        $userYear = trim($_POST['userYear'] ?? $user['Khoa']);
        $userUnitId = trim($_POST['userUnitId'] ?? $user['MaDonVi']);
        $classId = trim($_POST['classId'] ?? $user['MaNganh']);

        if( $userName === '' ||
            $userGender === '' ||
            $userTel === '' ||
            $userBirth === '' ||
            $userYear === '' ||
            $userUnitId === '' ||
            $classId === ''){
            echo json_encode([
            'success' => false,
            'message' => 'Vui lòng nhập đầy đủ thông tin',
            ]);
            exit;
        }

        // Xử lý upload ảnh
        $uploadDir = "../../assets/images/uploads/user/";
        $dbDir = "../assets/images/uploads/user/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $pathAvt = $user['AnhDaiDien'];
        if (isset($_FILES["userAvt"]) && $_FILES["userAvt"]["error"] === UPLOAD_ERR_OK) {

            $fileName = time() . "_avt_" . basename($_FILES["userAvt"]["name"]);

            if (move_uploaded_file($_FILES["userAvt"]["tmp_name"], $uploadDir . $fileName)) {
                $pathAvt = $dbDir . $fileName;
            }
        }

        $sql2 = "UPDATE SinhVien
                SET MaDonVi = ?,
                    MaNganh = ?,
                    HoTen = ?,
                    Khoa = ?,
                    GioiTinh = ?,
                    NgaySinh = ?,
                    SoDienThoai = ?,
                    AnhDaiDien = ?
                WHERE MSSV = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2 -> execute([$userUnitId, $classId, $userName, $userYear, $userGender, $userBirth, $userTel, $pathAvt, $user['MSSV']]);

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
    <div class="profile-user-container">
        <div class="profile-user-title">
            <h2>Hồ sơ</h2>
            <span>Quản lý thông tin cá nhân và theo dõi điểm rèn luyện của bạn.</span>
        </div>
        <div class="profile-user-block">
            <div class="profile-user-item">
                <div class="profile-user-avt">
                    <img src="<?= $user['AnhDaiDien'] ?>" alt="" id="profile-avt-img">
                </div>
                <div class="profile-user-name">
                    <?= $user['HoTen'] ?>
                </div>
                <div class="profile-user-role">
                    Sinh viên
                </div>
                <div class="profile-user-default">
                    <div class="profile-user-item-default">
                        <i class="fa-solid fa-address-card"></i>
                        <span>MSSV: <?= $user['MSSV'] ?></span>
                    </div>
                    <div class="profile-user-item-default">
                        <i class="fa-solid fa-school"></i>
                        <span><?= $user['TenDonVi'] ?> </span>
                    </div>
                    <div class="profile-user-item-default">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span><?= $user['TenNganh'] ?> </span>
                    </div>
                    <div class="profile-user-item-default">
                        <i class="fa-solid fa-user-graduate"></i>
                        <span>Khóa: <?= $user['Khoa'] ?> </span>
                    </div>
                    <div class="profile-user-item-default">
                        <i class="fa-solid fa-at"></i>
                        <span><?= $account['Email'] ?></span>
                    </div>
                </div>
            </div>
            <div class="profile-user-item">
                <h3>Thông tin cá nhân</h3>
                <form action="" id="profileForm" data-type="user">
                    <div class="profile-user-info-item">
                        <h4>Họ và tên</h4>
                        <div class="user-info-item-input">
                            <input type="text" name="userName" id="" value="<?= htmlspecialchars($user['HoTen']) ?>">
                        </div>
                    </div>
                    <div class="profile-user-info-item">
                        <h4>Giới tính</h4>
                        <div class="user-info-item-input profile-user-gender">
                            <div class="profile-input-gender">
                                <input type="radio" name="userGender" id="" value="male"  <?= $user['GioiTinh'] == 0 ? 'checked' : '' ?>> Nam
                            </div>
                            <div class="profile-input-gender">
                                <input type="radio" name="userGender" id="" value="female"  <?= $user['GioiTinh'] == 1 ? 'checked' : '' ?>> Nữ
                            </div>
                        </div>
                    </div>
                    <div class="profile-user-info-item">
                        <h4>Số điện thoại</h4>
                        <div class="user-info-item-input">
                            <input type="tel" name="userTel" id="" value="<?= htmlspecialchars($user['SoDienThoai']) ?>">
                        </div>
                    </div>
                    <div class="profile-user-info-item">
                        <h4>Ngày sinh</h4>
                        <div class="user-info-item-input">
                            <input type="date" name="userBirth" id="" value="<?= $user['NgaySinh'] ?>" >
                        </div>
                    </div>
                    <div class="profile-user-info-item">
                        <h4>Đơn vị</h4>
                        <div class="user-info-item-input register-input-block ">
                            <input type="text" class="search-input" data-type="unit" data-value="profile" name="userUnit" value="<?= htmlspecialchars($user['TenDonVi']) ?>" id="unit" >
                            <input type="hidden" name="userUnitId" id="userUnitId" value="<?= htmlspecialchars($user['MaDonVi']) ?>">
                        </div>
                        <div class="suggest-box suggest-box-profile"></div>
                    </div>
                    <div class="profile-user-info-item">
                        <h4>Ngành</h4>
                        <div class="user-info-item-input register-class-search">
                            <input type="text" class="search-input" data-type="class" data-value="profile" name="class" value="<?= htmlspecialchars($user['TenNganh']) ?>" >
                            <input type="hidden" name="classId" id="classId" value="<?= htmlspecialchars($user['MaNganh']) ?>">
                        </div>
                        <div class="suggest-box suggest-box-profile"></div>
                    </div>
                    <div class="profile-user-info-item">
                        <h4>Khóa</h4>
                        <div class="user-info-item-input">
                            <input type="text" name="userYear" id="" value="<?= htmlspecialchars($user['Khoa']) ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                    </div>
                    <label class="profile-user-info-item">
                        <h4>Ảnh đại diện</h4>
                        <div>
                            <i class="fa-solid fa-rotate"></i>
                            Thay đổi ảnh 
                            <input type="file" name="userAvt" id="profile-avt-input" accept="image/*">
                        </div>
                    </label>
                    <button type="submit" >
                        <i class="fa-solid fa-check"></i>
                        Lưu 
                    </button>
                </form>
            </div>
            <!-- doi mat khau -->
            <div class="profile-user-item">
                <h3>Đổi mật khẩu</h3>
                <form action="" id="changePasswordForm" data-type="user">
                    <div class="profile-user-password">
                        <h4>Mật khẩu hiện tại</h4>
                        <div class="user-password-item-input">
                            <input type="text" name="currentPassword" class="hidden-password">
                            <i class="fa-solid fa-eye toggle-password-icon"></i>
                        </div>
                    </div>
                    <div class="profile-user-password">
                        <h4>Mật khẩu mới</h4>
                        <div class="user-password-item-input">
                            <input type="text" name="newPassword" class="hidden-password">
                            <i class="fa-solid fa-eye toggle-password-icon"></i>
                        </div>
                    </div>
                    <div class="profile-user-password">
                        <h4>Xác nhận mật khẩu mới</h4>
                        <div class="user-password-item-input">
                            <input type="text" name="confirmPassword" class="hidden-password">
                            <i class="fa-solid fa-eye toggle-password-icon"></i>
                        </div>
                    </div>
                    <button type="submit" >
                        <i class="fa-solid fa-key"></i> Đổi mật khẩu
                    </button>
                </form>
            </div>
        </div>
        <div class="profile-user-table-container">
            <div class="profile-user-dropdown">
                <div class="profile-custom-dropdown" data-type="semester">
                    <span>Học kì</span>
                    <div class="profile-dropdown-selected">
                        <span class="profile-selected-text">
                            <?= !empty($semester) ? "HK" . htmlspecialchars($semester) : " Chọn học kỳ " ?>
                        </span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="profile-dropdown-menu">
                        <div class="profile-dropdown-option" data-value="">Chọn học kỳ</div>
                        <div class="profile-dropdown-option" data-value="1">HK1</div>
                        <div class="profile-dropdown-option" data-value="2">HK2</div>
                        <div class="profile-dropdown-option" data-value="3">HK3</div>
                    </div>
                </div>
                <div class="profile-custom-dropdown" data-type="year">
                    <span>Năm học</span>
                    <div class="profile-dropdown-selected">
                        <span class="profile-selected-text">
                            <?= !empty($year) ? htmlspecialchars($year) : " Chọn năm học " ?>
                        </span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="profile-dropdown-menu">
                        <?php while($row = $stmt3->fetch(PDO::FETCH_ASSOC)){ ?>
                        <div class="profile-dropdown-option" data-value="<?= $row['NamHoc'] ?>"><?= $row['NamHoc'] ?></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <table class="profile-user-table">
                <thead>
                    <tr>
                        <th>Mã tiêu chí</th>
                        <th>Tên tiêu chí</th>
                        <th>Điểm tối đa</th>
                        <th>Điểm đạt được</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($semester) || empty($year)): ?>
                        <tr class="profile-user-table-empty">
                            <td colspan="4" >
                                Vui lòng chọn học kỳ và năm học để xem chi tiết điểm rèn luyện.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php while ($point = $stmt5->fetch(PDO::FETCH_ASSOC)):?>
                        <tr>
                            <td>
                                <div class="profile-user-table-id">
                                    <span><?= $point['MaMucCongDiem'] ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="profile-user-table-name">
                                    <span><?= $point['TenMucCongDiem'] ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="profile-user-table-max-point">
                                    <span><?= $point['DiemToiDa'] ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="profile-user-table-get-point">
                                    <span><?= $point['TongDiem'] ?></span>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <tr class="profile-user-table-total">
                            <td colspan="3" >
                                Tổng cộng
                            </td>
                            <td >
                                <?= $totalPoint ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
    </div>
    <div id="notice-save-profile-user-modal" class="modal">
        <div class="modal-content">
            <h3 id="notice-save-profile-user-modal-title">Thông báo</h3>
            <p id="notice-save-profile-user-message"></p>
            <div class="model-btn">
                <button id="btn-cancel-notice-save-profile-user">Đóng</button>
                <button id="btn-close-notice-error-profile-user" class="hidden">Đóng</button>
            </div>
        </div>
    </div>
    <div id="notice-password-user-modal" class="modal">
        <div class="modal-content">
            <h3 id="notice-password-user-modal-title"></h3>
            <p id="notice-password-user-message"></p>
            <div class="model-btn">
                <button id="btn-close-notice-password-user">Đóng</button>
                <button id="btn-close-notice-error-password-user" class="hidden">Đóng</button>
            </div>
        </div>
    </div>
</body>
</html>