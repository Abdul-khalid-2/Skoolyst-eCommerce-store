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

// Shared view components (function-based partials used across resources/views).
require_once dirname(__DIR__) . '/resources/views/components/button.php';
require_once dirname(__DIR__) . '/resources/views/components/badge.php';
require_once dirname(__DIR__) . '/resources/views/components/card.php';
require_once dirname(__DIR__) . '/resources/views/components/input.php';
require_once dirname(__DIR__) . '/resources/views/components/modal.php';
require_once dirname(__DIR__) . '/resources/views/components/pagination.php';
require_once dirname(__DIR__) . '/resources/views/components/empty-state.php';
require_once dirname(__DIR__) . '/resources/views/components/alert.php';
require_once dirname(__DIR__) . '/resources/views/components/table.php';
