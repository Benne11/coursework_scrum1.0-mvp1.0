<?php
// filepath: coursework_scrum1.0/views/admin/car_form.php

/** @var array $car */
/** @var string $form_action */
/** @var string $form_title */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($form_title) ?> - Admin Panel</title>
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
        .btn-back-store { display: block; width: 100%; padding: 10px; background-color: #e74c3c; color: #fff; text-align: center; text-decoration: none; border-radius: 5px; font-weight: bold; transition: 0.3s; }
        .btn-back-store:hover { background-color: #c0392b; }

        /* Main Content */
        .main-content { flex-grow: 1; display: flex; flex-direction: column; overflow-x: hidden; }
        .top-navbar { background: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .top-navbar h1 { font-size: 24px; color: #2c3e50; }
        .admin-profile { display: flex; align-items: center; gap: 15px; }
        .content-body { padding: 30px; overflow-y: auto; }

        /* Form Container */
        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            max-width: 800px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }

        .form-group input, .form-group select, .form-group textarea {
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 15px;
            outline: none;
            transition: border-color 0.2s;
        }
        
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: #f48f0c;
        }

        .form-actions {
            margin-top: 30px;
            display: flex;
            gap: 15px;
        }

        .btn-submit {
            padding: 12px 30px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-submit:hover { background-color: #218838; }

        .btn-cancel {
            padding: 12px 30px;
            background-color: #6c757d;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            display: inline-block;
            transition: 0.3s;
        }
        .btn-cancel:hover { background-color: #5a6268; }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; height: auto; }
            .form-row { flex-direction: column; gap: 0; }
            .form-group { margin-bottom: 20px; }
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
            <a href="index.php?action=admin_cars" class="active"><i class="fas fa-car"></i> Manage Cars</a>
            <a href="index.php?action=admin_bookings"><i class="fas fa-calendar-alt"></i> Manage Bookings</a>
            <a href="index.php?action=admin_users"><i class="fas fa-users"></i> Manage Users</a>
        </div>

        <div class="sidebar-footer">
            <a href="index.php?action=home" class="btn-back-store"><i class="fas fa-store"></i> Back to Store</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-navbar">
            <h1><?= htmlspecialchars($form_title) ?></h1>
            <div class="admin-profile">
                <span><i class="fas fa-user-shield"></i> <?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
            </div>
        </div>

        <div class="content-body">
            
            <div class="form-container">
                <form action="<?= htmlspecialchars($form_action) ?>" method="POST">
                    
                    <?php if (!empty($car['id'])): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($car['id']) ?>">
                    <?php endif; ?>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="model_name">Car Model Name *</label>
                            <input type="text" id="model_name" name="model_name" required value="<?= htmlspecialchars($car['model_name'] ?? '') ?>" placeholder="e.g. Toyota Camry 2023">
                        </div>
                        <div class="form-group">
                            <label for="category">Category *</label>
                            <select id="category" name="category" required>
                                <option value="sedan" <?= ($car['category'] ?? '') === 'sedan' ? 'selected' : '' ?>>Sedan</option>
                                <option value="suv" <?= ($car['category'] ?? '') === 'suv' ? 'selected' : '' ?>>SUV</option>
                                <option value="hatchback" <?= ($car['category'] ?? '') === 'hatchback' ? 'selected' : '' ?>>Hatchback</option>
                                <option value="luxury" <?= ($car['category'] ?? '') === 'luxury' ? 'selected' : '' ?>>Luxury</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="seats">Seats</label>
                            <input type="number" id="seats" name="seats" required value="<?= htmlspecialchars($car['seats'] ?? 4) ?>" min="2" max="15">
                        </div>
                        <div class="form-group">
                            <label for="transmission">Transmission</label>
                            <select id="transmission" name="transmission">
                                <option value="automatic" <?= ($car['transmission'] ?? '') === 'automatic' ? 'selected' : '' ?>>Automatic</option>
                                <option value="manual" <?= ($car['transmission'] ?? '') === 'manual' ? 'selected' : '' ?>>Manual</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fuel_type">Fuel Type</label>
                            <select id="fuel_type" name="fuel_type">
                                <option value="petrol" <?= ($car['fuel_type'] ?? '') === 'petrol' ? 'selected' : '' ?>>Petrol</option>
                                <option value="diesel" <?= ($car['fuel_type'] ?? '') === 'diesel' ? 'selected' : '' ?>>Diesel</option>
                                <option value="electric" <?= ($car['fuel_type'] ?? '') === 'electric' ? 'selected' : '' ?>>Electric</option>
                                <option value="hybrid" <?= ($car['fuel_type'] ?? '') === 'hybrid' ? 'selected' : '' ?>>Hybrid</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="price_per_day">Price per Day (VND) *</label>
                            <input type="number" id="price_per_day" name="price_per_day" required value="<?= htmlspecialchars($car['price_per_day'] ?? '') ?>" step="1000" placeholder="1000000">
                        </div>
                        <div class="form-group">
                            <label for="price_per_hour">Price per Hour (VND) *</label>
                            <input type="number" id="price_per_hour" name="price_per_hour" required value="<?= htmlspecialchars($car['price_per_hour'] ?? '') ?>" step="1000" placeholder="100000">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="image_url">Image URL *</label>
                        <input type="text" id="image_url" name="image_url" required value="<?= htmlspecialchars($car['image_url'] ?? '') ?>" placeholder="https://example.com/car.jpg">
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="is_available">Status</label>
                        <select id="is_available" name="is_available">
                            <option value="1" <?= isset($car['is_available']) && $car['is_available'] == 1 ? 'selected' : '' ?>>Available - Active in Store</option>
                            <option value="0" <?= isset($car['is_available']) && $car['is_available'] == 0 ? 'selected' : '' ?>>Maintenance - Hidden</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="4" placeholder="Enter car details..."><?= htmlspecialchars($car['description'] ?? '') ?></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Save Car</button>
                        <a href="index.php?action=admin_cars" class="btn-cancel">Cancel</a>
                    </div>
                </form>
            </div>

        </div>
    </div>

</body>
</html>
