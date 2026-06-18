<?php

require_once "../config/db.php";
header('Content-Type: application/json');

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
    

    switch($type){
        case "unit":
            $sql = "SELECT 
                        MaDonVi as id
                        , TenDonVi as name
                        FROM DonVi
                        WHERE TenDonVi LIKE ?
                        LIMIT 8";
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
            break;
        default:
            echo json_encode([]);
            exit;
    }

    $stmt = $conn->prepare($sql);
    if($type == "class"){
        $stmt->execute([$unit_id, $search]);//execute chỉ nhận dạng mảng 
    } else{
        $stmt->execute([$search]);
    }
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);

}

?>