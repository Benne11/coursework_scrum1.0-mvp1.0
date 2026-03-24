<?php
// filepath: coursework_scrum1.0/views/pages/book_preview.php

if (!isset($_SESSION['pending_booking'])) {
    header("Location: index.php?action=browse_cars");
    exit;
}

$errorMessage = '';
if (isset($_SESSION['error_message'])) {
    $errorMessage = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

$booking = $_SESSION['pending_booking'];
$breakdown = $booking['breakdown'] ?? [
    'car_fee' => 0, 
    'driver_fee' => 0, 
    'subtotal' => 0, 
    'discount_amount' => 0, 
    'final_total' => 0, 
    'voucher_code' => ''
];

$pickupFormatted = date('d M Y - H:i', strtotime($booking['pickup_datetime']));
$dropoffFormatted = date('d M Y - H:i', strtotime($booking['dropoff_datetime']));

$diffHours = ceil((strtotime($booking['dropoff_datetime']) - strtotime($booking['pickup_datetime'])) / 3600);
$diffDays = ceil((strtotime($booking['dropoff_datetime']) - strtotime($booking['pickup_datetime'])) / 86400);

$durationText = ($diffHours < 24) ? "{$diffHours} Hours" : "{$diffDays} Days";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Preview | Born Car</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { background-color: #f4f6f8; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; color: #333;}
        .navbar { background-color: #1a1a1a; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; color: white;}
        .navbar .logo strong { font-size: 24px; color: #f48f0c;}
        .navbar a { color: #fff; text-decoration: none; margin-left: 20px;}
        .navbar a:hover { color: #f48f0c;}

        .preview-container {
            max-width: 800px;
            margin: 50px auto 100px;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .title { text-align: center; color: #1a1a1a; font-size: 32px; margin-top: 0; margin-bottom: 30px; font-weight: 800; border-bottom: 2px dashed #eee; padding-bottom: 15px;}
        
        .car-summary { display: flex; gap: 20px; align-items: center; margin-bottom: 30px; background: #f8f9fa; padding: 20px; border-radius: 8px;}
        .car-summary img { width: 180px; height: 120px; object-fit: cover; border-radius: 8px;}
        .car-summary div { flex: 1; }
        .car-summary h3 { margin: 0 0 10px; font-size: 24px; color: #1a1a1a;}
        .car-summary p { margin: 0; color: #666; font-size: 15px;}

        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        .detail-item { background: #fff; border: 1px solid #e9ecef; padding: 15px; border-radius: 8px; }
        .detail-item label { display: block; font-size: 12px; color: #888; text-transform: uppercase; font-weight: bold; margin-bottom: 5px;}
        .detail-item span { font-size: 16px; font-weight: 600; color: #1a1a1a;}

        /* Price Breakdown CSS */
        .breakdown-box {
            background: #fff;
            border: 1px solid #e9ecef;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .breakdown-row {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
            color: #555;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px dashed #eee;
        }
        .breakdown-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .breakdown-row.discount-row {
            color: #28a745;
            font-weight: 600;
        }
        .breakdown-row.subtotal-row {
            font-weight: bold;
            color: #1a1a1a;
        }

        .total-box {
            background: #fff9e6;
            border: 2px solid #f48f0c;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .total-box label { font-size: 18px; color: #1a1a1a; margin: 0; font-weight: 700; text-transform: uppercase;}
        .total-box .price { font-size: 32px; color: #d32f2f; font-weight: 900;}

        /* Voucher Form CSS */
        .voucher-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .voucher-box input[type="text"] {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 15px;
            outline: none;
            text-transform: uppercase;
        }
        .voucher-box input[type="text"]:focus {
            border-color: #f48f0c;
        }
        .voucher-box button {
            padding: 12px 25px;
            background: #1a1a1a;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }
        .voucher-box button:hover {
            background: #f48f0c;
            color: #1a1a1a;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #f5c6cb;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }

        .action-buttons {
            display: flex;
            gap: 20px;
        }
        .btn-back {
            flex: 1;
            padding: 15px;
            background: #e9ecef;
            color: #1a1a1a;
            text-decoration: none;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
            transition: background 0.3s;
        }
        .btn-back:hover { background: #dde2e6; }
        
        .btn-confirm {
            flex: 2;
            padding: 15px;
            background: #f48f0c;
            color: #1a1a1a;
            border: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
        }
        .btn-confirm:hover { background: #1a1a1a; color: #f48f0c; }

        @media (max-width: 600px) {
            .details-grid { grid-template-columns: 1fr; }
            .car-summary { flex-direction: column; text-align: center;}
            .car-summary img { width: 100%; height: auto;}
            .action-buttons { flex-direction: column; }
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
                <!--<a href="index.php?action=admin_dashboard" style="color: #f48f0c;">Admin Panel</a>-->
            <?php endif; ?>
            <a href="index.php?action=my_bookings">My Bookings</a>
            <a href="index.php?action=logout">Logout (<?= htmlspecialchars($_SESSION['user']['fullname']) ?>)</a>
        <?php endif; ?>
    </div>
</div>

<div class="preview-container">
    <h1 class="title">Booking Preview</h1>

    <?php if ($errorMessage): ?>
        <div class="alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>

    <div class="car-summary">
        <img 
            src="<?= !empty($booking['car_image']) ? htmlspecialchars($booking['car_image']) : 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=600&q=80' ?>" 
            onerror="this.src='https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=600&q=80'"
            alt="<?= htmlspecialchars($booking['car_name']) ?>">
        <div>
            <h3><?= htmlspecialchars($booking['car_name']) ?></h3>
            <p><strong>Rate (Day):</strong> <?= number_format($booking['price_per_day'], 0, '.', ',') ?> VND</p>
            <p><strong>Rate (Hour):</strong> <?= number_format($booking['price_per_hour'], 0, '.', ',') ?> VND</p>
        </div>
    </div>

    <div class="details-grid">
        <div class="detail-item">
            <label>Pick-up Time</label>
            <span><?= $pickupFormatted ?></span>
        </div>
        <div class="detail-item">
            <label>Drop-off Time</label>
            <span><?= $dropoffFormatted ?></span>
        </div>
        <div class="detail-item">
            <label>Rental Duration</label>
            <span><?= $durationText ?></span>
        </div>
        <div class="detail-item">
            <label>Service Type</label>
            <span>
                <?php if ($booking['service_type'] === 'with-driver'): ?>
                    🚗 Chauffeured (With Driver)
                <?php else: ?>
                    🔑 Self-Drive
                <?php endif; ?>
            </span>
        </div>
    </div>

    <!-- Price Breakdown -->
    <div class="breakdown-box">
        <div class="breakdown-row">
            <span>Car Rental Fee</span>
            <span><?= number_format($breakdown['car_fee'], 0, '.', ',') ?> VND</span>
        </div>
        <div class="breakdown-row">
            <span>Driver Fee (If applicable)</span>
            <span><?= number_format($breakdown['driver_fee'], 0, '.', ',') ?> VND</span>
        </div>
        <div class="breakdown-row subtotal-row">
            <span>Subtotal</span>
            <span><?= number_format($breakdown['subtotal'], 0, '.', ',') ?> VND</span>
        </div>
        <?php if ($breakdown['discount_amount'] > 0): ?>
        <div class="breakdown-row discount-row">
            <span>Discount (<?= htmlspecialchars($breakdown['voucher_code']) ?>)</span>
            <span>- <?= number_format($breakdown['discount_amount'], 0, '.', ',') ?> VND</span>
        </div>
        <?php endif; ?>
    </div>

    <div class="total-box">
        <label>Total Payment</label>
        <div class="price"><?= number_format($breakdown['final_total'], 0, '.', ',') ?> VND</div>
    </div>

    <!-- Voucher Form -->
    <form method="POST" action="index.php?action=book_preview" class="voucher-box">
        <!-- Pass hidden fields to maintain booking state during POST -->
        <input type="hidden" name="car_id" value="<?= htmlspecialchars($booking['car_id']) ?>">
        <input type="hidden" name="pickup_datetime" value="<?= htmlspecialchars($booking['pickup_datetime']) ?>">
        <input type="hidden" name="dropoff_datetime" value="<?= htmlspecialchars($booking['dropoff_datetime']) ?>">
        <input type="hidden" name="service_type" value="<?= htmlspecialchars($booking['service_type']) ?>">
        
        <strong style="white-space: nowrap; color: #495057;">Got a Voucher?</strong>
        <select name="voucher_code" style="flex: 1; padding: 12px 15px; border: 1px solid #ced4da; border-radius: 6px; font-size: 15px; outline: none;">
            <option value="">-- Select a Voucher --</option>
            <?php foreach ($available_vouchers ?? [] as $v): ?>
                <option value="<?= htmlspecialchars($v['code']) ?>" <?= ($breakdown['voucher_code'] === $v['code']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($v['code']) ?> - Discount <?= htmlspecialchars($v['discount_percent']) ?>%
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Apply</button>
    </form>

    <div class="action-buttons">
        <a href="index.php?action=book_form&car_id=<?= $booking['car_id'] ?>" class="btn-back">Cancel / Edit Dates</a>
        
        <form method="POST" action="index.php?action=checkout" style="flex: 2; margin: 0; display: flex;">
            <!-- Checkout action will use the final data in $_SESSION['pending_booking'] -->
            <button type="submit" class="btn-confirm">Confirm & Go to Payment</button>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>

</body>
</html>
