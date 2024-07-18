<?php
session_start();
include 'connect.php'; // Bao gồm file kết nối cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Kiểm tra thông tin đăng nhập trong cơ sở dữ liệu
    $query = "SELECT * FROM user_info WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['mat_khau']; // Lấy mật khẩu đã được hash từ cơ sở dữ liệu

        // Kiểm tra mật khẩu
        if (password_verify($password, $hashed_password)) {
            // Đăng nhập thành công
            $_SESSION['user_id'] = $row['id']; // Lưu trữ ID người dùng vào phiên làm việc
            $_SESSION['ho_va_ten'] = $row['ho_va_ten']; // Lưu trữ họ và tên người dùng vào phiên làm việc
            echo 'success'; // Trả về success cho ajax để xử lý chuyển hướng
        } else {
            // Sai mật khẩu
            echo 'failure';
        }
    } else {
        // Email không tồn tại
        echo 'failure';
    }
}

mysqli_close($conn); // Đóng kết nối cơ sở dữ liệu
?>
