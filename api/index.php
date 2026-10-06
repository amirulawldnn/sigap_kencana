<?php

// Vercel serverless environment bersifat read-only, kecuali /tmp.
// Kita siapkan folder storage dan cache di /tmp agar Laravel berjalan mulus tanpa error.
$storageDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
putenv('SESSION_DRIVER=cookie');
putenv('LOG_CHANNEL=stderr');

// Entry point ke aplikasi Laravel
require __DIR__ . '/../public/index.php';

