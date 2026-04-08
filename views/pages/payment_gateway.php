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
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <?php require_once __DIR__ . '/../layouts/header.php'; ?>

    <div class="payment-container">
        <a href="index.php?action=my_bookings" class="btn-back" onclick="if (window.history.length > 1) { event.preventDefault(); window.history.back(); }">&larr; Back</a>
        <h2 class="checkout-title">Select Payment Method</h2>

        <?php if (!empty($_SESSION['error_message'])): ?>
            <div class="msg-error payment-error-box">
                <?= htmlspecialchars((string) $_SESSION['error_message']) ?>
                <?php unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <div class="amount-box">
            <label>Total Amount to Pay</label>
            <div class="price"><?= number_format($bookingInfo['total_price'], 0, '.', ',') ?> đ</div>
        </div>

        <!-- Payment Form -->
        <form method="POST" action="index.php?action=process_payment">
            <input type="hidden" name="booking_id" value="<?= htmlspecialchars($bookingInfo['id']) ?>">
            <input type="hidden" name="payment_token" value="<?= htmlspecialchars($_SESSION['pending_payment_token'] ?? '') ?>">

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
                    <input type="radio" name="payment_method" value="credit_card" id="method_credit_card">
                    <div class="icon">💳</div>
                    <div class="info">
                        <strong>Credit / Debit Card</strong>
                        <span>Visa, Master, JCB</span>
                    </div>
                </label>
            </div>

            <div class="card-form-box card-form-hidden" id="creditCardFields">
                <h3>Secure Card Details</h3>

                <div class="form-group">
                    <label for="cardholder_name">Cardholder Name</label>
                    <input type="text" id="cardholder_name" name="cardholder_name" class="form-control" maxlength="100" autocomplete="cc-name">
                </div>

                <div class="form-group">
                    <label for="card_number">Credit Card Number</label>
                    <input type="text" id="card_number" name="card_number" class="form-control" inputmode="numeric" autocomplete="cc-number" placeholder="1234 5678 9012 3456" maxlength="23">
                </div>

                <div class="payment-card-grid">
                    <div class="form-group">
                        <label for="expiry_date">Expiry Date (MM/YY)</label>
                        <input type="text" id="expiry_date" name="expiry_date" class="form-control" placeholder="MM/YY" inputmode="numeric" autocomplete="cc-exp" maxlength="7">
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input type="password" id="cvv" name="cvv" class="form-control" placeholder="123" inputmode="numeric" autocomplete="cc-csc" maxlength="4">
                    </div>
                </div>

                <p class="payment-card-note">For demo mode: card numbers ending with 0000 simulate insufficient funds.</p>
            </div>

            <button type="submit" class="btn-pay">Confirm & Pay Now 🔒</button>
            <div class="secure-badge">✔ 100% Secure & Encrypted Payment</div>
        </form>
    </div>

    <?php include __DIR__ . '/../layouts/footer.php'; ?>

    <script>
        (function() {
            const paymentMethodInputs = document.querySelectorAll('input[name="payment_method"]');
            const cardBox = document.getElementById('creditCardFields');
            const cardHolder = document.getElementById('cardholder_name');
            const cardNumber = document.getElementById('card_number');
            const expiry = document.getElementById('expiry_date');
            const cvv = document.getElementById('cvv');

            function setCardFieldsRequired(required) {
                [cardHolder, cardNumber, expiry, cvv].forEach(function(input) {
                    if (!input) return;
                    input.required = required;
                });
            }

            function toggleCardBox() {
                const selected = document.querySelector('input[name="payment_method"]:checked');
                const isCard = selected && selected.value === 'credit_card';
                if (!cardBox) return;

                if (isCard) {
                    cardBox.classList.remove('card-form-hidden');
                    setCardFieldsRequired(true);
                } else {
                    cardBox.classList.add('card-form-hidden');
                    setCardFieldsRequired(false);
                }
            }

            paymentMethodInputs.forEach(function(input) {
                input.addEventListener('change', toggleCardBox);
            });

            if (cardNumber) {
                cardNumber.addEventListener('input', function() {
                    const digits = this.value.replace(/\D+/g, '').slice(0, 19);
                    this.value = digits.replace(/(\d{4})(?=\d)/g, '$1 ').trim();
                });
            }

            if (expiry) {
                expiry.addEventListener('input', function() {
                    const digits = this.value.replace(/\D+/g, '').slice(0, 4);
                    if (digits.length >= 3) {
                        this.value = digits.slice(0, 2) + '/' + digits.slice(2);
                    } else {
                        this.value = digits;
                    }
                });
            }

            if (cvv) {
                cvv.addEventListener('input', function() {
                    this.value = this.value.replace(/\D+/g, '').slice(0, 4);
                });
            }

            toggleCardBox();
        })();
    </script>

</body>

</html>