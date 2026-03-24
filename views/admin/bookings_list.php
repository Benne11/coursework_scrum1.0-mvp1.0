<?php
// filepath: coursework_scrum1.0/views/admin/bookings_list.php

/** @var array $bookings */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings - Admin Panel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f4f6f9;
            color: #333;
        }

        /* Sidebar Styles */
        .sidebar { width: 250px; background-color: #2c3e50; color: #fff; display: flex; flex-direction: column; flex-shrink: 0; }
        .sidebar-header { padding: 20px; background-color: #1a252f; text-align: center; border-bottom: 2px solid #f48f0c; }
        .sidebar-header h2 { color: #f48f0c; font-size: 22px; margin-bottom: 5px; }
        .sidebar-header span { font-size: 12px; color: #bdc3c7; }
        .sidebar-nav { flex-grow: 1; padding: 20px 0; }
        .sidebar-nav a { display: flex; align-items: center; padding: 15px 25px; color: #bdc3c7; text-decoration: none; transition: 0.3s; border-left: 4px solid transparent; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background-color: #34495e; color: #fff; border-left-color: #f48f0c; }
        .sidebar-nav a i { margin-right: 15px; width: 20px; text-align: center; }
        .sidebar-footer { padding: 20px; }
        .btn-back { display: block; width: 100%; padding: 10px; background-color: #e74c3c; color: #fff; text-align: center; text-decoration: none; border-radius: 5px; font-weight: bold; transition: 0.3s; }
        .btn-back:hover { background-color: #c0392b; }

        /* Main Content */
        .main-content { flex-grow: 1; display: flex; flex-direction: column; overflow-x: hidden; }
        .top-navbar { background: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .top-navbar h1 { font-size: 24px; color: #2c3e50; }
        .admin-profile { display: flex; align-items: center; gap: 15px; }
        .admin-profile span { font-weight: bold; color: #2c3e50; }
        .content-body { padding: 30px; overflow-y: auto; }

        /* Bookings List Specific Styles */
        .messages { margin-bottom: 20px; }
        .success-msg { background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 15px; }
        .error-msg { background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 15px; }

        .table-container { background: #fff; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; vertical-align: middle; }
        th { background-color: #1a252f; color: #fff; font-weight: 500; text-transform: uppercase; font-size: 14px; }
        tr:hover { background-color: #f8f9fa; }
        
        .badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; text-transform: uppercase; display: inline-block; }
        .badge.pending { background-color: #fff3cd; color: #856404; }
        .badge.confirmed { background-color: #d4edda; color: #155724; }
        .badge.completed { background-color: #cce5ff; color: #004085; }
        .badge.cancelled { background-color: #e2e3e5; color: #383d41; }
        
        .customer-info small { color: #777; display: block; }
        .period-info { font-size: 13px; color: #555; }
        .period-info strong { color: #333; }

        .action-btns { display: flex; gap: 5px; flex-wrap: wrap; }
        .btn-confirm { background-color: #28a745; color: #fff; padding: 6px 12px; border: none; border-radius: 4px; font-size: 13px; cursor: pointer; transition: 0.2s; font-weight: bold; }
        .btn-confirm:hover { background-color: #218838; }
        
        .btn-reject { background-color: #dc3545; color: #fff; padding: 6px 12px; border: none; border-radius: 4px; font-size: 13px; cursor: pointer; transition: 0.2s; font-weight: bold; }
        .btn-reject:hover { background-color: #c82333; }

        .btn-complete { background-color: #007bff; color: #fff; padding: 6px 12px; border: none; border-radius: 4px; font-size: 13px; cursor: pointer; transition: 0.2s; font-weight: bold; }
        .btn-complete:hover { background-color: #0069d9; }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; height: auto; }
            .table-container { overflow-x: auto; }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-car-side"></i> Bon Bon Admin</h2>
            <span>Management Panel</span>
        </div>
        
        <div class="sidebar-nav">
            <a href="index.php?action=admin_dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard Overview</a>
            <a href="index.php?action=admin_cars"><i class="fas fa-car"></i> Manage Cars</a>
            <a href="index.php?action=admin_bookings" class="active"><i class="fas fa-calendar-alt"></i> Manage Bookings</a>
            <a href="index.php?action=admin_users"><i class="fas fa-users"></i> Manage Users</a>
        </div>

        <div class="sidebar-footer">
            <a href="index.php?action=home" class="btn-back"><i class="fas fa-store"></i> Back to Store</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-navbar">
            <h1>Manage Bookings</h1>
            <div class="admin-profile">
                <span><i class="fas fa-user-shield"></i> <?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
            </div>
        </div>

        <div class="content-body">
            
            <?php if (empty($bookings)): ?>
                <p style="text-align: center; font-size: 18px; color: #777; margin-top: 20px;">No bookings found in the database.</p>
            <?php else: ?>

            <div class="messages">
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="success-msg"><?= htmlspecialchars($_SESSION['success_message'] ?? '') ?></div>
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="error-msg"><?= htmlspecialchars($_SESSION['error_message'] ?? '') ?></div>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Car Model</th>
                            <th>Period</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <?php if (!is_array($booking)) continue; ?>
                            <tr>
                                <td><strong>#<?= htmlspecialchars($booking['id'] ?? '') ?></strong></td>
                                <td class="customer-info">
                                    <?= htmlspecialchars($booking['fullname'] ?? 'User Deleted') ?>
                                    <small><?= htmlspecialchars($booking['email'] ?? 'User Deleted') ?></small>
                                </td>
                                <td><?= htmlspecialchars($booking['model_name'] ?? 'Car Deleted') ?></td>
                                <td class="period-info">
                                    <strong>Fr:</strong> <?= date('d/m/Y H:i', strtotime($booking['pickup_datetime'] ?? '')) ?><br>
                                    <strong>To:</strong> <?= date('d/m/Y H:i', strtotime($booking['dropoff_datetime'] ?? '')) ?>
                                </td>
                                <td style="font-weight: bold; color: #d32f2f;">
                                    <?= number_format((float)($booking['total_price'] ?? 0), 0, '.', ',') ?> VND
                                </td>
                                <td>
                                    <span class="badge <?= htmlspecialchars($booking['status'] ?? '') ?>">
                                        <?= htmlspecialchars($booking['status'] ?? '') ?>
                                    </span>
                                </td>
                                <td class="action-btns">
                                    <?php if (($booking['status'] ?? '') === 'pending'): ?>
                                        <form method="POST" action="index.php?action=admin_update_booking" style="display:inline-block;" onsubmit="return confirm('Confirm this booking?');">
                                            <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['id'] ?? '') ?>">
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="btn-confirm"><i class="fas fa-check"></i> Confirm</button>
                                        </form>

                                        <form method="POST" action="index.php?action=admin_update_booking" style="display:inline-block;" onsubmit="return confirm('Reject this booking?');">
                                            <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['id'] ?? '') ?>">
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn-reject"><i class="fas fa-times"></i> Reject</button>
                                        </form>
                                    <?php elseif (($booking['status'] ?? '') === 'confirmed'): ?>
                                        <form method="POST" action="index.php?action=admin_update_booking" style="display:inline-block;" onsubmit="return confirm('Mark this booking as completed?');">
                                            <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['id'] ?? '') ?>">
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="btn-complete"><i class="fas fa-flag-checkered"></i> Complete</button>
                                        </form>
                                    <?php else: ?>
                                        <span style="color: #999; font-size: 13px; font-style: italic;">No actions</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <?php endif; ?>

        </div>
    </div>

</body>
</html>