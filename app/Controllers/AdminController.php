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
    
    public function dashboard(): void
    {
        $data = [
            'total_users' => $this->userService->getUserCount(),
            'total_roles' => $this->roleService->getRoleCount(),
            'current_user' => $this->authService->getCurrentUser()
        ];
        
        require_once __DIR__ . '/../views/admin/dashboard.php';
    }
    
    public function listUsers(): void
    {
        $data = [
            'users' => $this->userService->getAllUsers(),
            'current_user' => $this->authService->getCurrentUser()
        ];
        
        require_once __DIR__ . '/../views/admin/users.php';
    }
    
    public function listRoles(): void
    {
        $data = [
            'roles' => $this->roleService->getAllRoles(),
            'current_user' => $this->authService->getCurrentUser()
        ];
        
        require_once __DIR__ . '/../views/admin/roles.php';
    }
    
    private function redirect(string $path): void
    {
        header("Location: $path");
        exit;
    }
}