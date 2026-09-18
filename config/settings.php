<?php
declare(strict_types=1);

return [
    'pagination' => [
        'stores_per_page' => 9,
        'products_per_page' => 12,
        'admin_per_page' => 15,
    ],
    'upload' => [
        'max_size' => (int) ($_ENV['UPLOAD_MAX_SIZE'] ?? 10485760),
        'allowed_mime' => ['image/jpeg', 'image/png', 'image/webp'],
        'allowed_ext' => ['jpg', 'jpeg', 'png', 'webp'],
        'stores_dir' => 'uploads/stores',
        'products_dir' => 'uploads/products',
    ],
];
