<?php
namespace App\Controllers;
use App\Services\AuthService;

class RecruiterController
{
    private AuthService $authService;
    
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    
    public function dashboard(): void
    {
        $user = $this->authService->getCurrentUser();
        
        $data = [
            'user' => $user
        ];
        
        require_once __DIR__ . '/../views/recruiter/dashboard.php';
    }
    
    private function redirect(string $path): void
    {
        header("Location: $path");
        exit;
    }
}