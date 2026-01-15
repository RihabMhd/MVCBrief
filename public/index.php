<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

require_once __DIR__ . '/../config/Database.php';

require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/models/Role.php';

require_once __DIR__ . '/../app/repositories/BaseRepository.php';
require_once __DIR__ . '/../app/repositories/UserRepository.php';
require_once __DIR__ . '/../app/repositories/RoleRepository.php';

require_once __DIR__ . '/../app/services/ValidatorService.php';
require_once __DIR__ . '/../app/services/AuthService.php';
require_once __DIR__ . '/../app/services/UserService.php';
require_once __DIR__ . '/../app/services/RoleService.php';

require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';
require_once __DIR__ . '/../app/controllers/RecruiterController.php';
require_once __DIR__ . '/../app/controllers/CandidateController.php';

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