<?php namespace Ngaji\Routing;
/**
 * Author: Ocki Bagus Pratama
 * Date: 03/04/15
 * Time: 20:54
 */

use app\contollers\ApplicationController as Controller;
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

        

    }

    public function getRoute() {
        return $this->router;
    }
}
