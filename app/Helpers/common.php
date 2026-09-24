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

/**
 * Resolves a stored image path (e.g. "uploads/products/abc.jpg") to an absolute URL.
 * Already-absolute URLs (external fallback images) are returned unchanged so the
 * <img> tag never breaks depending on which page path it's rendered from.
 */
function media_url(?string $path, string $fallback = ''): string
{
    $path = $path !== null && $path !== '' ? $path : $fallback;
    if ($path === '') {
        return '';
    }
    if (preg_match('#^(https?:)?//#i', $path)) {
        return $path;
    }
    return url($path);
}

/** Appends a filemtime-based ?v= query string so browsers pick up new CSS/JS after every deploy. */
function asset(string $path): string
{
    $relative = 'assets/' . ltrim($path, '/');
    $absolute = dirname(__DIR__, 2) . '/public/' . $relative;
    $version = is_file($absolute) ? filemtime($absolute) : null;

    return url($relative) . ($version ? '?v=' . $version : '');
}

/** The app favicon, served from /public/favicon.jpg with the same cache-busting as asset(). */
function favicon_url(): string
{
    $absolute = dirname(__DIR__, 2) . '/public/favicon.jpg';
    $version = is_file($absolute) ? filemtime($absolute) : null;

    return url('favicon.jpg') . ($version ? '?v=' . $version : '');
}

function paginate_offset(int $page, int $perPage): int
{
    return max(0, ($page - 1)) * $perPage;
}
