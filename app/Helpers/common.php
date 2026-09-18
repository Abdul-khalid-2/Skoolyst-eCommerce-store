<?php
declare(strict_types=1);

/**
 * Dot-notation config reader, e.g. config('database.host').
 * Config files live in /config and each return a plain array.
 */
function config(string $key, mixed $default = null): mixed
{
    static $cache = [];

    [$file, $path] = array_pad(explode('.', $key, 2), 2, null);

    if (!array_key_exists($file, $cache)) {
        $configPath = dirname(__DIR__, 2) . '/config/' . $file . '.php';
        $cache[$file] = is_file($configPath) ? require $configPath : [];
    }

    if ($path === null) {
        return $cache[$file] ?: $default;
    }

    $value = $cache[$file];
    foreach (explode('.', $path) as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }
        $value = $value[$segment];
    }

    return $value;
}

function slugify(string $text): string
{
    $slug = strtolower(trim($text));
    $slug = preg_replace('~[^a-z0-9]+~', '-', $slug) ?? '';
    return trim($slug, '-');
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

function paginate_offset(int $page, int $perPage): int
{
    return max(0, ($page - 1)) * $perPage;
}
