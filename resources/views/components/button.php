<?php
/**
 * Button component. Variants map to the classes defined in app.css
 * (Section 3 of SKOOLYST-DESIGN-SYSTEM.md): navy, accent, outline-navy,
 * light-navy, danger, plus the outline-secondary used for social buttons.
 */
if (!function_exists('skoolyst_btn')) {
    function skoolyst_btn(string $label, array $opts = []): string
    {
        $variant = $opts['variant'] ?? 'navy';
        $size = $opts['size'] ?? '';
        $icon = $opts['icon'] ?? null;
        $href = $opts['href'] ?? null;
        $type = $opts['type'] ?? 'button';
        $extraClass = $opts['class'] ?? '';
        $attrs = $opts['attrs'] ?? [];

        $classes = trim("btn btn-{$variant} " . ($size ? "btn-{$size} " : '') . $extraClass);
        $attrString = '';
        foreach ($attrs as $key => $value) {
            $attrString .= ' ' . clean($key) . '="' . clean($value) . '"';
        }

        $inner = ($icon ? '<i class="bi ' . clean($icon) . ' me-1"></i>' : '') . clean($label);

        if ($href !== null) {
            return '<a href="' . clean($href) . '" class="' . clean($classes) . '"' . $attrString . '>' . $inner . '</a>';
        }
        return '<button type="' . clean($type) . '" class="' . clean($classes) . '"' . $attrString . '>' . $inner . '</button>';
    }
}
