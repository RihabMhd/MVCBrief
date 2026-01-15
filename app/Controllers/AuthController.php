<?php

class AuthController
{
    private AuthService $authService;
    private ValidatorService $validator;
    

    public function __construct(AuthService $authService, ValidatorService $validator)
    {
        $this->authService = $authService;
        $this->validator = $validator;
    }
    
   
    public function showLoginForm(): void
    {
   
        if ($this->authService->isLoggedIn()) {
            $this->redirect('/dashboard');
            return;
        }
        
        require_once __DIR__ . '/../views/auth/login.php';
    }
    
 
    public function login(): void
    {
    
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
            return;
        }
   
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
     
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'email and password are required';
            $this->redirect('/login');
            return;
        }
       
        $user = $this->authService->login($email, $password);
        
        if ($user) {
            $_SESSION['success'] = 'login successful';
            
      
            $this->redirectToDashboard($user['role_id']);
        } else {
            $_SESSION['error'] = 'invalid email or password';
            $this->redirect('/login');
        }
    }
    
  
    public function showRegisterForm(): void
    {
   
        if ($this->authService->isLoggedIn()) {
            $this->redirect('/dashboard');
            return;
        }
        
        require_once __DIR__ . '/../views/auth/register.php';
    }
    

    public function register(): void
    {
 
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/register');
            return;
        }
  
        $userData = [
            'name' => $_POST['name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'role_id' => $_POST['role_id'] ?? 2
        ];
        
  
        $passwordConfirm = $_POST['password_confirm'] ?? '';
        if ($userData['password'] !== $passwordConfirm) {
            $_SESSION['error'] = 'passwords do not match';
            $_SESSION['old'] = $userData;
            $this->redirect('/register');
            return;
        }
        
    
        $errors = $this->validator->validateUser($userData);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $userData;
            $this->redirect('/register');
            return;
        }

        $userId = $this->authService->register($userData);
        
        if ($userId) {
            $_SESSION['success'] = 'registration successful, please login';
            $this->redirect('/login');
        } else {
            $_SESSION['error'] = 'registration failed, email may already exist';
            $_SESSION['old'] = $userData;
            $this->redirect('/register');
        }
    }
    
  
    public function logout(): void
    {
        $this->authService->logout();
        $_SESSION['success'] = 'logged out successfully';
        $this->redirect('/login');
    }
    

    public function showChangePasswordForm(): void
    {

        if (!$this->authService->isLoggedIn()) {
            $this->redirect('/login');
            return;
        }
        
      
        require_once __DIR__ . '/../views/auth/change-password.php';
    }
    
  
    public function changePassword(): void
    {
   
        if (!$this->authService->isLoggedIn()) {
            $this->redirect('/login');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/change-password');
            return;
        }
  
        $oldPassword = $_POST['old_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
       
        if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
            $_SESSION['error'] = 'all fields are required';
            $this->redirect('/change-password');
            return;
        }
        
  
        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = 'new passwords do not match';
            $this->redirect('/change-password');
            return;
        }
        
       
        $validation = $this->validator->validatePasswordStrength($newPassword);
        if ($validation['strength'] === 'weak') {
            $_SESSION['error'] = 'password is too weak: ' . implode(', ', $validation['feedback']);
            $this->redirect('/change-password');
            return;
        }
        
      
        $user = $this->authService->getCurrentUser();
        

        $success = $this->authService->changePassword($user['id'], $oldPassword, $newPassword);
        
        if ($success) {
            $_SESSION['success'] = 'password changed successfully';
            $this->redirect('/dashboard');
        } else {
            $_SESSION['error'] = 'current password is incorrect';
            $this->redirect('/change-password');
        }
    }
    
    
    private function redirectToDashboard(int $roleId): void
    {
        switch ($roleId) {
            case 1: 
                $this->redirect('/admin/dashboard');
                break;
            case 2: 
                $this->redirect('/recruiter/dashboard');
                break;
            case 3: 
                $this->redirect('/candidate/dashboard');
                break;
            default: 
                $this->redirect('/login');
                break;
        }
    }
    

    private function redirect(string $path): void
    {
        header("Location: $path");
        exit;
    }
    
  
    private function getFlash(string $key): ?string
    {
        if (isset($_SESSION[$key])) {
            $message = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $message;
        }
        return null;
    }
}