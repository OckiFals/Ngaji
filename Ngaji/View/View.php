<?php namespace Ngaji\view;

use Exception;
use Ngaji\Base\Component;

class View extends Component {
    static function render($file, $variables = array()) {
        try {
            $template = ABSPATH . '/view/' . strtolower($file) . '.php';

            if (!file_exists($template))
                $template = ABSPATH . '/app/views/' . strtolower($file) . '.php';
            elseif (!file_exists($template))
                throw new Exception('Template ' . $template . ' not found!');

            # extract each key into variables and assign the value with them
            extract($variables);

            ob_start();
            include_once($template);
            $renderedView = ob_get_clean();

            echo $renderedView;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    static function makeHead() {
        ob_start();
        include(ABSPATH . "/template/head.php");
        $renderedView = ob_get_clean();

        return $renderedView;
    }

    static function makeHeader() {
        ob_start();
        include(ABSPATH . "/template/header.php");
        $renderedView = ob_get_clean();

        return $renderedView;
    }

    static function makeFooter() {
        ob_start();
        include(ABSPATH . "/template/footer.php");
        $renderedView = ob_get_clean();

        return $renderedView;
    }
}