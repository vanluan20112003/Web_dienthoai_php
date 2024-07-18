<?php
session_start();
include 'connect.php'; // Bao gồm file kết nối cơ sở dữ liệu

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $ho_va_ten = $_POST['ho_va_ten'] ?? null;
        $email = $_POST['email'] ?? null;
        $dien_thoai = $_POST['dien_thoai'] ?? null;
        $dia_chi_giao_hang = $_POST['dia_chi_giao_hang'] ?? null;
        $ngay_sinh = $_POST['ngay_sinh'] ?? null;
        $gioi_tinh = $_POST['gioi_tinh'] == 'other' ? null : $_POST['gioi_tinh'];

        // Kiểm tra email và số điện thoại đã tồn tại ngoại trừ chính người dùng
        $query_check = "SELECT * FROM user_info WHERE (email='$email' OR dien_thoai='$dien_thoai') AND id != '$user_id'";
        $result_check = mysqli_query($conn, $query_check);
        
        if (mysqli_num_rows($result_check) > 0) {
            $response['error'] = "Email hoặc số điện thoại đã tồn tại.";
        } else {
            // Lấy thông tin cũ của người dùng
            $query_old_info = "SELECT * FROM user_info WHERE id='$user_id'";
            $result_old_info = mysqli_query($conn, $query_old_info);
            $old_info = mysqli_fetch_assoc($result_old_info);

            // Chỉ cập nhật các trường không rỗng
            $updates = [];
            if ($ho_va_ten) $updates[] = "ho_va_ten='$ho_va_ten'";
            if ($email) $updates[] = "email='$email'";
            if ($dien_thoai) $updates[] = "dien_thoai='$dien_thoai'";
            if ($dia_chi_giao_hang) $updates[] = "dia_chi_giao_hang='$dia_chi_giao_hang'";
            if ($ngay_sinh) $updates[] = "ngay_sinh='$ngay_sinh'";
            if ($gioi_tinh !== null) $updates[] = "gioi_tinh='$gioi_tinh'";

            if (!empty($updates)) {
                $update_query = "UPDATE user_info SET " . implode(', ', $updates) . " WHERE id='$user_id'";
                if (mysqli_query($conn, $update_query)) {
                    $response['success'] = "Cập nhật thông tin thành công.";
                    if ($ho_va_ten) $_SESSION['ho_va_ten'] = $ho_va_ten; // Cập nhật session nếu tên thay đổi
                } else {
                    $response['error'] = "Cập nhật thông tin thất bại.";
                }
            } else {
                $response['error'] = "Không có thông tin mới để cập nhật.";
            }
        }
    } else {
        $response['error'] = "Chưa đăng nhập.";
    }
} else {
    $response['error'] = "Phương thức không hợp lệ.";
}

mysqli_close($conn); // Đóng kết nối cơ sở dữ liệu

echo json_encode($response);
?>
