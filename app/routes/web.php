<?php
namespace App\Routers;
use App\Controllers\AuthController;
use App\Controllers\AdminController;
use App\Controllers\RecruiterController;
use App\Controllers\CandidateController;

class Router
{
   
}


$router = new Router();

// // Auth routes
// $router->get('', 'AuthController@showLoginForm');
// $router->get('login', 'AuthController@showLoginForm');
// $router->post('login', 'AuthController@login');
// $router->get('register', 'AuthController@showRegisterForm');
// $router->post('register', 'AuthController@register');
// $router->get('logout', 'AuthController@logout');
// $router->post('logout', 'AuthController@logout');
// $router->get('change-password', 'AuthController@showChangePasswordForm');
// $router->post('change-password', 'AuthController@changePassword');

// // Admin routes
// $router->get('admin/dashboard', 'AdminController@dashboard');
// $router->get('admin/users', 'AdminController@listUsers');
// $router->get('admin/roles', 'AdminController@listRoles');

// // Recruiter routes
// $router->get('recruiter/dashboard', 'RecruiterController@dashboard');

// // Candidate routes
// $router->get('candidate/dashboard', 'CandidateController@dashboard');

// // Default dashboard route
// $router->get('dashboard', 'AuthController@showLoginForm');

return $router;