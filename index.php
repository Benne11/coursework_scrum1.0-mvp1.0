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
        echo "<div style='min-height: 60vh; padding: 40px; font-family: sans-serif; text-align: center;'>";
        echo "<h1 style='color: #1a1a1a; margin-bottom: 20px;'>Home - Born Car</h1>";
        echo "<p style='margin-bottom: 30px;'><a href='index.php?action=browse_cars' style='padding: 15px 30px; background: #ffc107; color: #1a1a1a; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 18px;'>=> Browse Cars Now! <=</a></p>";
        if (isset($_SESSION['user'])) {
            $fullname = htmlspecialchars($_SESSION['user']['fullname']);
            $role = htmlspecialchars($_SESSION['user']['role']);
            $tier = htmlspecialchars($_SESSION['user']['membership_tier'] ?? 'new');
            //$adminLink = ($role === 'admin') ? "<a href='index.php?action=admin_dashboard' style='color: #ffc107; font-weight: bold; text-decoration: none; margin-right: 15px;'>Admin Panel</a>" : "";
            
            echo "<p style='font-size: 18px;'>Welcome, <strong>{$fullname}</strong>! (Role: {$role} | Tier: <span style='color: #ffc107; font-weight: bold;'>{$tier}</span>)</p>";
            echo "<p>
                    
                    
                    <a href='index.php?action=logout' style='color: #dc3545; font-weight: bold; text-decoration: none;'>Logout</a>
                  </p>";
        } else {
            echo "<p style='font-size: 18px;'><a href='index.php?action=login_form' style='color: #007bff; text-decoration: none; font-weight: bold;'>Login</a> | <a href='index.php?action=register_form' style='color: #28a745; text-decoration: none; font-weight: bold;'>Register</a></p>";
        }
        echo "</div>";
        // Nhúng Footer cho trang Home
        require_once 'views/layouts/footer.php';
        break;

    case 'browse_cars':
    case 'car_detail':
        require_once 'config/database.php';
        require_once 'controllers/CarController.php';
        break;

    case 'book_form':
    case 'book_preview':
    case 'checkout':
    case 'payment_gateway':
    case 'process_payment':
    case 'booking_success':
        require_once 'config/database.php';
        require_once 'controllers/BookingController.php';
        break;

    case 'register_form':
        require_once 'views/pages/register.php';
        break;

    case 'register_submit':
    case 'verify_otp':
    case 'verify_otp_submit':
        // Khởi tạo kết nối DB và xử lý form submit
        require_once 'config/database.php';
        require_once 'controllers/AuthController.php';
        break;

    case 'login_form':
        require_once 'views/pages/login.php';
        break;

    case 'login_submit':
    case 'logout':
        require_once 'config/database.php';
        require_once 'controllers/AuthController.php';
        break;

    case 'my_bookings':
    case 'cancel_booking':
    case 'edit_booking':    // Hiển thị Form để sửa
    case 'update_booking':  // Nhận dữ liệu POST để lưu vào DB
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
