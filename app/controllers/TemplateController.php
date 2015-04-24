<?php namespace app\contollers;
/**
 * Template Controller
 *
 * This is an example how to work
 * with Ngaji controller
 *
 * @package app/controllers
 * @author  Ocki Bagus Pratama
 * @since   1.0.0
 */

use Ngaji\Http\Response;
use Ngaji\Routing\Controller;

# use Response::render() func. to include template without passing array data
class YourController extends Controller {

    public static function index() {
        # use Response::render(string, false) to deactive HTML auto escaping
        Response::render('Hello World!');
    }

}
