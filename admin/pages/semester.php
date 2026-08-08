<?php 
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    if(ob_get_length()) ob_clean();
    header('Content-Type: application/json; charset=utf-8');

    $action = $_POST['action'] ?? '';
    $semester = $_POST['semester'] ?? '';
    $year = $_POST['year'] ?? '';
    $dateStart = $_POST['dateStart'] ?? '';
    $dateEnd = $_POST['dateEnd'] ?? '';

    if(empty($semester)){
        echo json_encode(['success' => false, 'message' => 'Vui lòng chọn học kỳ!']);
        exit;
    }elseif(empty($year)){
        echo json_encode(['success' => false, 'message' => 'Vui lòng chọn năm học!']);
        exit;
    }elseif(empty($dateStart)){
        echo json_encode(['success' => false, 'message' => 'Không được để trống thời gian bắt đầu!']);
        exit;
    }elseif(empty($dateEnd)){
        echo json_encode(['success' => false, 'message' => 'Không được để trống thời gian kết thúc!']);
        exit;
    }elseif (!empty($dateStart) && !empty($dateEnd)) {
        $start = new DateTime($dateStart);
        $end = new DateTime($dateEnd);
        $minDateEnd = (clone $start)->modify('+3 months');

        if ($end < $minDateEnd) {
            echo json_encode(['success' => false, 'message' => 'Thời gian giữa các học kỳ kéo dài ít nhất ba tháng!']);
            exit;
        } 
    }

    if ($action === 'edit') {

        try {
            
            $sql5 = "UPDATE HocKy
                          SET ThoiGianBatDau = ?
                            , ThoiGianKetThuc = ?
                          WHERE HocKy = ? AND NamHoc = ?";
            $stmt5 = $conn->prepare($sql5);
            $stmt5->execute([$dateStart, $dateEnd, $semester, $year]);

            echo json_encode([
                'success' => true, 
                'message' => 'Cập nhật học kỳ thành công'
                ]);
            exit;

        } catch (PDOException $e) {
            echo json_encode([
                'success' => false, 
                'message' => 'Lỗi cập nhật: ' . $e->getMessage()
                ]);
            exit;
        }
    }

    try {
        $sql1 = "UPDATE HocKy
                SET ThoiGianBatDau = ?, ThoiGianKetThuc = ?
                WHERE HocKy = ? AND NamHoc = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute([$dateStart, $dateEnd, $semester, $year]);

        echo json_encode(['success' => true, 'message' => 'Tạo học kỳ thành công']);
        exit;
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        exit;
    }
}

  
$sql3 = "SELECT DISTINCT NamHoc
        FROM HocKy
        WHERE ThoiGianBatDau IS NULL
            AND ThoiGianKetThuc IS NULL";
$stmt3 = $conn->prepare($sql3);
$stmt3->execute();

$sql4 = "SELECT DISTINCT NamHoc
        FROM HocKy
        WHERE ThoiGianBatDau IS NOT NULL
            AND ThoiGianKetThuc IS NOT NULL";
$stmt4 = $conn->prepare($sql4);
$stmt4->execute();

$filterYear = $_GET['filterYear'] ?? '';
$sql2 = "SELECT *
        FROM HocKy  
        WHERE ThoiGianBatDau IS NOT NULL
            AND ThoiGianKetThuc IS NOT NULL ";
