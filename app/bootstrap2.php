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
        $router = new Route($this->config);

        # TODO use pregex to handle client request
        # router2
        // $router2 = new Router2($this->config);

        # match the current request
        $match = $router->getRoute()->match();
        if ($match && is_callable($match['target'])) {
            call_user_func_array($match['target'], $match['params']);
        } else {
            # no route was matched
            header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
            echo "<h3>No Route was matched with</h3>";
            echo "<table>";
            echo "<tr>";
            echo "<th>Method</th>";
            echo "<th>Route</th>";
            echo "</tr>";
            // echo "<td>Controller</td>";
            foreach ($router->getRoute()->getRoutes() as $route) {
                print("<tr>");
                print("<td> $route[0] </td>");
                print("<td> $route[1] </td>");
                print("<tr>");
            }
            echo "</table>";
        }
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
                    throw new Exception('Class ' . $class . ' not found!');
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
    # TODO auto load class using this
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