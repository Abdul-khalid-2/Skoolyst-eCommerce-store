<?php
/**
 * Pagination component rendering .sk-pagination markup.
 */
if (!function_exists('skoolyst_pagination')) {
    function skoolyst_pagination(int $current, int $total, string $baseUrl, string $ariaLabel = 'Pagination'): string
    {
        if ($total <= 1) {
            return '';
        }
        $link = static fn (int $page): string => $baseUrl . (str_contains($baseUrl, '?') ? '&' : '?') . 'page=' . $page;

        $html = '<nav class="mt-4" aria-label="' . clean($ariaLabel) . '"><div class="sk-pagination">';
        $html .= '<button class="page-btn"' . ($current <= 1 ? ' disabled' : '') . ' onclick="location.href=\'' . clean($link(max(1, $current - 1))) . '\'"><i class="bi bi-chevron-left"></i></button>';
        for ($page = 1; $page <= $total; $page++) {
            $activeClass = $page === $current ? ' active' : '';
            $html .= '<button class="page-btn' . $activeClass . '" onclick="location.href=\'' . clean($link($page)) . '\'">' . $page . '</button>';
        }
        $html .= '<button class="page-btn"' . ($current >= $total ? ' disabled' : '') . ' onclick="location.href=\'' . clean($link(min($total, $current + 1))) . '\'"><i class="bi bi-chevron-right"></i></button>';
        $html .= '</div></nav>';
        return $html;
    }
}
