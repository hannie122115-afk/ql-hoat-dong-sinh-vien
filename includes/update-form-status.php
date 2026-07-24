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

$actId = $_POST['actId'] ?? '';
$status = $_POST['status'] ?? '';

$sql = "UPDATE HoatDong
        SET TrangThaiForm = ?
        WHERE MaHoatDong = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$status, $actId]);

echo json_encode([
    "success" => true
])

?>