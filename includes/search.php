<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

require_once "../config/db.php";
header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? null;
$user_role = $_SESSION['role'] ?? null;
$org_id = $_SESSION['org_id'] ?? null;

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['keyword']) && isset($_POST['type'])){
    $keyword = trim($_POST['keyword']);
    $type = $_POST['type'];
    $unit_id = null;
    if($type == "class"){
        $unit_id = $_POST['unit_id'] ?? null;
    }

    if(!empty($keyword)){
        $search = "%$keyword%";
    } else{
        echo json_encode([]); //tra ve mang json rong
        exit;
    }
    
    $params = [];

    switch($type){
        case "unit":
            $sql = "SELECT 
                        MaDonVi as id
                        , TenDonVi as name
                        FROM DonVi
                        WHERE TenDonVi LIKE ?
                        LIMIT 8";
            $params = [$search];
            break;
        case "class":
            if(!$unit_id){
                echo json_encode([]);
                exit;
            }
            $sql = "SELECT 
                        MaNganh as id
                        , TenNganh as name
                        FROM Nganh n
                        JOIN DonVi dv ON n.MaDonVi = dv.MaDonVi 
                        WHERE dv.MaDonVi = ?
                            AND n.TenNganh LIKE ?
                        LIMIT 8";
            $params = [$unit_id, $search];
            break;
        case "activity":
            if((int)$user_role === 1){
                $sql = "SELECT MaHoatDong as id
                                , TenHoatDong as name
                                FROM HoatDong 
                                WHERE MaToChuc = ?
                                    AND TenHoatDong LIKE ?
                                LIMIT 8";
                $params = [$org_id, $search];
            } else{
                $sql = "SELECT MaHoatDong as id
                                , TenHoatDong as name
                                FROM HoatDong 
                                WHERE TenHoatDong LIKE ?
                                LIMIT 8";
                $params = [$search];
            }
            break;

        default:
            echo json_encode([]);
            exit;
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);

}

?>