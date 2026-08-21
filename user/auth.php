<?php 

$sql1 = "SELECT sv.*, n.TenNganh, dv.TenDonVi
        FROM sinhvien sv
        INNER JOIN nganh n ON sv.MaNganh = n.MaNganh
        INNER JOIN donvi dv ON sv.MaDonVi = dv.MaDonVi
        WHERE sv.MaTaiKhoan = ?";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute([$_SESSION['user_id']]);
$user = $stmt1->fetch(PDO::FETCH_ASSOC);





?>