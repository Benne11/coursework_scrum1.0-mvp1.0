<?php
// filepath: coursework_scrum1.0/views/admin/users_list.php
/** @var array $users */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Panel</title>
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

        /* Actions & Tables */
        .table-container { background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow-x: auto;}
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; color: #2c3e50; font-weight: 600; }
        tr:hover { background-color: #f1f2f6; }

        .btn-sm { padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: bold; display: inline-flex; align-items: center; gap: 5px; cursor: pointer;}
        .btn-edit { background-color: #f1c40f; color: #333; }
        .btn-edit:hover { background-color: #f39c12; }
        .btn-delete { background-color: #e74c3c; color: #fff; }
        .btn-delete:hover { background-color: #c0392b; }

        .badge { padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: bold; color: #fff; }
        .bg-admin { background-color: #e74c3c; }
        .bg-customer { background-color: #3498db; }
        .bg-vip { background-color: #f1c40f; color: #000; }
        .bg-loyal { background-color: #2ecc71; }
        .bg-new { background-color: #95a5a6; }

        .msg-alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .msg-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
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
            <h1><i class="fas fa-users"></i> Manage Users</h1>
            <div class="admin-profile">
                <span style="font-weight: bold; color: #2c3e50;">Welcome, <?= htmlspecialchars($_SESSION['user']['username'] ?? 'Admin') ?></span>
            </div>
        </div>

        <div class="content-body">
            
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="msg-alert msg-success">
                    <?= htmlspecialchars($_SESSION['success_message']); ?>
                    <?php unset($_SESSION['success_message']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="msg-alert msg-error">
                    <?= htmlspecialchars($_SESSION['error_message']); ?>
                    <?php unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Tier</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 20px;">No users found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td>#<?= htmlspecialchars($user['id'] ?? '') ?></td>
                                    <td><strong><?= htmlspecialchars($user['username'] ?? '') ?></strong></td>
                                    <td><?= htmlspecialchars($user['fullname'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($user['email'] ?? '') ?></td>
                                    <td>
                                        <span class="badge <?= ($user['role'] ?? '') === 'admin' ? 'bg-admin' : 'bg-customer' ?>">
                                            <?= ucfirst($user['role'] ?? '') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php 
                                            $tClass = 'bg-new';
                                            if(($user['membership_tier'] ?? '') == 'loyal') $tClass = 'bg-loyal';
                                            if(($user['membership_tier'] ?? '') == 'vip') $tClass = 'bg-vip';
                                        ?>
                                        <span class="badge <?= $tClass ?>">
                                            <?= ucfirst($user['membership_tier'] ?? '') ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($user['created_at'] ?? 'now')) ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;">
                                        <!-- Nút Edit (Link GET) -->
                                        <a href="index.php?action=admin_edit_user&id=<?= $user['id'] ?>" style="background:#ffc107; color:#000; padding:5px 10px; text-decoration:none; border-radius:5px; margin-right:5px;">Edit</a>
                                        
                                        <?php if(($user['id'] ?? '') !== $_SESSION['user']['id']): ?>
                                        <!-- Nút Delete (Form POST) -->
                                        <form method="POST" action="index.php?action=admin_delete_user" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                            <button type="submit" style="background:#f44336; color:#fff; padding:5px 10px; border:none; border-radius:5px; cursor:pointer;">Delete</button>
                                        </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
