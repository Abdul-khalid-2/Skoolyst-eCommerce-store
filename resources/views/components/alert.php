<?php
/** Alert component: success, danger, warning, info. */
if (!function_exists('skoolyst_alert')) {
    function skoolyst_alert(string $message, string $type = 'info', string $icon = 'bi-info-circle-fill'): string
    {
        return '<div class="alert alert-' . clean($type) . ' d-flex align-items-center gap-2 mb-4" role="alert">'
            . '<i class="bi ' . clean($icon) . '"></i>'
            . '<span class="small">' . clean($message) . '</span>'
            . '</div>';
    }
}
