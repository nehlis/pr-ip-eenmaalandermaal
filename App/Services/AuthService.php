<?php

namespace App\Services;

use App\Controllers\AccountController;
use App\Core\Router;
use Error;

class AuthService
{
    /**
     * @var AccountController $ac Account Controller which contains all functions related to accounts
     */
    private $ac;

    public function __construct()
    {
        $this->ac = new AccountController();
    }

    /**
     * Login - First checks if email exists and then matches the password. After saving needed data in session storage it redirects the user to either the referrer or profile page.
     * @param   string  $email      Emailaddress of the user
     * @param   string  $password   Password of the user   
     * @throws  Error               Throws error when password is incorrect.
     */
    public function login(string $email, string $password): void
    {
        $user = $this->ac->getByEmail($email);

        // password_verify(password_hash($password, PASSWORD_BCRYPT), $user['Password']);
        if (isset($user) && $user['Password'] === $password) {
            // TODO: Welke data is nodig door de site?
            $_SESSION['ID'] = $user['ID'];
            $_SESSION['Name'] = $user['Firstname'] . ' ' . $user['Lastname'];

            // Redirect after successfully login
            if (isset($_GET['referrer'])) {
                Router::Redirect($_GET['referrer']);
            } else {
                Router::Redirect('/profiel');
            }
        } else {
            throw new Error('Wachtwoord onjuist!<hr> <a href="wachtwoord-vergeten" class="alert-link">Wachtwoord vergeten?</a>');
        }
    }

    /**
     * Logout - First destroys session then redirects the user to the login page.
     */
    public static function logout()
    {
        session_destroy();
        Router::Redirect('/inloggen');
    }

    /**
     * HELPER FUNCTIONS
     */

    /**
     * Is Logged In - Check whether a user is logged in or not.
     * @return bool Returns TRUE if logged in and FALSE otherwise
     */
    public static function isloggedIn(): bool
    {
        return isset($_SESSION['ID']);
    }

    /**
     * Check Auth - Checks whether the user is authenticated. If not the user gets redirected to the login page.
     */
    public static function checkAuth(): void
    {
        if (!AuthService::isloggedIn()) {
            Router::Redirect("/inloggen?referrer={$_SERVER['REQUEST_URI']}");
        }
    }
}
