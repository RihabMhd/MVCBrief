<?php

require_once './Middleware.php';

class RoleMiddleware implements Middleware
{
    private array $roles;

    public function __construct(array $roles)
    {
        $this->roles = $roles;
    }

    public function handle($request, $next)
    {
        $userRole = $this->getUserRole();

        if (!$this->hasRole($userRole, $this->roles)) {
            $this->unauthorized();
        }

        return $next($request);
    }

    private function getUserRole(): ?string
    {
        return $_SESSION['user']['role'] ?? null;
    }

    private function hasRole(?string $userRole, array|string $requiredRoles): bool
    {
        if (!$userRole) {
            return false;
        }

        if (is_string($requiredRoles)) {
            return $userRole === $requiredRoles;
        }

        return in_array($userRole, $requiredRoles);
    }

    private function unauthorized(): void
    {
        header('Location: /403');
        exit;
    }
}
