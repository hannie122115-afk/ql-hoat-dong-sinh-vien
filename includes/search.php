<?php 

require_once "config/db.php";

$q = $_GET['q'] ?? ''; //lấy ký tự gõ
$type = $_GET['type'] ?? '';

$search = "%$q%";

switch($type){
    case "unit":
        $sql = "SELECT * FROM DonVi WHERE TenDonVI LIKE ?";
        break;

    default:
    die("Invalid type");
}

$stmt = $conn->prepare($sql); // chuẩn bị dữ liệu
$stmt->bind_param("s", $search); // gắn dữ liệu vào phần ? trong sql
$stmt->execute();

$result = $stmt->get_result();

?>

<!-- Hiện kết quả  -->

<?php while ($row = $result->fetch_assoc()): ?>
    <div>
        <?php 
        
        switch($type){
            case "unit":
                $row['TenDonVi'];
        }
        ?>
    </div>
<?php endwhile; ?>