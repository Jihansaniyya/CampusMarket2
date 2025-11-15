<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - CampusMarket</title>
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
            max-width: 540px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3),
                0 10px 30px rgba(0, 0, 0, 0.25);
        }

        .email-content {
            padding: 30px 30px;
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
            padding-top: -20;
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
            margin-bottom: 40px;
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

        .footer {
            padding: 40px 50px;
            background: #f9fafb;
            text-align: center;
        }

        .footer-logo {
            color: #3b82f6;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .footer-text {
            color: #9ca3af;
            font-size: 12px;
            line-height: 1.6;
        }

        @media only screen and (max-width: 600px) {
            body {
                padding: 20px 15px;
            }

            .email-content {
                padding: 50px 30px;
            }

            .icon-wrapper {
                width: 70px;
                height: 70px;
                margin-bottom: 25px;
            }

            .icon-wrapper svg {
                width: 35px;
                height: 35px;
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

            <h1>Verifikasi Email</h1>

            <div class="divider"></div>

            <p class="greeting">Halo, <strong>{{ $notifiable->name }}</strong></p>

            <p class="message">
                Terima kasih telah mendaftar sebagai penjual di CampusMarket. Untuk mengaktifkan akun dan memulai
                berjualan, silakan klik tombol di bawah ini untuk verifikasi email Anda.
            </p>

            <!-- Tombol Verifikasi -->
            <a href="{{ $verificationUrl }}" class="verify-button">
                Verifikasi Email Saya
            </a>

            <!-- Expiry Note -->
            <div class="expiry-note">
                <p>
                    <strong>Link ini akan kadaluarsa dalam 60 menit.</strong><br>
                    Jika Anda tidak membuat akun ini, abaikan email ini.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-logo">CampusMarket</div>
            <p class="footer-text">
                &copy; 2025 CampusMarket. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>
