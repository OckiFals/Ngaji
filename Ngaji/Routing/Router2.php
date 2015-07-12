<?php namespace Ngaji\Routing;
/**
 * @author Ocki Bagus Pratama
 * @since 2.0.1
 * Date: 17/05/15
 * Time: 22:11
 */

class Router2 {
    var $config;
    var $url;
    var $controller;
    var $method;

    public function __construct() {
        # parsing get method from the URL
        $this->url = $this->parseUrl();
    }

    public function map() {
        # get controller object
        $this->controller = $this->getController();
        # get method name
        $this->method = $this->getMethod();
    }

    public function getController(){
        $url = $this->url;
        # default controller
        $controller = explode('::', $this->config['route']['404'])[0];
        # if no url was given
        if (empty ($url)) {
            # get default controller on config
            $default = explode('::', $this->config['route']['default']);
            # set controller
            $controller = $default[0];
            # set this method for instance
            $this->method = (isset($default[1])) ? $default[1] : null;
        }
        # if custom route defined for this url
        else if(in_array($url[0], array_keys($this->config['route']))) {
            // FIXME
            # get default controller on config
            $route = explode('::', $this->config['route'][$url[0]]);
            # set controller
            $controller = $route[0];
            # set this method for instance
            $this->method = (isset($route[1])) ? $route[1] : null;
        }


        else if(in_array($_GET['url'], array_keys($this->config['route']))) {
            // FIXME
            # get default controller on config
            $route = explode('::', $this->config['route'][$_GET['url']]);
            # set controller
            $controller = $route[0];
            # set this method for instance
            $this->method = (isset($route[1])) ? $route[1] : null;
        }


        # if controller's file exist
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
        # default method
        $method = (isset($this->method)) ? $this->method :'index';

        # if method was spesified in the URL
        if(isset($url[1])){
            if(method_exists($controller, $url[1])){
                $method = $url[1];
            } else if(method_exists($controller, $this->method) and $this->method != 'index'){
                $method = $this->method;
            }else {
                $method = explode('::', $this->config['route']['404'])[1];
            }
        } else {
            # FIXME 
            # $method = explode('::', $this->config['route']['404'])[1];
        }
        return $method;
    }

    public function getParam() {
        # get extra parameter if it was spesified in the URL
        return $this->url ? array_slice($this->url, 2) : [];
    }

    private function parseUrl() {
        if(isset($_GET['url'])){
            #preg_match('/(?P<year>\d{4})-(?P<month>\d{2})-(?P<day>\d{2})/', $urlRequest);
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return '';
    }

    public function setCustomRoute($route) {
        $this->config['route'] = $route;
    }

    public function setBasePath($hostname) {
        $this->config['hostname'] = $hostname;
    }

    public function match() {
        
    }
}