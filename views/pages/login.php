<?php
// filepath: coursework_scrum1.0/views/pages/login.php

$error = $_SESSION['login_error'] ?? '';
$successMessage = $_SESSION['register_success'] ?? '';
// Autocomplete email từ cookie nếu có
$rememberedEmail = $_COOKIE['remember_email'] ?? '';

unset($_SESSION['login_error']);
unset($_SESSION['register_success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Account</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background: #fff; padding: 20px 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .login-container h2 { text-align: center; margin-bottom: 20px; color: #333; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; color: #666; font-weight: bold;}
        .form-group input[type="email"], .form-group input[type="password"], .form-group input[type="text"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .form-group.checkbox { display: flex; align-items: center; }
        .form-group.checkbox input { margin-right: 10px; }
        
        .password-container { position: relative; display: flex; align-items: center; }
        .password-container input { padding-right: 40px; } 
        .toggle-password { position: absolute; right: 10px; cursor: pointer; user-select: none; font-size: 18px; color: #666; }
        
        .btn-submit { width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold;}
        .btn-submit:hover { background-color: #0056b3; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 4px; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .links { text-align: center; margin-top: 15px; font-size: 14px;}
        .links a { color: #007bff; text-decoration: none; }
        .links a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>

    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($successMessage) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form action="index.php?action=login_submit" method="POST" autocomplete="off">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($rememberedEmail) ?>" required placeholder="Enter your email" autocomplete="off">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <div class="password-container">
                <input type="password" id="password" name="password" required placeholder="Enter your password" autocomplete="new-password">
                <span class="toggle-password" onclick="togglePasswordVisibility('password', this)">👁️</span>
            </div>
        </div>

        <div class="form-group checkbox">
            <input type="checkbox" id="remember" name="remember" <?= $rememberedEmail ? 'checked' : '' ?>>
            <label for="remember" style="margin: 0;">Remember Me</label>
        </div>

        <button type="submit" class="btn-submit">Login</button>    
    </form>
    
    <div class="links">
        <p>Don't have an account? <a href="index.php?action=register_form">Register now</a></p>
    </div>
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