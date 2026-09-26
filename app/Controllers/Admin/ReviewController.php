<?php
declare(strict_types=1);

namespace Skoolyst\Controllers\Admin;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Request;
use Skoolyst\Core\Response;
use Skoolyst\Services\ReviewService;

class ReviewController extends Controller {
    private ReviewService $reviews;

    public function __construct() {
        $this->reviews = new ReviewService();
    }

    public function index(): mixed {
        $filters = array_filter([
            'status' => trim((string) Request::input('status', '')),
            'include_all_statuses' => true,
        ]);
        $page = (int) Request::input('page', 1);
        $perPage = (int) config('settings.pagination.admin_per_page', 15);

        return $this->view('admin/reviews/index', [
            'result' => $this->reviews->paginate($filters, $page, $perPage),
            'filters' => $filters,
        ]);
    }

    public function setStatus(string $id): never {
        csrf_verify_or_abort();
        $status = (string) Request::input('status', 'pending');
        $this->reviews->setStatus((int) $id, $status);
        flash('success', 'Review status updated.');
        Response::redirect(url('admin/reviews'));
    }

    public function destroy(string $id): never {
        csrf_verify_or_abort();
        $this->reviews->delete((int) $id);
        flash('success', 'Review deleted.');
        Response::redirect(url('admin/reviews'));
    }
}
