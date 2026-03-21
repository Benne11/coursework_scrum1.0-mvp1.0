<?php
// filepath: coursework_scrum1.0/views/pages/verify_otp.php
// View để nhập mã OTP xác thực email

$email = $_GET['email'] ?? '';
$error = '';
if (isset($_SESSION['otp_error'])) {
    $error = $_SESSION['otp_error'];
    unset($_SESSION['otp_error']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Email OTP - Born Car</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .otp-container { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 100%; max-width: 400px; text-align: center; }
        .otp-container h2 { margin-bottom: 20px; color: #333; }
        .otp-container p { color: #666; font-size: 14px; margin-bottom: 30px; }
        
        .form-group { margin-bottom: 20px; text-align: left; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        .form-group input { width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; box-sizing: border-box; text-align: center; letter-spacing: 5px; font-weight: bold; }
        
        button { width: 100%; padding: 12px; background-color: #28a745; color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background 0.3s; }
        button:hover { background-color: #218838; }

        .alert-error { background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; }
        .mock-otp { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 15px; border-radius: 6px; margin-bottom: 20px; font-size: 16px; font-weight: bold; text-align: center; }
        
        .back-link { display: block; margin-top: 20px; color: #007bff; text-decoration: none; font-size: 14px; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="otp-container">
    <h2>Verify Your Email</h2>
    <p>We have sent a 6-digit verification code to <strong><?= htmlspecialchars($email) ?></strong>. Please enter the code below to activate your account.</p>

    <!-- HIỂN THỊ MOCK OTP (CHỈ DÀNH CHO LOCALHOST/TESTING) -->
    <?php if (isset($_SESSION['mock_email_otp'])): ?>
        <div class="mock-otp">
            <?= $_SESSION['mock_email_otp'] ?>
        </div>
        <!-- Không unset ngay để user refresh vẫn thấy nếu chưa nhập -->
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?action=verify_otp_submit" method="POST">
        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
        
        <div class="form-group">
            <label for="otp">Enter 6-Digit Code</label>
            <input type="text" id="otp" name="otp" placeholder="000000" maxlength="6" required pattern="[0-9]{6}" title="Please enter exactly 6 digits">
        </div>

        <button type="submit">Verify Account</button>
    </form>

    <a href="index.php?action=login_form" class="back-link">Back to Login</a>
</div>

</body>
</html>
