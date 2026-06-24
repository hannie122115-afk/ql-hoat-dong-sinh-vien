<?php 

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

require_once "../config/db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

$stmt1 = $conn->prepare("SELECT * FROM ToChuc WHERE MaTaiKhoan = ?");
$stmt1->execute([$_SESSION['user_id']]);
$org = $stmt1->fetch(PDO::FETCH_ASSOC);

$stmt2 = $conn->prepare("SELECT * FROM DonVi WHERE MaDonVi = ?");
$stmt2->execute([$org['MaDonVi']]);
$unit = $stmt2->fetch(PDO::FETCH_ASSOC);

$stmt3 = $conn->prepare("SELECT * FROM HoatDong WHERE MaToChuc = ?");
$stmt3->execute([$org['MaToChuc']]);
$act = $stmt3->fetch(PDO::FETCH_ASSOC);

$stmt4 = $conn->prepare("SELECT COUNT(dk.MSSV) 
                        FROM DangKy dk
                        JOIN HoatDong hd ON dk.MaHoatDong = hd.MaHoatDong
                        WHERE hd.MaToChuc = ?");
$stmt4->execute([$org['MaToChuc']]);
$tongLuotDK = $stmt4->fetchColumn();

$stmt5 = $conn->prepare("SELECT COUNT(MaHoatDong) 
                        FROM HoatDong
                        WHERE MaToChuc = ?");
$stmt5->execute([$org['MaToChuc']]);
$tongSoHD = $stmt5->fetchColumn();



?>