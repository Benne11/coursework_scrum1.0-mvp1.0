<?php
// filepath: views/layouts/footer.php
?>


<footer class="site-footer">
    <div class="footer-container">
        <!-- Column 1 -->
        <div class="footer-col">
            <h4 class="footer-brand-title">Born Car</h4>
            <p>Drive your dreams with our premium car rental service. Comfort, safety, and reliability in every mile.</p>
            <p><strong>Company:</strong> Born Car JSC</p>
            <p><strong>Tax Code:</strong> 0123456789</p>
            <p><strong>Address:</strong> 20 Cong Hoa street, Tan Binh District, Ho Chi Minh City</p>
            <p><strong>Email:</strong> support@bonboncar.com</p>
            <!-- Ảnh Dummy Bộ Công Thương -->
            <img src="https://dummyimage.com/150x45/dc3545/ffffff.png&text=Bo+Cong+Thuong" alt="Da Thong Bao Bo Cong Thuong" class="bct-logo">
        </div>

        <!-- Column 2 -->
        <div class="footer-col">
            <h4>Policies</h4>
            <ul>
                <li><a href="#">Terms & Conditions</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Payment & Refund Policy</a></li>
                <li><a href="#">Insurance Information</a></li>
                <li><a href="#">Dispute Resolution</a></li>
            </ul>
        </div>

        <!-- Column 3 -->
        <div class="footer-col">
            <h4>Service Areas</h4>
            <ul>
                <li><a href="#">Hanoi</a></li>
                <li><a href="#">Da Nang</a></li>
                <li><a href="#">Ho Chi Minh City</a></li>
                <li><a href="#">Hai Phong</a></li>
                <li><a href="#">Can Tho</a></li>
            </ul>
        </div>

        <!-- Column 4 -->
        <div class="footer-col">
            <h4>Connect & Support</h4>
            <ul>
                <li><a href="https://www.facebook.com/GreenwichVietnam">📘 Facebook</a></li>
                <li><a href="#">💼 https://greenwich.edu.vn/</a></li>
                <li><a href="https://www.tiktok.com/@uniofgreenwich">🎵 TikTok</a></li>
                <li><a href="#">📸 Instagram</a></li>
            </ul>
            <div class="footer-hotline-box">
                <span class="footer-hotline-label">24/7 Hotline:</span>
                <span class="hotline">1900 8888</span>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        &copy; <?= date('Y') ?> Bon Bon Car. All rights reserved. Built with ❤️ for your journey.
    </div>
</footer>

