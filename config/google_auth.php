<?php
declare(strict_types=1);

/**
 * "Login with Google" — independent Google OAuth2 client, not routed
 * through skoolyst.com. See app/Services/GoogleAuthService.php.
 */
return [
    'client_id' => $_ENV['GOOGLE_CLIENT_ID'] ?? '',
    'client_secret' => $_ENV['GOOGLE_CLIENT_SECRET'] ?? '',
    'redirect_uri' => $_ENV['GOOGLE_REDIRECT_URI'] ?? '',
];
