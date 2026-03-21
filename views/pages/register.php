<?php
// filepath: coursework_scrum1.0/views/pages/register.php

// Giả sử index.php đã có session_start() và require layout. Đây là nội dung chính của phần thân.
$errors = $_SESSION['register_errors'] ?? [];
$successMessage = $_SESSION['register_success'] ?? '';
$oldData = $_SESSION['register_old_data'] ?? [];

// Clear session sau khi lấy
unset($_SESSION['register_errors']);
unset($_SESSION['register_success']);
unset($_SESSION['register_old_data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Account</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .register-container { background: #fff; padding: 20px 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .register-container h2 { text-align: center; margin-bottom: 20px; color: #333; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; color: #666; font-weight: bold;}
        .form-group input[type="text"], .form-group input[type="email"], .form-group input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .form-group.checkbox { display: flex; align-items: center; }
        .form-group.checkbox input { margin-right: 10px; }
        
        .password-container { position: relative; display: flex; align-items: center; }
        .password-container input { padding-right: 40px; }
        .toggle-password { position: absolute; right: 10px; cursor: pointer; user-select: none; font-size: 18px; color: #666; }

        .btn-submit { width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold;}
        .btn-submit:hover { background-color: #218838; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 4px; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error-list { margin: 0; padding-left: 20px; }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Register Account</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="error-list">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($successMessage) ?>
        </div>
    <?php endif; ?>

    <form action="index.php?action=register_submit" method="POST" autocomplete="off">
        <div class="form-group">
            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname" value="<?= htmlspecialchars($oldData['fullname'] ?? '') ?>" required placeholder="Enter your full name" autocomplete="off">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($oldData['email'] ?? '') ?>" required placeholder="Enter your email" autocomplete="off">
        </div>

        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($oldData['phone'] ?? '') ?>" required placeholder="Enter your phone number" autocomplete="view-transition">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <div class="password-container">
                <input type="password" id="password" name="password" required placeholder="Enter your password" autocomplete="new-password">
                <span class="toggle-password" onclick="togglePasswordVisibility('password', this)">👁️</span>
            </div>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <div class="password-container">
                <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirm your password" autocomplete="new-password">
                <span class="toggle-password" onclick="togglePasswordVisibility('confirm_password', this)">👁️</span>
            </div>
        </div>

        <div class="form-group checkbox">
            <input type="checkbox" id="terms" name="terms" required>
            <label for="terms" style="margin: 0;">I agree to the <a href="#">Terms and Conditions</a>.</label>
        </div>

        <button type="submit" class="btn-submit">Register</button>    
    </form>
</div>

<script>
function togglePasswordVisibility(inputId, iconElement) {
    const pwdInput = document.getElementById(inputId);
    if (pwdInput.type === "password") {
        pwdInput.type = "text";
        iconElement.innerText = "🫣";
    } else {
        pwdInput.type = "password";
        iconElement.innerText = "👁️";
    }
}
</script>
</body>
</html>
