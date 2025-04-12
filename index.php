<?php
require_once('./helpers.php');

require_once(base_path('framework/Session.php'));
require_once(base_path('framework/Database.php'));
require_once(base_path('framework/Router.php'));
require_once(base_path('framework/Validation.php'));
require_once(base_path('framework/middleware/Authorize.php'));

use Framework\Session;
use Framework\Database;
use Framework\Router;
use Framework\Validation;
use Framework\Middleware\Authorize;

Session::start();

$config = require(base_path('config/db.php'));

$db = new Database($config);

$router = new Router();
$routes = require(base_path("routes.php"));

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->route($uri);
