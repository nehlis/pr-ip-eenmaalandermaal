<?php

namespace App\Services;

use App\Controllers\AccountController;
use App\Core\Router;
use Error;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService
{
    /**
     * @var AccountController $ac Account Controller which contains all functions related to accounts
     */
    private $ac;

    /**
     * AuthService constructor.
     */
    public function __construct()
    {
        $this->ac = new AccountController;
    }

    /**
     * Logins user into the platform
     * First checks if email exists and then matches the password. After saving 
     * needed data in session storage it redirects the user to either the referrer or profile page.
     * @param   string  $email      Emailaddress of the user
     * @param   string  $password   Password of the user   
     * @throws  Error               Throws error when password is incorrect.
     */
    public function login(string $email, string $password): void
    {
        $user = $this->ac->getByEmail($email);

        // password_verify(password_hash($password, PASSWORD_BCRYPT), $user['Password']);
        if (!isset($user) || $user['Password'] !== $password) {
            throw new Error('Wachtwoord onjuist!<hr> <a href="wachtwoord-vergeten" class="alert-link">Wachtwoord vergeten?</a>');
        }

        if ($user['Blocked'] !== 0) {
            throw new Error('Je bent geblokkeerd of je account is nog niet geactiveerd! Neem contact op met de <a href="#" class="alert-link">klantenservice</a>');
        }

        // TODO: Welke data is nodig door de site?
        $_SESSION['id']   = $user['ID'];
        $_SESSION['name'] = $user['Firstname'] . ' ' . $user['Lastname'];

        // Redirect after successfully login
        Router::redirect($_GET['referrer'] ?? '/profiel');
    }

    /**
     * Registers user to the database
     * First checks if email exists and then if the username exists 
     * @param   array $data   Associative array with all required user data
     * @return  
     */
    public function register($data)
    {
        $user = $this->ac->getByEmail($data['email']);
    }


    /**
     * Logs the current logged in user out.
     * @return void
     */
    public static function logout(): void
    {
        session_destroy();
        Router::redirect('/inloggen');
    }

    /**
     * HELPER FUNCTIONS
     */

    /**
     * Is Logged In - Check whether a user is logged in or not.
     * @return bool Returns TRUE if logged in and FALSE otherwise
     */
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['id']);
    }

    /**
     * Check Auth - Checks whether the user is authenticated. If not the user gets redirected to the login page.
     */
    public static function checkAuth(): void
    {
        if (!self::isloggedIn()) {
            Router::redirect("/inloggen?referrer={$_SERVER['REQUEST_URI']}");
        }
    }
}
