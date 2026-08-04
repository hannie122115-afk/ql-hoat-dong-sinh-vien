<?php 

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$chart = [];

$sql = "SELECT tc.TenToChuc
            , COUNT(hd.MaHoatDong) AS SoHoatDong
        FROM ToChuc tc
            , HoatDong hd
            , HocKy hk
        WHERE hd.MaToChuc = tc.MaToChuc
        AND hk.MaHocKy = hd.MaHocKy
        AND hk.ThoiGianBatDau <= NOW()
        AND hk.ThoiGianKetThuc >= NOW()
        GROUP BY tc.TenToChuc";
$stmt = $conn->prepare($sql);
$stmt->execute();
$chart = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "status" => "success",
    "chart" => $chart
]);
?>