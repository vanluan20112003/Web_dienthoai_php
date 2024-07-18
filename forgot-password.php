<?php
include 'connect.php'; // Bao gồm file kết nối cơ sở dữ liệu

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

include 'connect.php'; // Bao gồm file kết nối cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Kiểm tra email đã tồn tại trong DB
    $query = "SELECT * FROM user_info WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Email tồn tại, tạo mã OTP
        $otp = rand(100000, 999999); // Tạo mã OTP ngẫu nhiên 6 chữ số

        // Lưu OTP vào cơ sở dữ liệu hoặc session
        session_start();
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        // Gửi OTP đến email người dùng sử dụng PHPMailer với Outlook
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.office365.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'levanluan20112003@outlook.com'; // Thay bằng email Outlook của bạn
            $mail->Password   = 'vta12345'; // Thay bằng mật khẩu của bạn
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('levanluan20112003@outlook.com', 'Luan');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Mã OTP của bạn';
            $mail->Body    = "Mã OTP của bạn là: $otp";

            $mail->send();
            echo 'success';
        } catch (Exception $e) {
            echo "Không thể gửi email. Vui lòng thử lại sau. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo 'Email không tồn tại trong hệ thống.';
    }
}

mysqli_close($conn); // Đóng kết nối cơ sở dữ liệu
?>
