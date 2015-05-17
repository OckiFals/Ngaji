<?php namespace Ngaji\Routing;
/**
 * Created by PhpStorm.
 * User: returnFALSE
 * Date: 17/05/15
 * Time: 22:11
 */

class Router2 {
    var $config;
    var $url;
    var $controller;
    var $method;

    public function __construct() {
        // parsing get method from the URL
        $this->url = $this->parseUrl();
        // get controller object
        $this->controller = $this->getController();
        // get method name
        $this->method = $this->getMethod();
    }

    public function getController(){
        $url = $this->url;
        // default controller
        $controller = 'notfound';
        // if no url was given
        if (empty ($url)) {
            $controller = 'Application' .'Controller';
        }
        // if controller's file exist
        else if(file_exists(ABSPATH . '/app/controllers/' . $url[0] . 'Controller.php')){
            $controller = $url[0] . 'Controller';
        }
        require_once ABSPATH . '/app/controllers/' . $controller . '.php';
        $controller = 'app\controllers\\' . $controller;
        return $controller;
    }

    public function getMethod(){
        $url = $this->url;
        $controller = $this->controller;
        // default method
        $method = 'index';
        // if method was spesified in the URL
        if(isset($url[1])){
            if(method_exists($controller, $url[1])){
                $method = $url[1];
            } else {
                $method = 'notfound';
            }
        }
        return $method;
    }

    public function getParam() {
        // get extra parameter if it was spesified in the URL
        return $this->url ? array_slice($this->url, 2) : [];
    }

    private function parseUrl() {
        if(isset($_GET['url'])){
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return '';
    }

    public function setBasePath($hostname) {
        $this->config['hostname'] = $hostname;
    }
}