<?php
declare(strict_types=1);

namespace Skoolyst\Services;

use Skoolyst\Core\Validator;
use Skoolyst\Models\Product;

class ProductService {
    private const RULES = [
        'name' => 'required|max:180',
        'price' => 'required|numeric',
        'sale_price' => 'numeric',
        'stock' => 'numeric',
        'status' => 'in:active,draft,out_of_stock',
        'description' => 'max:5000',
    ];

    public function paginate(array $filters, int $page, int $perPage): array {
        $result = Product::search($filters, max(1, $page), $perPage);
        return [
            'rows' => $result['rows'],
            'total' => $result['total'],
            'page' => max(1, $page),
            'perPage' => $perPage,
            'totalPages' => max(1, (int) ceil($result['total'] / $perPage)),
        ];
    }

    public function findBySlugOrFail(string $slug): ?array {
        return Product::findActiveBySlug($slug);
    }

    public function byStore(int $storeId): array {
        return Product::byStore($storeId);
    }

    /** @return array{errors: array<string,string>, id: ?int} */
    public function create(array $data, ?string $imagePath): array {
        $errors = Validator::make($data, self::RULES);
        if ($errors) {
            return ['errors' => $errors, 'id' => null];
        }

        $slug = $this->uniqueSlug($data['name']);
        $stock = (int) ($data['stock'] ?? 0);

        $id = Product::insert([
            'store_id' => (int) $data['store_id'],
            'category_id' => !empty($data['category_id']) ? (int) $data['category_id'] : null,
            'name' => $data['name'],
            'slug' => $slug,
            'description' => $data['description'] ?? null,
            'price' => (float) $data['price'],
            'sale_price' => isset($data['sale_price']) && $data['sale_price'] !== '' ? (float) $data['sale_price'] : null,
            'stock' => $stock,
            'status' => $data['status'] ?? ($stock > 0 ? 'active' : 'out_of_stock'),
            'image' => $imagePath,
        ]);

        return ['errors' => [], 'id' => $id];
    }

    /**
     * Store-owner product creation — store_id is forced to their own store,
     * never trusted from client input.
     * @return array{errors: array<string,string>, id: ?int}
     */
    public function createForStore(int $storeId, array $data, ?string $imagePath): array {
        $data['store_id'] = $storeId;
        return $this->create($data, $imagePath);
    }

    /**
     * Store-owner product update. Caller must already have verified the
     * product belongs to the caller's store before calling this.
     * @return array<string,string> errors
     */
    public function updateOwnProduct(int $id, array $data, ?string $imagePath): array {
        $errors = Validator::make($data, self::RULES);
        if ($errors) {
            return $errors;
        }

        $stock = (int) ($data['stock'] ?? 0);

        $update = [
            'category_id' => !empty($data['category_id']) ? (int) $data['category_id'] : null,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'price' => (float) $data['price'],
            'sale_price' => isset($data['sale_price']) && $data['sale_price'] !== '' ? (float) $data['sale_price'] : null,
            'stock' => $stock,
            'status' => $data['status'] ?? ($stock > 0 ? 'active' : 'out_of_stock'),
        ];

        if ($imagePath !== null) {
            $update['image'] = $imagePath;
        }

        Product::updateById($id, $update);
        return [];
    }

    public function setStatus(int $id, string $status): void {
        Product::updateById($id, ['status' => $status]);
    }

    public function delete(int $id): void {
        Product::deleteById($id);
    }

    public function stats(): array {
        return [
            'total' => Product::count(),
            'active' => Product::count('status = :s', ['s' => 'active']),
            'out_of_stock' => Product::count('status = :s', ['s' => 'out_of_stock']),
        ];
    }

    private function uniqueSlug(string $name): string {
        $base = slugify($name) ?: 'product';
        $slug = $base;
        $suffix = 1;
        while (Product::slugExists($slug)) {
            $slug = $base . '-' . (++$suffix);
        }
        return $slug;
    }
}
