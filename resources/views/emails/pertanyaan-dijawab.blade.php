<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jawaban Pertanyaan</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 1.8em;
        }
        .badge {
            display: inline-block;
            padding: 5px 12px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            font-size: 0.9em;
            margin-top: 10px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            color: #667eea;
            font-weight: 600;
            font-size: 1.1em;
            margin-bottom: 10px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 5px;
        }
        .question-box {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
            margin-bottom: 15px;
        }
        .answer-box {
            background: #e8f4f8;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #28a745;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            text-align: center;
            color: #666;
            font-size: 0.9em;
        }
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
        .info-row {
            margin-bottom: 8px;
        }
        .info-label {
            font-weight: 600;
            color: #667eea;
        }
        .image-container {
            margin-top: 15px;
            text-align: center;
        }
        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .image-label {
            display: block;
            font-size: 0.9em;
            color: #666;
            margin-bottom: 10px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pertanyaan Anda Telah Dijawab</h1>
            <div class="badge">{{ $pertanyaan->aplikasi }}</div>
            @if($pertanyaan->nomor_tiket)
                <div style="margin-top: 15px; font-size: 1.1em; background: rgba(255, 255, 255, 0.3); padding: 8px 15px; border-radius: 20px; display: inline-block;">
                    🎫 Nomor Tiket: <strong>{{ $pertanyaan->nomor_tiket }}</strong>
                </div>
            @endif
        </div>

        <div class="section">
            @if($pertanyaan->nomor_tiket)
                <div class="info-row">
                    <span class="info-label">Nomor Tiket:</span> {{ $pertanyaan->nomor_tiket }}
                </div>
            @endif
            <div class="info-row">
                <span class="info-label">Tanggal Pertanyaan:</span> {{ $pertanyaan->created_at->format('d F Y, H:i') }}
            </div>
            <div class="info-row">
                <span class="info-label">Dijawab oleh:</span> {{ $pertanyaan->replied_by ?? 'Admin' }}
            </div>
            <div class="info-row">
                <span class="info-label">Dijawab pada:</span> {{ $pertanyaan->replied_at ? $pertanyaan->replied_at->format('d F Y, H:i') : now()->format('d F Y, H:i') }}
            </div>
        </div>

        <div class="section">
            <div class="section-title">Pertanyaan Anda:</div>
            <div class="question-box">
                {{ $pertanyaan->pertanyaan }}
            </div>
            @if($pertanyaan->gambar)
                <div class="image-container">
                    <span class="image-label">📷 Screenshot yang Anda kirimkan:</span>
                    <img src="{{ asset($pertanyaan->gambar) }}" alt="Screenshot Pertanyaan">
                </div>
            @endif
        </div>

        <div class="section">
            <div class="section-title">Jawaban:</div>
            <div class="answer-box">
                {!! nl2br(e($pertanyaan->jawaban)) !!}
            </div>
            @if($pertanyaan->gambar_jawaban)
                <div class="image-container">
                    <span class="image-label">📷 Screenshot jawaban dari admin:</span>
                    <img src="{{ asset($pertanyaan->gambar_jawaban) }}" alt="Screenshot Jawaban">
                </div>
            @endif
        </div>

        <div class="footer">
            <p>Terima kasih telah menggunakan layanan kami.</p>
            <p>Jika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami kembali melalui saluran yang kami sediakan.</p>
            <p style="margin-top: 15px; font-size: 0.85em; color: #999;">
                Email ini dikirim secara otomatis, mohon tidak membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>
