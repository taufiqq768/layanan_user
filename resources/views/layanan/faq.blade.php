<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - {{ $aplikasiInfo->nama }}</title>
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
            padding: 40px 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .header .app-name {
            font-size: 1.5em;
            opacity: 0.95;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        .back-button {
            display: inline-block;
            background: white;
            color: #667eea;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .faq-container {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .faq-item {
            margin-bottom: 20px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
        }

        .faq-question {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            font-weight: 600;
            font-size: 1.1em;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            user-select: none;
        }

        .faq-question:hover {
            opacity: 0.95;
        }

        .faq-toggle {
            font-size: 1.5em;
            transition: transform 0.3s ease;
        }

        .faq-item.active .faq-toggle {
            transform: rotate(180deg);
        }

        .faq-answer {
            padding: 0 20px;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .faq-item.active .faq-answer {
            padding: 20px;
            max-height: 500px;
        }

        .faq-answer-content {
            color: #333;
            line-height: 1.6;
            font-size: 1em;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state svg {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 1.5em;
            margin-bottom: 10px;
            color: #666;
        }

        .empty-state p {
            font-size: 1em;
        }

        @media (max-width: 640px) {
            .header h1 {
                font-size: 2em;
            }

            .header .app-name {
                font-size: 1.2em;
            }

            .faq-container {
                padding: 25px;
            }

            body {
                padding: 20px 15px;
            }

            .faq-question {
                font-size: 1em;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('layanan.index') }}" class="back-button">← Kembali ke Form</a>

        <div class="header">
            <h1>Frequently Asked Questions</h1>
            <div class="app-name">{{ $aplikasiInfo->nama }}</div>
            <p>Berikut adalah pertanyaan yang sering diajukan</p>
        </div>

        <div class="faq-container">
            @if($faqList->count() > 0)
                @foreach($faqList as $faq)
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>{{ $faq->pertanyaan }}</span>
                            <span class="faq-toggle">▼</span>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-content">
                                {{ $faq->jawaban }}
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3>Belum Ada FAQ</h3>
                    <p>Saat ini belum ada FAQ yang tersedia untuk aplikasi {{ $aplikasiInfo->nama }}.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const faqItems = document.querySelectorAll('.faq-item');

            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');

                question.addEventListener('click', function() {
                    // Toggle active class
                    item.classList.toggle('active');

                    // Close other items (optional - remove if you want multiple items open)
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>