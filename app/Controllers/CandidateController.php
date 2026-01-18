<?php
namespace App\Controllers;
use App\Services\AuthService;

class CandidateController
{
    private AuthService $authService;
    
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    
    public function dashboard(): void
    {
        // No need to check role here - RoleMiddleware already did it
        $user = $this->authService->getCurrentUser();
        
        $data = [
            'user' => $user
        ];
        
        require_once __DIR__ . '/../views/candidate/dashboard.php';
    }
    
    private function redirect(string $path): void
    {
        header("Location: $path");
        exit;
    }
}