<?php namespace app\controllers;

/**
 * ApplicationController
 *
 * Is a basic contoller for the app.
 * This perform basic actions that can be performed by all users
 * like access the index and login page.
 *
 * @package app/controllers
 */

use app\models\LoginForm;
use Ngaji\Http\Request;
use Ngaji\Http\Response;
use Ngaji\Http\Session;
use Ngaji\Routing\Controller;
use Ngaji\view\View;
# use Response::render() func. to include template without passing array data
class ApplicationController extends Controller {

    public function index() {
        View::render('home');
    }

    public function login() {
        if ("POST" === Request::method()) {
            $form = new LoginForm;
            # loads all POST data
            $form->load(Request::POST());

            if ($form->validate() && self::auth($form->username, $form->password)) {
                /*
                 * auth using parent::auth
                 *
                 * Use $form->clean_data['key'] to escaping input data
                 * self::auth($form->clean_data['username'], $form->clean_data['password']);
                 */
                Response::redirect('');
            } else {
                # push a flash message
                Session::push('flash-message', 'Data yang Anda masukkan tidak valid!');

                View::render('login');
            }

        } else {
            $title = 'My Company Login';
            View::render('login', [
                'title' => $title
            ]);
        }
    }

    /**
     * Logout
     * @url /logout
     */
    public static function logout() {
        $session = new Session();

        if ($session->has('id_account'))
            $session->delete('id_account');

        $session->destroy();

        Response::redirect('');
    }

    public function test($id) {
        return "Test $id";
    }

    public function error404() {
        return '404 Not Found';
    }
}
