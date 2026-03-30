<?php
// filepath: coursework_scrum1.0/datafunctions/auth_functions.php

require_once __DIR__ . '/../config/database.php';

/**
 * Đăng ký người dùng mới.
 * 
 * @param PDO $db Đối tượng kết nối PDO
 * @param string $fullname Họ và tên
 * @param string $email Địa chỉ email
 * @param string $phone Số điện thoại
 * @param string $password Mật khẩu (chưa mã hóa)
 * @param string $otp_code Mã OTP để xác thực
 * @return array Mảng kết quả gồm trạng thái và thông báo
 */
function registerUser(PDO $db, string $fullname, string $email, string $phone, string $password, string $otp_code): array {
    try {
        // 1. Kiểm tra email hoặc số điện thoại đã tồn tại chưa
        $stmtCheck = $db->prepare("SELECT id FROM users WHERE email = :email OR phone = :phone LIMIT 1");
        $stmtCheck->execute([
            ':email' => $email,
            ':phone' => $phone
        ]);
        
        if ($stmtCheck->fetch()) {
            return [
                'success' => false, 
                'message' => 'Email or Phone number is already in use.'
            ];
        }

        // 2. Nếu chưa tồn tại, tiến hành băm mật khẩu
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // 3. Thực hiện INSERT người dùng mới
        // is_verified = 0 (chưa xác thực), is_active = 0 (chưa kích hoạt)
        // role='customer', membership_tier='new'
        $stmtInsert = $db->prepare("
            INSERT INTO users (fullname, email, phone, password_hash, role, membership_tier, otp_code, is_verified, is_active) 
            VALUES (:fullname, :email, :phone, :password_hash, 'customer', 'new', :otp_code, 0, 0)
        ");
        
        $inserted = $stmtInsert->execute([
            ':fullname'      => $fullname,
            ':email'         => $email,
            ':phone'         => $phone,
            ':password_hash' => $passwordHash,
            ':otp_code'      => $otp_code
        ]);

        if ($inserted) {
            return [
                'success' => true, 
                'message' => 'Registration successful! Please verify your email.'
            ];
        }

        return [
            'success' => false, 
            'message' => 'An error occurred while saving data. Please try again.'
        ];

    } catch (PDOException $e) {
        error_log("registerUser Error: " . $e->getMessage());
        return [
            'success' => false, 
            'message' => 'System error. Please try again later.'
        ];
    }
}

/**
 * Xác thực mã OTP
 *
 * @param PDO $db
 * @param string $email
 * @param string $otp
 * @return bool
 */
function verifyOTP(PDO $db, string $email, string $otp): bool {
    try {
        // Kiểm tra OTP có khớp với email không
        // (Có thể thêm điều kiện thời gian hết hạn nếu muốn, ở đây làm simple MVP)
        $stmt = $db->prepare("SELECT id FROM users WHERE email = :email AND otp_code = :otp AND is_verified = 0 LIMIT 1");
        $stmt->execute([':email' => $email, ':otp' => $otp]);
        
        if ($stmt->fetch()) {
            // Nếu khớp, update is_verified = 1, is_active = 1, xóa otp_code
            $update = $db->prepare("UPDATE users SET is_verified = 1, is_active = 1, otp_code = NULL WHERE email = :email");
            return $update->execute([':email' => $email]);
        }
        
        return false;
    } catch (PDOException $e) {
        error_log("verifyOTP Error: " . $e->getMessage());
        return false;
    }
}

/**
 * Đăng nhập người dùng.
 * 
 * @param PDO $db Đối tượng kết nối PDO
 * @param string $email Địa chỉ email
 * @param string $password Mật khẩu (chưa mã hóa)
 * @return array Mảng kết quả gồm trạng thái, thông báo và dữ liệu user (nếu thành công)
 */
function loginUser(PDO $db, string $email, string $password): array {
    try {
        // 1. Tìm user theo email
        $stmt = $db->prepare("SELECT id, fullname, password_hash, role, membership_tier FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        // 2. Kiểm tra nếu email không tồn tại
        if (!$user) {
            return [
                'success' => false,
                'message' => 'Email does not exist.'
            ];
        }

        // 3. Kiểm tra mật khẩu bằng password_verify
        if (!password_verify($password, $user['password_hash'])) {
            return [
                'success' => false,
                'message' => 'Incorrect password.'
            ];
        }

        // 4. Nếu đúng, trả về thông tin user (loại bỏ password_hash)
        return [
            'success' => true,
            'message' => 'Login successful.',
            'user' => [
                'id'       => $user['id'],
                'fullname' => $user['fullname'],
                'role'     => $user['role'],
                'membership_tier' => $user['membership_tier']
            ]
        ];

    } catch (PDOException $e) {
        error_log("loginUser Error: " . $e->getMessage());
        return [
            'success' => false, 
            'message' => 'System error. Please try again later.'
        ];
    }
}

/**
 * Gửi email xác thực OTP
 * 
 * @param string $email
 * @param string $fullname
 * @param string $otp
 * @return array ['success' => bool, 'message' => string]
 */
function sendVerificationEmail(string $email, string $fullname, string $otp): array {
    // Chỉ cần require một lần, nếu đã có rồi thì bỏ qua
    require_once __DIR__ . '/../PHPMailer/Exception.php';
    require_once __DIR__ . '/../PHPMailer/PHPMailer.php';
    require_once __DIR__ . '/../PHPMailer/SMTP.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'tan0979876976@gmail.com'; 
        $mail->Password   = 'cuigwyrdskymibyy'; 
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        // Fix lỗi SSL Localhost
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->setFrom('tan0979876976@gmail.com', 'Car Booking System');
        $mail->addAddress($email); 
        $mail->isHTML(true);
        $mail->Subject = 'Xác thực tài khoản - Car Booking';
        $mail->Body    = "<h2>Chào $fullname,</h2><p>Mã OTP xác thực tài khoản của bạn là: <b style='color:red;font-size:24px;'>$otp</b></p>";

        $mail->send();
        return ['success' => true, 'message' => 'Email sent successfully'];
    } catch (PHPMailer\PHPMailer\Exception $e) {
        return ['success' => false, 'message' => $mail->ErrorInfo];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

