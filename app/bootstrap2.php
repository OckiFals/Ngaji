<?php
/**
 * Bootstrap2
 *
 * Start the app!
 *
 * @package App
 * @author  Ocki Bagus Pratama
 * @since   2.0.1
 */

use Ngaji\Database\Connection;
use Ngaji\Routing\Route;
use Ngaji\Routing\Route2;
use Ngaji\Routing\Router2;


class bootstrap2 {

    protected $config;

    public function __construct($config = null) {
        $this->config = $config;

        # test
        $autoloader = function ($class) {
            $this->__autoloader($class);
        };

        spl_autoload_register($autoloader);
    }

    public function setConfig($config = null) {
        $this->config = $config;
        return $this;
    }

    public function start() {
        # start PHP session
        session_start();

        $this->loadClasses();
        # FIXME
        # require('Ngaji/Routing/Router.php');

        # bind array $config ke class Connection
        Connection::setConfig($this->config['db']);

        # make a route
        $router = new Route2($this->config);
        $router->execute();
        
    }

    public function loadClasses() {
        $classes = $this->config['class'];
        $models = $this->config['models'];

        try {
            # load classes
            foreach ($classes as $class) {
                if (empty($class))
                    continue;

                if (file_exists($class))
                    require("$class");
                else
                    throw new Exception('Class ' . $class . ' not found! Check your settings.php');
            }

            # load models
            foreach ($models as $model) {
                if (empty($model))
                    continue;

                if (file_exists("app/models/{$model}.php"))
                    require("app/models/{$model}.php");
                else
                    throw new Exception('ModelClass ' . $model . ' not found!');
            }

        } catch (Exception $e) {
            die($e->getMessage());
            # die($e->getTraceAsString());
        }
    }

    /**
     * Load undefined class automatically
     * @since 2.0.1
     * @param $class : class name(automatic define by PHP)
     */
    public function __autoloader($class) {
        $full_class_path = sprintf('%s.php', str_replace('\\', '/', $class));
        if (file_exists($full_class_path))
            require($full_class_path);
        else {
            echo $full_class_path . "\n";
            echo "Class not found! \n";
            echo "use Ngaji/bla-bla \n";
        }
    }
}