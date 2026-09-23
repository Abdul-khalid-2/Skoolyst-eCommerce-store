<?php
declare(strict_types=1);

// Shared global helper functions used by all Skoolyst modules.
require_once dirname(__DIR__) . '/app/Helpers/auth.php';
require_once dirname(__DIR__) . '/app/Helpers/url.php';
require_once dirname(__DIR__) . '/app/Helpers/csrf.php';
require_once dirname(__DIR__) . '/app/Helpers/validation.php';
require_once dirname(__DIR__) . '/app/Helpers/response.php';
require_once dirname(__DIR__) . '/app/Helpers/session.php';
require_once dirname(__DIR__) . '/app/Helpers/upload.php';
require_once dirname(__DIR__) . '/app/Helpers/format.php';
require_once dirname(__DIR__) . '/app/Helpers/common.php';
require_once dirname(__DIR__) . '/app/Helpers/security.php';
require_once dirname(__DIR__) . '/app/Helpers/shopping.php';
require_once dirname(__DIR__) . '/app/Helpers/seo.php';

// Shared view components (function-based partials used across app/Views).
require_once dirname(__DIR__) . '/app/Views/layouts/partials/button.php';
require_once dirname(__DIR__) . '/app/Views/layouts/partials/badge.php';
require_once dirname(__DIR__) . '/app/Views/layouts/partials/card.php';
require_once dirname(__DIR__) . '/app/Views/layouts/partials/input.php';
require_once dirname(__DIR__) . '/app/Views/layouts/partials/modal.php';
require_once dirname(__DIR__) . '/app/Views/layouts/partials/pagination.php';
require_once dirname(__DIR__) . '/app/Views/layouts/partials/empty-state.php';
require_once dirname(__DIR__) . '/app/Views/layouts/partials/alerts.php';
require_once dirname(__DIR__) . '/app/Views/layouts/partials/table.php';
