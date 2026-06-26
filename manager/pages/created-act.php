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

        <form action="#" method="post">
                <!-- STEP 1 -->
            <div class="step-block active" id="step1">
                <h1>ĐÂY LÀ BƯỚC 1</h1>
                <div class="act-info-container">
                    <div class="step1-block act-info-block">
                        <h3>Thông tin hoạt động</h3>
                        <span>Nhập các thông tin cơ bản của hoạt động</span>
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
                                    <input type="text" name="act-max-slot" id="act-max-slot" placeholder="Nhập số lượng tối đa (để trống nếu không giới hạn)" class="validate-input">
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
                                    <input type="text" name="bonus" class="search-input validate-input" data-type="bonus" value="" id="bonus" placeholder="Gõ mục cộng điểm rèn luyện để tìm kiếm và chọn">
                                </div>
                                <div class="suggest-box"></div>
                                <div class="error-message"></div>
                            </div>

                            <div class="act-info-item">
                                <h4>Điểm rèn luyện</h4>
                                <div class="act-info-item-input">
                                    <input type="text" name="act-point" id="act-point" placeholder="Nhập điểm rèn luyện" class="validate-input">
                                </div>
                                <div class="error-message"></div>
                                <span>Nhập điểm rèn luyện sinh viên nhận được khi tham gia.</span>
                            </div>
                        </div>
                    </div>
                    <div class="step1-block act-content-block">
                        <h3>Nội dung hoạt động</h3>
                        <span>Mô tả chi tiết về hoạt động để thu hút sinh viên tham gia</span>
                        <div class="act-info-item act-content-item">
                            <h4>Nội dung chi tiết</h4>
                            <div class="act-info-item-input">
                                <input type="text" name="act-content" id="act-content" placeholder="Nhập nội dung chi tiết của hoạt động" class="validate-input">
                            </div>
                            <div class="error-message"></div>
                        </div>
                        <div class="act-content-item">
                            <h4>Hình ảnh hoạt động</h4>
                            <div class="act-info-item-input">
                                <input type="file" name="act-img" id="act-img" >
                            </div>
                        </div>
                    </div>
                    <div class="step1-block">
                        <div class="btn-step-next">Tiếp theo</div>
                    </div>
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
        </form>
    </div>
        <!-- <script src="../../assets/js/step.js"></script> -->

    <!-- <script src="../assets/js/manager-pages.js"></script> -->
    <!-- <script src="../assets/js/suggest.js"></script> -->

</body>
</html>