<?php
declare(strict_types=1);

/**
 * Centralized upload validation: MIME, extension, size, filename normalization and storage path.
 * Returns the stored relative path (e.g. "uploads/stores/abc123.jpg") on success, or null on failure.
 * $errors is populated by reference with human-readable messages on failure.
 */
function store_uploaded_image(array $file, string $subdir, array &$errors = []): ?string
{
    if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Upload failed. Please try again.';
        return null;
    }

    $maxSize = config('settings.upload.max_size', 10485760);
    if ($file['size'] > $maxSize) {
        $errors[] = 'Image is too large. Maximum size is ' . round($maxSize / 1048576, 1) . 'MB.';
        return null;
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']) ?: '';
    $allowedMime = config('settings.upload.allowed_mime', []);
    if (!in_array($mime, $allowedMime, true)) {
        $errors[] = 'Only JPG, PNG and WebP images are allowed.';
        return null;
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExt = config('settings.upload.allowed_ext', []);
    if (!in_array($ext, $allowedExt, true)) {
        $errors[] = 'Invalid file extension.';
        return null;
    }

    $safeName = bin2hex(random_bytes(16)) . '.' . $ext;
    $relativeDir = trim($subdir, '/');
    $absoluteDir = dirname(__DIR__, 2) . '/public/' . $relativeDir;

    if (!is_dir($absoluteDir) && !mkdir($absoluteDir, 0755, true) && !is_dir($absoluteDir)) {
        $errors[] = 'Could not create upload directory.';
        return null;
    }

    $destination = $absoluteDir . '/' . $safeName;
    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        $errors[] = 'Could not save the uploaded file.';
        return null;
    }

    return $relativeDir . '/' . $safeName;
}