<div id="authModal" class="auth-modal-overlay" aria-hidden="true">
    <div class="auth-modal-content" role="dialog" aria-modal="true" aria-labelledby="authModalTitle">
        <button type="button" class="auth-modal-close" id="authCloseBtn" aria-label="Close">&times;</button>

        <?php
        $loginError = $_SESSION['login_error'] ?? '';
        $loginSuccess = $_SESSION['login_success'] ?? '';
        $registerErrors = $_SESSION['register_errors'] ?? [];
        $registerOld = $_SESSION['register_old_data'] ?? [];
        unset($_SESSION['login_error'], $_SESSION['login_success'], $_SESSION['register_errors'], $_SESSION['register_old_data']);
        ?>

        <div id="authLoginPanel" class="auth-panel">
            <h2 id="authModalTitle" class="auth-title">Login</h2>
            <?php if (!empty($loginError)): ?>
                <div class="auth-modal-alert auth-modal-alert-danger"><?= htmlspecialchars($loginError) ?></div>
            <?php endif; ?>
            <?php if (!empty($loginSuccess)): ?>
                <div class="auth-modal-alert auth-modal-alert-success"><?= htmlspecialchars($loginSuccess) ?></div>
            <?php endif; ?>
            <form action="index.php?action=login" method="POST" autocomplete="off">
                <div class="auth-form-group">
                    <label for="modal_login_email">Email <span class="required-star">*</span></label>
                    <input id="modal_login_email" type="email" name="email" class="auth-input" required>
                </div>

                <div class="auth-form-group">
                    <label for="modal_login_password">Password <span class="required-star">*</span></label>
                    <input id="modal_login_password" type="password" name="password" class="auth-input" required>
                </div>

                <div class="auth-remember-wrap">
                    <input id="modal_login_remember" type="checkbox" name="remember" value="1">
                    <label for="modal_login_remember">Remember me</label>
                </div>

                <button type="submit" class="auth-btn auth-btn-primary">Login</button>
            </form>

            <p class="auth-switch-text">
                Don't have an account?
                <button type="button" class="auth-switch-link" data-auth-switch="register">Register now</button>
            </p>
        </div>

        <div id="authRegisterPanel" class="auth-panel auth-hidden">
            <h2 class="auth-title">Register</h2>
            <?php if (!empty($registerErrors)): ?>
                <div class="auth-modal-alert auth-modal-alert-danger"><?php foreach ($registerErrors as $error): ?><?= htmlspecialchars($error) ?><br><?php endforeach; ?></div>
            <?php endif; ?>
            <form action="index.php?action=register_submit" method="POST" autocomplete="off">
                <div class="auth-form-group">
                    <label for="modal_register_fullname">Full name <span class="required-star">*</span></label>
                    <input id="modal_register_fullname" type="text" name="fullname" class="auth-input" value="<?= htmlspecialchars($registerOld['fullname'] ?? '') ?>" required>
                </div>

                <div class="auth-form-group">
                    <label for="modal_register_email">Email <span class="required-star">*</span></label>
                    <input id="modal_register_email" type="email" name="email" class="auth-input" value="<?= htmlspecialchars($registerOld['email'] ?? '') ?>" required>
                </div>

                <div class="auth-form-group">
                    <label for="modal_register_phone">Phone number <span class="required-star">*</span></label>
                    <input id="modal_register_phone" type="text" name="phone" class="auth-input" value="<?= htmlspecialchars($registerOld['phone'] ?? '') ?>" required>
                </div>

                <div class="auth-form-group">
                    <label for="modal_register_password">Password <span class="required-star">*</span></label>
                    <input id="modal_register_password" type="password" name="password" class="auth-input" required>
                </div>

                <button type="submit" class="auth-btn auth-btn-primary">Register</button>
                <button type="button" class="auth-btn auth-btn-cancel" id="authCancelBtn">Cancel</button>
            </form>

            <p class="auth-switch-text">
                Already have an account?
                <button type="button" class="auth-switch-link" data-auth-switch="login">Login</button>
            </p>
        </div>
    </div>
</div>

<script>
    (function() {
        var modal = document.getElementById('authModal');
        var closeBtn = document.getElementById('authCloseBtn');
        var cancelBtn = document.getElementById('authCancelBtn');
        var loginPanel = document.getElementById('authLoginPanel');
        var registerPanel = document.getElementById('authRegisterPanel');

        if (!modal || !loginPanel || !registerPanel) {
            return;
        }

        function openModal(mode) {
            if (mode === 'register') {
                loginPanel.classList.add('auth-hidden');
                registerPanel.classList.remove('auth-hidden');
            } else {
                registerPanel.classList.add('auth-hidden');
                loginPanel.classList.remove('auth-hidden');
            }

            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('auth-modal-lock');
        }

        function closeModal() {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('auth-modal-lock');
        }

        document.addEventListener('click', function(event) {
            var loginTrigger = event.target.closest('a[href*="action=login_form"], [data-auth-open="login"]');
            var registerTrigger = event.target.closest('a[href*="action=register_form"], [data-auth-open="register"]');
            var switchBtn = event.target.closest('[data-auth-switch]');

            if (loginTrigger) {
                event.preventDefault();
                openModal('login');
                return;
            }

            if (registerTrigger) {
                event.preventDefault();
                openModal('register');
                return;
            }

            if (switchBtn) {
                var mode = switchBtn.getAttribute('data-auth-switch');
                openModal(mode === 'register' ? 'register' : 'login');
                return;
            }

            if (event.target === modal) {
                closeModal();
            }
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', closeModal);
        }

        if (cancelBtn) {
            cancelBtn.addEventListener('click', closeModal);
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && modal.classList.contains('is-open')) {
                closeModal();
            }
        });

        var query = new URLSearchParams(window.location.search);
        var queryAuth = query.get('auth');
        var hasLoginError = <?= !empty($loginError) ? 'true' : 'false' ?>;
        var hasLoginSuccess = <?= !empty($loginSuccess) ? 'true' : 'false' ?>;
        var hasRegisterErrors = <?= !empty($registerErrors) ? 'true' : 'false' ?>;

        if (queryAuth === 'register' || hasRegisterErrors) {
            openModal('register');
        } else if (queryAuth === 'login' || hasLoginError || hasLoginSuccess) {
            openModal('login');
        }
    })();
</script>