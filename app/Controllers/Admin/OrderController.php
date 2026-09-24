<?php
declare(strict_types=1);

namespace Skoolyst\Controllers\Admin;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Request;
use Skoolyst\Core\Response;
use Skoolyst\Services\OrderService;

// Platform-wide order visibility: admin sees every order and every item on it,
// regardless of which store(s) the items belong to.
class OrderController extends Controller {
    private OrderService $orders;

    public function __construct() {
        $this->orders = new OrderService();
    }

    public function index(): mixed {
        $filters = array_filter([
            'q' => trim((string) Request::input('q', '')),
            'status' => trim((string) Request::input('status', '')),
        ]);
        $page = (int) Request::input('page', 1);
        $perPage = (int) config('settings.pagination.admin_per_page', 15);

        return $this->view('admin/orders/index', [
            'result' => $this->orders->paginateForAdmin($filters, $page, $perPage),
            'filters' => $filters,
        ]);
    }

    public function show(string $id): mixed {
        $data = $this->orders->findForAdmin((int) $id);
        if (!$data) {
            http_response_code(404);
            return $this->view('errors/404');
        }

        return $this->view('admin/orders/show', $data);
    }

    public function setStatus(string $id): never {
        csrf_verify_or_abort();

        $status = (string) Request::input('status', 'pending');
        $this->orders->setStatus((int) $id, $status);

        flash('success', 'Order status updated.');
        Response::redirect(url('admin/orders/' . $id));
    }
}
