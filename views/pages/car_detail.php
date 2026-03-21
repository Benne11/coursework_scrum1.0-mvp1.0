<?php
// filepath: coursework_scrum1.0/views/pages/car_detail.php

/** @var array $car */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($car['model_name']) ?> - Details | Born Car</title>
    <!-- Use Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: #f4f6f8; 
            margin: 0; 
            padding: 0; 
            color: #333;
        }
        
        /* Navbar Styling */
        .navbar { 
            background-color: #1a1a1a; 
            color: #fff; 
            padding: 15px 40px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .navbar .logo strong { font-size: 24px; color: #ffc107; letter-spacing: 1px;}
        .navbar a { 
            color: #fff; 
            text-decoration: none; 
            margin-left: 20px; 
            font-weight: 500;
            transition: color 0.3s;
        }
        .navbar a:hover { color: #ffc107; }

        /* Container & Back Button */
        .car-detail-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .top-actions {
            margin-bottom: 20px;
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

        /* 2-Column Wrapper */
        .detail-wrapper {
            display: flex;
            gap: 50px;
            align-items: stretch;
        }

        /* Left Side: Image */
        .car-image-col {
            flex: 1.5;
        }
        .car-image-col img {
            width: 100%;
            height: auto;
            aspect-ratio: 16/10;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            display: block;
        }

        /* Right Side: Info Box */
        .car-info-col {
            flex: 1;
            background: #fff;
            padding: 35px 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Essential Services Section */
        .essential-services {
            margin-top: 30px;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        .services-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #1a1a1a;
            border-bottom: 2px solid #ffc107;
            padding-bottom: 8px;
            display: inline-block;
        }
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        .service-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .service-icon {
            background: #fff9e6;
            color: #ffc107;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        .service-text h4 {
            margin: 0 0 4px 0;
            font-size: 15px;
            color: #1a1a1a;
            font-weight: 600;
        }
        .service-text p {
            margin: 0;
            font-size: 13px;
            color: #666;
            line-height: 1.4;
        }

        .car-title {
            font-size: 36px;
            margin: 0;
            color: #1a1a1a;
            font-weight: 800;
            line-height: 1.2;
        }

        .availability-badge {
            align-self: flex-start;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-available { background: #d4edda; color: #155724; }
        .badge-unavailable { background: #f8d7da; color: #721c24; }

        .price-box {
            background: #fcfcfc;
            border-left: 5px solid #ffc107;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #f1f1f1;
            border-left-width: 5px;
        }
        .price-day {
            font-size: 32px;
            color: #e53e3e;
            font-weight: 800;
            margin: 0 0 5px;
        }
        .price-day span {
            font-size: 18px;
            color: #495057;
            font-weight: 600;
        }
        .price-hour {
            font-size: 18px;
            color: #6c757d;
            margin: 0;
            font-weight: 500;
        }

        .car-specs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #eee;
        }
        .spec-item {
            font-size: 16px;
            color: #1a1a1a;
            font-weight: 600;
        }
        .spec-item strong {
            display: block;
            font-size: 13px;
            color: #868e96;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
            font-weight: 700;
        }

        .car-desc {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
            flex-grow: 1; 
        }

        /* Call to Action */
        .btn-book {
            text-align: center;
            background-color: #ffc107;
            color: #1a1a1a;
            font-size: 20px;
            font-weight: 800;
            padding: 18px;
            border-radius: 10px;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
            margin-top: 10px;
            width: 100%;
            box-sizing: border-box;
            display: block;
        }
        .btn-book:hover {
            background-color: #1a1a1a;
            color: #ffc107;
            box-shadow: 0 8px 25px rgba(26, 26, 26, 0.3);
            transform: translateY(-2px);
        }
        .btn-book.disabled {
            background: #e9ecef;
            color: #adb5bd;
            cursor: not-allowed;
            pointer-events: none;
            box-shadow: none;
        }

        @media (max-width: 768px) {
            .detail-wrapper { 
                flex-direction: column; 
                gap: 30px;
            }
            .car-image-col, .car-info-col {
                width: 100%;
                flex: none;
            }
            .car-title {
                font-size: 28px;
            }
            .price-day {
                font-size: 28px;
            }
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
                <!--<a href="index.php?action=admin_dashboard" style="color: #ffc107;">Admin Panel</a>-->
            <?php endif; ?>
            <a href="index.php?action=my_bookings">My Bookings</a>
            <a href="index.php?action=logout">Logout (<?= htmlspecialchars($_SESSION['user']['fullname']) ?>)</a>
        <?php else: ?>
            <a href="index.php?action=login_form">Login</a>
        <?php endif; ?>
    </div>
</div>

<div class="car-detail-container">
    <div class="top-actions">
        <a href="index.php?action=browse_cars" class="btn-back">&larr; Back to Cars</a>
    </div>

    <div class="detail-wrapper">
        <!-- Left Column: Image -->
        <div class="car-image-col">
            <img 
                src="<?= !empty($car['image_url']) ? htmlspecialchars($car['image_url']) : 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=1200&q=80' ?>" 
                alt="<?= htmlspecialchars($car['model_name']) ?>"
                onerror="this.src='https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=1200&q=80'"
            >

            <!-- Additional Service Details -->
            <div class="essential-services">
                <div class="services-title">Our Premium Services</div>
                <div class="services-grid">
                    <div class="service-item">
                        <div class="service-icon"><i class="fas fa-car-side"></i></div>
                        <div class="service-text">
                            <h4>Self-Drive Rental</h4>
                            <p>Experience total freedom and flexibility behind the wheel on your own journey.</p>
                        </div>
                    </div>
                    <div class="service-item">
                        <div class="service-icon"><i class="fas fa-user-tie"></i></div>
                        <div class="service-text">
                            <h4>Chauffeur-Driven Service</h4>
                            <p>Professional, polite drivers committed to your comfort and safety every mile.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Info Box -->
        <div class="car-info-col">
            <h1 class="car-title"><?= htmlspecialchars($car['model_name']) ?></h1>
            
            <?php if ($car['is_available'] == 1): ?>
                <span class="availability-badge badge-available">Available</span>
            <?php else: ?>
                <span class="availability-badge badge-unavailable">Not Available</span>
            <?php endif; ?>

            <div class="price-box">
                <p class="price-day"><?= number_format($car['price_per_day'], 0, '.', ',') ?> VND <span>/ Day</span></p>
                <p class="price-hour"><?= number_format($car['price_per_hour'], 0, '.', ',') ?> VND / Hour</p>
            </div>

            <div class="car-specs">
                <div class="spec-item">
                    <strong>Category</strong>
                    <?= htmlspecialchars($car['category']) ?>
                </div>
                <div class="spec-item">
                    <strong>Seats</strong>
                    <?= htmlspecialchars($car['seats']) ?> Passengers
                </div>
                <div class="spec-item">
                    <strong>Transmission</strong>
                    <?= strtoupper(htmlspecialchars($car['transmission'])) ?>
                </div>
                <div class="spec-item">
                    <strong>Fuel Type</strong>
                    <?= htmlspecialchars($car['fuel_type']) ?>
                </div>
            </div>

            <div class="car-desc">
                <strong>Description:</strong><br>
                <?= !empty($car['description']) ? nl2br(htmlspecialchars($car['description'])) : 'No additional information available for this vehicle. Perfect condition and ready to drive.' ?>
            </div>

            <?php if ($car['is_available'] == 1): ?>
                <a href="index.php?action=book_form&car_id=<?= htmlspecialchars($car['id']) ?>" class="btn-book">Book This Car Now</a>
            <?php else: ?>
                <a href="#" class="btn-book disabled">Currently Unavailable</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>

</body>
</html>