$params = [];
if(!empty($filterYear)){
    $sql2 .= " AND NamHoc = ? ";
    $params[] = $filterYear;
}
$stmt2 = $conn->prepare($sql2);
$stmt2->execute($params);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý học kỳ</title>
</head>
<body>
    <div class="semester-container">
        <div class="semester-title">
            <h2>Quản lý học kỳ</h2>
            <span>Quản lý và tạo học kì mới cho năm học</span>
        </div>
        <div class="semester-create-container" id="create-form-wrapper">
            <h3>Tạo học kì mới</h3>
            <div class="semester-create">
                <form action="" id="semesterForm">
                    <div class="semester-create-item" data-type="semester">
                        <span>Học kì</span>
                        <div class="semester-dropdown-selected">
                            <span class="semester-selected-text">
                                <?= !empty($semester) ? "HK" . htmlspecialchars($semester) : "--Chọn học kỳ--" ?>
                            </span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="semester-dropdown-menu">
                            <div class="semester-dropdown-option" data-value="">--Chọn học kỳ--</div>
                            <div class="semester-dropdown-option" data-value="1">HK1</div>
                            <div class="semester-dropdown-option" data-value="2">HK2</div>
                            <div class="semester-dropdown-option" data-value="3">HK3</div>
                        </div>
                        <input type="hidden" name="semester" id="input-semester" value="">
                        <?php if(!empty($error['semester'])): ?>
                            <small style="color:red;">
                                <?= $error['semester'] ?>
                            </small>
                        <?php endif;?>
                    </div>
                    <div class="semester-create-item" data-type="year">
                        <span>Năm học</span>
                        <div class="semester-dropdown-selected">
                            <span class="semester-selected-text">
                                <?= !empty($year) ? htmlspecialchars($year) : "--Chọn năm học--" ?>
                            </span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="semester-dropdown-menu">
                            <div class="semester-dropdown-option" data-value="">--Chọn năm học--</div>
                            <?php while($row = $stmt3->fetch(PDO::FETCH_ASSOC)){ ?>
                            <div class="semester-dropdown-option" data-value="<?= $row['NamHoc'] ?>"><?= $row['NamHoc'] ?></div>
                            <?php } ?>
                        </div>
                        <input type="hidden" name="year" id="input-year" value="">
                        <?php if(!empty($error['year'])): ?>
                            <small style="color:red;">
                                <?= $error['year'] ?>
                            </small>
                        <?php endif;?>
                    </div>
                    <div class="semester-create-item">
                        <span>Thời gian bắt đầu</span>
                        <div class="semester-create-input">
                            <input type="date" name="dateStart" id="">
                        </div>
                        <?php if(!empty($error['dateStart'])): ?>
                            <small style="color:red;">
                                <?= $error['dateStart'] ?>
                            </small>
                        <?php endif;?>
                    </div>
                    <div class="semester-create-item">
                        <span>Thời gian kết thúc</span>
                        <div class="semester-create-input">
                            <input type="date" name="dateEnd" id="">
                        </div>
                        <?php if(!empty($error['dateEnd'])): ?>
                            <small style="color:red;">
                                <?= $error['dateEnd'] ?>
                            </small>
                        <?php endif;?>
                    </div>
                    <button type="submit">Tạo học kỳ</button>
                </form>
            </div>
        </div>
        <!-- edit -->
        <div class="semester-create-container hidden" id="edit-form-wrapper">
            <h3>Cập nhật học kỳ</h3>
            <div class="semester-create">
                <form action="" id="editSemesterForm">
                    <input type="hidden" name="action" value="edit">
                    <!-- <input type="hidden" name="maHocKy" id="edit-maHocKy"> -->

                    <div class="semester-create-item" data-type="semester">
                        <span>Học kỳ</span>
                        <div class="semester-create-input">
                            <input type="text" name="dateStart" id="edit-semester-text" class="input-edit-semester-readonly" readonly>
                        </div>
                        <input type="hidden" name="semester" id="edit-input-semester" value="">
                    </div>

                    <div class="semester-create-item" data-type="year">
                        <span>Năm học</span>
                        <input type="text" name="dateStart" id="edit-year-text" class="input-edit-semester-readonly" readonly>
                        <input type="hidden" name="year" id="edit-input-year" value="">
                    </div>

                    <div class="semester-create-item">
                        <span>Thời gian bắt đầu</span>
                        <div class="semester-create-input">
                            <input type="date" name="dateStart" id="edit-dateStart">
                        </div>
                    </div>

                    <div class="semester-create-item">
                        <span>Thời gian kết thúc</span>
                        <div class="semester-create-input">
                            <input type="date" name="dateEnd" id="edit-dateEnd">
                        </div>
                    </div>

                    <div style="display: flex; gap: 10px;">
                        <button type="submit">Lưu cập nhật</button>
                        <button type="button" id="btn-cancel-edit" >Hủy bỏ</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="semester-list">
            <h3>Danh sách học kỳ</h3>
            <!-- create -->
            <div class="header-semester-list">
                <div class="semester-search-container">
                    <div class="semester-search" data-type="year">
                        <span>Năm học</span>
                        <div class="semester-year-dropdown-selected">
                            <span class="semester-year-selected-text">
                                <?= !empty($filterYear) ? htmlspecialchars($filterYear) : "--Chọn năm học--" ?>
                            </span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="semester-year-dropdown-menu">
                            <?php while($row = $stmt4->fetch(PDO::FETCH_ASSOC)){ ?>
                            <div class="semester-year-dropdown-option" data-value="<?= $row['NamHoc'] ?>"><?= $row['NamHoc'] ?></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <table class="semester-table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Học kỳ</th>
                        <th>Năm học</th>
                        <th>Thời gian bắt đầu</th>
                        <th>Thời gian kết thúc</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $stt = 1; 
                    while ($semester = $stmt2->fetch(PDO::FETCH_ASSOC)):?>
                    <tr>
                        <td><?= $stt++ ?></td>
                        <td>
                            <div class="semester-info">
                                <h4>Học kỳ <?= $semester['HocKy'] ?></h4>
                            </div>
                        </td>
                        <td>
                            <div class="semester-info">
                                <h4><?= $semester['NamHoc'] ?></h4>
                            </div>
                        </td>
                        <td>
                            <div class="semester-info">
                                <h4><?= $semester['ThoiGianBatDau'] ?></h4>
                            </div>
                        </td>
                        <td>
                            <div class="semester-info">
                                <h4><?= $semester['ThoiGianKetThuc'] ?></h4>
                            </div>
                        </td>
                        <td>
                            <button class="edit-semester-btn"  data-id="<?= $semester['MaHocKy'] ?>" 
                            data-hk="<?= $semester['HocKy'] ?>"
                            data-nam="<?= $semester['NamHoc'] ?>"
                            data-start="<?= $semester['ThoiGianBatDau'] ?>"
                            data-end="<?= $semester['ThoiGianKetThuc'] ?>">
                                Sửa
                            </button>

                            <button class="delete-semester-btn"  data-id="<?= $semester['MaHocKy'] ?>" data-name="<?= htmlspecialchars($semester['HocKy']) ?> (<?= htmlspecialchars($semester['NamHoc']) ?>)">
                                Xóa
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div id="delete-semester-modal" class="modal">
                <div class="modal-content">
                    <h3 id="delete-semester-modal-title">Xác nhận xóa</h3>
                    <p id="delete-semester-message"></p>
                    <div class="model-btn">
                        <button id="btn-cancel-delete-semester">Hủy</button>
                        <button id="btn-confirm-delete-semester">Xóa</button>
                    </div>
                </div>
            </div>
            <div id="notice-semester-modal" class="modal">
                <div class="modal-content">
                    <h3 id="notice-semester-modal-title">Thông báo</h3>
                    <p id="notice-semester-message"></p>
                    <div class="model-btn">
                        <button id="btn-cancel-notice-semester">Đóng</button>
                        <button id="btn-cancel-notice-error-semester" class="hidden">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>