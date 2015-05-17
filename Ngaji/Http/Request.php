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
 *
 * @property String username
 * @property String password
 * @property Integer id
 * @property Integer type
 * @property String type_display
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

    private static $method_call;

    #  Location for overloaded data
    private static $data = array();

    /**
     * Get HTTP method
     * @return mixed
     */
    public static function method() {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Is the GET request?
     *
     */
    public static function GET() {
        self::$method_call = self::METHOD_GET;
        return new Request();
    }

    /**
     * Is the POST request?
     *
     */
    public static function POST() {
        self::$method_call = self::METHOD_POST;
        return new Request();
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
        return (new Session)->has('id_account');
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
     * @param bool $field
     * @return mixed : array and string
     */
    public static function get_user($field = false) {

        $session = new Session();
        # if $field is not define, return all
        if (!$field) {
            return $session->get('id_account');
        } # return the specific value of the _SESSION
        else {
            $user_data = explode('|', $session->get('id_account'));
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
                            return "Admin";
                        case 2:
                            return "Member";
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
    public static function is_admin() {
        return 1 == self::get_user('type');
    }

    /**
     * Is the request from Chef?
     * @return bool
     */
    public static function is_member() {
        return 2 == self::get_user('type');
    }

    public static function user() {

        if (!Request::is_authenticated())
            die("There are no auth account!");

        $session = new Session();

        $data = explode('|', $session->get('id_account'));

        self::$data['id'] = $data[0];
        self::$data['username'] = $data[1];
        self::$data['name'] = $data[2];
        self::$data['type'] = $data[3];

        return new Request();
    }


    /**
     * Set variable value with magic set method
     * @param $name
     * @param $value
     */
    public function __set($name, $value) {
        # echo "Setting '$name' to '$value'\n";
        self::$data[$name] = $value;
    }

    /**
     * Get variable value with magic get method
     * @param $name
     * @return null if error
     */
    public function __get($name) {
        # echo "Getting '$name'\n";

        if (self::$method_call == self::METHOD_POST) {

            if (array_key_exists($name, $_POST))
                return $_POST[$name];

        } else if (self::$method_call == self::METHOD_GET) {

            if (array_key_exists($name, $_GET))
                return $_GET[$name];

        } else if (array_key_exists($name, self::$data)) {
            return self::$data[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
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