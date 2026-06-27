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

        <form action="#" method="post">
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
                                    <input type="text" name="act-point" id="act-point" placeholder="Nhập điểm rèn luyện" class="validate-input act-point">
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
                        <div class="act-content-item act-info-item-input">
                            <h4>Hình ảnh hoạt động</h4>
                            <div class="act-info-item-input">
                                <input type="file" name="act-img" id="act-img" >
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
                                    <input type="checkbox" name="" id="">
                                    <span class="auto-ques-checkmark"></span>
                                </label>
                                Mã số sinh viên
                            </div>
                            <div class="auto-ques-item">
                                <label class="auto-ques-checkbox">
                                    <input type="checkbox" name="" id="">
                                    <span class="auto-ques-checkmark"></span>
                                </label>
                                Họ tên
                            </div>
                            <div class="auto-ques-item">
                                <label class="auto-ques-checkbox">
                                    <input type="checkbox" name="" id="">
                                    <span class="auto-ques-checkmark"></span>
                                </label>
                                Nghành
                            </div>
                            <div class="auto-ques-item">
                                <label class="auto-ques-checkbox">
                                    <input type="checkbox" name="" id="">
                                    <span class="auto-ques-checkmark"></span>
                                </label>
                                Khóa
                            </div>
                            <div class="auto-ques-item">
                                <label class="auto-ques-checkbox">
                                    <input type="checkbox" name="" id="">
                                    <span class="auto-ques-checkmark"></span>
                                </label>
                                Đơn vị trường
                            </div>
                            <div class="auto-ques-item">
                                <label class="auto-ques-checkbox">
                                    <input type="checkbox" name="" id="">
                                    <span class="auto-ques-checkmark"></span>
                                </label>
                                Giới tính
                            </div>
                            <div class="auto-ques-item">
                                <label class="auto-ques-checkbox">
                                    <input type="checkbox" name="" id="">
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
                <div class="btn-step-previous">Trở lại</div>
            </div>
        </form>
    </div>
        <!-- <script src="../../assets/js/step.js"></script> -->

    <!-- <script src="../assets/js/manager-pages.js"></script> -->
    <!-- <script src="../assets/js/suggest.js"></script> -->

</body>
</html>