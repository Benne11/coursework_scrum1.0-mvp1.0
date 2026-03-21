<?php
// filepath: coursework_scrum1.0/views/pages/my_bookings.php

/** @var array $bookings */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - Born Car</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: #f4f6f8; 
            margin: 0; 
            color: #333;
        }
        
        /* Navbar */
        .navbar { 
            background-color: #1a1a1a; 
            color: #fff; 
            padding: 15px 40px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
        }
        .navbar .logo strong { font-size: 24px; color: #ffc107; letter-spacing: 1px;}
        .navbar a { color: #fff; text-decoration: none; margin-left: 20px; font-weight: 500;}
        .navbar a:hover { color: #ffc107; }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .page-title {
            font-size: 32px;
            color: #1a1a1a;
            margin-bottom: 20px;
            font-weight: 800;
            border-bottom: 3px solid #ffc107;
            display: inline-block;
            padding-bottom: 10px;
        }

        .messages { margin-bottom: 20px; }
        .msg-success { color: #155724; background-color: #d4edda; padding: 15px; border-radius: 5px; }
        .msg-error { color: #721c24; background-color: #f8d7da; padding: 15px; border-radius: 5px; }

        .booking-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .booking-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            display: flex;
            overflow: hidden;
            transition: transform 0.2s;
        }
        .booking-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .car-image {
            width: 250px;
            background-color: #eaeaea;
            flex-shrink: 0;
        }
        .car-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-right: 1px solid #eee;
        }

        .booking-details {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .booking-header h3 {
            margin: 0 0 5px 0;
            font-size: 22px;
            color: #1a1a1a;
        }
        
        .booking-meta {
            font-size: 13px;
            color: #777;
        }
        .booking-meta strong { color: #444; }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .badge.pending { background-color: #fff3cd; color: #856404; }
        .badge.confirmed { background-color: #d4edda; color: #155724; }
        .badge.cancelled { background-color: #e2e3e5; color: #383d41; }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
            background: #fdfdfd;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #f0f0f0;
        }
        .info-item {
            font-size: 14px;
            color: #555;
        }
        .info-item strong {
            display: block;
            color: #222;
            margin-bottom: 4px;
        }
        
        .price-total {
            font-size: 20px;
            font-weight: 800;
            color: #d32f2f;
        }

        .booking-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            border-top: 1px solid #eee;
            padding-top: 15px;
            margin-top: 10px;
        }

        .btn-cancel {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.2s;
        }
        .btn-cancel:hover { background-color: #c82333; }

        .no-data {
            text-align: center;
            padding: 50px;
            background: #fff;
            border-radius: 10px;
            color: #777;
            font-size: 18px;
        }
        .no-data a {
            display: inline-block;
            margin-top: 15px;
            background: #ffc107;
            color: #1a1a1a;
            padding: 10px 25px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
        }
        .btn-edit {
            background-color: #ffc107; /* Màu vàng thương hiệu */
            color: #1a1a1a;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: bold;
            transition: background 0.2s;
            margin-right: 15px; /* Khoảng cách với nút Cancel */
            display: inline-block;
        }
        .btn-edit:hover {
            background-color: #e0a800;
        }

        @media (max-width: 768px) {
            .booking-card { flex-direction: column; }
            .car-image { width: 100%; height: 200px; }
            .info-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo"><strong>Born Car</strong></div>
    <div class="nav-links">
        <a href="index.php?action=home">Home</a>
        <?php if (isset($_SESSION['user'])): ?>
            <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
                <a href="index.php?action=admin_dashboard" style="color: #ffc107;">Admin Panel</a>
            <?php endif; ?>
            <a href="index.php?action=my_bookings">My Bookings</a>
            <a href="index.php?action=logout">Logout (<?= htmlspecialchars($_SESSION['user']['fullname']) ?>)</a>
        <?php else: ?>
            <a href="index.php?action=login_form">Login</a>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <h1 class="page-title">My Bookings</h1>

    <div class="messages">
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="msg-success"><?= htmlspecialchars($_SESSION['success_message']) ?></div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="msg-error"><?= htmlspecialchars($_SESSION['error_message']) ?></div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
    </div>

    <?php if (empty($bookings)): ?>
        <div class="no-data">
            <p>You haven't made any bookings yet.</p>
            <a href="index.php?action=home">Browse Cars</a>
        </div>
    <?php else: ?>
        <div class="booking-list">
            <?php foreach ($bookings as $booking): ?>
                <div class="booking-card">
                    <div class="car-image">
                        <img src="<?= !empty($booking['image_url']) ? htmlspecialchars($booking['image_url']) : 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=600&q=80' ?>" alt="<?= htmlspecialchars($booking['model_name']) ?>">
                    </div>
                    
                    <div class="booking-details">
                        <div>
                            <div class="booking-header">
                                <div>
                                    <h3><?= htmlspecialchars($booking['model_name']) ?></h3>
                                    <div class="booking-meta">
                                        Booking ID: <strong>#<?= htmlspecialchars($booking['id']) ?></strong> | 
                                        Placed on: <?= date('M d, Y H:i', strtotime($booking['created_at'])) ?>
                                    </div>
                                </div>
                                <span class="badge <?= htmlspecialchars($booking['status']) ?>">
                                    <?= htmlspecialchars($booking['status']) ?>
                                </span>
                            </div>

                            <div class="info-grid">
                                <div class="info-item">
                                    <strong>Pick-up</strong>
                                    <?= date('M d, Y H:i', strtotime($booking['pickup_datetime'])) ?>
                                </div>
                                <div class="info-item">
                                    <strong>Drop-off</strong>
                                    <?= date('M d, Y H:i', strtotime($booking['dropoff_datetime'])) ?>
                                </div>
                                <div class="info-item">
                                    <strong>Service Type</strong>
                                    <?= htmlspecialchars(ucfirst($booking['service_type'])) ?>
                                </div>
                                <div class="info-item">
                                    <strong>Total Price</strong>
                                    <span class="price-total"><?= number_format($booking['total_price'], 0, '.', ',') ?> VND</span>
                                </div>
                            </div>
                        </div>

                        <?php if ($booking['status'] === 'pending' || $booking['status'] === 'confirmed'): ?>
                            <div class="booking-actions">
                                <a href="index.php?action=edit_booking&id=<?= htmlspecialchars($booking['id']) ?>" class="btn-edit" ...>Edit booking</a>
                                <form method="POST" action="index.php?action=cancel_booking" onsubmit="return confirm('Are you sure you want to cancel this booking? This action cannot be undone.');">
                                    <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['id']) ?>">
                                    <button type="submit" class="btn-cancel">Cancel Booking</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>

</body>
</html>
