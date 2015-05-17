<?php namespace Ngaji\Routing;
/**
 * Created by PhpStorm.
 * User: returnFALSE
 * Date: 17/05/15
 * Time: 22:47
 */

class Route2 {
    public $router;

    public function __construct($config = []) {
        $this->router = new Router2();
        $this->router->setBasePath($config['hostname']);
    }

    public function getRoute() {
        return $this->router;
    }
}