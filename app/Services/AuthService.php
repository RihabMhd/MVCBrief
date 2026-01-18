<?php
namespace App\Services;

use App\Repository\UserRepository;

class AuthService
{
    private UserRepository $userRepository;
    
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    public function login(string $email, string $password): ?array
    {
        $user = $this->userRepository->findByEmail($email);
        
        if (!$user || !password_verify($password, $user['password'])) {
            return null;
        }
        
        // Map role_id to role name
        $roleNames = [1 => 'admin', 2 => 'recruiter', 3 => 'candidate'];
        
        // Set session data with correct keys
        $_SESSION['user'] = [
            'id' => $user['id'],  // Use 'id' not 'user_id'
            'name' => $user['name'],
            'email' => $user['email'],
            'role_id' => $user['role_id'],
            'role' => $roleNames[$user['role_id']] ?? 'candidate'
        ];
        
        return $user;
    }
    
    public function register(array $userData): ?int
    {
        // Hash password
        $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
        
        return $this->userRepository->create($userData);
    }
    
    public function logout(): void
    {
        unset($_SESSION['user']);
        session_destroy();
    }
    
    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user']) && isset($_SESSION['user']['id']);
    }
    
    public function getCurrentUser(): ?array
    {
        // Return the user from session, or null if not logged in
        return $_SESSION['user'] ?? null;
    }
    
    public function changePassword(int $userId, string $oldPassword, string $newPassword): bool
    {
        $user = $this->userRepository->findById($userId);
        
        if (!$user || !password_verify($oldPassword, $user['password'])) {
            return false;
        }
        
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        return $this->userRepository->updatePassword($userId, $hashedPassword);
    }
}