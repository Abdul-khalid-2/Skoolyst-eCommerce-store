<?php
/**
 * Card component helpers (Section 4 of SKOOLYST-DESIGN-SYSTEM.md).
 * For markup-heavy cards (product/store cards) pages compose the .card
 * classes directly; these helpers cover the plain content-card + stat-card
 * shapes reused across dashboard and info panels.
 */
if (!function_exists('skoolyst_stat_card')) {
    function skoolyst_stat_card(string $icon, string $iconBg, string $label, string $value, ?string $trend = null, string $trendDir = 'up'): string
    {
        $trendHtml = $trend
            ? '<div class="stat-trend ' . clean($trendDir) . '"><i class="bi bi-arrow-' . clean($trendDir) . '"></i> ' . clean($trend) . '</div>'
            : '';
        return '<div class="stat-card">'
            . '<div class="stat-icon ' . clean($iconBg) . '"><i class="bi ' . clean($icon) . '"></i></div>'
            . '<div><div class="stat-label">' . clean($label) . '</div><div class="stat-value">' . clean($value) . '</div>' . $trendHtml . '</div>'
            . '</div>';
    }
}

if (!function_exists('skoolyst_card_open')) {
    function skoolyst_card_open(string $extraClass = ''): string
    {
        return '<div class="card ' . clean($extraClass) . '">';
    }
}

if (!function_exists('skoolyst_card_close')) {
    function skoolyst_card_close(): string
    {
        return '</div>';
    }
}
