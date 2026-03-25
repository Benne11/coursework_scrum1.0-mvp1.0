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
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Home - Born Car</title>
            <style>
                body { 
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
                    background-color: #f8f9fa; 
                    margin: 0; 
                    padding: 0; 
                    color: #333;
                }
                
                /* Navbar Styling */
                .navbar { 
                    background-color: #1a1a1a; 
                    color: #fff; 
                    padding: 15px 40px; 
                    display: flex; 
                    justify-content: space-between; 
                    align-items: center; 
                    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
                }
                .navbar .logo strong { font-size: 24px; letter-spacing: 1px; color: #f48f0c;}
                .navbar a { 
                    color: #fff; 
                    text-decoration: none; 
                    margin-left: 20px; 
                    font-weight: 500;
                    transition: color 0.3s;
                }
                .navbar a:hover { color: #f48f0c; }
                
                /* User Context Fix */
                .nav-links {
                    display: flex;
                    align-items: center;
                }
                .user-greeting {
                    color: white;
                    margin-left: 20px;
                    font-weight: 500;
                }
                
                /* Home Content */
                .home-content {
                    min-height: auto;
                    padding: 0;
                    text-align: center;
                    display: none;
                }
                .home-title {
                    color: #1a1a1a;
                    margin-bottom: 20px;
                    font-size: 42px;
                    font-weight: 700;
                }
                .home-content p {
                    margin-bottom: 30px;
                    font-size: 18px;
                }
                .btn-primary {
                    display: inline-block;
                    padding: 15px 30px;
                    background: #f48f0c;
                    color: #1a1a1a;
                    text-decoration: none;
                    border-radius: 8px;
                    font-weight: bold;
                    font-size: 18px;
                    transition: background 0.3s;
                }
                .btn-primary:hover {
                    background: #1a1a1a;
                    color: #f48f0c;
                }
                .welcome-message {
                    background: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    margin-bottom: 30px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                    max-width: 600px;
                    margin-left: auto;
                    margin-right: auto;
                    margin-top: 20px;
                }
                
                /* Banner Advertisement */
                .banner-ad {
                    width: 100%;
                    height: 350px;
                    background: linear-gradient(135deg, rgba(30, 30, 30, 0.7) 0%, rgba(100, 50, 150, 0.7) 100%), 
                                url('https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80');
                    background-size: cover;
                    background-position: center;
                    border-radius: 12px;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    color: white;
                    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
                    margin-bottom: 50px;
                    overflow: hidden;
                }
                .banner-ad h2 {
                    font-size: 48px;
                    font-weight: 700;
                    margin: 0 0 20px 0;
                    text-align: center;
                    max-width: 90%;
                    line-height: 1.2;
                }
                .banner-ad p {
                    font-size: 18px;
                    margin: 0 0 30px 0;
                    text-align: center;
                    max-width: 80%;
                    line-height: 1.5;
                }
                .banner-ad .btn-cta {
                    display: inline-block;
                    padding: 15px 40px;
                    background: #f48f0c;
                    color: white;
                    text-decoration: none;
                    border-radius: 30px;
                    font-weight: 600;
                    font-size: 16px;
                    transition: all 0.3s;
                    border: none;
                    cursor: pointer;
                }
                .banner-ad .btn-cta:hover {
                    background: #bd7211;
                    transform: scale(1.05);
                }
                
                @media (max-width: 768px) {
                    .banner-ad {
                        height: 250px;
                    }
                    .banner-ad h2 {
                        font-size: 32px;
                    }
                    .banner-ad p {
                        font-size: 15px;
                    }
                }
            </style>
        </head>
        <body>
            <div class="navbar">
                <div class="logo"><strong>Born Car</strong></div>
                <div class="nav-links">
                    <a href="index.php?action=home" class="active">Home</a>
                    <a href="index.php?action=browse_cars">Browse Cars</a>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="index.php?action=my_bookings">My Bookings</a>
                        <span class="user-greeting">Hi, <?= htmlspecialchars($_SESSION['user']['fullname']) ?></span>
                        <a href="index.php?action=logout" style="color: #f48f0c;">Logout</a>
                    <?php else: ?>
                        <a href="index.php?action=login_form">Login/Register</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Advertisement Banner -->
            <div class="banner-ad">
                <h2>Easy Car Rental, Perfect Journey</h2>
                <p>Over 100+ latest car models ready to accompany you on every road.</p>
                <a href="index.php?action=browse_cars" class="btn-cta">Get Started Now</a>
            </div>

            <!-- Welcome Message -->
            <div class="welcome-message">
                <?php if (isset($_SESSION['user'])): 
                    $fullname = htmlspecialchars($_SESSION['user']['fullname']);
                    $role = htmlspecialchars($_SESSION['user']['role']);
                    $tier = htmlspecialchars($_SESSION['user']['membership_tier'] ?? 'new');
                ?>
                    <p style="margin: 0;">Welcome, <strong><?= $fullname ?></strong>! (Role: <?= $role ?> | Tier: <span style="color: #f48f0c; font-weight: bold;"><?= $tier ?></span>)</p>
                <?php else: ?>
                    <p style="margin: 0;">Welcome to Born Car! Please <a href="index.php?action=login_form" style="color: #f48f0c; font-weight: bold;">login or register</a> to start your car rental journey.</p>
                <?php endif; ?>
            </div>

            <div class="home-content">
            </div>

            <?php require_once 'views/layouts/footer.php'; ?>
        </body>
        </html>
        <?php
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
