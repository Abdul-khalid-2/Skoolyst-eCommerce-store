<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;
use Skoolyst\Services\FavoriteService;

class FavoriteController extends Controller {
    private FavoriteService $favorites;

    public function __construct() {
        $this->favorites = new FavoriteService();
    }

    public function index(): mixed {
        return $this->view('favorites/index', [
            'products' => $this->favorites->products(),
        ]);
    }

    public function toggle(string $id): never {
        csrf_verify_or_abort();

        $isFavorite = $this->favorites->toggle((int) $id);

        $this->json([
            'ok' => true,
            'isFavorite' => $isFavorite,
            'count' => $this->favorites->count(),
        ]);
    }
}
