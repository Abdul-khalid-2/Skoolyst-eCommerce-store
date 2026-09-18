<?php
declare(strict_types=1);

namespace Skoolyst\Controllers\Admin;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Request;
use Skoolyst\Core\Response;
use Skoolyst\Core\Validator;
use Skoolyst\Models\Category;

class CategoryController extends Controller {
    public function index(): mixed {
        return $this->view('admin/categories/index', [
            'categories' => Category::withStoreCounts(),
        ]);
    }

    public function create(): mixed {
        return $this->view('admin/categories/create');
    }

    public function store(): mixed {
        csrf_verify_or_abort();

        $data = Request::all();
        $errors = Validator::make($data, ['name' => 'required|max:100']);

        $slug = slugify($data['name'] ?? '');
        if (!$errors && Category::slugExists($slug)) {
            $errors['name'] = 'A category with this name already exists.';
        }

        if ($errors) {
            return $this->view('admin/categories/create', ['errors' => $errors, 'old' => $data]);
        }

        Category::insert([
            'name' => $data['name'],
            'slug' => $slug,
            'icon' => $data['icon'] ?? null,
        ]);

        flash('success', 'Category created successfully.');
        Response::redirect(url('admin/categories'));
    }

    public function destroy(string $id): never {
        csrf_verify_or_abort();
        Category::deleteById((int) $id);
        flash('success', 'Category deleted.');
        Response::redirect(url('admin/categories'));
    }
}
