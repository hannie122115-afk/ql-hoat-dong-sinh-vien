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

if($_SERVER['REQUEST_METHOD'] === 'POST'){
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
        // $actBonus = $step1['actBonus'] ?? '';

        $actBonus = $step1['actBonusId'] ?? '';

        $actPoint = $step1['actPoint'] ?? '';
        $actContent = $step1['actContent'] ?? '';

        // Xử lý upload ảnh
        $uploadDir = "../../assets/images/uploads/activity/";
        $dbDir = "../assets/images/uploads/activity/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $pathAvt = "";
        if (isset($_FILES["actImgAvt"]) && $_FILES["actImgAvt"]["error"] === UPLOAD_ERR_OK) {

            $fileName = time() . "_avt_" . basename($_FILES["actImgAvt"]["name"]);

            if (move_uploaded_file($_FILES["actImgAvt"]["tmp_name"], $uploadDir . $fileName)) {
                $pathAvt = $dbDir . $fileName;
            }
        }

        $pathCover = "";
        if (isset($_FILES["actImgCover"]) && $_FILES["actImgCover"]["error"] === UPLOAD_ERR_OK) {

            $fileName = time() . "_cover_" . basename($_FILES["actImgCover"]["name"]);

            if (move_uploaded_file($_FILES["actImgCover"]["tmp_name"], $uploadDir . $fileName)) {
                $pathCover = $dbDir . $fileName;
            }
        }

        $actImgAvt = $_FILES["actImgAvt"];
        $actImgCover = $_FILES["actImgCover"];

        $sql1 = "INSERT INTO HoatDong(
                    MaHoatDong
                    ,MaToChuc
                    ,TenHoatDong
                    ,DiaDiem
                    ,DoiTuongThamGia
                    ,SoLuongToiDa
                    ,ThoiGianBatDau
                    ,ThoiGianKetThuc
                    ,MaMucCongDiem
                    ,DiemRenLuyen
                    ,NoiDungHD
                    ,AnhAvt
                    ,AnhBia )
                VALUES (? ,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute(["a", $org['MaToChuc'], $actName, $actLocate, $actObject, $actMaxSlot, $actStart, $actEnd, $actBonus, $actPoint, $actContent, $pathAvt, $pathCover]);
        $lastActId = $conn->lastInsertId();
        $actCode = "HD".str_pad($lastActId, 4, "0", STR_PAD_LEFT);

        $sql2 = "UPDATE HoatDong
                SET MaHoatDong = ?
                WHERE Id = ?";
        $stmt = $conn->prepare($sql2);
        $stmt->execute([$actCode, $lastActId]);

        $step2 = $actData['step2'];
        $autoQuestions = $step2['autoQuestions'];
        $customQuestions = $step2['customQuestions'];

        foreach($autoQuestions as $question){
            $sql3 = "INSERT INTO CauHoiDangKy(
                        MaCauHoi
                        ,MaHoatDong
                        ,LoaiCauHoi
                        ,TenHienThi)
                    VALUES (?, ?, ?, ?)";
            $stmt2 = $conn->prepare($sql3);
            $stmt2->execute(["b", $actCode, $question['aqType'], $question['aqContent'],]);
            $lastAqId = $conn->lastInsertId();
            $AqCode = "HD".str_pad($lastAqId, 4, "0", STR_PAD_LEFT);

            $sql4 = "UPDATE CauHoiDangKy
                    SET MaCauHoi = ?
                    WHERE Id = ?";
            $stmt = $conn->prepare($sql4);
            $stmt->execute([$AqCode, $lastAqId]);

        }

        foreach($customQuestions as $question){
            $sql5 = "INSERT INTO CauHoiDangKy(
                        MaCauHoi
                        ,MaHoatDong
                        ,LoaiCauHoi
                        ,TenHienThi)
                    VALUES (?, ?, ?, ?)";
            $stmt2 = $conn->prepare($sql5);
            $stmt2->execute(["c", $actCode, "custom", $question['cqContent'],]);
            $lastCqId = $conn->lastInsertId();
            $CqCode = "HD".str_pad($lastCqId, 4, "0", STR_PAD_LEFT);

            $sql6 = "UPDATE CauHoiDangKy
                    SET MaCauHoi = ?
                    WHERE Id = ?";
            $stmt = $conn->prepare($sql6);
            $stmt->execute([$CqCode, $lastCqId]);
        }

        echo json_encode([
            "success" => true, 
            "message" => "Thêm hoạt động thành công",
            "actCode" => $actCode]);
        exit;
    }catch(Exception $e){
        echo json_encode([
            "success" => false,
            "message" => $e->getMessage()
        ]);
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
                                    <input type="text" name="act-name" id="act-name"  placeholder="Nhập tên hoạt động" class="validate-input">
                                </div>
                                <div class="error-message"></div>
                            </div>

                            <div class="act-info-item">
                                <h4>Đối tượng tham gia</h4>
                                <div class="act-info-item-input">
                                    <input type="text" name="act-object" id="act-object" placeholder="Nhập đối tượng tham gia hoạt động" class="validate-input">
                                </div>
                                <div class="error-message"></div>
                            </div>

                            <div class="act-info-item">
                                <h4>Địa điểm</h4>
                                <div class="act-info-item-input">
                                    <input type="text" name="act-locate" id="act-locate" placeholder="Nhập địa điểm tổ chức" class="validate-input">
                                </div>
                                <div class="error-message"></div>
                            </div>

                            <div class="act-info-item">
                                <h4>Thời gian bắt đầu</h4>
                                <div class="act-info-item-input">
                                    <input type="datetime-local" name="act-start" id="act-start" class="validate-input">
                                </div>
                                <div class="error-message"></div>
                                <span>Thời gian bắt đầu diễn ra hoạt động.</span>
                            </div>

                            <div class="act-info-item">
                                <h4>Số lượng tối đa</h4>
                                <div class="act-info-item-input">
                                    <input type="text" name="act-max-slot" id="act-max-slot" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^0+/, '')" maxlength='5' placeholder="Nhập số lượng tối đa (để trống nếu không giới hạn)" class="validate-input">
                                </div>
                                <div class="error-message"></div>
                                <span>Số lượng sinh viên tối đa có thể đăng ký tham gia.</span>
                            </div>

                            <div class="act-info-item">
                                <h4>Thời gian kết thúc</h4>
                                <div class="act-info-item-input">
                                    <input type="datetime-local" name="act-end" id="act-end" class="validate-input">
                                </div>
                                <div class="error-message"></div>
                                <span>Thời gian kết thúc hoạt động.</span>
                            </div>

                            <div class="act-info-item">
                                <h4>Mục cộng điểm</h4>
                                <div class="act-info-item-input">
                                    <input type="text" class="search-input validate-input" data-type="bonus" value="" id="bonus" placeholder="Gõ mục cộng điểm rèn luyện để tìm kiếm và chọn">
                                </div>
                                <div class="suggest-box"></div>
                                <div class="error-message"></div>
                            </div>
                            <input type="hidden" name="bonus" id="bonusId">

                            <div class="act-info-item">
                                <h4>Điểm rèn luyện</h4>
                                <div class="act-info-item-input">
                                    <input type="text" name="act-point" id="act-point" inputmode="numeric" placeholder="Nhập điểm rèn luyện" class="validate-input act-point" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^0+/, '')" maxlength='2'>
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
                                <textarea name="act-content" id="act-content" placeholder="Nhập nội dung chi tiết của hoạt động" class="validate-input"></textarea>
                            </div>
                            <div class="error-message"></div>
                        </div>
                        <div class="act-info-item act-content-item">
                            <h4>Hình ảnh hoạt động</h4>
                            <span>Chọn ảnh 1 ảnh đại diện cho hoạt động</span>
                            <div class="act-info-item-input">
                                <input type="file" name="act-img-avt" id="act-img-avt" class="act-img-input validate-input">
                            </div>
                            <div class="error-message"></div>
                        </div>
                        <div class="act-info-item act-content-item">
                            <h4>Hình ảnh hoạt động</h4>
                            <span>Chọn ảnh 1 ảnh bìa cho hoạt động</span>
                            <div class="act-info-item-input">
                                <input type="file" name="act-img-cover" id="act-img-cover" class="act-img-input validate-input">
                            </div>
                            <div class="error-message"></div>
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
                                    <input type="checkbox" name="auto-ques" value="Mã số sinh viên" data-id="mssv">
                                    <span class="auto-ques-checkmark"></span>
                                </label>
                                Mã số sinh viên
                            </div>
                            <div class="auto-ques-item">
                                <label class="auto-ques-checkbox">
                                    <input type="checkbox" name="auto-ques" value="Họ tên" data-id="fullname">
                                    <span class="auto-ques-checkmark"></span>
                                </label>
                                Họ tên
                            </div>
                            <div class="auto-ques-item">
                                <label class="auto-ques-checkbox">
                                    <input type="checkbox" name="auto-ques" value="Nghành" data-id="class">
                                    <span class="auto-ques-checkmark"></span>
                                </label>
                                Nghành
                            </div>
                            <div class="auto-ques-item">
                                <label class="auto-ques-checkbox">
                                    <input type="checkbox" name="auto-ques" value="Khóa" data-id="year">
                                    <span class="auto-ques-checkmark"></span>
                                </label>
                                Khóa
                            </div>
                            <div class="auto-ques-item">
                                <label class="auto-ques-checkbox">
                                    <input type="checkbox" name="auto-ques" value="Đơn vị trường" data-id="unit">
                                    <span class="auto-ques-checkmark"></span>
                                </label>
                                Đơn vị trường
                            </div>
                            <div class="auto-ques-item">
                                <label class="auto-ques-checkbox">
                                    <input type="checkbox" name="auto-ques" value="Giới tính" data-id="gender">
                                    <span class="auto-ques-checkmark"></span>
                                </label>
                                Giới tính
                            </div>
                            <div class="auto-ques-item">
                                <label class="auto-ques-checkbox">
                                    <input type="checkbox" name="auto-ques" value="Số điện thoại" data-id="tel">
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
                <button type="submit" id="btn-submit-act">Tạo hoạt động</button>
            </div>
        </form>
    </div>
        <!-- <script src="../../assets/js/manager-pages.js"></script> -->

    <!-- <script src="../assets/js/manager-pages.js"></script> -->
    <!-- <script src="../assets/js/suggest.js"></script> -->

</body>
</html>