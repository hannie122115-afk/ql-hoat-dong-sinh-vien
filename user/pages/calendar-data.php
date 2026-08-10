<?php 

if(session_status() === PHP_SESSION_NONE){
    session_start();
}
require_once "../../config/db.php";
require_once "../auth.php";

$sql = "SELECT 
            hd.MaHoatDong
            ,hd.TenHoatDong
            ,hd.ThoiGianBatDau
            ,hd.ThoiGianKetThuc
            ,dk.DaDiemDanh
        FROM DangKy dk
        JOIN HoatDong hd ON dk.MaHoatDong = hd.MaHoatDong
        WHERE dk.MSSV = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$user['MSSV']]);

$events = [];

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $events[] = [
        "id" => $row["MaHoatDong"],
        "title" => $row["TenHoatDong"],
        "start" => $row["ThoiGianBatDau"],
        "end" => $row["ThoiGianKetThuc"]
    ];
}

header('Content-Type: application/json');
echo json_encode($events);
exit;
?>