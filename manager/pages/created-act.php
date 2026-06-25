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
    $actName = $_POST['act-name'] ?? '';
    $actLocate = $_POST['act-locate'] ?? '';
    $actStart = $_POST['act-start'] ?? '';
    $actMaxSlot = $_POST['act-max-slot'] ?? '';
    $actEnd = $_POST['act-end'] ?? '';
    
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

        <!-- STEP 1 -->
         <div class="step-block active act-info-container" id="step1">
            <h1>ĐÂY LÀ BƯỚC 1</h1>
            <div class="act-info-block">
                <h3>Thông tin hoạt động</h3>
                <span>Nhập các thông tin cơ bản của hoạt động</span>
                <div class="act-info-form">
                    <div class="act-info-item">
                        <h4>Tên hoạt động</h4>
                        <div class="act-info-item-input">
                            <input type="text" name="act-name" id="" placeholder="Nhập tên hoạt động">
                        </div>
                    </div>

                    <div class="act-info-item">
                        <h4>Địa điểm</h4>
                        <div class="act-info-item-input">
                            <input type="text" name="act-locate" id="" placeholder="Nhập địa điểm tổ chức">
                        </div>
                    </div>

                    <div class="act-info-item">
                        <h4>Thời gian bắt đầu</h4>
                        <div class="act-info-item-input">
                            <input type="datetime-local" name="act-start" id="" >
                        </div>
                        <span>Thời gian bắt đầu diễn ra hoạt động.</span>
                    </div>

                    <div class="act-info-item">
                        <h4>Số lượng tối đa</h4>
                        <div class="act-info-item-input">
                            <input type="text" name="act-max-slot" id="" placeholder="Nhập số lượng tối đa (để trống nếu không giới hạn)">
                        </div>
                        <span>Số lượng sinh viên tối đa có thể đăng ký tham gia.</span>
                    </div>

                    <div class="act-info-item">
                        <h4>Thời gian kết thúc</h4>
                        <div class="act-info-item-input">
                            <input type="datetime-local" name="act-end" id="" >
                        </div>
                        <span>Thời gian kết thúc hoạt động.</span>
                    </div>

                    <div class="act-info-item">
                        <h4>Mục cộng điểm</h4>
                        <div class="act-info-item-input">
                            <input type="text" name="bonus" class="search-input" data-type="bonus" value="" id="bonus" placeholder="Gõ mục cộng điểm rèn luyện để tìm kiếm và chọn">
                        </div>
                        <div class="suggest-box"></div>
                    </div>

                    <div class="act-info-item">
                        <h4>Điểm rèn luyện</h4>
                        <div class="act-info-item-input">
                            <input type="text" name="act-point" id="" placeholder="Nhập điểm rèn luyện">
                        </div>
                        <span>Nhập điểm rèn luyện sinh viên nhận được khi tham gia.</span>
                    </div>
                </div>
            </div>
            <div class="act-info-block"></div>
            <div class="act-info-block"></div>
            <div class="act-info-block">
                <div class="btn-step-next">Tiếp theo</div>
            </div>
            
         </div>
        <!-- STEP 2 -->
         <div class="step-block" id="step2">
            <h1>ĐÂY LÀ BƯỚC 2</h1>
            <div class="btn-step-next">Tiếp theo</div>
            <div class="btn-step-previous">Trở lại</div>

         </div>
        <!-- STEP 3 -->
         <div class="step-block" id="step3">
            <h1>ĐÂY LÀ BƯỚC 3</h1>
            <div class="btn-step-previous">Trở lại</div>
         </div>
    </div>
        <!-- <script src="../../assets/js/step.js"></script> -->

    <!-- <script src="../assets/js/manager-pages.js"></script> -->
    <!-- <script src="../assets/js/suggest.js"></script> -->

</body>
</html>