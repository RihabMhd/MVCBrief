<?php

class CandidateController
{
    private AuthService $authService;
    
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    
    private function requireCandidate(): array
    {
        if (!$this->authService->isLoggedIn()) {
            $_SESSION['error'] = 'please login to continue';
            $this->redirect('/login');
            exit;
        }
        
        $user = $this->authService->getCurrentUser();
        
        if (!$this->authService->hasRole('candidate')) {
            $_SESSION['error'] = 'access denied, candidate privileges required';
            $this->redirect('/dashboard');
            exit;
        }
        
        return $user;
    }
    
    public function dashboard(): void
    {
        $user = $this->requireCandidate();
        
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