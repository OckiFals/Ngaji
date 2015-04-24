<?php
/**
 * Bootstrap
 *
 * Start the app!
 *
 * @package App
 * @author  Ocki Bagus Pratama
 * @since   1.0.0
 */

use app\contollers;
use Ngaji\Database\Connection;
use Ngaji\Routing\Route;

session_start();

class bootstrap {

    public static $config;

    public static function start() {

        # load config
        $config = include(__DIR__ . '/settings.php');
        self::$config = $config;

        self::loadClasses();

        # bind array $config ke class Connection
        Connection::setConfig(self::$config['db']);

        # make a route
        $router = new Route(self::$config);

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

    public static function loadClasses() {
        $classes = self::$config['class'];
        $models = self::$config['models'];

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
            echo $e->getMessage();
        }
    }
}