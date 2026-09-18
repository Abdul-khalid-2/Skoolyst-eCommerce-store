<?php
/** Empty state component. */
if (!function_exists('skoolyst_empty_state')) {
    function skoolyst_empty_state(string $icon, string $title, string $message, string $actionHtml = ''): string
    {
        return '<div class="empty-state">'
            . '<div class="empty-icon"><i class="bi ' . clean($icon) . '"></i></div>'
            . '<h4>' . clean($title) . '</h4>'
            . '<p>' . clean($message) . '</p>'
            . $actionHtml
            . '</div>';
    }
}
