<?php
//path: coursework_scrum1.0/views/pages/user_edit_booking.php
$pickup_format = '';
$dropoff_format = '';
if (!empty($booking)) {
    $pickup_format = date('Y-m-d\TH:i', strtotime($booking['pickup_datetime']));
    $dropoff_format = date('Y-m-d\TH:i', strtotime($booking['dropoff_datetime']));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking - LuxeDrive</title>
    <!-- Include Bootstrap or any CSS you need here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; }
        .edit-container { max-width: 800px; margin: 50px auto; background: #fff; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); padding: 30px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    .edit-header { text-align: center; border-bottom: 2px solid #f4f6f9; padding-bottom: 20px; margin-bottom: 30px; }
    .edit-header h2 { color: #2c3e50; font-size: 28px; margin-bottom: 10px; }
    .edit-header p { color: #7f8c8d; font-size: 15px; }

    .car-info-card { display: flex; align-items: center; background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid #f48f0c; }
    .car-info-card img { width: 100px; height: auto; border-radius: 5px; margin-right: 20px; object-fit: cover; }
    .car-info-card h4 { margin: 0 0 5px 0; color: #333; font-size: 18px; }
    .car-info-card span { font-size: 14px; color: #666; }

    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: bold; margin-bottom: 8px; color: #34495e; }
    .form-group input, .form-group select { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px; transition: 0.3s; }
    .form-group input:focus, .form-group select:focus { border-color: #f48f0c; outline: none; box-shadow: 0 0 5px rgba(244, 143, 12, 0.3); }

    .form-row { display: flex; gap: 20px; }
    .form-col { flex: 1; }

    .alert-warning { background-color: #fff3cd; color: #856404; padding: 15px; border-radius: 6px; margin-bottom: 25px; font-size: 14px; border: 1px solid #ffeeba; }

    .btn-submit { background-color: #2ecc71; color: white; border: none; padding: 14px 20px;font-size: 16px; font-weight: bold; border-radius: 6px; width: 100%; cursor: pointer; transition: 0.3s; margin-bottom: 15px; }
    .btn-submit:hover { background-color: #27ae60; }
    .btn-back { display: block; text-align: center; color: #7f8c8d; text-decoration: none; font-size: 15px; }
    .btn-back:hover { color: #34495e; text-decoration: underline; }
    
    .msg-error { background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
</style>
</head>
<body>

<div class="edit-container">
    <div class="edit-header">
        <h2>Modify Your Booking</h2>
        <p>Update your travel dates or service type below.</p>
    </div>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="msg-error">
            <?= htmlspecialchars($_SESSION['error_message'] ?? '') ?>
            <?php unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($booking)): ?>
        <div class="alert-warning">
            <strong><i class="fas fa-exclamation-triangle"></i> Note:</strong> Changing your dates or service type may cause the Total Price to be recalculated based on current rates.
        </div>

        <div class="car-info-card">
            <?php if (!empty($booking['image_url'])): ?>
                <img src="<?= htmlspecialchars($booking['image_url']) ?>" alt="Car Image">
            <?php else: ?>
                 <img src="https://via.placeholder.com/100x60?text=No+Image" alt="No Image">
            <?php endif; ?>
            <div>
                <h4><?= htmlspecialchars($booking['model_name'] ?? 'Selected Car') ?></h4>
                <span>Booking ID: <strong>#<?= htmlspecialchars($booking['id']) ?></strong></span><br>
                <span>Current Total: <strong id="displayPrice"><?= number_format((float)($booking['total_price'] ?? 0), 0, '.', ',') ?></strong> <strong>VND</strong></span>
            </div>
        </div>

        <form action="index.php?action=update_booking" method="POST">
            <!-- Input ẩn chứa ID của Booking để Controller biết mà cập nhật -->
            <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['id']) ?>">

            <div class="form-row">
                <div class="form-col form-group">
                    <label>Pick-up Date & Time</label>
                    <input type="datetime-local" id="pickup_datetime" name="pickup_datetime" value="<?= $pickup_format ?>" required onchange="calculateNewPrice()">
                </div>
                <div class="form-col form-group">
                    <label>Drop-off Date & Time</label>
                    <input type="datetime-local" id="dropoff_datetime" name="dropoff_datetime" value="<?= $dropoff_format ?>" required onchange="calculateNewPrice()">
                </div>
            </div>

            <div class="form-group">
                <label>Service Type</label>
                <select name="service_type" id="service_type" required onchange="calculateNewPrice()">
                    <option value="self-drive" <?= ($booking['service_type'] === 'self-drive') ? 'selected' : '' ?>>Self-Drive</option>
                    <option value="with-driver" <?= ($booking['service_type'] === 'with-driver') ? 'selected' : '' ?>>With Driver</option>
                </select>
            </div>

            <button type="submit" class="btn-submit">Confirm Changes</button>
            <a href="index.php?action=my_bookings" class="btn-back">Cancel and return to My Bookings</a>
        </form>

        <script>
            const pricePerHour = <?= (float)($booking['price_per_hour'] ?? 0) ?>;
            const pricePerDay = <?= (float)($booking['price_per_day'] ?? 0) ?>;
            const driverFeePerDay = 500000;

            function calculateNewPrice() {
                const pickup = document.getElementById('pickup_datetime').value;
                const dropoff = document.getElementById('dropoff_datetime').value;
                const serviceType = document.getElementById('service_type').value;

                if (!pickup || !dropoff) return;

                const pickupTime = new Date(pickup).getTime();
                const dropoffTime = new Date(dropoff).getTime();
                
                const diffMs = dropoffTime - pickupTime;
                if (diffMs <= 0) {
                    document.getElementById('displayPrice').innerText = "0";
                    return;
                }

                const diffHours = Math.ceil(diffMs / (1000 * 60 * 60));
                const diffDays = Math.ceil(diffMs / (1000 * 60 * 60 * 24));

                let carFee = 0;
                let driverFee = 0;

                if (diffHours < 24) {
                    carFee = diffHours * pricePerHour;
                    if (serviceType === 'with-driver') {
                        driverFee = driverFeePerDay;
                    }
                } else {
                    carFee = diffDays * pricePerDay;
                    if (serviceType === 'with-driver') {
                        driverFee = diffDays * driverFeePerDay;
                    }
                }

                const total = carFee + driverFee;
                document.getElementById('displayPrice').innerText = total.toLocaleString('en-US');
            }
        </script>

    <?php else: ?>
        <div class="msg-error">Booking information could not be loaded.</div>
        <a href="index.php?action=my_bookings" class="btn-back">Return to My Bookings</a>
    <?php endif; ?>
</div>
</body>
</html>