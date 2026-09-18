<?php
/**
 * Badge / status component (Section 13 of SKOOLYST-DESIGN-SYSTEM.md).
 * Variants: navy, accent, success, warning-soft, error, verified, discount, muted.
 */
if (!function_exists('skoolyst_badge')) {
    function skoolyst_badge(string $label, string $variant = 'navy', ?string $icon = null): string
    {
        $icon = $icon ? '<i class="bi ' . clean($icon) . '"></i> ' : '';
        return '<span class="badge badge-' . clean($variant) . '">' . $icon . clean($label) . '</span>';
    }
}

if (!function_exists('skoolyst_status_badge')) {
    function skoolyst_status_badge(string $label, string $status): string
    {
        return '<span class="status-badge status-' . clean($status) . '">' . clean($label) . '</span>';
    }
}
