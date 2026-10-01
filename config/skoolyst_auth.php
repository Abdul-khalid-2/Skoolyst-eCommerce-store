<?php
declare(strict_types=1);

/**
 * "Login with Skoolyst" SSO client config — skoolyst.com is the central
 * identity provider for the Skoolyst family of apps. See
 * app/Services/SkoolystAuthService.php for the OAuth2 Authorization Code
 * flow this drives.
 */
return [
    'base_url' => $_ENV['SKOOLYST_AUTH_BASE'] ?? 'https://skoolyst.com',
    'client_id' => $_ENV['SKOOLYST_AUTH_CLIENT_ID'] ?? '',
    'client_secret' => $_ENV['SKOOLYST_AUTH_CLIENT_SECRET'] ?? '',
    'redirect_uri' => $_ENV['SKOOLYST_AUTH_REDIRECT_URI'] ?? '',
];
