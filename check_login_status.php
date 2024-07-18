<?php
session_start();

if (isset($_SESSION['user_id'])) {
    echo json_encode([
        'loggedIn' => true,
        'ho_va_ten' => $_SESSION['ho_va_ten']
    ]);
} else {
    echo json_encode(['loggedIn' => false]);
}
?>
