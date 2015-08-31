<?php namespace Ngaji\Base;

use Ngaji\Web\Validate;

/**
 * Class Model
 * @package Ngaji\Database
 * @author Ocki Bagus Pratama
 * @since 2.0
 */
abstract class Model extends Component {
    # model attributer
    protected $_attributes = [];
    # validate status of model attributes
    private $_isValid = false;
    # array of error message when validating model attributes
    private $_errors = [];
    # Ngaji\Web\Validate instance
    private $_validator;

    /**
     * Constructors.
     * @param array $modelData the data model array to be applied to this object.
     * @param array $config the configuration array to be applied to this object.
     */
    public function __construct($modelData = [], $config = []) {
        parent::__construct($config);
        $this->fillAttributes();
        $this->load($modelData);
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
     * Load attributes into object model
     * If attribute has default value, set that value currently
     * This method is invoked of the constructor after the object is initialized with the
     * defined attributes.
     * @see contructor
     */
    private function fillAttributes() {
        foreach (static::attributes() as $attribute) {
            if (count($attribute) !== 2)
                throw new \Exception("Attribute: `" . $attribute[0] . '` must have rules definiton on it!', 1);


            list($property, $rules) = $attribute;

            if (is_array($property)) {

            } else {
                if (array_key_exists('default', $rules)) {
                    $this->defineAttribute($property, $rules['default']);
                } else {
                    $this->defineAttribute($property, null);
                }
            }
        }
    }

    /**
     * Load property into object model
     * This method is invoked of the constructor after the object is initialized with the
     * given data.
     * @param array $modelData the data model array to be applied to this object.
     * @see contructor
     */
    public function load($modelData) {
        foreach ($modelData as $property => $value) {
            $this->{$property} = $value;
        }

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

    public function rules() {
        return [];
    }

    /**
     * Validate attributes.
     */
    public function validate() {
        # before validate callback
        $this->beforeValidate();
        $valid = true;
        # Iterate rules of definition
        foreach (static::attributes() as $attribute) {
            /*
             * array(
             *     ['id', ['required', 'int', 'auto_increment']],
             * );
             *
             * assign index 0 to $propertyName and index 1 to $scenario
             */
            list($propertyName, $scenario) = $attribute;
            # check if $rule is not an array object
            if (is_array($propertyName)) {

            } else {
                if (!is_array($scenario)) {
                    if (false === self::validateProperty(
                            $scenario, $this->{$propertyName}
                        )) {
                        $valid = false;
                        # write error data
                        $this->setError($propertyName, $scenario);
                    }
                } else {
                    # FIXME experimental
                    $is_ai = in_array('auto_increment', $scenario);
                    foreach ($scenario as $key => $filter_scenario) {
                        # ['required', ... ],
                        # index: 0 value 'required'
                        if (is_numeric($key)) {
                            if($is_ai && (('required' === $filter_scenario) ||
                                    ('int' === $filter_scenario) ||
                                    ('auto_increment' === $filter_scenario)
                                )) {
                                continue;
                            } else if (false === self::validateProperty(
                                    $filter_scenario, $this->{$propertyName}
                                )) {
                                $valid = false;
                                # write error data
                                $this->setError($propertyName, $filter_scenario);
                                break;
                            }
                        }
                        # ['max_length' => 14, ... ],
                        # index: 'max_length' value: 14
                        else {
                            if (false === self::validateProperty(
                                    $key, $this->{$propertyName}, $filter_scenario
                                )) {
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
        # after validate callback
        $this->afterValidate();
        # if validate was success, return validated data
        if ($valid) {
            $this->_isValid = true;
            return true;
        } # if validate failure, return false
        else {
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
        if (method_exists($this->_validator, $filter)) {
            return $this->_validator->{$filter}($value, $value2);
        } else if ('default' === $filter) {
            # TODO
            return true;
        } else {
            # if validate rules is function callback
            if (method_exists($this, $filter)) {
                return (call_user_func(
                    get_class($this) . '::' . $filter, $value)
                ) ? true : false;
            }
        }
        return false;
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
    public function getAttr($field) {
        foreach (static::attributes() as $attr) {
            if (in_array($field, $attr) || (is_array($attr[0]) && in_array($field, $attr[0]))) {
                return $attr[1];
            }
        }
        return false;
    }

    /**
     * Is the model has Primary Key?
     * @return mixed
     */
    public static function hasPK() {
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