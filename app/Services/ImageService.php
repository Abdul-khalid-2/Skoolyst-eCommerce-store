<?php
declare(strict_types=1);

namespace Skoolyst\Services;

class ImageService {
    /**
     * @return array{path: ?string, errors: string[]}
     */
    public function upload(array $file, string $subdir): array {
        $errors = [];
        $path = store_uploaded_image($file, $subdir, $errors);
        return ['path' => $path, 'errors' => $errors];
    }

    public function delete(?string $relativePath): void {
        if (!$relativePath) {
            return;
        }
        $absolute = dirname(__DIR__, 2) . '/public/' . $relativePath;
        if (is_file($absolute)) {
            @unlink($absolute);
        }
    }
}
