<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;

/** Static public informational pages (About, Contact, Privacy, Terms, Returns). */
class PageController extends Controller {
    public function about(): mixed {
        return $this->view('pages/about');
    }

    public function contact(): mixed {
        return $this->view('pages/contact');
    }

    public function privacy(): mixed {
        return $this->view('pages/privacy');
    }

    public function terms(): mixed {
        return $this->view('pages/terms');
    }

    public function returns(): mixed {
        return $this->view('pages/returns');
    }
}
