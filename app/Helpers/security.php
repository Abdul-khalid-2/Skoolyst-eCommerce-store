<?php
declare(strict_types=1);

/** Verifies the `_csrf` field submitted on POST/PUT/DELETE forms against the session token. */
function csrf_verify(): bool
{
    $submitted = $_POST['_csrf'] ?? '';
    $expected = $_SESSION['_csrf'] ?? '';
    return $submitted !== '' && $expected !== '' && hash_equals($expected, $submitted);
}

/** Aborts the request with 419 if CSRF verification fails. Call at the top of state-changing controller actions. */
function csrf_verify_or_abort(): void
{
    if (!csrf_verify()) {
        http_response_code(419);
        flash('error', 'Your session expired. Please try again.');
        \Skoolyst\Core\View::render('errors/419');
        exit;
    }
}
