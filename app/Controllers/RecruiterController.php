<?php

class RecruiterController
{
    private AuthService $authService;
    
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    
    private function requireRecruiter(): array
    {
        if (!$this->authService->isLoggedIn()) {
            $_SESSION['error'] = 'please login to continue';
            $this->redirect('/login');
            exit;
        }
        
        $user = $this->authService->getCurrentUser();
        
        if (!$this->authService->hasRole('recruiter')) {
            $_SESSION['error'] = 'access denied, recruiter privileges required';
            $this->redirect('/dashboard');
            exit;
        }
        
        return $user;
    }
    
    public function dashboard(): void
    {
        $user = $this->requireRecruiter();
        
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