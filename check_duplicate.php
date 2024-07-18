<?php
// Kết nối đến cơ sở dữ liệu và thực hiện kiểm tra
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu từ request POST
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];

// Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu chưa
$stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Nếu tồn tại email trong cơ sở dữ liệu
    echo json_encode(array('error' => true, 'message' => 'Email đã được sử dụng.'));
    exit();
}

// Kiểm tra xem số điện thoại đã tồn tại trong cơ sở dữ liệu chưa
$stmt = $conn->prepare("SELECT phone FROM users WHERE phone = ?");
$stmt->bind_param("s", $phone);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Nếu tồn tại số điện thoại trong cơ sở dữ liệu
    echo json_encode(array('error' => true, 'message' => 'Số điện thoại đã được sử dụng.'));
    exit();
}

// Nếu không có lỗi
echo json_encode(array('error' => false));
$stmt->close();
$conn->close();
?>
