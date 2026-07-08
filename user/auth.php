<?php 

$sql1 = "SELECT sv.*, n.TenNganh, dv.TenDonVi
        FROM sinhvien sv
        INNER JOIN nganh n ON sv.MaNganh = n.MaNganh
        INNER JOIN donvi dv ON sv.MaDonVi = dv.MaDonVi
        WHERE sv.MaTaiKhoan = ?";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute([$_SESSION['user_id']]);
$user = $stmt1->fetch(PDO::FETCH_ASSOC);

// $stmt2 = $conn->prepare("SELECT * FROM DonVi WHERE MaDonVi = ?");
// $stmt2->execute([$user['MaDonVi']]);
// $unit = $stmt2->fetch(PDO::FETCH_ASSOC);

// $stmt3 = $conn->prepare("SELECT COUNT(dk.MSSV) 
//                         FROM DangKy dk
//                         JOIN HoatDong hd ON dk.MaHoatDong = hd.MaHoatDong
//                         WHERE hd.MaToChuc = ?");
// $stmt3->execute([$org['MaToChuc']]);
// $tongLuotDK = $stmt3->fetchColumn();

// $stmt4 = $conn->prepare("SELECT COUNT(MaHoatDong) 
//                         FROM HoatDong");
// $stmt4->execute([$org['MaToChuc']]);
// $tongSoHD = $stmt4->fetchColumn();



?>