<?php 

$host = "localhost";
$dbname = "ql-hoat-dong-sinh-vien";
$username = "root";
$password = "";
date_default_timezone_set('Asia/Ho_Chi_Minh');

try{
    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username,
        $password
    );

    $conn->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

}catch(PDOException $e){
    die("Lỗi kết nối: " . $e->getMessage());
}

?>