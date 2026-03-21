<?php
// filepath: coursework_scrum1.0/views/pages/book_form.php

/** @var array $car */
$errorMessage = '';
if (isset($_SESSION['error_message'])) {
    $errorMessage = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book <?= htmlspecialchars($car['model_name']) ?> | Born Car</title>
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

        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }
        
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

        .booking-wrapper {
            display: flex;
            gap: 40px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            overflow: hidden;
            align-items: stretch;
        }

        /* Left Side: Car Summary */
        .car-summary-col {
            flex: 1;
            background: #f8f9fa;
            padding: 40px;
            border-right: 1px solid #eee;
            display: flex;
            flex-direction: column;
        }
        .car-summary-col h2 { margin-top: 0; color: #1a1a1a; font-size: 24px; }
        .car-summary-col img {
            width: 100%;
            border-radius: 10px;
            object-fit: cover;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .price-box {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            border: 2px solid #ffc107;
            margin-top: auto;
        }
        .price-box .day-rate { font-size: 24px; font-weight: bold; color: #dc3545;}
        .price-box .hour-rate { font-size: 14px; color: #6c757d; margin-top: 5px;}

        /* Right Side: Form */
        .booking-form-col {
            flex: 1.2;
            padding: 40px;
        }
        .booking-form-col h3 { margin-top: 0; margin-bottom: 25px; color: #1a1a1a; font-size: 22px;}
        
        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #495057;
        }
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 16px;
            font-family: inherit;
            box-sizing: border-box;
            background-color: #fdfdfd;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #ffc107;
            outline: none;
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(255,193,7,0.2);
        }
        
        .btn-submit {
            width: 100%;
            padding: 16px;
            background-color: #ffc107;
            color: #1a1a1a;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px;
        }
        .btn-submit:hover {
            background-color: #1a1a1a;
            color: #ffc107;
        }

        .btn-back {
            display: inline-flex;
            text-decoration: none;
            color: #1a1a1a;
            font-weight: 600;
            font-size: 16px;
            padding: 10px 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }
        .btn-back:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transform: translateX(-3px);
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo"><strong>Born Car</strong></div>
    <div class="nav-links">
        <a href="index.php?action=home">Home</a>
        <a href="index.php?action=browse_cars">Browse Cars</a>
        <?php if (isset($_SESSION['user'])): ?>
            <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
                <a href="index.php?action=admin_dashboard" style="color: #ffc107;">Admin Panel</a>
            <?php endif; ?>
            <a href="index.php?action=my_bookings">My Bookings</a>
            <a href="index.php?action=logout">Logout (<?= htmlspecialchars($_SESSION['user']['fullname']) ?>)</a>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <a href="index.php?action=car_detail&id=<?= htmlspecialchars($car['id']) ?>" class="btn-back">&larr; Back to Car Details</a>
    
    <?php if ($errorMessage): ?>
        <div class="alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>

    <div class="booking-wrapper">
        <!-- Left: Summary -->
        <div class="car-summary-col">
            <h2><?= htmlspecialchars($car['model_name']) ?></h2>
            <img 
                src="<?= !empty($car['image_url']) ? htmlspecialchars($car['image_url']) : 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=600&q=80' ?>" 
                alt="<?= htmlspecialchars($car['model_name']) ?>"
                onerror="this.src='https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=600&q=80'"
            >
            <div style="margin-bottom: 20px; font-size: 15px; color: #555;">
                <strong>Category:</strong> <?= htmlspecialchars($car['category']) ?> &bull; 
                <strong>Seats:</strong> <?= htmlspecialchars($car['seats']) ?> &bull; 
                <strong>Trans:</strong> <?= strtoupper(htmlspecialchars($car['transmission'])) ?>
            </div>
            
            <div class="price-box">
                <div class="day-rate"><?= number_format($car['price_per_day'], 0, '.', ',') ?> VND / Day</div>
                <div class="hour-rate"><?= number_format($car['price_per_hour'], 0, '.', ',') ?> VND / Hour</div>
            </div>
        </div>

        <!-- Right: Form -->
        <div class="booking-form-col">
            <h3>Set Your Schedule</h3>
            <form method="POST" action="index.php?action=book_preview">
                <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
                
                <div class="form-group">
                    <label for="pickup_datetime">Pick-up Date & Time</label>
                    <input type="datetime-local" id="pickup_datetime" name="pickup_datetime" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="dropoff_datetime">Drop-off Date & Time</label>
                    <input type="datetime-local" id="dropoff_datetime" name="dropoff_datetime" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="service_type">Service Type</label>
                    <select id="service_type" name="service_type" class="form-control" required>
                        <option value="self-drive">Self-drive (No additional cost)</option>
                        <option value="with-driver">With Driver (+500,000 VND / Day)</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-submit">Calculate Price & Continue</button>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>

</body>
</html>
