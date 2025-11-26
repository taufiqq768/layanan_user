<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Mail\PertanyaanDijawab;
use App\Models\Pertanyaan;
use Illuminate\Support\Facades\Mail;

try {
    echo "Testing email configuration...\n";
    echo "MAIL_MAILER: " . config('mail.default') . "\n";
    echo "MAIL_HOST: " . config('mail.mailers.smtp.host') . "\n";
    echo "MAIL_PORT: " . config('mail.mailers.smtp.port') . "\n";
    echo "MAIL_USERNAME: " . config('mail.mailers.smtp.username') . "\n";
    echo "MAIL_ENCRYPTION: " . config('mail.mailers.smtp.encryption') . "\n\n";

    // Get pertanyaan terbaru
    $pertanyaan = Pertanyaan::latest()->first();

    if (!$pertanyaan) {
        echo "Tidak ada pertanyaan di database!\n";
        exit(1);
    }

    if (!$pertanyaan->email) {
        echo "Pertanyaan tidak memiliki email!\n";
        exit(1);
    }

    echo "Sending test email to: " . $pertanyaan->email . "\n";

    Mail::to($pertanyaan->email)->send(new PertanyaanDijawab($pertanyaan));

    echo "\n✓ Email sent successfully!\n";

} catch (\Exception $e) {
    echo "\n✗ Error: " . $e->getMessage() . "\n";
    echo "\nFull trace:\n";
    echo $e->getTraceAsString() . "\n";
}