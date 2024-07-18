<?php
include 'connect.php'; // Bao gồm file kết nối cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];

    // Kiểm tra email đã tồn tại trong DB
    $query = "SELECT * FROM user_info WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        echo "Email đã tồn tại trong hệ thống. Vui lòng nhập lại.";
        exit; // Dừng việc xử lý tiếp theo
    }

    // Kiểm tra số điện thoại đã tồn tại trong DB
    $query = "SELECT * FROM user_info WHERE dien_thoai='$phone'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        echo "Số điện thoại đã tồn tại trong hệ thống. Vui lòng nhập lại.";
        exit; // Dừng việc xử lý tiếp theo
    }

    // Nếu không có vấn đề gì, tiếp tục thêm thông tin người dùng vào DB
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $insertQuery = "INSERT INTO user_info (ho_va_ten, dien_thoai, email, mat_khau) VALUES ('$name', '$phone', '$email', '$hashed_password')";
    if (mysqli_query($conn, $insertQuery)) {
        echo "Đăng ký thành công!";
    } else {
        echo "Đăng ký thất bại. Vui lòng thử lại sau.";
    }
}

mysqli_close($conn); // Đóng kết nối cơ sở dữ liệu
?>
