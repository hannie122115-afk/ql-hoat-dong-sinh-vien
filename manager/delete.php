<?php 
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit;
}

require_once "../config/db.php";
require_once "auth.php";

$id = $_POST["id"] ?? "";

if($id == ""){
    echo json_encode([
        "success" => false,
        "message" => "Thiếu mã hoạt động"
    ]);
    exit;
}

$sql = "DELETE FROM HoatDong
        WHERE MaHoatDong = ?";
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