<?php namespace Ngaji\Database;

use Ngaji\Base\Component;
use Ngaji\Web\Validate;

/**
 * Class Model
 * @package Ngaji\Database
 * @author Ocki Bagus Pratama
 * @since 2.0
 */
abstract class Model extends Component {

    private $_attributes = [];
    private $_isValid = false;
    private $_errors=[];
    # Ngaji\Web\Validate instance
    private $_validator;


    /**
     * Constructors.
     * @param array $config the configuration array to be applied to this object.
     */
    public function __construct($config = []) {
        foreach (static::attributes() as $attribute) {
            list($property) = $attribute;

            if (is_array($property)) {

            } else {
                $this->_attributes[$property] = null;
            }
        }
        parent::__construct($config);
        $this->_validator = new Validate();
    }

    /**
     * Returns the fully qualified name of this class.
     * @return string the fully qualified name of this class.
     */
    public static function className() {
        return get_called_class();
    }

    /**
     * Initializes the object.
     * This method is invoked at the end of the constructor after the object is initialized with the
     * given configuration.
     */
    public function init() {
    }

    /**
     * @inheritdoc
     */
    public function __get($name) {
        if (array_key_exists($name, $this->_attributes)) {
            return $this->_attributes[$name];
        } else {
            return parent::__get($name);
        }
    }

    /**
     * @inheritdoc
     */
    public function __set($name, $value) {
        if (array_key_exists($name, $this->_attributes)) {
            $this->_attributes[$name] = $value;
        } else {
            parent::__set($name, $value);
        }
    }

    /**
     * @inheritdoc
     */
    public function __isset($name) {
        if (array_key_exists($name, $this->_attributes)) {
            return isset($this->_attributes[$name]);
        } else {
            return parent::__isset($name);
        }
    }

    /**
     * @inheritdoc
     */
    public function __unset($name) {
        if (array_key_exists($name, $this->_attributes)) {
            unset($this->_attributes[$name]);
        } else {
            parent::__unset($name);
        }
    }

    /**
     * Defines an attribute.
     * @param string $name the attribute name
     * @param mixed $value the attribute value
     */
    public function defineAttribute($name, $value = null) {
        $this->_attributes[$name] = $value;
    }

    /**
     * Undefines an attribute.
     * @param string $name the attribute name
     */
    public function undefineAttribute($name) {
        unset($this->_attributes[$name]);
    }

    public abstract function tableName();

    public abstract function attributes();

    public abstract function rules();

    /**
     * Validate attributes.
     */
    public function validate() {
        # before validate callback
        $this->beforeValidate();

        $valid = true;
        /*
         * Iterate rules of definition
         */
        foreach (static::attributes() as $attribute) {
            list($propertyName, $scenario) = $attribute;

            # check if $rule is not an array object
            if (is_array($propertyName)) {

            } else {
                if (!is_array($scenario)) {
                    if (false === self::validateProperty($scenario, $this->{$propertyName})) {
                        $valid = false;
                        # write error data
                        $this->setError($propertyName, $scenario);
                    }
                } else {
                    foreach ($scenario as $key => $filter_scenario) {
                        if (is_numeric($key)) {
                            if (false === self::validateProperty($filter_scenario, $this->{$propertyName})) {
                                $valid = false;
                                # write error data
                                $this->setError($propertyName, $filter_scenario);
                                break;
                            }
                        } else {
                            if (false === self::validateProperty($key, $this->{$propertyName}, $filter_scenario)) {
                                $valid = false;
                                # write error data
                                $this->setError($propertyName, [
                                    $key => $filter_scenario
                                ]);
                                break;
                            }
                        }
                    }
                }
            }
        }

        # if validate was success, return validated data
        if ($valid) {
            $this->_isValid = true;
            # afterValidate callback
            $this->afterValidate();

            return true;
        } # if validate failure, return false
        else {
            # afterValidate callback
            $this->afterValidate();
            return false;
        }
    }

    /**
     * before validate callback
     */
    public function beforeValidate() {

    }

    /**
     * before validate callback
     */
    public function afterValidate() {

    }

    /**
     * Validate each property
     * @param $filter
     * @param $value
     * @param string $value2
     * @return bool property validate
     */
    public function validateProperty($filter, $value, $value2 = '') {
        switch ($filter) {
            case 'required':
                return $this->_validator->required($value);
                break;
            case 'int':
                return $this->_validator->numeric($value);
                break;
            case 'float':
                return $this->_validator->float($value);
                break;
            case 'string':
                return $this->_validator->string($value);
                break;
            case 'email':
                return $this->_validator->email($value);
                break;
            case 'ip':
                return $this->_validator->ip($value);
                break;
            case 'mac':
                return $this->_validator->mac($value);
                break;
            case 'min_range':
                return $this->_validator->minRange($value, $value2);
                break;
            case 'max_range':
                return $this->_validator->maxRange($value, $value2);
                break;
            case 'min_length':
                return $this->_validator->minLength($value, $value2);
                break;
            case 'max_length':
                return $this->_validator->maxLength($value, $value2);
                break;
            default:
                if (method_exists($this, $filter)) {
                    return (call_user_func(
                        get_class($this) . '::' . $filter, $value)
                    ) ? true : false;
                }
                return false;
                break;
        }
    }

    /**
     * Is validate is failure and has error?
     * @return boolean
     */
    public function hasError() {
        return !empty($this->_errors);
    }

    /**
     * Set error info
     * @param string $scenario
     * @param string $reason
     */
    public function setError($scenario, $reason) {
        if (!array_key_exists($scenario, $this->_errors)) {
            $this->_errors[$scenario] = $reason;
        }
    }

    /**
     * Get all errors
     * @return array
     */
    public function getErrors() {
        return $this->_errors;
    }

    /**
     * Get model attributes
     * @param $field : column name
     * @return mixed: array or string
     */
    public function get_attr($field) {
        return static::attributes()[$field];
    }

    /**
     * Is the model has Primary Key?
     * @return mixed
     */
    public static function has_PK() {
        $attrs = static::rules();

        if (array_key_exists('primary_key', $attrs))
            return $attrs['primary_key'];
        else
            return false;
    }

    /**
     * Is the model has relations?
     */
    public static function hasRelations() {
        $attrs = static::rules();

        if (array_key_exists('belongs_to', $attrs))
            return $attrs['belongs_to'];
        else
            return null;
    }
}