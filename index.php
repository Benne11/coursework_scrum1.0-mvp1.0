<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// filepath: coursework_scrum1.0/index.php
// Router chính điều hướng các request

session_start();

$action = $_GET['action'] ?? 'home';

// Định tuyến cơ bản
switch ($action) {
    case 'home':
        require_once 'config/database.php';
        require_once 'controllers/HomeController.php';
        break;

    case 'browse_cars':
    case 'car_detail':
        require_once 'config/database.php';
        require_once 'controllers/CarController.php';
        break;

    case 'book_form':
    case 'book_preview':
    case 'update_booking':
    case 'checkout':
    case 'payment_gateway':
    case 'process_payment':
    case 'booking_success':
        require_once 'config/database.php';
        require_once 'controllers/BookingController.php';
        break;

    case 'register_form':
        header('Location: index.php?action=browse_cars&auth=register');
        exit;

    case 'register_submit':
    case 'verify_otp':
    case 'verify_otp_submit':
        // Khởi tạo kết nối DB và xử lý form submit
        require_once 'config/database.php';
        require_once 'controllers/AuthController.php';
        break;

    case 'login_form':
        header('Location: index.php?action=browse_cars&auth=login');
        exit;

    case 'login_submit':
    case 'login':
    case 'logout':
        require_once 'config/database.php';
        require_once 'controllers/AuthController.php';
        break;

    case 'my_bookings':
    case 'cancel_booking':
    case 'edit_booking':    // Hiển thị Form để sửa
        require_once 'config/database.php';
        require_once 'controllers/UserController.php';
        break;


    case 'admin_dashboard':
    case 'admin_cars':
    case 'admin_delete_car':
    case 'admin_add_car':
    case 'admin_edit_car':
    case 'admin_users':
    case 'admin_edit_user':
    case 'admin_delete_user':
    case 'admin_bookings':
    case 'admin_update_booking':
        require_once 'config/database.php';
        require_once 'controllers/AdminController.php';
        break;

    default:
        http_response_code(404);
        echo "<h1>404 - Page not found</h1>";
        break;
}
