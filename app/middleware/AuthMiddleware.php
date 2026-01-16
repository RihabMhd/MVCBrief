<?php
require_once './Middleware.php';
class AuthMiddleware implements Middleware
{

    public function handle($request, $next) {
        if(!$this->isAuthentication()){
            $this->unauthenticated();
        }
        return $next($request);
    }


    private function isAuthentication(): bool
    {
        return isset($_SESSION['user']);
    }

    private function unauthenticated()
    {
        header('Location: /public/auth/login');
        exit;
    }
}
