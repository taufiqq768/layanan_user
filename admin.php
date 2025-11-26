<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Daftar Pertanyaan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .stats {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            flex: 1;
            min-width: 200px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .stat-card h3 {
            color: #667eea;
            font-size: 2em;
            margin-bottom: 5px;
        }

        .stat-card p {
            color: #666;
        }

        .questions-container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .question-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .question-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }

        .question-date {
            color: #667eea;
            font-weight: 600;
        }

        .question-ip {
            color: #999;
            font-size: 0.9em;
        }

        .question-content {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .contact-info {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            background: #f0f0f0;
            border-radius: 5px;
        }

        .contact-item strong {
            color: #667eea;
        }

        .contact-item a {
            color: #333;
            text-decoration: none;
        }

        .contact-item a:hover {
            color: #667eea;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
            font-size: 1.1em;
        }

        .refresh-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            margin-bottom: 20px;
        }

        .refresh-btn:hover {
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .question-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .contact-info {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Dashboard Admin</h1>
            <p>Kelola pertanyaan dari pengguna</p>
        </div>

        <?php
        $filename = 'data/pertanyaan.json';
        $questions = [];

        if (file_exists($filename)) {
            $json_content = file_get_contents($filename);
            $questions = json_decode($json_content, true);
            if (!is_array($questions)) {
                $questions = [];
            }
        }

        // Urutkan berdasarkan timestamp terbaru
        usort($questions, function($a, $b) {
            return strtotime($b['timestamp']) - strtotime($a['timestamp']);
        });

        $total_questions = count($questions);
        $total_with_email = 0;
        $total_with_whatsapp = 0;

        foreach ($questions as $q) {
            if (!empty($q['email'])) $total_with_email++;
            if (!empty($q['whatsapp'])) $total_with_whatsapp++;
        }
        ?>

        <div class="stats">
            <div class="stat-card">
                <h3><?php echo $total_questions; ?></h3>
                <p>Total Pertanyaan</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $total_with_email; ?></h3>
                <p>Dengan Email</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $total_with_whatsapp; ?></h3>
                <p>Dengan WhatsApp</p>
            </div>
        </div>

        <div class="questions-container">
            <button class="refresh-btn" onclick="location.reload()">Refresh Data</button>

            <?php if (empty($questions)): ?>
                <div class="no-data">
                    Belum ada pertanyaan masuk
                </div>
            <?php else: ?>
                <?php foreach ($questions as $index => $question): ?>
                    <div class="question-card">
                        <div class="question-header">
                            <span class="question-date">
                                <?php echo date('d/m/Y H:i:s', strtotime($question['timestamp'])); ?>
                            </span>
                            <span class="question-ip">
                                IP: <?php echo htmlspecialchars($question['ip_address']); ?>
                            </span>
                        </div>

                        <div class="question-content">
                            <strong>Pertanyaan:</strong><br>
                            <?php echo nl2br(htmlspecialchars($question['pertanyaan'])); ?>
                        </div>

                        <div class="contact-info">
                            <?php if (!empty($question['email'])): ?>
                                <div class="contact-item">
                                    <strong>Email:</strong>
                                    <a href="mailto:<?php echo htmlspecialchars($question['email']); ?>">
                                        <?php echo htmlspecialchars($question['email']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($question['whatsapp'])): ?>
                                <div class="contact-item">
                                    <strong>WhatsApp:</strong>
                                    <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $question['whatsapp']); ?>" target="_blank">
                                        <?php echo htmlspecialchars($question['whatsapp']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>