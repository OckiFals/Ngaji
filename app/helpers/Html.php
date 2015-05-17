<?php # namespace app/helpers;

/**
 * The lazy helper to work with HTML tags
 *
 * @package app/helpers
 * @author Ocki Bagus Pratama
 * @date 15/04/15
 * @since 2.0
 */
class Html {

    /**
     * HTML helper to include any script file
     * @param $uri : URI script
     * @param array $variables
     * @return string
     */
    public static function render($uri, $variables = array()) {
        if (file_exists(ABSPATH . "/$uri")) {
            extract($variables);

            ob_start();
            include_once(ABSPATH . "/$uri");
            $renderedView = ob_get_clean();

        } else {
            $renderedView =  htmlspecialchars($uri);
        }

        return $renderedView;
    }

    ############################# LOAD FILE ###############################
    /**
     * HTML helper to perform dynamically load resources
     * @param $type : file type
     * @param $fileName : file name
     * @param array $attr : attribute for images(if necessary)
     * @return string: HTML tags string
     */
    public static function load($type, $fileName, $attr = []) {
        $tags = "\n    ";
        if ("CSS" === strtoupper($type))
            $tags .= self::loadCSS($fileName);
        else if ("JS" === strtoupper($type))
            $tags .= self::loadJS($fileName);
        else if ("IMG" === strtoupper($type))
            $tags .= self::loadIMG($fileName, $attr);
        else
            $tags .= "<strong>Unknown file type $type!</strong>";

        $tags .= "\n";
        return $tags;
    }

    /**
     * If request for is a CSS file
     * Called by load function
     * @param $fileName : file name
     * @return string: HTML css tag string
     */
    private static function loadCSS($fileName) {
        $tags = '';
        if (file_exists(ABSPATH . "/assets/{$fileName}"))
            $tags = sprintf('<link rel="stylesheet" href="%s/%s">', HOSTNAME, "assets/{$fileName}");
        else if (file_exists(ABSPATH . "/assets/css/{$fileName}"))
            $tags = sprintf('<link rel="stylesheet" href="%s/%s">', HOSTNAME, "assets/css/{$fileName}");
        else
            print('<strong>CSS file is not found in ' . ABSPATH . "/assets/css/{$fileName}!</strong>");

        return $tags;
    }

    /**
     * If request for is a JavaScript file
     * Called by load function
     * @param $fileName : file name
     * @return string: HTML js tag string
     */
    private static function loadJS($fileName) {
        $tags = '';
        if (file_exists(ABSPATH . "/assets/$fileName"))
            $tags = sprintf('<script src="%s/%s" type="text/javascript"></script>', HOSTNAME, "assets/$fileName");
        else if (file_exists(ABSPATH . "/assets/js/$fileName"))
            $tags = sprintf('<script src="%s/%s" type="text/javascript"></script>', HOSTNAME, "assets/js/$fileName");
        else
            print('<strong>JS file is not found in ' . ABSPATH . "/assets/js/{$fileName}!</strong>");

        return $tags;
    }

    /**
     * If request for is an Image
     * Call by load function or call directly on the view
     * @param $fileName : name file
     * @param array $attrs : attributes of the image file
     * @return string: HTML image tag string
     */
    public static function loadIMG($fileName, $attrs = []) {
        if (file_exists(ABSPATH . "/assets/$fileName")) {
            /* <img src="<?= HOSTNAME ?>/assets/img/avatar.png" class="user-image" alt="User Image"/> */
            // $tags = sprintf('<img src="%s/%s" ', HOSTNAME, "assets/$fileName");
            $target = HOSTNAME . "/assets/$fileName";
        } else if (file_exists(ABSPATH . "/assets/img/$fileName")) {
            // $tags = sprintf('<img src="%s/%s" ', HOSTNAME, "assets/img/$fileName");
            $target = HOSTNAME . "/assets/img/$fileName";
        } else {
            print('<strong>Image file is not found in ' . ABSPATH . "/assets/img/{$fileName}!</strong>");
            return '';
        }

        $tags = "    ";
        $temp = '';

        if (is_array($attrs) and !empty($attrs)) {
            foreach ($attrs as $attr => $value) {
                if (is_array($value)) {
                    $temp .= $attr.'="'.implode(' ', $value);
                    $temp = rtrim($temp).'" ';
                } else {
                    $temp .= $attr.'="'.$value.'" ';
                }
            }
        }
        $tags .= sprintf('<img src="%s" %s>', $target, rtrim($temp));
        return $tags;
    }

    ############################# LOAD FILE ###############################

    ############################# LINK $ TYPOGRAFI #############################
    /**
     * A lazy way to work with HTML anchor
     * @param $target : link to?
     * @param $text : printed text
     * @param $attrs : array attributes(optional)
     * @return string : HTML anchor tag string
     */
    public static function anchor($target, $text, $attrs = []) {
        $tags = "    ";

        $temp = '';
        if (is_array($attrs) and !empty($attrs)) {
            foreach ($attrs as $attr => $value) {
                if (is_array($value)) {
                    $temp .= $attr.'="'.implode(' ', $value);
                    $temp = rtrim($temp).'" ';
                } else {
                    $temp .= $attr.'="'.$value.'" ';
                }
            }
        }

        $tags .= sprintf(
            '<a href="%s/%s" %s>%s</a>%s',
            HOSTNAME, ltrim($target, '/'), rtrim($temp), $text, "\n"
        );

        return $tags;
    }

    public static function span($text, $attrs=[]) {
        return sprintf('<span %s>%s</span>',
            self::genererate_properties($attrs), "\n",
            $text
        );
    }

    public static function italic($text, $attrs=[]) {
        return sprintf('<i %s>%s</i>',
            self::genererate_properties($attrs), "\n",
            $text
        );
    }

    public static function button($text, $attrs=[]) {
        return sprintf('<button %s>%s</button>',
            self::genererate_properties($attrs), "\n",
            $text
        );
    }

    ############################# /LINK $ TYPOGRAFI #############################

    ################################# FORM ###################################
    public static function form_begin($action='', $method='POST', $attrs = []) {
        return sprintf(
            '<form action=%s/%s method=%s %s>%s',
            HOSTNAME, $action, $method,
            self::genererate_properties($attrs), "\n"
        );
    }

    public static function form_end() {
        return '</form>';
    }

    ################################# /FORM ###################################
    private static function genererate_properties($attrs) {
        $temp = '';
        if (is_array($attrs) and !empty($attrs)) {
            foreach ($attrs as $attr => $value) {
                if (is_array($value)) {
                    $temp .= $attr.'="'.implode(' ', $value);
                    $temp = rtrim($temp).'" ';
                } else {
                    $temp .= $attr.'="'.$value.'" ';
                }
            }
        }

        return $temp;
    }
}