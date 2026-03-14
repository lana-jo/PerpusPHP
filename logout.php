<?php

declare(strict_types=1);

function logout(string $redirectTo = 'login.php'): never
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            name    : session_name(),
            value   : '',
            expires_or_options: time() - 42000,
            path    : $params['path'],
            domain  : $params['domain'],
            secure  : $params['secure'],
            httponly: true,
        );
    }

    session_destroy();

    header("Location: {$redirectTo}");
    exit();
}

logout();