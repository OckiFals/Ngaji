<?php namespace Ngaji\Routing;

use app\models\Accounts;
use Ngaji\Http\Request;
use Ngaji\Http\Response;
use Ngaji\view\View;

/**
 * Controller(Base)
 *
 * This is a simple controller class
 *
 * @package Ngaji/Routing
 * @author  Ocki Bagus Pratama
 * @since   1.0.0
 */
class Controller {

    public static function login() {
        # if user was login before and the session is still valid
        if (Request::is_authenticated()) {
            Response::redirect('index.php');
        } else if ("POST" == Request::method()) { # another way Request::POST()
            $nama = $_POST['username'];
            $pass = $_POST['password'];

            # auth by controller class
            $auth = self::auth($nama, $pass);

            if ($auth)
                Response::redirect('index.php');
            else
                View::render('login', ['message' => 'login-failure']);
        } else {
            View::render('login');
        }
    }

    public static function logout() {
        session_start();

        if (isset($_SESSION['id_account']))
            unset($_SESSION['id_account']);

        session_destroy();
        Response::redirect('index.php');
    }

    /**
     * Use this function for authenticated member and ustadz
     * if the authenticated is failure, the user will be redirect to
     * warning page that they can input username and pass again
     *
     * @param $username : username user
     * @param $password : password user
     * @return bool
     */
    public static function auth($username, $password) {

        $data = Accounts::find([
            'username' => $username,
            'password' => md5($password)
        ]);

        if ($data) { # validate was successed
            # Set a session ID
            $account = array($data['id'], $data['username'], $data['name'], $data['type']);
            $_SESSION['id_account'] = implode('|', $account);
            return TRUE;
        }

        # validate was failure
        return FALSE;
    }

    /**
     * Inspirate to login_required decorator in Django Python.
     * If user is not authenticated, redirect to front page
     * @return mixed : self instance
     */
    public static function login_required() {
        if (!Request::is_auth())
            Response::redirect('index.php');

        return new static;
    }

    public static function middleware($role) {
        $req_role = Request::get_user('type-display');
        $role = strcmp($role, strtolower($req_role));

        if ($role) die('403');
    }
}