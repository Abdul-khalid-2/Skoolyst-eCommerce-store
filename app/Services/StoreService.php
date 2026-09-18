<?php
declare(strict_types=1);

namespace Skoolyst\Services;

use Skoolyst\Core\Validator;
use Skoolyst\Models\Store;

class StoreService {
    private const RULES = [
        'name' => 'required|max:160',
        'city' => 'max:80',
        'address' => 'max:255',
        'store_type' => 'in:retail,wholesale,brand_outlet',
        'phone' => 'max:30',
        'email' => 'email|max:160',
        'website' => 'max:255',
        'description' => 'max:5000',
    ];

    public function paginate(array $filters, int $page, int $perPage): array {
        $result = Store::search($filters, max(1, $page), $perPage);
        return [
            'rows' => $result['rows'],
            'total' => $result['total'],
            'page' => max(1, $page),
            'perPage' => $perPage,
            'totalPages' => max(1, (int) ceil($result['total'] / $perPage)),
        ];
    }

    public function findBySlugOrFail(string $slug): ?array {
        return Store::findActiveBySlug($slug);
    }

    public function featured(int $limit = 4): array {
        return Store::featured($limit);
    }

    /** @return array{errors: array<string,string>, id: ?int} */
    public function create(array $data, ?string $logoPath): array {
        $errors = Validator::make($data, self::RULES);
        if ($errors) {
            return ['errors' => $errors, 'id' => null];
        }

        $slug = $this->uniqueSlug($data['name']);
        $categoryId = !empty($data['category_id']) ? (int) $data['category_id'] : null;

        $id = Store::insert([
            'name' => $data['name'],
            'slug' => $slug,
            'description' => $data['description'] ?? null,
            'city' => $data['city'] ?? null,
            'address' => $data['address'] ?? null,
            'store_type' => $data['store_type'] ?? 'retail',
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'website' => $data['website'] ?? null,
            'category_id' => $categoryId,
            'logo' => $logoPath,
            'status' => $data['status'] ?? 'pending',
            'verified' => !empty($data['verified']) ? 1 : 0,
        ]);

        return ['errors' => [], 'id' => $id];
    }

    /** @return array<string,string> errors */
    public function update(int $id, array $data, ?string $logoPath): array {
        $errors = Validator::make($data, self::RULES);
        if ($errors) {
            return $errors;
        }

        $update = [
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'city' => $data['city'] ?? null,
            'address' => $data['address'] ?? null,
            'store_type' => $data['store_type'] ?? 'retail',
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'website' => $data['website'] ?? null,
            'category_id' => !empty($data['category_id']) ? (int) $data['category_id'] : null,
            'status' => $data['status'] ?? 'pending',
            'verified' => !empty($data['verified']) ? 1 : 0,
        ];

        if ($logoPath !== null) {
            $update['logo'] = $logoPath;
        }

        Store::updateById($id, $update);
        return [];
    }

    /**
     * Self-service store creation by a regular user ("Open a Store").
     * Always lands as unverified + pending, regardless of what was posted —
     * only a platform admin can activate/verify a store.
     * @return array{errors: array<string,string>, id: ?int}
     */
    public function createForOwner(int $userId, array $data, ?string $logoPath): array {
        $errors = Validator::make($data, self::RULES);
        if ($errors) {
            return ['errors' => $errors, 'id' => null];
        }

        $slug = $this->uniqueSlug($data['name']);
        $categoryId = !empty($data['category_id']) ? (int) $data['category_id'] : null;

        $id = Store::insert([
            'user_id' => $userId,
            'name' => $data['name'],
            'slug' => $slug,
            'description' => $data['description'] ?? null,
            'city' => $data['city'] ?? null,
            'address' => $data['address'] ?? null,
            'store_type' => $data['store_type'] ?? 'retail',
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'website' => $data['website'] ?? null,
            'category_id' => $categoryId,
            'logo' => $logoPath,
            'status' => 'pending',
            'verified' => 0,
        ]);

        return ['errors' => [], 'id' => $id];
    }

    /**
     * Self-service update by the store's own owner. Status/verified are
     * deliberately not accepted here — those stay platform-admin-only.
     * @return array<string,string> errors
     */
    public function updateOwnStore(int $id, array $data, ?string $logoPath): array {
        $errors = Validator::make($data, self::RULES);
        if ($errors) {
            return $errors;
        }

        $update = [
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'city' => $data['city'] ?? null,
            'address' => $data['address'] ?? null,
            'store_type' => $data['store_type'] ?? 'retail',
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'website' => $data['website'] ?? null,
            'category_id' => !empty($data['category_id']) ? (int) $data['category_id'] : null,
        ];

        if ($logoPath !== null) {
            $update['logo'] = $logoPath;
        }

        Store::updateById($id, $update);
        return [];
    }

    public function setStatus(int $id, string $status): void {
        Store::updateById($id, ['status' => $status]);
    }

    public function delete(int $id): void {
        Store::deleteById($id);
    }

    public function stats(): array {
        return [
            'total' => Store::count(),
            'active' => Store::countByStatus('active'),
            'pending' => Store::countByStatus('pending'),
            'inactive' => Store::countByStatus('inactive'),
        ];
    }

    private function uniqueSlug(string $name): string {
        $base = slugify($name) ?: 'store';
        $slug = $base;
        $suffix = 1;
        while (Store::slugExists($slug)) {
            $slug = $base . '-' . (++$suffix);
        }
        return $slug;
    }
}
