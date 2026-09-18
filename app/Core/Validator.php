<?php
declare(strict_types=1);

namespace Skoolyst\Core;

class Validator {
    /**
     * @param array<string,string> $rules pipe-separated rule strings, e.g. 'name' => 'required|max:160'
     * @return array<string,string> field => first error message (empty array means valid)
     */
    public static function make(array $data, array $rules): array {
        $errors = [];

        foreach ($rules as $field => $ruleString) {
            $value = $data[$field] ?? null;

            foreach (explode('|', $ruleString) as $rule) {
                [$name, $param] = array_pad(explode(':', $rule, 2), 2, null);
                $error = self::applyRule($name, $param, $field, $value);
                if ($error !== null) {
                    $errors[$field] = $error;
                    break;
                }
            }
        }

        return $errors;
    }

    private static function applyRule(string $rule, ?string $param, string $field, mixed $value): ?string {
        $label = str_replace('_', ' ', $field);

        switch ($rule) {
            case 'required':
                if ($value === null || trim((string) $value) === '') {
                    return "The {$label} field is required.";
                }
                return null;

            case 'email':
                if ($value !== null && $value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    return "The {$label} must be a valid email address.";
                }
                return null;

            case 'numeric':
                if ($value !== null && $value !== '' && !is_numeric($value)) {
                    return "The {$label} must be a number.";
                }
                return null;

            case 'max':
                if ($value !== null && strlen((string) $value) > (int) $param) {
                    return "The {$label} must not exceed {$param} characters.";
                }
                return null;

            case 'min':
                if ($value !== null && $value !== '' && strlen((string) $value) < (int) $param) {
                    return "The {$label} must be at least {$param} characters.";
                }
                return null;

            case 'in':
                $allowed = $param !== null ? explode(',', $param) : [];
                if ($value !== null && $value !== '' && !in_array((string) $value, $allowed, true)) {
                    return "The selected {$label} is invalid.";
                }
                return null;

            default:
                return null;
        }
    }
}
