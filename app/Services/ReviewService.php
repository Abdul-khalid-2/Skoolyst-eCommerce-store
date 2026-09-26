<?php
declare(strict_types=1);

namespace Skoolyst\Services;

use Skoolyst\Core\Validator;
use Skoolyst\Models\Review;

class ReviewService {
    private const RULES = [
        'rating' => 'required|numeric',
        'title' => 'max:160',
        'comment' => 'max:2000',
    ];

    public function paginate(array $filters, int $page, int $perPage): array {
        $result = Review::search($filters, max(1, $page), $perPage);
        return [
            'rows' => $result['rows'],
            'total' => $result['total'],
            'page' => max(1, $page),
            'perPage' => $perPage,
            'totalPages' => max(1, (int) ceil($result['total'] / $perPage)),
        ];
    }

    public function byStore(int $storeId): array {
        return Review::activeByStore($storeId);
    }

    /** New reviews always start out pending — they only become visible once an admin approves them. */
    public function create(int $storeId, ?int $userId, array $data): array {
        $errors = Validator::make($data, self::RULES);
        $rating = (int) ($data['rating'] ?? 0);
        if (!$errors && ($rating < 1 || $rating > 5)) {
            $errors['rating'] = 'The rating must be between 1 and 5.';
        }
        if ($errors) {
            return ['errors' => $errors, 'id' => null];
        }

        $id = Review::insert([
            'store_id' => $storeId,
            'user_id' => $userId,
            'rating' => $rating,
            'title' => $data['title'] ?? null,
            'comment' => $data['comment'] ?? null,
            'status' => 'pending',
        ]);

        return ['errors' => [], 'id' => $id];
    }

    public function setStatus(int $id, string $status): void {
        Review::updateById($id, ['status' => $status]);
    }

    public function delete(int $id): void {
        Review::deleteById($id);
    }
}
