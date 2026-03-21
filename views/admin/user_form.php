<?php
// filepath: coursework_scrum1.0/views/admin/user_form.php
/** @var array $user */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Admin Panel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { display: flex; min-height: 100vh; background-color: #f4f6f9; color: #333; }
        
        /* Sidebar */
        .sidebar { width: 250px; background-color: #2c3e50; color: #fff; display: flex; flex-direction: column; flex-shrink: 0; }
        .sidebar-header { padding: 20px; background-color: #1a252f; text-align: center; border-bottom: 2px solid #ffc107; }
        .sidebar-header h2 { color: #ffc107; font-size: 22px; margin-bottom: 5px; }
        .sidebar-header span { font-size: 12px; color: #bdc3c7; }
        .sidebar-nav { flex-grow: 1; padding: 20px 0; }
        .sidebar-nav a { display: flex; align-items: center; padding: 15px 25px; color: #bdc3c7; text-decoration: none; transition: 0.3s; border-left: 4px solid transparent; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background-color: #34495e; color: #fff; border-left-color: #ffc107; }
        .sidebar-nav a i { width: 25px; font-size: 18px; }
        .sidebar-footer { padding: 20px; text-align: center; border-top: 1px solid #34495e; }
        .btn-back { display: inline-block; padding: 10px 20px; background-color: #e74c3c; color: white; text-decoration: none; border-radius: 5px; transition: 0.3s; font-weight: bold; width: 100%; }
        .btn-back:hover { background-color: #c0392b; }

        /* Main Content */
        .main-content { flex-grow: 1; display: flex; flex-direction: column; overflow-x: hidden; }
        .top-navbar { background: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .top-navbar h1 { font-size: 24px; color: #2c3e50; }
        .content-body { padding: 30px; overflow-y: auto; }

        .form-container { background: #fff; border-radius: 10px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto; }
        .form-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 2px solid #f4f6f9; padding-bottom: 15px; }
        .form-header h2 { color: #2c3e50; font-size: 20px; }

        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px; background: #f8f9fa; padding: 20px; border-radius: 8px; }
        .info-col { display: flex; flex-direction: column; gap: 5px; }
        .info-label { font-size: 13px; color: #7f8c8d; text-transform: uppercase; font-weight: bold; }
        .info-val { font-size: 15px; color: #2c3e50; font-weight: 500; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; }
        .form-control { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px; transition: border-color 0.3s; }
        .form-control:focus { outline: none; border-color: #3498db; box-shadow: 0 0 5px rgba(52, 152, 219, 0.2); }

        .btn-submit { background-color: #2ecc71; color: white; padding: 12px 25px; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: 600; transition: background 0.3s; width: 100%; margin-top: 10px; }
        .btn-submit:hover { background-color: #27ae60; }
        .btn-cancel { display: inline-block; background-color: #95a5a6; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; font-size: 14px; font-weight: 600; transition: background 0.3s; }
        .btn-cancel:hover { background-color: #7f8c8d; }

        .msg-alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .msg-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-car-side"></i> Bon Bon Admin</h2>
            <span>Management Panel</span>
        </div>
        <div class="sidebar-nav">
            <a href="index.php?action=admin_dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard Overview</a>
            <a href="index.php?action=admin_cars"><i class="fas fa-car"></i> Manage Cars</a>
            <a href="index.php?action=admin_bookings"><i class="fas fa-calendar-alt"></i> Manage Bookings</a>
            <a href="index.php?action=admin_users" class="active"><i class="fas fa-users"></i> Manage Users</a>
        </div>
        <div class="sidebar-footer">
            <a href="index.php?action=home" class="btn-back"><i class="fas fa-store"></i> Back to Store</a>
        </div>
    </div>

    <div class="main-content">
        <div class="top-navbar">
            <h1><i class="fas fa-user-edit"></i> Edit User Permissions</h1>
            <div class="admin-profile">
                <span style="font-weight: bold; color: #2c3e50;">Welcome, <?= htmlspecialchars($_SESSION['user']['username'] ?? 'Admin') ?></span>
            </div>
        </div>

        <div class="content-body">
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="msg-alert msg-error">
                    <?= htmlspecialchars($_SESSION['error_message']); ?>
                    <?php unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>

            <div class="form-container">
                <div class="form-header">
                    <h2>Edit Role & Membership Tier</h2>
                    <a href="index.php?action=admin_users" class="btn-cancel"><i class="fas fa-arrow-left"></i> Back</a>
                </div>

                <form action="index.php?action=admin_edit_user&id=<?= $user['id'] ?>" method="POST">
                    
                    <div class="info-grid">
                        <div class="info-col">
                            <span class="info-label">Username</span>
                            <span class="info-val"><?= htmlspecialchars($user['username'] ?? '') ?></span>
                        </div>
                        <div class="info-col">
                            <span class="info-label">Full Name</span>
                            <span class="info-val"><?= htmlspecialchars($user['fullname'] ?? '') ?></span>
                        </div>
                        <div class="info-col">
                            <span class="info-label">Email</span>
                            <span class="info-val"><?= htmlspecialchars($user['email'] ?? '') ?></span>
                        </div>
                        <div class="info-col">
                            <span class="info-label">Registered At</span>
                            <span class="info-val"><?= date('d/m/Y H:i', strtotime($user['created_at'] ?? 'now')) ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="role">User Role</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="customer" <?= (($user['role'] ?? '') === 'customer') ? 'selected' : '' ?>>Customer</option>
                            <option value="admin" <?= (($user['role'] ?? '') === 'admin') ? 'selected' : '' ?>>Administrator</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tier">Membership Tier</label>
                        <select name="membership_tier" id="tier" class="form-control" required>
                            <option value="new" <?= (($user['membership_tier'] ?? '') === 'new') ? 'selected' : '' ?>>New</option>
                            <option value="loyal" <?= (($user['membership_tier'] ?? '') === 'loyal') ? 'selected' : '' ?>>Loyal</option>
                            <option value="vip" <?= (($user['membership_tier'] ?? '') === 'vip') ? 'selected' : '' ?>>VIP</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
