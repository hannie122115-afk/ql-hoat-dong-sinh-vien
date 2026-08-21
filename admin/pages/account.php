<?php 
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $unitId = $_POST['unitId'] ?? '';
    $orgName = $_POST['orgName'] ?? '';
    $orgEmail = $_POST['orgEmail'] ?? '';
    $orgPassword = strstr($orgEmail, '@', true);
    $password_hashed = password_hash($orgPassword, PASSWORD_DEFAULT);

    if(empty($unitId)){
        echo json_encode(['success' => false, 'message' => 'Vui lòng chọn đơn vị!']);
        exit;
    }elseif(empty($orgName)){
        echo json_encode(['success' => false, 'message' => 'Vui lòng nhập tên tổ chức / câu lạc bộ!']);
        exit;
    }elseif(empty($orgEmail)){
        echo json_encode(['success' => false, 'message' => 'Vui lòng nhập email tổ chức / câu lạc bộ!']);
        exit;
    }

    if(empty($orgName)){
        echo json_encode(['success' => false, 'message' => 'Vui lòng nhập tên tổ chức / câu lạc bộ!']);
        exit;
    }elseif(empty($orgEmail)){
        echo json_encode(['success' => false, 'message' => 'Vui lòng nhập email tổ chức / câu lạc bộ!']);
        exit;
    }elseif(empty($unitId)){
        echo json_encode(['success' => false, 'message' => 'Vui lòng chọn đơn vị!']);
        exit;
    }

    try{
        $conn->beginTransaction();

        $sql1 = "INSERT INTO TaiKhoanDangNhap (Email, MatKhau, Role) VALUES (?, ?, ?)";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute([$orgEmail, $password_hashed, 1]);

        $userId = $conn->lastInsertId();

        $sql2 = "INSERT INTO ToChuc (MaToChuc, MaTaiKhoan, MaDonVi, TenToChuc) VALUES (?, ?, ?, ?)";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute(['tc', $userId, $unitId, $orgName]);
        $lastOrgId = $conn->lastInsertId();
        $orgCode = "TC".str_pad($lastOrgId, 4, "0", STR_PAD_LEFT);

        $sql3 = "UPDATE ToChuc
                SET MaToChuc = ?
                WHERE Id = ?";
        $stmt3 = $conn->prepare($sql3);
        $stmt3->execute([$orgCode, $lastOrgId]);

        $conn->commit();
        echo json_encode([
            'success' => true, 
            'message' => 'Cấp tài khoản thành công']);
        exit;
            
    }catch(PDOException $e){
        $conn->rollBack();
        echo json_encode([
            'success' => false,
            'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
        ]);
        exit;
    }
}


$type = $_GET['type'] ?? 'account';
$keyword = trim($_GET['keyword'] ?? '');
$search = "%$keyword%";

$sql4 = "SELECT tk.Email
                , tk.Role
                , tk.NgayTao
                , tk.TrangThai
                , COALESCE(sv.HoTen, tc.TenToChuc) AS TenTaiKhoan
                , COALESCE(dv_sv.TenDonVi, dv_tc.TenDonVi) AS TenDonVi
        FROM TaiKhoanDangNhap tk
        LEFT JOIN SinhVien sv ON tk.MaTaiKhoan = sv.MaTaiKhoan
        LEFT JOIN ToChuc tc ON tk.MaTaiKhoan = tc.MaTaiKhoan
        LEFT JOIN DonVi dv_sv ON dv_sv.MaDonVi = sv.MaDonVi
        LEFT JOIN DonVi dv_tc ON dv_tc.MaDonVi = tc.MaDonVi";
if(!empty($keyword)){
    $sql4 .= " WHERE sv.HoTen LIKE ? 
                OR tc.TenToChuc LIKE ? 
                OR dv_sv.TenDonVi LIKE ? 
                OR dv_tc.TenDonVi LIKE ?";
    $params = [$search, $search, $search, $search];
}
$stmt4 = $conn->prepare($sql4);
empty($params) ? $stmt4 -> execute() : $stmt4 -> execute($params);

$sql5 = "SELECT COUNT(Email)
        FROM TaiKhoanDangNhap";
