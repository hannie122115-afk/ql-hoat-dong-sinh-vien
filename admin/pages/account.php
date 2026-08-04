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
    $orgInitName = $_POST['orgInitName'] ?? '';
    $orgEmail = $_POST['orgEmail'] ?? '';
    $orgPassword = strstr($orgEmail, '@', true);
    $password_hashed = password_hash($orgPassword, PASSWORD_DEFAULT);

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
        <div class="account-create-org">
            <h2>Cấp tài khoản tổ chức</h2>
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
                            <input type="text" name="orgEmail" id="" placeholder="Nhập email đăng nhập">
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
    </div>

</body>
</html>