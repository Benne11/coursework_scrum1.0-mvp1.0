<?php
// filepath: views/pages/home.php
$activeFilters = [
    'keyword' => $_GET['keyword'] ?? '',
    'category' => $_GET['category'] ?? '',
    'transmission' => $_GET['transmission'] ?? '',
    'service' => $_GET['service'] ?? ''
];
$availableCars = $availableCars ?? [];
$smallFamilyCars = $smallFamilyCars ?? [];
$premiumCars = $premiumCars ?? [];
$featuredDistricts = $featuredDistricts ?? [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Born Car</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="navbar">
        <div class="logo"><strong>Born Car</strong></div>
        <div class="nav-links">
            <a href="index.php?action=home" class="active">Home</a>
            <a href="index.php?action=browse_cars">Browse Cars</a>
            <?php if (isset($_SESSION['user'])): ?>
                <a href="index.php?action=my_bookings">My Bookings</a>
                <span class="user-greeting">Hi, <?= htmlspecialchars($_SESSION['user']['fullname']) ?></span>
                <a href="index.php?action=logout" class="nav-link-accent">Logout</a>
            <?php else: ?>
                <a href="index.php?action=login_form">Login</a>
            <?php endif; ?>
        </div>
    </div>

    <section class="hero-banner" aria-label="Homepage hero banner">
        <div class="hero-slider" aria-hidden="true">
            <img class="hero-slide-image active" src="images/Screenshot%202026-03-26%20141821.png" alt="Hero slide 1">
            <img class="hero-slide-image" src="images/Screenshot%202026-03-26%20142147.png" alt="Hero slide 2">
            <img class="hero-slide-image" src="images/Screenshot%202026-03-26%20142250.png" alt="Hero slide 3">
            <img class="hero-slide-image" src="images/Screenshot%202026-03-26%20142715.png" alt="Hero slide 4">
            <img class="hero-slide-image" src="images/Screenshot%202026-03-26%20142946.png" alt="Hero slide 5">
        </div>

        <div class="hero-overlay"></div>

        <div class="hero-content-wrapper">
            <div class="hero-search-shell">
                <!-- PASTE SEARCH FORM CODE HERE -->
                <div class="filter-section hero-filter-section">
                    <form method="GET" action="index.php" class="filter-form">
                        <input type="hidden" name="action" value="browse_cars">

                        <div class="form-group">
                            <input type="text" name="keyword" placeholder="Search car model..."
                                value="<?= htmlspecialchars($activeFilters['keyword']) ?>">
                        </div>

                        <div class="form-group">
                            <select name="category">
                                <option value="all">All Categories</option>
                                <option value="Sedan" <?= ($activeFilters['category'] === 'Sedan') ? 'selected' : '' ?>>Sedan</option>
                                <option value="SUV" <?= ($activeFilters['category'] === 'SUV') ? 'selected' : '' ?>>SUV</option>
                                <option value="Hatchback" <?= ($activeFilters['category'] === 'Hatchback') ? 'selected' : '' ?>>Hatchback</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <select name="transmission">
                                <option value="all">All Transmissions</option>
                                <option value="auto" <?= ($activeFilters['transmission'] === 'auto') ? 'selected' : '' ?>>Auto</option>
                                <option value="manual" <?= ($activeFilters['transmission'] === 'manual') ? 'selected' : '' ?>>Manual</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <select name="service">
                                <option value="all">All Services</option>
                                <option value="self-drive" <?= ($activeFilters['service'] === 'self-drive') ? 'selected' : '' ?>>Self-Drive</option>
                                <option value="with-driver" <?= ($activeFilters['service'] === 'with-driver') ? 'selected' : '' ?>>With Driver</option>
                            </select>
                        </div>

                        <button type="submit">Search</button>

                    </form>
                </div>
            </div>


        </div>
    </section>

    <section class="districts-section" aria-label="Featured Districts">
        <div class="container">
            <h2 class="available-cars-title">Featured Locations</h2>
            <p class="available-cars-subtitle">Choose a district to find cars near you.</p>

            <div class="available-cars-slider-wrapper">
                <button type="button" class="available-cars-nav-btn available-cars-nav-btn-left" data-target="districtsTrack" aria-label="Previous districts">&lt;</button>

                <div class="districts-track" id="districtsTrack">
                    <?php
                    $districtImageMap = [
                        'District 1' => 'https://images.unsplash.com/photo-1565967511849-76a60a516170?auto=format&fit=crop&w=1200&q=80',
                        'District 3' => 'https://images.unsplash.com/photo-1583417319070-4a69db38a482?auto=format&fit=crop&w=1200&q=80',
                        'District 4' => 'https://images.unsplash.com/photo-1470004914212-05527e49370b?auto=format&fit=crop&w=1200&q=80',
                        'District 5' => 'https://images.unsplash.com/photo-1528127269322-539801943592?auto=format&fit=crop&w=1200&q=80',
                        'District 6' => 'https://images.unsplash.com/photo-1505764706515-aa95265c5abc?auto=format&fit=crop&w=1200&q=80',
                        'District 7' => 'https://images.unsplash.com/photo-1499092346589-b9b6be3e94b2?auto=format&fit=crop&w=1200&q=80',
                        'District 10' => 'https://images.unsplash.com/photo-1516483638261-f4dbaf036963?auto=format&fit=crop&w=1200&q=80',
                        'District 11' => 'https://images.unsplash.com/photo-1549692520-acc6669e2f0c?auto=format&fit=crop&w=1200&q=80',
                        'Binh Thanh District' => 'https://images.unsplash.com/photo-1508057198894-247b23fe5ade?auto=format&fit=crop&w=1200&q=80',
                        'Go Vap District' => 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=1200&q=80',
                        'Phu Nhuan District' => 'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=1200&q=80',
                        'Tan Binh District' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=1200&q=80',
                        'Tan Phu District' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=1200&q=80',
                        'Binh Tan District' => 'https://images.unsplash.com/photo-1439066615861-d1af74d74000?auto=format&fit=crop&w=1200&q=80'
                    ];
                    $districtFallbackImage = 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?auto=format&fit=crop&w=1200&q=80';
                    ?>
                    <?php foreach ($featuredDistricts as $districtItem): ?>
                        <?php
                        $rawDistrictName = (string) ($districtItem['district'] ?? 'Unknown District');
                        $districtName = htmlspecialchars($rawDistrictName);
                        $districtCars = (int) ($districtItem['car_count'] ?? 0);
                        $districtImage = htmlspecialchars($districtImageMap[$rawDistrictName] ?? $districtFallbackImage);
                        ?>
                        <article class="district-card">
                            <div class="district-card-image-wrap">
                                <img class="district-card-image" src="<?= $districtImage ?>" alt="<?= $districtName ?>" onerror="this.src='https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?auto=format&fit=crop&w=1200&q=80'">
                            </div>
                            <div class="district-card-content">
                                <h3 class="district-card-name"><?= $districtName ?></h3>
                                <div class="district-card-footer">
                                    <p class="district-card-count">📍 <?= htmlspecialchars((string) $districtCars) ?>+ xe</p>
                                    <a class="district-card-btn" href="index.php?action=browse_cars&district=<?= urlencode((string) ($districtItem['district'] ?? '')) ?>">TÌM XE</a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <button type="button" class="available-cars-nav-btn available-cars-nav-btn-right" data-target="districtsTrack" aria-label="Next districts">&gt;</button>
            </div>
        </div>
    </section>

    <section class="available-cars-section" aria-label="Available Cars">
        <div class="container">
            <h2 class="available-cars-title">Available Cars</h2>
            <p class="available-cars-subtitle">Cars ready to book right now.</p>

            <div class="available-cars-slider-wrapper">
                <button type="button" class="available-cars-nav-btn available-cars-nav-btn-left" data-target="availableCarsTrack" aria-label="Previous cars">&lt;</button>

                <div class="available-cars-track" id="availableCarsTrack">
                    <?php foreach ($availableCars as $car): ?>
                        <?php
                        $carImage = !empty($car['image_url'])
                            ? htmlspecialchars($car['image_url'])
                            : 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=800&q=80';
                        ?>
                        <article class="available-car-card">
                            <a class="available-car-link" href="index.php?action=car_detail&id=<?= urlencode((string) ($car['id'] ?? '')) ?>" aria-label="View details for <?= htmlspecialchars($car['model_name'] ?? 'car') ?>">
                                <div class="available-car-image-wrap">
                                    <img class="available-car-image" src="<?= $carImage ?>" alt="<?= htmlspecialchars($car['model_name'] ?? 'Car') ?>">
                                    <span class="available-car-status">Available</span>
                                </div>

                                <div class="available-car-content">
                                    <h3 class="available-car-name"><?= htmlspecialchars($car['model_name'] ?? 'Unknown Car') ?></h3>

                                    <div class="available-car-pricing">
                                        <div class="available-car-price-item">
                                            <span class="available-car-price-label">Hourly Rate</span>
                                            <span class="available-car-price-value"><?= number_format((float) ($car['price_per_hour'] ?? 0), 0, '.', ',') ?>đ</span>
                                        </div>
                                        <div class="available-car-price-item">
                                            <span class="available-car-price-label">Daily Rate</span>
                                            <span class="available-car-price-value"><?= number_format((float) ($car['price_per_day'] ?? 0), 0, '.', ',') ?>đ</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="available-car-meta">
                                    <div class="available-car-meta-item">
                                        <span class="available-car-meta-icon">👥</span>
                                        <span class="available-car-meta-text"><?= htmlspecialchars((string) ($car['seats'] ?? '-')) ?> Seats</span>
                                    </div>
                                    <div class="available-car-meta-item">
                                        <span class="available-car-meta-icon">⚙️</span>
                                        <span class="available-car-meta-text"><?= htmlspecialchars(strtoupper((string) ($car['transmission'] ?? '-'))) ?></span>
                                    </div>
                                    <div class="available-car-meta-item">
                                        <span class="available-car-meta-icon">⛽</span>
                                        <span class="available-car-meta-text"><?= htmlspecialchars(ucfirst((string) ($car['fuel_type'] ?? '-'))) ?></span>
                                    </div>
                                </div>
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>

                <button type="button" class="available-cars-nav-btn available-cars-nav-btn-right" data-target="availableCarsTrack" aria-label="Next cars">&gt;</button>
            </div>
        </div>
    </section>

    <section class="available-cars-section" aria-label="Cars For Small Families">
        <div class="container">
            <h2 class="available-cars-title">Cars For Small Families</h2>
            <p class="available-cars-subtitle">Suitable for small families with up to 5 seats.</p>

            <div class="available-cars-slider-wrapper">
                <button type="button" class="available-cars-nav-btn available-cars-nav-btn-left" data-target="smallFamilyCarsTrack" aria-label="Previous small family cars">&lt;</button>

                <div class="available-cars-track" id="smallFamilyCarsTrack">
                    <?php foreach ($smallFamilyCars as $car): ?>
                        <?php
                        $carImage = !empty($car['image_url'])
                            ? htmlspecialchars($car['image_url'])
                            : 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=800&q=80';
                        ?>
                        <article class="available-car-card">
                            <a class="available-car-link" href="index.php?action=car_detail&id=<?= urlencode((string) ($car['id'] ?? '')) ?>" aria-label="View details for <?= htmlspecialchars($car['model_name'] ?? 'car') ?>">
                                <div class="available-car-image-wrap">
                                    <img class="available-car-image" src="<?= $carImage ?>" alt="<?= htmlspecialchars($car['model_name'] ?? 'Car') ?>">
                                    <span class="available-car-status">Family Fit</span>
                                </div>

                                <div class="available-car-content">
                                    <h3 class="available-car-name"><?= htmlspecialchars($car['model_name'] ?? 'Unknown Car') ?></h3>

                                    <div class="available-car-pricing">
                                        <div class="available-car-price-item">
                                            <span class="available-car-price-label">Hourly Rate</span>
                                            <span class="available-car-price-value"><?= number_format((float) ($car['price_per_hour'] ?? 0), 0, '.', ',') ?>đ</span>
                                        </div>
                                        <div class="available-car-price-item">
                                            <span class="available-car-price-label">Daily Rate</span>
                                            <span class="available-car-price-value"><?= number_format((float) ($car['price_per_day'] ?? 0), 0, '.', ',') ?>đ</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="available-car-meta">
                                    <div class="available-car-meta-item">
                                        <span class="available-car-meta-icon">👥</span>
                                        <span class="available-car-meta-text"><?= htmlspecialchars((string) ($car['seats'] ?? '-')) ?> Seats</span>
                                    </div>
                                    <div class="available-car-meta-item">
                                        <span class="available-car-meta-icon">⚙️</span>
                                        <span class="available-car-meta-text"><?= htmlspecialchars(strtoupper((string) ($car['transmission'] ?? '-'))) ?></span>
                                    </div>
                                    <div class="available-car-meta-item">
                                        <span class="available-car-meta-icon">⛽</span>
                                        <span class="available-car-meta-text"><?= htmlspecialchars(ucfirst((string) ($car['fuel_type'] ?? '-'))) ?></span>
                                    </div>
                                </div>
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>

                <button type="button" class="available-cars-nav-btn available-cars-nav-btn-right" data-target="smallFamilyCarsTrack" aria-label="Next small family cars">&gt;</button>
            </div>
        </div>
    </section>

    <section class="available-cars-section" aria-label="Premium Cars">
        <div class="container">
            <h2 class="available-cars-title">Premium Cars</h2>
            <p class="available-cars-subtitle">Daily rental price is above 1,000,000đ.</p>

            <div class="available-cars-slider-wrapper">
                <button type="button" class="available-cars-nav-btn available-cars-nav-btn-left" data-target="premiumCarsTrack" aria-label="Previous premium cars">&lt;</button>

                <div class="available-cars-track" id="premiumCarsTrack">
                    <?php foreach ($premiumCars as $car): ?>
                        <?php
                        $carImage = !empty($car['image_url'])
                            ? htmlspecialchars($car['image_url'])
                            : 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=800&q=80';
                        ?>
                        <article class="available-car-card">
                            <a class="available-car-link" href="index.php?action=car_detail&id=<?= urlencode((string) ($car['id'] ?? '')) ?>" aria-label="View details for <?= htmlspecialchars($car['model_name'] ?? 'car') ?>">
                                <div class="available-car-image-wrap">
                                    <img class="available-car-image" src="<?= $carImage ?>" alt="<?= htmlspecialchars($car['model_name'] ?? 'Car') ?>">
                                    <span class="available-car-status">Premium</span>
                                </div>

                                <div class="available-car-content">
                                    <h3 class="available-car-name"><?= htmlspecialchars($car['model_name'] ?? 'Unknown Car') ?></h3>

                                    <div class="available-car-pricing">
                                        <div class="available-car-price-item">
                                            <span class="available-car-price-label">Hourly Rate</span>
                                            <span class="available-car-price-value"><?= number_format((float) ($car['price_per_hour'] ?? 0), 0, '.', ',') ?>đ</span>
                                        </div>
                                        <div class="available-car-price-item">
                                            <span class="available-car-price-label">Daily Rate</span>
                                            <span class="available-car-price-value"><?= number_format((float) ($car['price_per_day'] ?? 0), 0, '.', ',') ?>đ</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="available-car-meta">
                                    <div class="available-car-meta-item">
                                        <span class="available-car-meta-icon">👥</span>
                                        <span class="available-car-meta-text"><?= htmlspecialchars((string) ($car['seats'] ?? '-')) ?> Seats</span>
                                    </div>
                                    <div class="available-car-meta-item">
                                        <span class="available-car-meta-icon">⚙️</span>
                                        <span class="available-car-meta-text"><?= htmlspecialchars(strtoupper((string) ($car['transmission'] ?? '-'))) ?></span>
                                    </div>
                                    <div class="available-car-meta-item">
                                        <span class="available-car-meta-icon">⛽</span>
                                        <span class="available-car-meta-text"><?= htmlspecialchars(ucfirst((string) ($car['fuel_type'] ?? '-'))) ?></span>
                                    </div>
                                </div>
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>

                <button type="button" class="available-cars-nav-btn available-cars-nav-btn-right" data-target="premiumCarsTrack" aria-label="Next premium cars">&gt;</button>
            </div>
        </div>
    </section>

    <div class="container hero-home-meta">
        <?php if (isset($_SESSION['user'])): ?>
            <?php
            $fullname = htmlspecialchars($_SESSION['user']['fullname']);
            $role = htmlspecialchars($_SESSION['user']['role']);
            $tier = htmlspecialchars($_SESSION['user']['membership_tier'] ?? 'new');
            ?>



        <?php endif; ?>
    </div>

    <?php require_once __DIR__ . '/../layouts/footer.php'; ?>

    <script>
        (function() {
            var slides = document.querySelectorAll('.hero-slide-image');
            if (!slides.length) {
                return;
            }

            var currentIndex = 0;

            setInterval(function() {
                slides[currentIndex].classList.remove('active');
                currentIndex = (currentIndex + 1) % slides.length;
                slides[currentIndex].classList.add('active');
            }, 4000);
        })();

        (function() {
            var navButtons = document.querySelectorAll('.available-cars-nav-btn[data-target]');
            if (!navButtons.length) {
                return;
            }

            function getStep(track) {
                var card = track.querySelector('.available-car-card');
                if (!card) {
                    return 320;
                }
                var cardWidth = card.getBoundingClientRect().width;
                var styles = window.getComputedStyle(track);
                var gap = parseFloat(styles.gap || styles.columnGap || '16') || 16;
                return cardWidth + gap;
            }

            navButtons.forEach(function(btn) {
                var targetId = btn.getAttribute('data-target');
                var track = targetId ? document.getElementById(targetId) : null;
                if (!track) {
                    return;
                }

                var isPrev = btn.classList.contains('available-cars-nav-btn-left');
                btn.addEventListener('click', function() {
                    var step = getStep(track);
                    track.scrollBy({
                        left: isPrev ? -step : step,
                        behavior: 'smooth'
                    });
                });
            });
        })();
    </script>
</body>

</html>