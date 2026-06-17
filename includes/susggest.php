<?php
require_once "config/db.php";

$q = $_GET['q'] ?? '';
$type = $_GET['type'] ?? '';

$search = "%$q%";

$data = [];

switch ($type) {
    case "unit":
        $sql = "SELECT * FROM DonVi WHERE TenDonVi LIKE ?";
        break;

    default:
        echo json_encode([]);
        exit;
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $search);
$stmt->execute();

$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $data[] = [
        "id" => $row["MaDonVi"],
        "name" => $row["TenDonVi"]
    ];
}

echo json_encode($data);