<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    // Lấy thông tin người dùng từ cơ sở dữ liệu
    include 'connect.php';
    $query = "SELECT ho_va_ten, email, dien_thoai, dia_chi_giao_hang, ngay_sinh, gioi_tinh FROM user_info WHERE id='$user_id'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user_info = mysqli_fetch_assoc($result);
        echo json_encode($user_info);
    } else {
        echo json_encode(['error' => 'Không tìm thấy thông tin người dùng.']);
    }
    mysqli_close($conn);
} else {
    echo json_encode(['error' => 'Chưa đăng nhập.']);
}
?>
