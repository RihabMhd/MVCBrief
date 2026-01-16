<?php
namespace App\Controllers;
use App\Services\AuthService;
use App\Services\UserService;
use App\Services\RoleService;
class AdminController
{
    private AuthService $authService;
    private UserService $userService;
    private RoleService $roleService;
    
    public function __construct(
        AuthService $authService,
        UserService $userService,
        RoleService $roleService
    ) {
        $this->authService = $authService;
        $this->userService = $userService;
        $this->roleService = $roleService;
    }
    
    private function requireAdmin(): void
    {
        if (!$this->authService->isLoggedIn()) {
            $_SESSION['error'] = 'please login to continue';
            $this->redirect('/login');
            return;
        }
        
        if (!$this->authService->hasRole('admin')) {
            $_SESSION['error'] = 'access denied, admin privileges required';
            $this->redirect('/dashboard');
            return;
        }
    }
    
    public function dashboard(): void
    {
        $this->requireAdmin();
        
        $data = [
            'total_users' => $this->userService->getUserCount(),
            'total_roles' => $this->roleService->getRoleCount(),
            'current_user' => $this->authService->getCurrentUser()
        ];
        
        require_once __DIR__ . '/../views/admin/dashboard.php';
    }
    
    private function redirect(string $path): void
    {
        header("Location: $path");
        exit;
    }
}