<?php namespace Ngaji\view;

/**
 * View
 *
 * @package Ngaji/View
 * @author  Ocki Bagus Pratama
 * @since   1.0.0
 */

use Exception;

class View {

    /**
     * Render the page
     * @param  string $file          template name
     * @param  array  $variables     variables data
     * @param  array  $template_tags null
     */
    public static function render($file, $variables = array(), $template_tags = array()) {
        try {

            $template = ABSPATH . '/app/views/' . strtolower($file) . '.php';
            if (!file_exists($template))
                throw new Exception('Template ' . $template . ' not found!');

            # set the default title as the name of the function being called
            if (!array_key_exists('title', $variables))
                $variables['title'] = ucfirst(debug_backtrace()[1]['function']);

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

    public static function makeHead() {
        ob_start();
        include(ABSPATH . "/template/head.php");
        $renderedView = ob_get_clean();

        return $renderedView;
    }

    public static function makeHeader() {
        ob_start();
        include(ABSPATH . "/template/header.php");
        $renderedView = ob_get_clean();

        return $renderedView;
    }

    public static function makeFooter() {
        ob_start();
        include(ABSPATH . "/template/footer.php");
        $renderedView = ob_get_clean();

        return $renderedView;
    }
}