$stmt5 = $conn->prepare($sql5);
$stmt5 -> execute();
$TongSo = $stmt5->fetchColumn();   


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý hoạt động</title>
</head>
<body>
    <div class="account-container">
        <div class="account-title">
            <h2>Quản lý tài khoản</h2>
            <span>Quản lý và cấp tài khoản cho tổ chức và người dùng</span>
        </div>
        <div class="account-create-org-container">
            <h3>Cấp tài khoản tổ chức</h3>
            <div class="account-create-org">
                <form action="" id="accountForm">
                    <div class="account-create-org-item">
                        <span>Tên tổ chức</span>
                        <div class="account-create-org-input">
                            <input type="text" name="orgName" id="" placeholder="Nhập tên tổ chức">
                        </div>
                    </div>
                    <div class="account-create-org-item">
                        <span>Email đăng nhập</span>
                        <div class="account-create-org-input">
                            <input type="email" name="orgEmail" id="" placeholder="Nhập email đăng nhập">
                        </div>
                    </div>
                    <div class="account-create-org-item">
                        <span>Đơn vị trực thuộc</span>
                        <div class="account-create-org-input">
                            <input type="text" class="search-input" data-type="unit" data-value="account" name="unit" id="unit" placeholder="Gõ tên đơn vị để tìm kiếm và chọn">
                        </div>
                        <div class="suggest-box suggest-unit-box-account"></div>
                        <input type="hidden" name="unitId" id="unitId" >
                    </div>
                    <button type="submit">Cấp tài khoản</button>
                </form>
            </div>
        </div>
        <div class="account-list">
            <h3>Danh sách tài khoản</h3>
            <div class="header-account-list">
                <span>Tổng số tài khoản: <?= $TongSo ?></span>
                <div class="account-search-container">
                    <div class="account-custom-dropdown" data-type="type">
                        <span>Tìm kiểm theo:</span>
                        <div class="account-dropdown-selected">
                            <span class="account-selected-text">
                                Tên tổ chức / sinh viên
                            </span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="account-dropdown-menu">
                            <div class="account-dropdown-option" data-value="unit">Tên đơn vị</div>
                            <div class="account-dropdown-option" data-value="account">Tên tổ chức / sinh viên</div>
                        </div>
                    </div>
                    <div class="account-search">
                        <div class="search-account-input">
                            <input
                                type="text"
                                id="searchInput"
                                class="search-input account-search-input"
                                data-type="account"
                                placeholder="Tìm kiếm tên tổ chức / sinh viên...">

                            <button type="button" id="btn-search-account">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                        <div class="suggest-box account-suggest-box"></div>
                    </div>
                </div>

            </div>
            <div class="table-wrapper">
                <table class="account-table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên tổ chức / sinh viên</th>
                            <th>Đơn vị</th>
                            <th>Email</th>
                            <th>Vai trò</th>
                            <th>Ngày tạo</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $stt = 1; 
                        while ($account = $stmt4->fetch(PDO::FETCH_ASSOC)):
                            $createDate = new DateTime($account['NgayTao']); ?>
                        <tr class="table-row-account"
                            data-name="<?= $account['TenTaiKhoan'] ?>"
                            data-unit="<?= $account['TenDonVi'] ?>"
                            data-email="<?= $account['Email'] ?>"
                            data-role="<?= $account['Role']?>"
                            data-date="<?= $account['NgayTao'] ?>"
                            data-status="<?= $account['TrangThai'] ?>">
                            <td><?= $stt++ ?></td>
                            <td>
                                <div class="account-info">
                                    <span><?= $account['TenTaiKhoan'] ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="account-info">
                                    <span><?= $account['TenDonVi'] ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="account-info">
                                    <span><?= $account['Email'] ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="account-info">
                                    <?php if($account['Role'] == 1):?>
                                    <span>Tổ chức</span>
                                    <?php elseif($account['Role'] == 2):?>
                                    <span>Quản trị viên</span>
                                    <?php elseif($account['Role'] == 0):?>
                                    <span>Sinh viên</span>
                                    <?php endif;?>
                                </div>
                            </td>
                            <td>
                                <div class="account-info">
                                    <span><?= $createDate->format('d/m/y') ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="account-info">
                                    <?php if($account['TrangThai'] == 1): ?>
                                    <span>Đang hoạt động</span>
                                    <?php else: ?>
                                    <span>Đã khóa</span>
                                    <?php endif; ?>    
                                </div>
                            </td>
                            <td>
                                <?php if($account['TrangThai'] == 1): ?>
                                    <button class="block-account-btn " data-id="<?= $account['Email'] ?>" data-name="<?= htmlspecialchars($account['TenTaiKhoan']) ?>">
                                        Khóa
                                    </button>
                                <?php else: ?>
                                    <button class="unblock-account-btn " data-id="<?= $account['Email'] ?>" data-name="<?= htmlspecialchars($account['TenTaiKhoan']) ?>">
                                        Mở khóa
                                    </button>
                                <?php endif; ?>
                                
                                <button class="delete-account-btn"  data-id="<?= $account['Email'] ?>" data-name="<?= htmlspecialchars($account['TenTaiKhoan']) ?>">
                                    Xóa
                                </button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div id="delete-account-modal" class="modal">
                <div class="modal-content">
                    <h3>Xác nhận xóa</h3>
                    <p id="delete-account-message"></p>
                    <div class="model-btn">
                        <button id="btn-cancel-delete-account">Hủy</button>
                        <button id="btn-confirm-delete-account">Xóa</button>
                    </div>
                </div>
            </div>
            <div id="block-account-modal" class="modal">
                <div class="modal-content">
                    <h3 id="block-account-modal-title">Xác nhận khóa</h3>
                    <p id="block-account-message"></p>
                    <div class="model-btn">
                        <button id="btn-cancel-block-account">Hủy</button>
                        <button id="btn-confirm-block-account">Khóa</button>
                    </div>
                </div>
            </div>
            <div id="unblock-account-modal" class="modal">
                <div class="modal-content">
                    <h3 id="unblock-account-modal-title">Xác nhận mở khóa</h3>
                    <p id="unblock-account-message"></p>
                    <div class="model-btn">
                        <button id="btn-cancel-unblock-account">Hủy</button>
                        <button id="btn-confirm-unblock-account">Mở khóa</button>
                    </div>
                </div>
            </div>
            <div id="notice-account-modal" class="modal">
                <div class="modal-content">
                    <h3 id="notice-account-modal-title"></h3>
                    <p id="notice-account-message"></p>
                    <div class="model-btn">
                        <button id="btn-cancel-notice-account">Đóng</button>
                        <button id="btn-cancel-notice-error-account" class="hidden">Đóng</button>
                    </div>
                </div>
            </div>
            <div id="info-account-modal" class="modal">
                <div class="modal-content modal-content-lg">
                    <h3 id="info-account-modal-title">Thông tin chi tiết</h3>
                     <div id="info-account-message-container" class="info-account-message-container"></div>
                    <div class="model-btn">
                        <button id="btn-cancel-info-account">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>