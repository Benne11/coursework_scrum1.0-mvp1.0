<?php
// filepath: coursework_scrum1.0/views/admin/dashboard.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bon Bon Car</title>
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
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #fff;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .sidebar-header {
            padding: 20px;
            background-color: #1a252f;
            text-align: center;
            border-bottom: 2px solid #ffc107;
        }

        .sidebar-header h2 {
            color: #ffc107;
            font-size: 22px;
            margin-bottom: 5px;
        }

        .sidebar-header span {
            font-size: 12px;
            color: #bdc3c7;
        }

        .sidebar-nav {
            flex-grow: 1;
            padding: 20px 0;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: #bdc3c7;
            text-decoration: none;
            transition: 0.3s;
            border-left: 4px solid transparent;
        }

        .sidebar-nav a:hover, .sidebar-nav a.active {
            background-color: #34495e;
            color: #fff;
            border-left-color: #ffc107;
        }

        .sidebar-nav a i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 20px;
        }

        .btn-back {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #e74c3c;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-back:hover {
            background-color: #c0392b;
        }

        /* Main Content Styles */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        .top-navbar {
            background: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .top-navbar h1 {
            font-size: 24px;
            color: #2c3e50;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .admin-profile span {
            font-weight: bold;
            color: #2c3e50;
        }

        .content-body {
            padding: 30px;
            overflow-y: auto;
        }

        /* Dashboard Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-info h3 {
            font-size: 14px;
            color: #7f8c8d;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .stat-info h2 {
            font-size: 28px;
            color: #2c3e50;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            color: #fff;
        }

        .icon-blue { background: #3498db; }
        .icon-green { background: #2ecc71; }
        .icon-orange { background: #f39c12; }
        .icon-purple { background: #9b59b6; }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; height: auto; }
            .stats-grid { grid-template-columns: 1fr; }
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
            <a href="index.php?action=admin_dashboard" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard Overview</a>
            <a href="index.php?action=admin_cars"><i class="fas fa-car"></i> Manage Cars</a>
            <a href="index.php?action=admin_bookings"><i class="fas fa-calendar-alt"></i> Manage Bookings</a>
            <a href="index.php?action=admin_users"><i class="fas fa-users"></i> Manage Users</a>
        </div>

        <div class="sidebar-footer">
            <a href="index.php?action=home" class="btn-back"><i class="fas fa-store"></i> Back to Store</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-navbar">
            <h1>Dashboard Overview</h1>
            <div class="admin-profile">
                <span><i class="fas fa-user-shield"></i> <?= htmlspecialchars($_SESSION['user']['fullname']) ?> (Admin)</span>
            </div>
        </div>

        <div class="content-body">
            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Total Cars</h3>
                        <h2><?= number_format($total_cars) ?></h2>
                    </div>
                    <div class="stat-icon icon-blue"><i class="fas fa-car"></i></div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Total Bookings</h3>
                        <h2><?= number_format($total_bookings) ?></h2>
                    </div>
                    <div class="stat-icon icon-green"><i class="fas fa-calendar-check"></i></div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Total Revenue</h3>
                        <h2><?= number_format($revenue, 0, '.', ',') ?> <small>VND</small></h2>
                    </div>
                    <div class="stat-icon icon-orange"><i class="fas fa-money-bill-wave"></i></div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Total Users</h3>
                        <h2><?= number_format($total_users) ?></h2>
                    </div>
                    <div class="stat-icon icon-purple"><i class="fas fa-users"></i></div>
                </div>
            </div>
            
            <div style="background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <h3 style="color: #2c3e50; margin-bottom: 15px;">Welcome to Admin Panel</h3>
                <p style="color: #7f8c8d; line-height: 1.6;">This is the control center for Bon Bon Car Platform. From here, you can manage the entire system workflow, monitor revenues, update vehicle stock, and resolve user bookings.</p>
            </div>
        </div>
    </div>

</body>
</html>
