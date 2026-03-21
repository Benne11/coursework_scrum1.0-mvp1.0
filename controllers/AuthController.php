<?php
// filepath: coursework_scrum1.0/controllers/AuthController.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../datafunctions/auth_functions.php';

// Xử lý POST request cho action 'register_submit'
$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'register_submit') {
    // 1. Nhận dữ liệu và sanitize cơ bản
    $fullname = trim($_POST['fullname'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $terms    = isset($_POST['terms']);

    $errors = [];

    // 2. Validation
    if (empty($fullname)) {
        $errors[] = "Full name is required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }

    // Validate phone (chỉ chứa chữ số, độ dài 10-11)
    if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
        $errors[] = "Phone number must be 10-11 digits.";
    }

    // Validate password: Phải có ít nhất 8 ký tự, 1 chữ hoa, 1 chữ thường, 1 số, 1 ký tự đặc biệt
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
        $errors[] = "Password must be at least 8 characters long, including uppercase, lowercase, numbers, and special characters.";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Confirm password does not match.";
    }

    if (!$terms) {
        $errors[] = "You must agree to the Terms and Conditions.";
    }

    // 3. Nếu có lỗi, lưu vào session và redirect (hoặc trả về JSON nếu là API)
    if (!empty($errors)) {
        $_SESSION['register_errors'] = $errors;
        // Lưu lại data để fill lại form (ngoại trừ password)
        $_SESSION['register_old_data'] = [
            'fullname' => $fullname,
            'email'    => $email,
            'phone'    => $phone
        ];
        header("Location: index.php?action=register_form");
        exit;
    }

    // 4. Nếu Validation pass, gọi DataFunction để xử lý
    try {
        $db = getConnection();
        $result = registerUser($db, $fullname, $email, $phone, $password);

        if ($result['success']) {
            $_SESSION['register_success'] = $result['message'];
            // Có thể redirect sang trang login (tạm thời chưa có thì về trang chủ hoặc login)
            header("Location: index.php?action=login_form");
            exit;
        } else {
            $_SESSION['register_errors'] = [$result['message']];
            header("Location: index.php?action=register_form");
            exit;
        }
    } catch (Exception $e) {
        $_SESSION['register_errors'] = ['System error: ' . $e->getMessage()];
        header("Location: index.php?action=register_form");
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'login_submit') {
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

            // Chuyển hướng về trang chủ
            header("Location: index.php?action=browse_cars");
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

    // Chuyển hướng về trang chủ hoặc đăng nhập
    header("Location: index.php?action=login_form");
    exit;
}

