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

$data = json_decode(file_get_contents("php://input"), true);

$semester = $data["semester"] ?? "";
$year = $data["year"] ?? "";

$chart = [];

if ($semester !== "" && $year !== ""){
    $sql2 = "SELECT
                hd.TenHoatDong,
                COUNT(dk.MSSV) AS DangKy,
                COUNT(CASE WHEN dk.DaDiemDanh=1 THEN 1 END) AS ThamGia
            FROM HoatDong hd
            LEFT JOIN DangKy dk
            ON hd.MaHoatDong=dk.MaHoatDong
            JOIN HocKy hk
            ON hk.MaHocKy = hd.MaHocKy
            WHERE hd.MaToChuc = ?
                AND hk.HocKy = ?
                AND hk.NamHoc = ?
            GROUP BY hd.MaHoatDong
                    , hd.TenHoatDong";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute([$org['MaToChuc'], $semester, $year]);
    $chart = $stmt2->fetchAll(PDO::FETCH_ASSOC);
}

echo json_encode([
    "status" => "success",
    "chart"  => $chart
]);

?>