<?php

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

        if (!$user) {
            error_log("Login failed: User not found for email: " . $email);
            return null;
        }


        error_log("Stored hash: " . $user['password']);
        error_log("Hash length: " . strlen($user['password']));

        if (password_verify($password, $user['password'])) {
            unset($user['password']);
            $this->createSession($user);
            return $user;
        }

        error_log("Login failed: Password verification failed for email: " . $email);
        return null;
    }


    public function register(array $userData): int|false
    {
        if ($this->userRepository->findByEmail($userData['email'])) {
            return false;
        }

  
        $hashedPassword = password_hash($userData['password'], PASSWORD_BCRYPT);
        $userData['password'] = $hashedPassword;

        try {
            $userId = $this->userRepository->create($userData);
            return $userId;
        } catch (Exception $e) {
            return false;
        }
    }


    private function createSession(array $user): void
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role_id'] = $user['role_id'];
        $_SESSION['logged_in'] = true;
    }


    public function logout(): void
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        $_SESSION = [];


        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }


        session_destroy();
    }


    public function isLoggedIn(): bool
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }


    public function getCurrentUser(): ?array
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!$this->isLoggedIn()) {
            return null;
        }


        return $this->userRepository->findById($_SESSION['user_id']);
    }


    public function hasRole(string $roleName): bool
    {
        $user = $this->getCurrentUser();

        if (!$user) {
            return false;
        }


        $userWithRole = $this->userRepository->findByIdWithRole($user['id']);

        return $userWithRole && $userWithRole['role_name'] === $roleName;
    }


    public function changePassword(int $userId, string $oldPassword, string $newPassword): bool
    {

        $user = $this->userRepository->findById($userId);

        if (!$user) {
            return false;
        }


        if (!password_verify($oldPassword, $user['password'])) {
            return false;
        }


        return $this->userRepository->update($userId, ['password' => $newPassword]);
    }


    public function resetPassword(int $userId, string $newPassword): bool
    {
        return $this->userRepository->update($userId, ['password' => $newPassword]);
    }
}
