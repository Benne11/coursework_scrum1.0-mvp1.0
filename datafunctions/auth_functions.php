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
 * @return array Mảng kết quả gồm trạng thái và thông báo
 */
function registerUser(PDO $db, string $fullname, string $email, string $phone, string $password): array {
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
        // Mặc định role là 'customer', is_active = 0 (chưa kích hoạt)
        $stmtInsert = $db->prepare("
            INSERT INTO users (fullname, email, phone, password_hash) 
            VALUES (:fullname, :email, :phone, :password_hash)
        ");
        
        $inserted = $stmtInsert->execute([
            ':fullname'      => $fullname,
            ':email'         => $email,
            ':phone'         => $phone,
            ':password_hash' => $passwordHash
        ]);

        if ($inserted) {
            return [
                'success' => true, 
                'message' => 'Registration successful! Please login.'
            ];
        }

        return [
            'success' => false, 
            'message' => 'An error occurred while saving data. Please try again.'
        ];

    } catch (PDOException $e) {
        // Ghi log lỗi hệ thống (không hiển thị ra view)
        error_log("registerUser Error: " . $e->getMessage());
        return [
            'success' => false, 
            'message' => 'System error. Please try again later.'
        ];
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
        $stmt = $db->prepare("SELECT id, fullname, password_hash, role FROM users WHERE email = :email LIMIT 1");
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
                'role'     => $user['role']
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

