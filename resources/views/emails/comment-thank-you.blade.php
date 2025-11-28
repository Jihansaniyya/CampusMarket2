<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih Atas Komentar Anda</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica', 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px 20px;
            line-height: 1.6;
            color: #333;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .details {
            background-color: #f9fafb;
            border-left: 4px solid #2563eb;
            padding: 15px;
            margin: 20px 0;
        }
        .details p {
            margin: 8px 0;
        }
        .details strong {
            color: #1e40af;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #666;
        }
        .button {
            display: inline-block;
            background-color: #2563eb;
            color: white;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>✓ Terima Kasih Atas Komentar Anda!</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Halo <strong>{{ $comment->visitor_name }}</strong>,
            </div>

            <p>
                Terima kasih telah meninggalkan komentar dan rating untuk produk 
                <strong>{{ $product->name }}</strong> di CampusMarket.
            </p>

            <!-- Comment Details -->
            <div class="details">
                <p><strong>Rating Anda:</strong> 
                    @for ($i = 0; $i < $comment->rating; $i++)
                        ⭐
                    @endfor
                    {{ $comment->rating }} dari 5 bintang
                </p>
                <p><strong>Komentar:</strong><br>
                    {{ $comment->comment ?? '<em>Tidak ada komentar tambahan</em>' }}
                </p>
                <p><strong>Tanggal:</strong> {{ $comment->created_at->format('d M Y H:i') }}</p>
            </div>

            <p>
                Tim kami akan memeriksa komentar Anda, dan setelah disetujui, 
                komentar Anda akan ditampilkan di halaman produk untuk membantu 
                pembeli lain membuat keputusan yang tepat.
            </p>

            <p>
                Jika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk 
                menghubungi kami melalui email ini.
            </p>

            <div style="text-align: center;">
                <a href="{{ route('home') }}" class="button">Kembali ke CampusMarket</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                <strong>CampusMarket</strong> - Platform Belanja Online Kampus Terpercaya
            </p>
            <p>
                © {{ date('Y') }} CampusMarket. Semua hak dilindungi.
            </p>
        </div>
    </div>
</body>
</html>

