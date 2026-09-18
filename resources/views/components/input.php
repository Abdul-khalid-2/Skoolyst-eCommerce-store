<?php
/**
 * Form field component (Section 5 of SKOOLYST-DESIGN-SYSTEM.md).
 * Renders label + input/select/textarea + hint/error, wrapped in .form-group.
 */
if (!function_exists('skoolyst_input')) {
    function skoolyst_input(array $opts): string
    {
        $type = $opts['type'] ?? 'text';
        $name = $opts['name'] ?? '';
        $id = $opts['id'] ?? $name;
        $label = $opts['label'] ?? '';
        $value = $opts['value'] ?? '';
        $placeholder = $opts['placeholder'] ?? '';
        $required = !empty($opts['required']);
        $hint = $opts['hint'] ?? null;
        $error = $opts['error'] ?? null;
        $attrs = $opts['attrs'] ?? [];

        $attrString = '';
        foreach ($attrs as $key => $val) {
            $attrString .= ' ' . clean($key) . '="' . clean($val) . '"';
        }

        $labelHtml = $label !== '' ? '<label class="form-label" for="' . clean($id) . '">' . clean($label) . '</label>' : '';
        $controlClass = 'form-control' . ($error ? ' is-invalid' : '');

        if ($type === 'textarea') {
            $field = '<textarea class="' . $controlClass . '" id="' . clean($id) . '" name="' . clean($name) . '"'
                . ($required ? ' required' : '') . ' placeholder="' . clean($placeholder) . '"' . $attrString . '>' . clean($value) . '</textarea>';
        } else {
            $field = '<input type="' . clean($type) . '" class="' . $controlClass . '" id="' . clean($id) . '" name="' . clean($name) . '"'
                . ' value="' . clean($value) . '" placeholder="' . clean($placeholder) . '"' . ($required ? ' required' : '') . $attrString . '>';
        }

        $hintHtml = $hint ? '<div class="form-hint">' . clean($hint) . '</div>' : '';
        $errorHtml = $error ? '<div class="form-error">' . clean($error) . '</div>' : '';

        return '<div class="form-group">' . $labelHtml . $field . $hintHtml . $errorHtml . '</div>';
    }
}
