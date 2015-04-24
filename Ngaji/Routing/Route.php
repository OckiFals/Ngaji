<?php namespace Ngaji\Routing;
/**
 * Author: Ocki Bagus Pratama
 * Date: 03/04/15
 * Time: 20:54
 */

use app\contollers\ApplicationController as Controller;
use app\contollers\ManagerController;
use app\contollers\WaitressController;
use Ngaji\Http\Response;


class Route {
    private $router;

    public function __construct($config = []) {
        $this->router = new AltoRouter();
        $this->router->setBasePath($config['hostname']);

        # Main routes
        $this->router->map('GET', '/', function () {
            Response::redirect('index.php');
        }, 'home');
        $this->router->map('GET', '/index.php', 'app\contollers\ApplicationController::index', 'home_home');

        $this->router->map('GET', '/profile', function () {
            # login required
            Controller::login_required()->profile();
        }, 'order');

        # Manager routes
        $this->router->map('GET', '/index.php/manage-menus', function () {
            ManagerController::manage_menus();
        });

        # Waitress routes
        $this->router->map('GET|POST', '/add-order',  function () {
            WaitressController::addOrder();
        }, 'add-order');

        $this->router->map('GET|POST', '/login', function () {
            Controller::login();
        }, 'login');
        $this->router->map('GET', '/logout', function () {
            Controller::logout();
        }, 'logout');
        
        # benchmark
        $this->router->map('GET', '/index.php/hello-world', function () {
            echo 'Hello Ngaji';
        });

    }

    public function getRoute() {
        return $this->router;
    }
}
