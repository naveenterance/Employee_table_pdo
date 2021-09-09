<?php

/**
 * Auth
 */
class Auth
{

    /**
     * isLoggedIn
     *
     * @return void
     */
    public static function isLoggedIn()
    {
        return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
    }

    /**
     * requireLogin
     *
     * @return void
     */
    public static function requireLogin()
    {
        if (!(static::isLoggedIn())) {

            die("Unauthorised");

        }
    }

    /**
     * login
     *
     * @return void
     */
    public static function login()
    {
        session_regenerate_id(true);

        $_SESSION['is_logged_in'] = true;
    }

    /**
     * logout
     *
     * @return void
     */
    public static function logout()
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }
}