<?php

require_once "../config/db.php";
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['keyword']) && isset($_POST['type'])){
    $keyword = trim($_POST['keyword']);
    $type = $_POST['type'];

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
            // demo trước 1 bảng , còn lại sẽ thêm vào sau nếu luống đi đúng
        default:
            echo json_encode([]);
            exit;
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute([$search]); //execute chỉ nhận dạng mảng
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);

}

?>