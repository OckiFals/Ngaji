<?php namespace app\controllers;

/**
 * ApplicationController
 *
 * Is a basic contoller for the app.
 * This perform basic actions that can be performed by all users
 * like access the index and login page.
 *
 * @package app/controllers
 * @author  Ocki Bagus Pratama
 * @date    14/02/15
 * @time    14:09
 * @since   1.0.0
 */

use Ngaji\Http\Request;
use Ngaji\Http\Response;
use Ngaji\Routing\Controller;
use app\models\Accounts;

# use Response::render() func. to include template without passing array data
class ApplicationController extends Controller {

    public static function index() {
        # if user was login before and session is still valid
        if (Request::is_authenticated()) {
            if (Request::is_manager()) {
                ManagerController::index();
            }
        } else {
            self::login();
            # Response::redirect('login');
        }
    }

    public static function profile($id) {
        # self::login_required();

        echo $id;
        # get id account from request header
        $id = Request::get_user('id');
        # fetch user data account
        $account = Accounts::findByPK($id);

        print_r($account);

        Response::render('hello profile');
    }

    public static function test($id=0) {
        echo 'test';
        print_r($id);
    } 

    public static function error404() {
        echo '404 Not Found';
    }
}
