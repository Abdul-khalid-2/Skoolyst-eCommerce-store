<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;
use Skoolyst\Models\Category;
use Skoolyst\Models\Store;

class HomeController extends Controller {
    public function index(): mixed {
        return $this->view('home/index', [
            'categories' => Category::withStoreCounts(),
            'featuredStores' => Store::featured(4),
            'cities' => Store::cityCounts(),
        ]);
    }
}
