<?php

namespace App\Services;

use App\Core\Database;
use App\Controllers\AccountController;
use App\Controllers\PhonenumberController;
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
     * @var PhonenumberController $ac Account Controller which contains all functions related to accounts
     */
    private $pc;


    /**
     * @var Database Database to execute custom queries.
     */
    private $db;


    /**
     * AuthService constructor.
     */
    public function __construct()
    {
        $this->ac = new AccountController;
        $this->pc = new PhonenumberController;
        $this->db = new Database;
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

        try {
            $user = $this->ac->getByEmail($email);
        } catch (Error $error) {
            throw new Error('Email en wachtwoord combinatie niet bekend!<hr> <a href="wachtwoord-vergeten" class="alert-link">Wachtwoord vergeten</a> of <a href="/registreren" class="alert-link">Nieuw account aanmaken</a> ');
        }

        if (!password_verify($password, $user['Password'])) {
            throw new Error('Email en wachtwoord combinatie niet bekend!<hr> <a href="wachtwoord-vergeten" class="alert-link">Wachtwoord vergeten</a> of <a href="/registreren" class="alert-link">Nieuw account aanmaken</a> ');
        }

        if ($user['Blocked'] === 1) {
            throw new Error('Je bent geblokkeerd of je account is nog niet geactiveerd! Neem contact op met de <a href="#" class="alert-link">klantenservice</a>');
        }

        // TODO: Welke data is nodig door de site?
        $_SESSION['id']   = $user['ID'];
        $_SESSION['name'] = "{$user['Firstname']} {$user['Lastname']}";
        $_SESSION['isAdmin'] = $user['Admin'];
        $_SESSION['isSeller'] = $user['Seller'];


        // Redirect after successfully login
        Router::redirect($_GET['referrer'] ?? '/');
    }

    /**
     * Registers user to the database
     * First checks if email exists and then if the username exists
     * @param   array $data   Associative array with all required user data
     * @return  string
     */
    public function register(array $data): string
    {
        if ($this->ac->existsByColumn('Email', $data['Email'])) {
            throw new Error("Er is al een account gekoppeld aan {$data['Email']}");
        }

        if ($this->ac->existsByColumn('Username', $data['Username'])) {
            throw new Error("Er is al een account gekoppeld aan {$data['Username']}");
        }

        try {
            // Extract phonenumbers
            $phonenumbers = $data['Phonenumbers'];
            unset($data['Phonenumbers']);

            // Hash password
            $data['Password'] = password_hash($data['Password'], PASSWORD_BCRYPT);

            $user = $this->ac->create($data);

            // Register phonenumbers
            foreach ($phonenumbers as $key => $value) {
                $this->pc->create(['AccountID' => $user['ID'], 'Phonenumber' => $value]);
            }
        } catch (Error $error) {
            throw new Error("Kon niet registreren!");
        }

        return "Account geregistreerd. Neem contact op met beheerder om je account te activeren!";
    }


    /**
     * Logs the current logged in user out.
     * @return void
     */
    public static function logout(): void
    {
        session_destroy();
        Router::redirect('/');
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
     * Is Seller - Check if user is a seller.
     * @return bool Returns TRUE if user is a seller and FALSE otherwise.
     */
    public static function isSeller(): bool
    {
        return isset($_SESSION['isSeller']) && $_SESSION['isSeller'];
    }

    /**
     * Is Admin - Check if user is a Admin.
     * @return bool Returns TRUE if user is a Admin and FALSE otherwise.
     */
    public static function isAdmin(): bool
    {
        return isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'];
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
