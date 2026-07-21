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

try{
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        throw new Exception("Phương thức yêu cầu không hợp lệ!");
    }

    $actId = $_POST['actId'] ?? '';

    $sql = "SELECT MaForm
        FROM HoatDong
        WHERE MaHoatDong = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$actId]);
    $actData = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$actData){
        throw new Exception("Không tìm thấy hoạt động.");
    }

    $formId = $actData['MaForm'];
    $scriptUrl = "https://script.google.com/macros/s/AKfycbyKjOsqGZHpH5Lz3UhEnG40mWLU3dc_aODOissZGAb18ZzcSp4bL-neO30CUN5mTlW5MA/exec";

    $targetUrl = $scriptUrl."?action=getResponses&formId=" . urlencode($formId);

    $result = @file_get_contents($targetUrl);
    if ($result === FALSE) {
        throw new Exception("Không thể kết nối đến máy chủ Google Apps Script!");
    }

    $response = json_decode($result, true);
    if (!$response || !isset($response['success']) || $response['success'] !== true) {
        $errorMsg = $response['message'] ?? "Lỗi không xác định từ Google Apps Script!";
        throw new Exception($errorMsg);
    }

    $responsesData = $response['data'] ?? [];

    $checkedCount = 0;
    $notRegistered = [];

    $uniqueMssvList = [];
    foreach ($responsesData as $item) {
        if (!empty($item['mssv'])) {
            $cleanMssv = strtoupper(trim($item['mssv']));
            $uniqueMssvList[$cleanMssv] = true;
        }
    }


    $sqlUpdate = "UPDATE DangKy 
                  SET DaDiemDanh = 1 
                  WHERE MSSV = ? AND MaHoatDong = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $sqlCheck = "SELECT COUNT(*) FROM DangKy WHERE MSSV = ? AND MaHoatDong = ?";
    $stmtCheck = $conn->prepare($sqlCheck);

    $conn->beginTransaction();

    foreach (array_keys($uniqueMssvList) as $mssv) {
        $stmtCheck->execute([$mssv, $actId]);
        $isRegistered = $stmtCheck->fetchColumn() > 0;

        if ($isRegistered) {
            $stmtUpdate->execute([$mssv, $actId]);
            $checkedCount++;
        } else {
            $notRegistered[] = $mssv;
        }
    }

    $conn->commit();

    echo json_encode([
        "success" => true,
        "message" => "Đồng bộ điểm danh thành công!",
        "checked" => $checkedCount,
        "notRegistered" => $notRegistered
    ]);
    exit;

} catch (Exception $e) {
    if (isset($conn) && $conn->inTransaction()) {
        $conn->rollBack();
    }
    
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
    exit;
}

?>