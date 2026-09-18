<?php
/**
 * Table wrapper helpers (Section 6 of SKOOLYST-DESIGN-SYSTEM.md).
 * Used by dashboard list pages: pass column headers, then echo <tr> rows,
 * then call skoolyst_table_close().
 */
if (!function_exists('skoolyst_table_open')) {
    function skoolyst_table_open(array $headers, string $class = 'dash-table'): string
    {
        $ths = implode('', array_map(static fn ($h) => '<th>' . clean($h) . '</th>', $headers));
        return '<div class="table-wrap"><table class="' . clean($class) . '"><thead><tr>' . $ths . '</tr></thead><tbody>';
    }
}

if (!function_exists('skoolyst_table_close')) {
    function skoolyst_table_close(): string
    {
        return '</tbody></table></div>';
    }
}
