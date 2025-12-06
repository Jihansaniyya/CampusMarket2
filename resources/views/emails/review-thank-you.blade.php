<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih - CampusMarket</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f3f4f6;
            min-height: 100vh;
            padding: 40px 20px;
            line-height: 1.6;
        }

        .email-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3),
                0 10px 30px rgba(0, 0, 0, 0.25);
        }

        .email-content {
            padding: 30px 50px;
            text-align: center;
        }

        .logo {
            display: inline-block;
            line-height: 0;
            margin-bottom: 0;
        }

        .logo img {
            height: 250px;
            width: auto;
            display: block;
            margin-bottom: -50px;
        }

        .tagline {
            color: #9ca3af;
            font-size: 14px;
            margin-top: 0;
            margin-bottom: 30px;
            font-weight: 500;
            line-height: 1;
        }

        h1 {
            color: #111827;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }

        .greeting {
            color: #6b7280;
            font-size: 16px;
            margin-bottom: 30px;
        }

        .divider {
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
            margin: 30px auto;
            border-radius: 2px;
        }

        .message {
            color: #6b7280;
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        .review-box {
            background: #f9fafb;
            border-radius: 12px;
            border-left: 4px solid #3b82f6;
            padding: 16px 24px;
            margin: 30px 0;
        }

        .review-box-title {
            font-size: 12px;
            color: #3b82f6;
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .product-name {
            font-size: 16px;
            color: #111827;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .rating-stars {
            font-size: 20px;
            color: #f59e0b;
            margin-bottom: 5px;
        }

        .verify-button {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white !important;
            text-decoration: none;
            padding: 18px 50px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.35);
            transition: all 0.3s ease;
            letter-spacing: 0.3px;
        }

        .verify-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.45);
        }

        .expiry-note {
            margin-top: 30px;
            padding: 16px 24px;
            background: #f9fafb;
            border-radius: 12px;
            border-left: 4px solid #3b82f6;
        }

        .email-footer {
            background-color: #1f2937;
            color: #9ca3af;
            padding: 30px;
            text-align: center;
        }

        .footer-logo {
            font-size: 20px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 15px;
        }

        .footer-text {
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .social-links {
            margin: 20px 0;
        }

        .social-link {
            display: inline-block;
            margin: 0 10px;
            color: #60a5fa;
            text-decoration: none;
            font-size: 14px;
        }

        .footer-contact {
            font-size: 13px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #374151;
        }

        .footer-contact a {
            color: #60a5fa;
            text-decoration: none;
        }

        @media only screen and (max-width: 600px) {
            body {
                padding: 20px 15px;
            }

            .email-content {
                padding: 50px 30px;
            }

            h1 {
                font-size: 26px;
            }

            .verify-button {
                padding: 16px 40px;
                font-size: 15px;
            }

            .footer {
                padding: 35px 30px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Main Content -->
        <div class="email-content">
            <!-- Logo -->
            <div class="logo">
                <img src="https://i.ibb.co/bgMrzTCf/logo2.png" alt="CampusMarket Logo">
            </div>
            <p class="tagline">Marketplace untuk Mahasiswa</p>

            <h1>Terima Kasih!</h1>

            <div class="divider"></div>

            <p class="greeting">Halo, <strong>{{ $visitorName }}</strong></p>

            <p class="message">
                Terima kasih telah memberikan review pada produk di CampusMarket. Review Anda sangat membantu pembeli
                lain dalam membuat keputusan yang tepat.
            </p>

            <!-- Review Summary Box -->
            <div class="review-box">
                <div class="review-box-title">Review Anda</div>
                <div class="product-name">{{ $productName }}</div>
                <div class="rating-stars">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $rating)
                            ⭐
                        @else
                            ☆
                        @endif
                    @endfor
                    <span style="font-size: 14px; color: #6b7280; margin-left: 10px;">{{ $rating }}/5</span>
                </div>
            </div>

            <!-- Tombol Belanja Lagi -->
            <a href="{{ url('/') }}" class="verify-button">
                Belanja Lagi
            </a>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <div class="footer-logo">🛒 CampusMarket</div>
            <div class="footer-text">
                Marketplace terpercaya untuk komunitas kampus.<br>
                Jual beli mudah, aman, dan terpercaya.
            </div>

            <div class="social-links">
                <a href="#" class="social-link">Facebook</a> |
                <a href="#" class="social-link">Instagram</a> |
                <a href="#" class="social-link">Twitter</a>
            </div>

            <div class="footer-contact">
                📍 Jl. Pendidikan No. 123, Jakarta Selatan &nbsp;&nbsp;|&nbsp;&nbsp; 📧 <a
                    href="mailto:support@campusmarket.id">support@campusmarket.id</a> &nbsp;&nbsp;|&nbsp;&nbsp; 📞 <a
                    href="tel:+6281234567890">+62 812-3456-7890</a>
            </div>

            <div style="margin-top: 20px; font-size: 12px; color: #6b7280;">
                © {{ date('Y') }} CampusMarket. All rights reserved.<br>
                Email ini dikirim otomatis, mohon tidak membalas email ini.
            </div>
        </div>
    </div>
</body>

</html>
