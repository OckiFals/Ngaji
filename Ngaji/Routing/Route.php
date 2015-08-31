<?php namespace Ngaji\Routing;

use Ngaji\Web\HttpException;

/**
 * @author Ocki Bagus Pratama <ocki.bagus.p@gmail.com>
 * @package Ngaji\Routing
 * @since 2.1
 */

class Route {
    private $route;

    public function __construct($basePath) {
        $mux = new Mux;
        $mux->setBasePath($basePath);
        $mux->add("/", ['app\controllers\ApplicationController', 'index']);
        $mux->add("/test/:id", ['app\controllers\ApplicationController', 'test'], [
            'require' => ['id' => '\d+'],
            'default' => ['id' => 1]
        ]);

        $this->route = $mux->dispatch($_SERVER['REQUEST_URI']);
    }

    public function getRoute() {
        return $this->route;
    }

    public function execute() {
        if (NULL !== $this->getRoute())
            echo Executor::execute($this->getRoute());
        else
            throw new HttpException(404, 'The requested Page could not be found.');
    }
}
