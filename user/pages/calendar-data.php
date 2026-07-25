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
    // $start = new DateTime($row["ThoiGianBatDau"]);
    // $end   = new DateTime($row["ThoiGianKetThuc"]);
    // $now = new DateTime();

    // if($row["DaDiemDanh"] == 1){
    //     $status = "Đã tham gia";
    //     $backgroundColor = "#22c55e";
    //     $borderColor = "#22c55e";
    //     $textColor = "#ffffff";
    // }
    // elseif($end < $now){
    //     $status = "Đã kết thúc";
    //     $backgroundColor = "#ef4444";
    //     $borderColor = "#ef4444";
    //     $textColor = "#ffffff";
    // }
    // elseif($start <= $now && $end >= $now){
    //     $status = "Đang diễn ra";
    //     $backgroundColor = "#f59e0b";
    //     $borderColor = "#f59e0b";
    //     $textColor = "#ffffff";
    // }
    // else{
    //     $status = "Sắp diễn ra";
    //     $backgroundColor = "#3b82f6";
    //     $borderColor = "#3b82f6";
    //     $textColor = "#ffffff";
    // }

    $events[] = [
        "id" => $row["MaHoatDong"],
        "title" => $row["TenHoatDong"],
        "start" => $row["ThoiGianBatDau"],
        "end" => $row["ThoiGianKetThuc"]
        // "backgroundColor" => $backgroundColor,
        // "borderColor" => $borderColor,
        // "textColor" => $textColor,
        // "extendedProps" => [
        //     "status" => $status
        // ]
    ];
}

header('Content-Type: application/json');
echo json_encode($events);
exit;
?>