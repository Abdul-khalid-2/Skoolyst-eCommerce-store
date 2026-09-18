<?php
declare(strict_types=1);
require dirname(__DIR__) . '/bootstrap/app.php';

use Skoolyst\Core\Request;
use Skoolyst\Core\Router;
use Skoolyst\Core\Session;

Session::start();

$router = new Router();
require dirname(__DIR__) . '/routes/web.php';
require dirname(__DIR__) . '/routes/api.php';

$router->dispatch(Request::method(), Request::uri());
