<?php
return [
    'driver' => 'smtp',
    'host' => $_ENV['MAIL_HOST'] ?? '',
    'port' => $_ENV['MAIL_PORT'] ?? 587,

    // Centralized Skoolyst Email API (ads.skoolyst.com) — every Skoolyst app
    // sends mail through this one HTTP endpoint instead of talking SMTP
    // directly. See app/Services/MailService.php.
    'api' => [
        'base_url' => $_ENV['SKOOLYST_MAIL_API_URL'] ?? 'https://ads.skoolyst.com/api/v1',
        'api_key' => $_ENV['SKOOLYST_MAIL_API_KEY'] ?? '',
        'source_app' => $_ENV['SKOOLYST_MAIL_SOURCE_APP'] ?? 'skoolyst-store',
    ],
];
