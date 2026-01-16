<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Config\Database;
use App\Repository\UserRepository;
use App\Repository\RoleRepository;
use App\Services\ValidatorService;
use App\Services\AuthService;
use App\Services\UserService;
use App\Services\RoleService;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$database = new Database();
$db = $database->connect();

$userRepository = new UserRepository($db);
$roleRepository = new RoleRepository($db);

$validator = new ValidatorService();
$authService = new AuthService($userRepository);
$userService = new UserService($userRepository, $validator);
$roleService = new RoleService($roleRepository);

global $authService, $userService, $roleService, $validator;

$router = require_once __DIR__ . '/../routes/web.php';

$router->run();