<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak - Helpdesk Layanan PTPN I</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 60px 40px;
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        .icon {
            font-size: 80px;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 15px;
        }

        .message {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 30px 0;
            text-align: left;
            border-radius: 8px;
        }

        .info-box h3 {
            color: #667eea;
            font-size: 18px;
            margin-bottom: 15px;
        }

        .info-box p {
            color: #555;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .info-box code {
            background: #e9ecef;
            padding: 3px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            color: #d63384;
        }

        .app-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
            margin-top: 15px;
        }

        .app-item {
            background: white;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            font-size: 13px;
            color: #495057;
            font-weight: 500;
        }

        .contact-info {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #e0e0e0;
        }

        .contact-info p {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .contact-info a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            .container {
                padding: 40px 25px;
            }

            h1 {
                font-size: 24px;
            }

            .icon {
                font-size: 60px;
            }

            .app-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="icon">🚫</div>
        <h1>Akses Ditolak</h1>
        <p class="message">
            Silakan masuk melalui salah satu aplikasi PTPN I untuk mengakses layanan helpdesk.
        </p>

        <div class="info-box">
            <h3>Cara Mengakses Helpdesk:</h3>
            <p>Halaman helpdesk hanya dapat diakses melalui aplikasi internal PTPN I dengan menggunakan parameter URL
                yang valid.</p>
            <!-- <p style="margin-top: 15px;"><strong>Contoh URL yang valid:</strong></p>
            <ul style="list-style: none; padding-left: 0; margin-top: 10px;">
                <li style="margin: 8px 0;">• <code>?token=your-app-token</code></li>
            </ul> -->
        </div>

        <div class="contact-info">
            <p>Jika Anda memerlukan bantuan, silakan hubungi administrator sistem atau</p>
            <p>gunakan tombol helpdesk yang tersedia di aplikasi PTPN I yang Anda gunakan.</p>
        </div>
    </div>
</body>

</html>