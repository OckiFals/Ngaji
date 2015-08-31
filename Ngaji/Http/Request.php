<?php namespace Ngaji\Http;

use ArrayAccess;
use Ngaji\Base\Component;
use Ngaji\Base\UnknownPropertyException;

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
class Request extends Component implements ArrayAccess {
    const METHOD_HEAD = 'HEAD';
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_FILES = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_PATCH = 'PATCH';
    const METHOD_DELETE = 'DELETE';
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_OVERRIDE = '_METHOD';

    /**
     * Type of the user
     */
    const ADMIN = 1;
    const USTADZ = 2;
    const MEMBER = 3;
    # method call
    private $method_call;

    #  Location for overloaded data
    private $data = array();

    /**
     * @param string $method
     */
    public function __construct($method = '') {
        parent::__construct();
        if (isset($method)) {
            $this->method_call = $method;
        }
    }

    /**
     * Get HTTP method
     * @return mixed
     */
    public static function method() {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Get the GET request data
     *
     * Originally in PHP way, to gets the 'example' get data
     * we use $_GET['example']
     *
     * With this func. you can perform that action by 2 different way
     *
     * Usage:
     * Request::GET('example');
     * Or
     * Request::GET() to gets all $_GET data
     *
     * @param null $key post request key name
     * @return String|Request
     */
    public static function GET($key = null) {
        if ($key) {
            return (array_key_exists($key, $_GET)) ?
                $_GET[$key] : null;
        } else {
            # return alls data
            return $_GET;
        }
    }

    /**
     * Get the POST request data
     *
     * Originally in PHP way, to gets the 'example' post data
     * we use $_POST['example']
     *
     * With this func. you can perform that action by 2 different way
     *
     * Usage:
     * Request::POST('example');
     * Or
     * Request::POST() to gets all $_POST data
     *
     * @param null $key post request key name
     * @return String|Request
     */
    public static function POST($key = null) {
        if ($key) {
            return (array_key_exists($key, $_POST)) ?
                $_POST[$key] : null;
        } else {
            # return alls data
            return $_POST;
        }
    }

    /**
     * Get the FILES request data
     *
     * Originally in PHP way, to gets the 'example' file data
     * we use $_FILES['example']
     *
     * With this func. you can perform that action by 2 different way
     *
     * Usage:
     * Request::FILES('example', 'key');
     * Or
     * Request::FILES('example') to gets all $_FILES['example'] data
     *
     * @param $name
     * @param null $key post request key name
     * @return Request|String|null
     */
    public static function FILES($name, $key = null) {
        if ($key) {
            return (array_key_exists($key, $_FILES[$name])) ?
                $_FILES[$name][$key] : null;
        } else {
            return $_FILES[$name];
        }
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
     *
     * Usage:
     * Request::user(field);
     *
     * Fields:
     * id
     * username
     * name
     * type
     * type-display
     *
     * @param String $field
     * @return mixed array | string
     * @throws UnknownPropertyException if try to gets undefined user data
     */
    public static function user($field='') {

        if (!Request::is_authenticated())
            return false;

        $session = new Session();
        $user_data = explode('|', $session->get('id_account'));

        switch ($field) {
            case '':
                return $user_data;
            case 'id':
                return $user_data[0];
            case 'username':
                return $user_data[1];
            case 'name':
                return $user_data[2];
            case 'type':
                return $user_data[3];
            case 'type-display':
                if (1 === $user_data[3])
                    return 'Admin';
                else if (2 === $user_data[3])
                    return 'Ustadz';
                else
                    return 'Member';
            default:
                throw new UnknownPropertyException(
                    'Getting unknown property: `' . $field . '` when using Request::user'
                );
        }

    }

    /**
     * Is the request from Manager?
     * @return bool
     */
    public static function is_admin() {
        return 1 == self::user('type');
    }

    /**
     * Is the request from Ustadz?
     * @return bool
     */
    public static function is_ustadz() {
        return 2 == self::user('type');
    }

    /**
     * Is the request from Member?
     * @return bool
     */
    public static function is_member() {
        return 3 == self::user('type');
    }

    /**
     * Set variable value with magic set method
     * @param $name
     * @param $value
     */
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    /**
     * Get variable value with magic get method
     * @param $name
     * @return null if error
     */
    public function __get($name) {
        if ($this->method_call == self::METHOD_POST) {
            return (array_key_exists($name, $_POST)) ?
                $_POST[$name] : null;
        } else if ($this->method_call == self::METHOD_GET) {
            return (array_key_exists($name, $_GET)) ?
                $_GET[$name] : null;
        } else if ($this->method_call == self::METHOD_FILES) {
            return (array_key_exists($name, $_FILES)) ?
                $_FILES[$name] : null;
        } else if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
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