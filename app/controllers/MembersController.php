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
class MembersController extends Controller {

    public static function index() {
        Response::render('hello member');
    }

    public static function profile($id='') {
        Response::render('hello ' . $id);
    }

    public static function notFound404() {
        Response::render('404 not found');
    }
}
