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

$actManagementId = $_GET['id'] ?? '';

$sql = "SELECT *
        FROM HoatDong hd, MucCongDiemRenLuyen mcdrl
        WHERE hd.MaMucCongDiem = mcdrl.MaMucCongDiem
        AND MaHoatDong = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$actManagementId]);
$actInfo = $stmt->fetch(PDO::FETCH_ASSOC);

$sql7 = "SELECT LoaiCauHoi
        FROM CauHoiDangKy
        WHERE MaHoatDong = ?
        AND LoaiCauHoi <> 'custom'";
$stmt7 = $conn->prepare($sql7);
$stmt7->execute([$actManagementId]);
$oldAutoQues = $stmt7->fetchAll(PDO::FETCH_COLUMN);

$sql8 = "SELECT MaCauHoi, TenHienThi
        FROM CauHoiDangKy
        WHERE MaHoatDong = ?
        AND LoaiCauHoi = 'custom'";
$stmt8 = $conn->prepare($sql8);
$stmt8->execute([$actManagementId]);
$customQuestions = $stmt8->fetchAll(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    ob_clean(); 
    header('Content-Type: application/json; charset=utf-8');
    try{
            
        // mở gói actData

        if(!isset($_POST["activityData"])){
            throw new Exception("Thiếu dữ liệu!");
        }
        $actData = json_decode($_POST["activityData"], true);
        if(is_null($actData)){
            throw new Exception("Dữ liệu sai định dạng!");
        }

        $step1 = $actData['step1'];
        $actName = $step1['actName'] ?? '';
        $actLocate = $step1['actLocate'] ?? '';
        $actObject = $step1['actObject'] ?? '';
        $actStart = $step1['actStart'] ?? '';
        $actMaxSlot = $step1['actMaxSlot'] ?? '';
        $actEnd = $step1['actEnd'] ?? '';

        $actBonus = $step1['actBonusId'] ?? '';

        $actPoint = $step1['actPoint'] ?? '';
        $actContent = $step1['actContent'] ?? '';

        // Xử lý upload ảnh
        $uploadDir = "../../assets/images/uploads/activity/";
        $dbDir = "../assets/images/uploads/activity/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $pathAvt = $actInfo['AnhAvt'];
        if (isset($_FILES["actImgAvt"]) && $_FILES["actImgAvt"]["error"] === UPLOAD_ERR_OK) {

            $fileName = time() . "_avt_" . basename($_FILES["actImgAvt"]["name"]);

            if (move_uploaded_file($_FILES["actImgAvt"]["tmp_name"], $uploadDir . $fileName)) {
                if (!empty($actInfo['AnhAvt']) && file_exists("../../" . str_replace("../", "", $actInfo['AnhAvt']))) {
                    @unlink("../../" . str_replace("../", "", $actInfo['AnhAvt']));
                }
                $pathAvt = $dbDir . $fileName;
            }
        }

        $pathCover = $actInfo['AnhBia'];
        if (isset($_FILES["actImgCover"]) && $_FILES["actImgCover"]["error"] === UPLOAD_ERR_OK) {

            $fileName = time() . "_cover_" . basename($_FILES["actImgCover"]["name"]);

            if (move_uploaded_file($_FILES["actImgCover"]["tmp_name"], $uploadDir . $fileName)) {
                if (!empty($actInfo['AnhBia']) && file_exists("../../" . str_replace("../", "", $actInfo['AnhBia']))) {
                    @unlink("../../" . str_replace("../", "", $actInfo['AnhBia']));
                }
                $pathCover = $dbDir . $fileName;
            }
        }

        $actImgAvt = $_FILES["actImgAvt"] ?? null;
        $actImgCover = $_FILES["actImgCover"] ?? null;

        $sql1 = "UPDATE HoatDong
                SET TenHoatDong = ?
                    ,DiaDiem = ?
                    ,DoiTuongThamGia = ?
                    ,SoLuongToiDa = ?
                    ,ThoiGianBatDau = ?
                    ,ThoiGianKetThuc = ?
                    ,MaMucCongDiem = ?
                    ,DiemRenLuyen = ?
                    ,NoiDungHD = ?
                    ,AnhAvt = ?
                    ,AnhBia = ?
                WHERE MaHoatDong = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute([$actName, $actLocate, $actObject, $actMaxSlot, $actStart, $actEnd, $actBonus, $actPoint, $actContent, $pathAvt, $pathCover, $actManagementId]);

        $step2 = $actData['step2'];
        $autoQuestions = $step2['autoQuestions'];
        $customQuestions = $step2['customQuestions'];

        // Cau hoi tu dong
        $sql2 = "SELECT LoaiCauHoi
                FROM CauHoiDangKy
                WHERE MaHoatDong = ?
                AND LoaiCauHoi <> 'custom'";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute([$actManagementId]);
        $oldAutoQues = $stmt2->fetchAll(PDO::FETCH_COLUMN);

        $newAutoQues = [];
        foreach($autoQuestions as $autoQues){
            $newAutoQues[] = $autoQues['aqType'];
        }

        foreach($oldAutoQues as $type){
            if(!in_array($type, $newAutoQues)){
                $sql3 = "DELETE FROM CauHoiDangKy
                        WHERE MaHoatDong = ?
                        AND LoaiCauHoi = ?";
                $stmt3 = $conn->prepare($sql3);
                $stmt3->execute([$actManagementId, $type]);
            }
        }

        foreach($autoQuestions as $autoQues){
            if(!in_array($autoQues['aqType'], $oldAutoQues)){
                $sql4 = "INSERT INTO CauHoiDangKy(MaCauHoi, MaHoatDong, LoaiCauHoi, TenHienThi) 
                        VALUES (?, ?, ?, ?)";
                $stmt4 = $conn->prepare($sql4);
                $stmt4->execute(['a', $actManagementId, $autoQues['aqType'], $autoQues['aqContent']]);
                $lastAqId = $conn->lastInsertId();
                $AqCode = "CH".str_pad($lastAqId, 4, "0", STR_PAD_LEFT);

                $sql5 = "UPDATE CauHoiDangKy
                        SET MaCauHoi = ?
                        WHERE Id = ?";
                $stmt5 = $conn->prepare($sql5);
                $stmt5->execute([$AqCode, $lastAqId]);
            }
        }

        // Câu hỏi bổ sung

        foreach($customQuestions as $q){
            switch($q['status']){
                case "new":
                    $sql6 = "INSERT INTO CauHoiDangKy(MaCauHoi, MaHoatDong, LoaiCauHoi, TenHienThi) 
                            VALUES (?, ?, ?, ?)";
                    $stmt6 = $conn->prepare($sql6);
                    $stmt6->execute(["a", $actManagementId, "custom", $q['cqContent']]);
                    $lastAqId = $conn->lastInsertId();
                    $AqCode = "CH".str_pad($lastAqId, 4, "0", STR_PAD_LEFT);

                    $sql7 = "UPDATE CauHoiDangKy
                            SET MaCauHoi = ?
                            WHERE Id = ?";
                    $stmt7 = $conn->prepare($sql7);
                    $stmt7->execute([$AqCode, $lastAqId]);
                    break;
                case "update":
                    $sql6 = "UPDATE CauHoiDangKy
                            SET TenHienThi = ?
                            WHERE MaCauHoi = ?";
                    $stmt6 = $conn->prepare($sql6);
                    $stmt6->execute([$q['cqContent'], $q['cqId']]);
                    break;
                case "delete":
                    $sql6 = "DELETE FROM CauHoiDangKy
                            WHERE MaCauHoi = ?";
                    $stmt6 = $conn->prepare($sql6);
                    $stmt6->execute([$q['cqId']]);
                    break;
            }
        }
        echo json_encode([
            "success" => true, 
            "message" => "Sửa hoạt động thành công",
            "actCode" => $actManagementId]);
        exit;
    }catch(Exception $e){
        echo json_encode([
            "success" => false,
            "message" => $e->getMessage()
        ]);
        exit;
    }

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/manager-pages.css">
</head>
<body>
    <h1>ĐÂY LÀ TRANG TẠO HOẠT ĐỘNG</h1>

    <div class="created-act-container">
        <div class="created-act-title">
            <h2>Tạo hoạt động mới</h2>
            <span>Điền đầy đủ thông tin để tạo hoạt động cho sinh viên đăng ký tham gia.</span>
        </div>

        <div class="step-line">
            <div class="step-line-item active" data-step="1">
                1. Tạo hoạt động
            </div>
            <div class="step-line-item" data-step="2">
                2. Câu hỏi bổ sung
            </div>
            <div class="step-line-item" data-step="3">
                3. Xem trước
            </div>
        </div>

        <form action="" method="post">
                <!-- STEP 1 -->
            <div class="step-block active" id="step1">
                <h1>ĐÂY LÀ BƯỚC 1</h1>
                <div class="act-info-container">
                    <div class="step1-block act-info-block">
                        <div class="act-title-block">
                            <span>
                            <i class="fa-solid fa-circle-info"></i>
                            </span>
                            <h3>Thông tin hoạt động</h3>
                            <span>Nhập các thông tin cơ bản của hoạt động</span>
                        </div>
                        
                        <div class="act-info">
                            <div class="act-info-item">
                                <h4>Tên hoạt động</h4>
                                <div class="act-info-item-input">
                                    <input type="text" name="act-name" id="act-name"  placeholder="Nhập tên hoạt động" class="validate-input" value="<?= $actInfo['TenHoatDong'] ?>">
                                </div>
                                <div class="error-message"></div>
                            </div>

                            <div class="act-info-item">
                                <h4>Đối tượng tham gia</h4>
                                <div class="act-info-item-input">
                                    <input type="text" name="act-object" id="act-object" placeholder="Nhập đối tượng tham gia hoạt động" class="validate-input" value="<?= $actInfo['DoiTuongThamGia'] ?>">
                                </div>
                                <div class="error-message"></div>
                            </div>

                            <div class="act-info-item">
                                <h4>Địa điểm</h4>
                                <div class="act-info-item-input">
                                    <input type="text" name="act-locate" id="act-locate" placeholder="Nhập địa điểm tổ chức" class="validate-input" value="<?= $actInfo['DiaDiem'] ?>">
                                </div>
                                <div class="error-message"></div>
                            </div>

                            <div class="act-info-item">
                                <h4>Thời gian bắt đầu</h4>
                                <div class="act-info-item-input">
                                    <input type="datetime-local" name="act-start" id="act-start" class="validate-input" value="<?= $actInfo['ThoiGianBatDau'] ?>">
                                </div>
                                <div class="error-message"></div>
                                <span>Thời gian bắt đầu diễn ra hoạt động.</span>
                            </div>

                            <div class="act-info-item">
                                <h4>Số lượng tối đa</h4>
                                <div class="act-info-item-input">
                                    <input type="text" name="act-max-slot" id="act-max-slot" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^0+/, '')" maxlength='5' placeholder="Nhập số lượng tối đa (để trống nếu không giới hạn)" class="validate-input" value="<?= $actInfo['SoLuongToiDa'] ?>">
                                </div>
                                <div class="error-message"></div>
                                <span>Số lượng sinh viên tối đa có thể đăng ký tham gia.</span>
                            </div>

                            <div class="act-info-item">
                                <h4>Thời gian kết thúc</h4>
                                <div class="act-info-item-input">
                                    <input type="datetime-local" name="act-end" id="act-end" class="validate-input" value="<?= $actInfo['ThoiGianKetThuc'] ?>">
                                </div>
                                <div class="error-message"></div>
                                <span>Thời gian kết thúc hoạt động.</span>
                            </div>

                            <div class="act-info-item">
                                <h4>Mục cộng điểm</h4>
                                <div class="act-info-item-input">
                                    <input type="text" class="search-input validate-input" data-type="bonus" id="bonus" value="<?= $actInfo['TenMucCongDiem'] ?>">
                                </div>
                                <div class="suggest-box"></div>
                                <div class="error-message"></div>
                            </div>
                            <input type="hidden" name="bonus" id="bonusId">

                            <div class="act-info-item">
                                <h4>Điểm rèn luyện</h4>
                                <div class="act-info-item-input">
                                    <input type="text" name="act-point" id="act-point" inputmode="numeric" placeholder="Nhập điểm rèn luyện" class="validate-input act-point" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^0+/, '')" maxlength='2' value="<?= $actInfo['DiemRenLuyen'] ?>">
                                </div>
                                <div class="error-message"></div>
                                <span>Nhập điểm rèn luyện sinh viên nhận được khi tham gia.</span>
                            </div>
                        </div>
                    </div>
                    <div class="step1-block act-content-block">
                        <div class="act-title-block">
                            <span>
                            <i class="fa-solid fa-camera"></i>
                            </span>
                            <h3>Nội dung hoạt động</h3>
                            <span>Mô tả chi tiết về hoạt động để thu hút sinh viên tham gia</span>
                        </div>
                        <div class="act-info-item act-content-item">
                            <h4>Nội dung chi tiết</h4>
                            <div class="act-info-item-input">
                                <textarea name="act-content" id="act-content" placeholder="Nhập nội dung chi tiết của hoạt động" class="validate-input" > <?= $actInfo['NoiDungHD'] ?></textarea>
                            </div>
                            <div class="error-message"></div>
                        </div>
                        <div class="act-info-item act-content-item">
                            <h4>Hình ảnh hoạt động</h4>
                            <span>Chọn ảnh 1 ảnh đại diện cho hoạt động</span>
                            <div class="act-info-item-input">
                                <div class="img-avt-present">
                                    <img src="<?= $actInfo['AnhAvt'] ?>" id="img-avt-present">
                                </div>
                                <div class="img-cover-new">
                                    <input type="file" name="act-img-avt" id="act-img-avt" class="act-img-input validate-input" data-required="false">
                                </div>
                            </div>
                        </div>
                        <div class="act-info-item act-content-item">
                            <h4>Hình ảnh hoạt động</h4>
                            <span>Chọn ảnh 1 ảnh bìa cho hoạt động</span>
                            <div class="act-info-item-input">
                                <div class="img-cover-present">
                                    <img src="<?= $actInfo['AnhBia'] ?>" id="img-cover-present">
                                </div>
                                <div class="img-cover-new">
                                    <input type="file" name="act-img-cover" id="act-img-cover" class="act-img-input validate-input" data-required="false">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-block">
                    <div class="btn-step-next">Tiếp theo</div>
                </div>
            </div>
            <!-- STEP 2 -->
            <div class="step-block" id="step2">
                <h1>ĐÂY LÀ BƯỚC 2</h1>
                <div class="act-question-container">
                    <div class="step2-block auto-ques-block" >
                        <div class="act-title-block">
                            <span>
                            <i class="fa-solid fa-circle-question"></i>
                            </span>
                            <h3>Câu hỏi tự động</h3>
                            <span>Các thông tin này sẽ được tự động điền dựa trên thông tin tài khoảng của người tham gia</span>
                        </div>
                        <div class="auto-ques-container">
                            <div class="auto-ques-item">
                                <label class="auto-ques-checkbox">
                                    <input type="checkbox" name="auto-ques" value="Mã số sinh viên" data-id="MSSV" <?= in_array("MSSV", $oldAutoQues) ? "checked" : "" ?>>
                                    <span class="auto-ques-checkmark"></span>
                                </label>
                                Mã số sinh viên
                            </div>
                            <div class="auto-ques-item">
                                <label class="auto-ques-checkbox">
                                    <input type="checkbox" name="auto-ques" value="Họ tên" data-id="HoTen" <?= in_array("HoTen", $oldAutoQues) ? "checked" : "" ?>>
                                    <span class="auto-ques-checkmark"></span>
                                </label>
                                Họ tên
                            </div>
                            <div class="auto-ques-item">
                                <label class="auto-ques-checkbox">
                                    <input type="checkbox" name="auto-ques" value="Ngành" data-id="TenNganh" <?= in_array("TenNganh", $oldAutoQues) ? "checked" : "" ?>>
                                    <span class="auto-ques-checkmark"></span>
                                </label>
                                Ngành
                            </div>
                            <div class="auto-ques-item">
                                <label class="auto-ques-checkbox">
                                    <input type="checkbox" name="auto-ques" value="Khóa" data-id="Khoa" <?= in_array("Khoa", $oldAutoQues) ? "checked" : "" ?>>
                                    <span class="auto-ques-checkmark"></span>
                                </label>
                                Khóa
                            </div>
                            <div class="auto-ques-item">
                                <label class="auto-ques-checkbox">
                                    <input type="checkbox" name="auto-ques" value="Đơn vị trường" data-id="TenDonVi" <?= in_array("TenDonVi", $oldAutoQues) ? "checked" : "" ?>>
                                    <span class="auto-ques-checkmark"></span>
                                </label>
                                Đơn vị trường
                            </div>
                            <div class="auto-ques-item">
                                <label class="auto-ques-checkbox">
                                    <input type="checkbox" name="auto-ques" value="Giới tính" data-id="GioiTinh" <?= in_array("GioiTinh", $oldAutoQues) ? "checked" : "" ?>>
                                    <span class="auto-ques-checkmark"></span>
                                </label>
                                Giới tính
                            </div>
                            <div class="auto-ques-item">
                                <label class="auto-ques-checkbox">
                                    <input type="checkbox" name="auto-ques" value="Số điện thoại" data-id="SoDienThoai" <?= in_array("SoDienThoai", $oldAutoQues) ? "checked" : "" ?>>
                                    <span class="auto-ques-checkmark"></span>
                                </label>
                                Số điện thoại 
                            </div>
                            
                        </div>
                    </div>
                    <div class="step2-block custom-ques-block">
                        <div class="act-title-block">
                            <span>
                            <i class="fa-solid fa-clock"></i>
                            </span>
                            <h3>Câu hỏi bổ sung</h3>
                            <span>Tạo các câu hỏi để thu thập thêm thông tin từ người tham gia (không bắt buộc).</span>
                        </div>
                        <div class="custom-ques-container">
                            <!-- <div class="custom-ques-item">
                                <div class="custom-ques-input">
                                    <input type="text" name="" id="">
                                </div>
                                <div class="save-custom-ques-btn">Lưu</div>
                                <div class="cancel-custom-ques-btn">Hủy</div>
                            </div> -->
                        </div>
                        <div class="add-question-btn">
                            Thêm câu hỏi
                        </div>
                    </div>
                    
                </div>
                <div class="btn-block">
                    <div class="btn-step-next">Tiếp theo</div>
                    <div class="btn-step-previous">Trở lại</div>
                </div>
            </div>
            <!-- STEP 3 -->
            <div class="step-block" id="step3">
                <h1>ĐÂY LÀ BƯỚC 3</h1>
                <div class="preview-container-step3">
                    <div class="preview-block-step3">
                        <div class="act-title-block">
                            <h3>Thông tin hoạt động</h3>
                        </div>
                        <div class="preview-info-content">
                            <div class="preview-info-item">
                                <div class="preview-info-left">
                                    <span>
                                        <i class="fa-regular fa-clipboard"></i>
                                    </span>
                                    <h4>Tên hoạt động</h4>
                                </div>
                                <div class="preview-info-right" id="preview-act-name">
                                    
                                </div>
                            </div>
                            <div class="preview-info-item">
                                <div class="preview-info-left">
                                    <span>
                                        <i class="fa-solid fa-location-dot"></i>
                                    </span>
                                    <h4>Địa điểm</h4>
                                </div>
                                <div class="preview-info-right" id="preview-act-locate">
                                    
                                </div>
                            </div>
                            <div class="preview-info-item">
                                <div class="preview-info-left">
                                    <span>
                                        <i class="fa-solid fa-user-group"></i>
                                    </span>
                                    <h4>Số lượng tối đa</h4>
                                </div>
                                <div class="preview-info-right" id="preview-act-amount">
                                    
                                </div>
                            </div>
                            <div class="preview-info-item">
                                <div class="preview-info-left">
                                    <span>
                                        <i class="fa-solid fa-clock"></i>
                                    </span>
                                    <h4>Thời gian bắt đầu</h4>
                                </div>
                                <div class="preview-info-right" id="preview-act-start">
                                    
                                </div>
                            </div>
                            <div class="preview-info-item">
                                <div class="preview-info-left">
                                    <span>
                                        <i class="fa-solid fa-clock"></i>
                                    </span>
                                    <h4>Thời gian kết thúc</h4>
                                </div>
                                <div class="preview-info-right" id="preview-act-end">
                                    
                                </div>
                            </div>
                            <div class="preview-info-item">
                                <div class="preview-info-left">
                                    <span>
                                        <i class="fa-solid fa-star"></i>
                                    </span>
                                    <h4>Điểm rèn luyện</h4>
                                </div>
                                <div class="preview-info-right" id="preview-act-score">
                                    
                                </div>
                            </div>
                            <div class="preview-info-item">
                                <div class="preview-info-left">
                                    <span>
                                        <i class="fa-solid fa-clipboard-list"></i>
                                    </span>
                                    <h4>Mục cộng điểm</h4>
                                </div>
                                <div class="preview-info-right" id="preview-act-bonus">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="preview-block-step3">
                        <div class="act-title-block">
                            <h3>Nội dung hoạt động</h3>
                        </div>
                        <div id="preview-act-describe">

                        </div>
                    </div>
                    <div class="preview-block-step3">
                        <div class="act-title-block">
                            <h3>Hình ảnh hoạt động</h3>
                        </div>
                        <div class="preview-act-img">
                            <img src="" alt="Hình ảnh hoạt động" id="preview-act-img-avt">
                            <img src="" alt="Hình ảnh hoạt động" id="preview-act-img-cover">
                        </div>
                    </div>
                    <div class="preview-block-step3">
                        <div class="act-title-block">
                            <h3>Form đăng ký tham gia</h3>
                        </div>
                        <h4>Thông tin mặc định</h4>
                        <div id="preview-block-auto-ques">
                            <!-- <div class="preview-auto-ques-item">
                                <div class="number-auto-ques"></div>
                                <h4></h4>
                            </div> -->
                        </div>
                        <h4>Các câu hỏi bổ sung</h4>
                        <div id="preview-block-custom-ques">
                            <!-- <div class="preview-custom-ques-item">
                                <div class="number-custom-ques"></div>
                                <div class="ques-content"></div>
                                <div class="answer-content"></div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="btn-step-previous">Trở lại</div>
                <button type="submit" id="btn-update-act">Cập nhật hoạt động</button>
            </div>
        </form>
    </div>

    <div id="edit-data"
     data-custom='<?= htmlspecialchars(json_encode($customQuestions), ENT_QUOTES) ?>'>
    </div>
</body>
</html>