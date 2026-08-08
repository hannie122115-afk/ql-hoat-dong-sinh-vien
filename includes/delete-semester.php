<?php 
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit;
}

require_once "../config/db.php";

$id = $_POST["id"] ?? "";

if($id == ""){
    echo json_encode([
        "success" => false,
        "message" => "Thiếu mã học kỳ"
    ]);
    exit;
}

$sql1 = "SELECT COUNT(*) FROM HoatDong WHERE MaHocKy = ?";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute([$id]);
$count = $stmt1->fetchColumn();

if ($count > 0) {
    echo json_encode([
        'success' => false,
        'message' => "Không thể xóa! Học kỳ bạn chọn đang có $count hoạt động được tổ chức."
    ]);
    exit;
}

$sql = "UPDATE HocKy
        SET ThoiGianBatDau = NULL
            ,ThoiGianKetThuc = NULL
        WHERE MaHocKy = ?";
$stmt = $conn->prepare($sql);

if($stmt->execute([$id])){
    echo json_encode([
        "success" => true,
        "rowCount" => $stmt->rowCount(),
        "id" => $id
    ]);
}else{
    echo json_encode([
        "success" => false,
        "message" => "Xóa thất bại"
    ]);
}
?>