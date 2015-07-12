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
        $this->router->setCustomRoute($config['route']);
        $this->router->map();
    }

    public function getRoute() {
        return $this->router;
    }

    public function execute() {
    	call_user_func_array(
            $this->router->getController() . '::' . $this->router->getMethod() , 
                $this->router->getParam()
        );
    }
}