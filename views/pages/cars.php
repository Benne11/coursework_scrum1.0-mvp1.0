<?php
// filepath: coursework_scrum1.0/views/pages/cars.php

// Dữ liệu lấy từ CarController
/** @var array $carsList */
/** @var string $errorMessage */
/** @var array $activeFilters */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Cars - Born Car</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: #f8f9fa; 
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
        .navbar .logo strong { font-size: 24px; letter-spacing: 1px; color: #f48f0c;}
        .navbar a { 
            color: #fff; 
            text-decoration: none; 
            margin-left: 20px; 
            font-weight: 500;
            transition: color 0.3s;
        }
        .navbar a:hover { color: #f48f0c; }

        /* User Context Fix */
        .nav-links {
            display: flex;
            align-items: center;
        }
        .user-greeting {
            color: white;
            margin-left: 20px;
            font-weight: 500;
        }

        /* Container Layout */
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .page-title { 
            text-align: center; 
            color: #2c3e50; 
            margin-bottom: 30px; 
            font-size: 32px;
            font-weight: 700;
        }

        /* Filter Form Styling */
        .filter-section {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
        }
        .filter-form .form-group {
            flex: 1;
            min-width: 200px;
        }
        .filter-form input[type="text"],
        .filter-form select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 15px;
            box-sizing: border-box;
            outline: none;
            transition: border-color 0.3s;
        }
        .filter-form input[type="text"]:focus,
        .filter-form select:focus {
            border-color: #f48f0c;
        }
        .filter-form button {
            padding: 12px 30px;
            background-color: #1a1a1a;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            text-transform: uppercase;
        }
        .filter-form button:hover {
            background-color: #f48f0c;
            color: #1a1a1a;
        }
        .filter-form .reset-btn {
            background-color: #6c757d;
            text-decoration: none;
            color: white;
            padding: 12px 20px;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .filter-form .reset-btn:hover { background-color: #5a6268; }

        .alert-danger { 
            background-color: #f8d7da; 
            color: #721c24; 
            padding: 15px; 
            border-radius: 6px; 
            border: 1px solid #f5c6cb; 
            margin-bottom: 20px;
            text-align: center;
        }

        /* Modern CSS Grid for Car Cards */
        .car-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }

        /* Car Card Design */
        .car-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            border: 1px solid #eaeaea;
        }

        .car-card:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 12px 25px rgba(0,0,0,0.15); 
        }

        .car-image {
            width: 100%; 
            height: 220px;
            overflow: hidden;
            background-color: #f1f1f1;
        }

        .car-image img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
            transition: transform 0.5s ease;
        }
        
        .car-card:hover .car-image img {
            transform: scale(1.05);
        }

        /* Car Info Section */
        .car-info { padding: 20px; flex-grow: 1; display: flex; flex-direction: column;}
        .car-title { font-size: 22px; font-weight: bold; margin: 0 0 15px; color: #1a1a1a; }
        
        /* Badges for Meta Data */
        .car-meta { 
            display: flex; 
            flex-wrap: wrap; 
            gap: 8px;
            margin-bottom: 20px;
            font-size: 13px;
        }
        .car-meta span { 
            background: #f0f2f5; 
            color: #495057;
            padding: 5px 10px; 
            border-radius: 20px; 
            font-weight: 500;
            border: 1px solid #e9ecef;
        }
        
        /* Adjustments for Responsive Car Meta */
        .car-meta span {
            font-size: 11px;
            padding: 3px 8px;
        }
        
        /* Pricing Info */
        .pricing-box {
            background-color: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #f48f0c;
        }
        .car-price { font-size: 18px; color: #dc3545; font-weight: bold; line-height: 1.4;}
        .car-price-sub { font-size: 14px; color: #6c757d; }
        
        /* Action Button */
        .card-actions {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }
        .btn-book {
            display: block;
            text-align: center;
            background-color: #1a1a1a;
            color: white;
            text-decoration: none;
            padding: 12px 5px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-sizing: border-box;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .btn-view {
            flex: 2; /* Chiếm 2/3 */
        }
        .btn-instant {
            flex: 1; /* Chiếm 1/3 */
            background-color: #f48f0c;
            color: #1a1a1a;
        }
        .btn-book:hover { 
            background-color: #f48f0c; 
            color: #1a1a1a;
        }
        .btn-instant:hover {
            background-color: #1a1a1a;
            color: #f48f0c;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo"><strong>Born Car</strong></div>
    <div class="nav-links">
        <a href="index.php?action=home">Home</a>
        <a href="index.php?action=browse_cars" class="active">Browse Cars</a>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="index.php?action=my_bookings">My Bookings</a>
            <span class="user-greeting">Hi, <?= htmlspecialchars($_SESSION['user']['fullname']) ?></span>
            <a href="index.php?action=logout" style="color: #f48f0c;">Logout</a>
        <?php else: ?>
            <a href="index.php?action=login_form">Login</a>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <h2 class="page-title">Available Cars for Rent</h2>

    <!-- Search & Filter Section -->
    <div class="filter-section">
        <form method="GET" action="index.php" class="filter-form">
            <input type="hidden" name="action" value="browse_cars">
            
            <div class="form-group">
                <input type="text" name="keyword" placeholder="Search car model..." 
                       value="<?= htmlspecialchars($activeFilters['keyword'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <select name="category">
                    <option value="all">All Categories</option>
                    <option value="Sedan" <?= (isset($activeFilters['category']) && $activeFilters['category'] === 'Sedan') ? 'selected' : '' ?>>Sedan</option>
                    <option value="SUV" <?= (isset($activeFilters['category']) && $activeFilters['category'] === 'SUV') ? 'selected' : '' ?>>SUV</option>
                    <option value="Hatchback" <?= (isset($activeFilters['category']) && $activeFilters['category'] === 'Hatchback') ? 'selected' : '' ?>>Hatchback</option>
                </select>
            </div>

            <div class="form-group">
                <select name="transmission">
                    <option value="all">All Transmissions</option>
                    <option value="auto" <?= (isset($activeFilters['transmission']) && $activeFilters['transmission'] === 'auto') ? 'selected' : '' ?>>Auto</option>
                    <option value="manual" <?= (isset($activeFilters['transmission']) && $activeFilters['transmission'] === 'manual') ? 'selected' : '' ?>>Manual</option>
                </select>
            </div>
            <div class="form-group">
                <select name="service">
                    <option value="all">All Services</option>
                    <option value="self-drive" <?= (isset($activeFilters['service']) && $activeFilters['service'] === 'self-drive') ? 'selected' : '' ?>>Self-Drive</option>
                    <option value="with-driver" <?= (isset($activeFilters['service']) && $activeFilters['service'] === 'with-driver') ? 'selected' : '' ?>>With Driver</option>
                </select>
            </div>

            <button type="submit">Search</button>
            <?php if (!empty($activeFilters['keyword']) || !empty($activeFilters['category']) || !empty($activeFilters['transmission'])): ?>
                <a href="index.php?action=browse_cars" class="reset-btn">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <?php if (!empty($errorMessage)): ?>
        <div class="alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>

    <?php if (empty($carsList) && empty($errorMessage)): ?>
        <p style="text-align: center; color: #6c757d; font-size: 18px;">No cars match your search criteria.</p>
    <?php else: ?>
        <div class="car-grid">
            <?php foreach ($carsList as $car): ?>
                <div class="car-card">
                    <div class="car-image">
                        <img 
                            src="<?= !empty($car['image_url']) ? htmlspecialchars($car['image_url']) : 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=600&q=80' ?>" 
                            alt="<?= htmlspecialchars($car['model_name']) ?>"
                            onerror="this.src='https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=600&q=80'"
                        >
                    </div>
                    <div class="car-info">
                        <h3 class="car-title"><?= htmlspecialchars($car['model_name']) ?></h3>
                        
                        <div class="car-meta">
                            <span><?= htmlspecialchars($car['category']) ?></span>
                            <span><?= htmlspecialchars($car['seats']) ?> Seats</span>
                            <span><?= strtoupper(htmlspecialchars($car['transmission'])) ?></span>
                            <span><?= htmlspecialchars($car['fuel_type']) ?></span>
                        </div>
                        
                        <div class="pricing-box">
                            <div class="car-price"><?= number_format($car['price_per_day'], 0) ?> ₫<span class="car-price-sub">/ Day</span></div>
                            <div class="car-price-sub"><?= number_format($car['price_per_hour'], 0) ?> ₫/ Hour</div>
                        </div>
                        
                        <div class="card-actions">
                            <a href="index.php?action=car_detail&id=<?= htmlspecialchars($car['id']) ?>" class="btn-book btn-view">Details</a>
                            <a href="index.php?action=book_form&car_id=<?= htmlspecialchars($car['id']) ?>" class="btn-book btn-instant">Book Now</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>

</body>
</html>
