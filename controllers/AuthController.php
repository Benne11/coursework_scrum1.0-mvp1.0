<?php
// filepath: coursework_scrum1.0/controllers/AuthController.php

// Khai báo thư viện PHPMailer thủ công
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Nhúng trực tiếp các file từ thư mục PHPMailer
require_once __DIR__ . '/../PHPMailer/Exception.php';
require_once __DIR__ . '/../PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/SMTP.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../datafunctions/auth_functions.php';

// Xử lý POST request cho action 'register_submit'
$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'register_submit') {
    $fullname = trim($_POST['fullname'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $phone    = trim($_POST['phone'] ?? '');

    // Validation cơ bản để bắt lỗi input rỗng
    $errors = [];
    if (empty($fullname)) $errors[] = "Full Name is required.";
    if (empty($email)) $errors[] = "Email is required.";
    if (empty($password)) $errors[] = "Password is required.";

    // Nếu có lỗi validation input
    if (!empty($errors)) {
        $_SESSION['register_errors'] = $errors;
        $_SESSION['register_old_data'] = $_POST;
        header("Location: index.php?action=register_form");
        exit;
    }

    if ($fullname && $email && $password) {
        // 1. Tạo OTP 6 số ngẫu nhiên
        $otp = sprintf("%06d", mt_rand(1, 999999));

        // 2. Lưu user vào DB (is_verified = 0)
        $db = getConnection();
        // registerUser returns array ['success' => bool, 'message' => string]
        $result = registerUser($db, $fullname, $email, $phone, $password, $otp);

        if ($result['success']) {
            // 3. Khởi tạo PHPMailer gửi mail thật
            require_once __DIR__ . '/../PHPMailer/Exception.php';
            require_once __DIR__ . '/../PHPMailer/PHPMailer.php';
            require_once __DIR__ . '/../PHPMailer/SMTP.php';

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'tan0979876976@gmail.com';
                $mail->Password   = 'cuigwyrdskymibyy';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;
                $mail->CharSet    = 'UTF-8';

                // THÊM ĐOẠN NÀY ĐỂ FIX LỖI XAMPP LOCALHOST
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                $mail->setFrom('tan0979876976@gmail.com', 'Car Booking System');
                $mail->addAddress($email); // Gửi tới email khách đăng ký
                $mail->isHTML(true);
                $mail->Subject = 'Xác thực tài khoản - Car Booking';
                $mail->Body    = "<h2>Chào $fullname,</h2><p>Mã OTP xác thực tài khoản của bạn là: <b style='color:red;font-size:24px;'>$otp</b></p>";

                $mail->send();
                $_SESSION['success_message'] = "Vui lòng kiểm tra Email để lấy mã OTP!";

                // Mail gửi thành công -> Xóa mock OTP nếu có
                unset($_SESSION['mock_email_otp']);
            } catch (Exception $e) {
                // Nếu cấu hình email sai, fallback hiện OTP ra màn hình
                $_SESSION['mock_email_otp'] = "LỖI MAIL: " . $mail->ErrorInfo . " - MÃ TEST LÀ: $otp";
            }

            // 4. BẮT BUỘC CHUYỂN HƯỚNG SANG TRANG NHẬP OTP
            header("Location: index.php?action=verify_otp&email=" . urlencode($email));
            exit;
        } else {
            // Lỗi từ DB (ví dụ Email trùng)
            $_SESSION['register_errors'] = [$result['message']]; // Dùng register_errors để view hiển thị được
            $_SESSION['register_old_data'] = $_POST;
            header("Location: index.php?action=register_form");
            exit;
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $action === 'verify_otp') {
    // Hiển thị form nhập OTP
    $email = $_GET['email'] ?? '';
    require_once __DIR__ . '/../views/pages/verify_otp.php'; // Lưu ý tôi dùng pages để đồng bộ
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'verify_otp_submit') {
    // Xử lý xác thực OTP
    $email = $_POST['email'] ?? '';
    $otp_input = $_POST['otp'] ?? '';

    if (empty($email) || empty($otp_input)) {
        $_SESSION['otp_error'] = "Please enter the OTP sent to your email.";
        header("Location: index.php?action=verify_otp&email=" . urlencode($email));
        exit;
    }

    try {
        $db = getConnection();
        $isVerified = verifyOTP($db, $email, $otp_input);

        if ($isVerified) {
            $_SESSION['login_success'] = "Account verified successfully! You can login now.";
            // Xóa session mock otp
            unset($_SESSION['mock_email_otp']);
            header("Location: index.php?action=login_form");
            exit;
        } else {
            $_SESSION['otp_error'] = "Invalid or expired OTP code.";
            header("Location: index.php?action=verify_otp&email=" . urlencode($email));
            exit;
        }
    } catch (Exception $e) {
        $_SESSION['otp_error'] = "System error: " . $e->getMessage();
        header("Location: index.php?action=verify_otp&email=" . urlencode($email));
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && ($action === 'login_submit' || $action === 'login')) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = "Please enter both Email and Password.";
        header("Location: index.php?action=login_form");
        exit;
    }

    try {
        $db = getConnection();
        $result = loginUser($db, $email, $password);

        if ($result['success']) {
            // Lưu thông tin user vào Session
            $_SESSION['user'] = $result['user'];

            // Xử lý Remember Me (Lưu cookie 30 ngày)
            if ($remember) {
                setcookie('remember_email', $email, time() + (30 * 24 * 60 * 60), "/");
            } else {
                // Xóa cookie nếu không tick
                if (isset($_COOKIE['remember_email'])) {
                    setcookie('remember_email', '', time() - 3600, "/");
                }
            }

            $redirectAfterLogin = $_SESSION['after_login_redirect'] ?? 'index.php?action=browse_cars';
            unset($_SESSION['after_login_redirect']);

            // Chỉ cho phép redirect nội bộ để tránh open redirect
            if (strpos($redirectAfterLogin, 'index.php?') !== 0) {
                $redirectAfterLogin = 'index.php?action=browse_cars';
            }

            header("Location: " . $redirectAfterLogin);
            exit;
        } else {
            $_SESSION['login_error'] = $result['message'];
            header("Location: index.php?action=login_form");
            exit;
        }
    } catch (Exception $e) {
        $_SESSION['login_error'] = 'System error: ' . $e->getMessage();
        header("Location: index.php?action=login_form");
        exit;
    }
} elseif ($action === 'logout') {
    // Xóa toàn bộ Session
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_unset();
        session_destroy();
    }

    // Xóa Cookie "Remember Me" nếu có
    if (isset($_COOKIE['remember_email'])) {
        setcookie('remember_email', '', time() - 3600, "/");
    }

    // Chuyển hướng về trang danh sách xe
    header("Location: index.php?action=browse_cars");
    exit;
}
