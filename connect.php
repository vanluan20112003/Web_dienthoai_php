<?php
$servername = "localhost";
$username = "root"; // Tài khoản mặc định của MySQL trên XAMPP
$password = ""; // Mật khẩu mặc định là rỗng
$dbname = "web_dien_thoai"; // Thay bằng tên cơ sở dữ liệu bạn đã tạo

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
