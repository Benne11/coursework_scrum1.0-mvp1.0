<?php
// filepath: views/layouts/footer.php
?>
<style>
    /* Footer CSS */
    .site-footer {
        background-color: #f8f9fa;
        color: #333;
        padding: 60px 20px 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        border-top: 1px solid #eaeaea;
        margin-top: 50px;
    }
    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 40px;
    }
    .footer-col h4 {
        font-size: 18px;
        color: #1a1a1a;
        margin-bottom: 20px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .footer-col p, .footer-col ul {
        font-size: 14.5px;
        line-height: 1.8;
        color: #555;
    }
    .footer-col p strong { color: #333; font-weight: 600; }
    .footer-col ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .footer-col ul li {
        margin-bottom: 12px;
    }
    .footer-col ul li a {
        text-decoration: none;
        color: #555;
        transition: color 0.3s;
    }
    .footer-col ul li a:hover {
        color: #ffc107;
    }
    .footer-bottom {
        text-align: center;
        padding-top: 30px;
        margin-top: 50px;
        border-top: 1px solid #e9ecef;
        font-size: 14px;
        color: #888;
    }
    .bct-logo {
        max-width: 140px;
        margin-top: 15px;
        display: block;
        border-radius: 4px;
    }
    .hotline {
        font-size: 22px;
        color: #dc3545;
        font-weight: bold;
        margin-top: 5px;
        display: block;
    }
</style>

<footer class="site-footer">
    <div class="footer-container">
        <!-- Column 1 -->
        <div class="footer-col">
            <h4 style="color: #ffc107; font-size: 22px; letter-spacing: 1px;">Born Car</h4>
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
                <li><a href="#">📘 Facebook</a></li>
                <li><a href="#">💼 LinkedIn</a></li>
                <li><a href="#">🎵 TikTok</a></li>
                <li><a href="#">📸 Instagram</a></li>
            </ul>
            <div style="margin-top: 30px;">
                <span style="font-size:14px; color:#555; text-transform: uppercase; font-weight: bold;">24/7 Hotline:</span>
                <span class="hotline">1900 8888</span>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        &copy; <?= date('Y') ?> Bon Bon Car. All rights reserved. Built with ❤️ for your journey.
    </div>
</footer>