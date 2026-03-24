<?php
// filepath: coursework_scrum1.0/views/pages/payment_gateway.php

/** @var array $bookingInfo */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Checkout - Born Car</title>
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
        .navbar .logo strong { font-size: 24px; color: #f48f0c; letter-spacing: 1px;}
        .navbar a { color: #fff; text-decoration: none; margin-left: 20px; font-weight: 500;}
        .navbar a:hover { color: #f48f0c; }

        .payment-container {
            max-width: 700px;
            margin: 50px auto;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .checkout-title {
            text-align: center;
            font-size: 28px;
            color: #1a1a1a;
            margin-top: 0;
            margin-bottom: 30px;
            font-weight: 800;
        }

        .amount-box {
            background-color: #fff9e6;
            border: 2px dashed #f48f0c;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 40px;
        }
        .amount-box label { display: block; color: #555; font-size: 16px; margin-bottom: 10px; text-transform: uppercase; font-weight: bold;}
        .amount-box .price { font-size: 42px; color: #d32f2f; font-weight: 900;}

        /* Radio Card Selection */
        .payment-methods {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 30px;
        }
        .method-card {
            border: 2px solid #eaeaea;
            border-radius: 10px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 15px;
            background-color: #fafafa;
        }
        .method-card:hover {
            border-color: #f48f0c;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(255,193,7,0.15);
        }
        .method-card input[type="radio"] {
            transform: scale(1.5);
            accent-color: #1a1a1a;
        }
        .method-card .icon {
            font-size: 24px;
        }
        .method-card .info strong {
            display: block;
            font-size: 16px;
            color: #1a1a1a;
            margin-bottom: 4px;
        }
        .method-card .info span {
            font-size: 13px;
            color: #777;
        }

        /* Khi radio được check thì style cái label */
        .method-card:has(input[type="radio"]:checked) {
            border-color: #f48f0c;
            background-color: #fff;
            box-shadow: 0 4px 15px rgba(255,193,7,0.2);
        }

        .btn-pay {
            width: 100%;
            background-color: #1a1a1a;
            color: #f48f0c;
            border: none;
            padding: 20px;
            font-size: 18px;
            font-weight: 800;
            border-radius: 8px;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            transition: 0.3s;
        }
        .btn-pay:hover {
            background-color: #f48f0c;
            color: #1a1a1a;
        }

        .secure-badge {
            text-align: center;
            margin-top: 20px;
            color: #28a745;
            font-weight: 600;
            font-size: 14px;
        }
        
        @media (max-width: 600px) {
            .payment-methods { grid-template-columns: 1fr; }
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

<div class="payment-container">
    <h2 class="checkout-title">Select Payment Method</h2>

    <div class="amount-box">
        <label>Total Amount to Pay</label>
        <div class="price"><?= number_format($bookingInfo['total_price'], 0, '.', ',') ?> VND</div>
    </div>

    <!-- Payment Form -->
    <form method="POST" action="index.php?action=process_payment">
        <input type="hidden" name="booking_id" value="<?= htmlspecialchars($bookingInfo['id']) ?>">
        
        <div class="payment-methods">
            <!-- COD -->
            <label class="method-card">
                <input type="radio" name="payment_method" value="cash" checked>
                <div class="icon">💵</div>
                <div class="info">
                    <strong>Cash on Delivery</strong>
                    <span>Pay when you take the car</span>
                </div>
            </label>

            <!-- Bank Transfer -->
            <label class="method-card">
                <input type="radio" name="payment_method" value="bank_transfer">
                <div class="icon">🏦</div>
                <div class="info">
                    <strong>Bank Transfer</strong>
                    <span>Direct via Banking app</span>
                </div>
            </label>

            <!-- Momo -->
            <label class="method-card">
                <input type="radio" name="payment_method" value="momo">
                <div class="icon">📱</div>
                <div class="info">
                    <strong>MoMo Wallet</strong>
                    <span>Scan QR Code to pay</span>
                </div>
            </label>

            <!-- Credit Card -->
            <label class="method-card">
                <input type="radio" name="payment_method" value="credit_card">
                <div class="icon">💳</div>
                <div class="info">
                    <strong>Credit / Debit Card</strong>
                    <span>Visa, Master, JCB</span>
                </div>
            </label>
        </div>

        <button type="submit" class="btn-pay">Confirm & Pay Now 🔒</button>
        <div class="secure-badge">✔ 100% Secure & Encrypted Payment</div>
    </form>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>

</body>
</html>
