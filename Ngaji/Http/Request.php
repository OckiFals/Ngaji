<?php namespace Ngaji\Http;

use ArrayAccess;
/**
 * Ngaji HTTP Request
 *
 * This class provides a human-friendly interface to the Ngaji environment variables;
 * environment variables are passed by reference and will be modified directly.
 *
 * @package App/Ngaji/Http
 * @author  Ocki Bagus Pratama
 * @since   2.0.0
 */
class Request implements ArrayAccess {
    const METHOD_HEAD = 'HEAD';
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_PATCH = 'PATCH';
    const METHOD_DELETE = 'DELETE';
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_OVERRIDE = '_METHOD';

    /**
     * Get HTTP method
     * @return mixed
     */
    public static function method() {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Is the GET request?
     * @return bool
     */
    public static function GET() {
        return self::method() === self::METHOD_GET;
    }

    /**
     * Is the POST request?
     * @return bool
     */
    public static function POST() {
        return self::method() === self::METHOD_POST;
    }

    /**
     * Is the HEAD request?
     * @return bool
     */
    public static function HEAD() {
        return self::method() === self::METHOD_HEAD;
    }

    /**
     * Is the request was authenticated?
     * @return bool
     */
    public static function is_authenticated() {
        return isset($_SESSION['id_account']);
    }

    /**
     * Shortcut to is_authenticated function
     * @return bool
     */
    public static function is_auth() {
        return self::is_authenticated();
    }

    /**
     * Get the session info
     * @return mixed: array and string
     */
    public static function get_user($field = false) {

        # if $field is not define, return all
        if (!$field) {
            return $_SESSION['id_account'];
        }
        # return the specific value of the _SESSION
        else {
            $user_data = explode('|', $_SESSION['id_account']);
            switch ($field) {
                case 'username':
                    $index = 1;
                    break;
                case 'name':
                    $index = 2;
                    break;
                case 'type':
                    $index = 3;
                    break;
                case 'type-display':
                    switch ($user_data[3]) {
                        case 1:
                            return "Manager";
                        case 2:
                            return "Chef";
                        case 3:
                            return "Waitress";
                        case 4:
                            return "Cashier";
                    }
                default:
                    $index = 0;
                    break;
            }
            return $user_data[$index];
        }
    }

    /**
     * Is the request from Manager?
     * @return bool
     */
    public static function is_manager() {
        return 1 == self::get_user('type');
    }

    /**
     * Is the request from Chef?
     * @return bool
     */
    public static function is_chef() {
        return 2 == self::get_user('type');
    }

    /**
     * Is the request from Waitress?
     * @return bool
     */
    public static function is_waitress() {
        return 3 == self::get_user('type');
    }

    /**
     * Is the request from Cashier?
     * @return bool
     */
    public static function is_cashier() {
        return 4 == self::get_user('type');
    }

    public static function REST() {
        $request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

//        switch ($this->method()) {
//            case 'PUT':
//                Rest($request);
//                break;
//            case 'POST':
//                rest_post($request);
//                break;
//            case 'GET':
//                rest_get($request);
//                break;
//            case 'HEAD':
//                rest_head($request);
//                break;
//            case 'DELETE':
//                rest_delete($request);
//                break;
//            case 'OPTIONS':
//                rest_options($request);
//                break;
//            default:
//                rest_error($request);
//                break;
//        }
    }


    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset) {
        // TODO: Implement offsetExists() method.
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset) {
        // TODO: Implement offsetGet() method.
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value) {
        // TODO: Implement offsetSet() method.
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public function offsetUnset($offset) {
        // TODO: Implement offsetUnset() method.
    }
}