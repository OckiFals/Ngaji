<?php namespace Ngaji\Web;

/**
 * FormModel
 *
 * @package Ngaji/web
 * @author  Ocki Bagus Pratama
 * @since   2.1
 */

use Ngaji\Base\Component;

class FormModel extends Component {

    private $is_valid = false;
    private $form_error=[];
    private $validator;

    /**
     * @param array $form_data
     */
    public function __construct($form_data = []) {
        parent::__construct();
        # Init. closure object
        $this->init();
        # load form_data if defined or null
        self::load($form_data);
        # create Validate instance
        $this->validator = new Validate();
    }

    /**
     * Initial. action when new closure object was created
     */
    public function init() {

    }

    /**
     * Basic rules, can inherit to child class
     * @return array array of rules
     */
    public function rules() {
        return array();
    }

    /**
     * Validate raw input
     * @return bool is valid?
     */
    public function validate() {
        # before validate callback
        $this->beforeValidate();

        $valid = true;
        # validate data
        #
        /*
         * Iterate rules of definition
         *
         * array (
         *    ['username', 'required'],
         *    ['email', ['required', 'email'] ]
         * )
         *
         */
        foreach ($this->rules() as $index => $rule) {
        	list($propertyName, $scenario) = $rule;

            # check if $rule is not an array object
        	if (!is_array($propertyName)) {
        		if (!is_array($scenario)) {
        			if (false === $this->getValidateFilter($scenario, $this->getData($propertyName))) {
        				$valid = false;
                    	# write error data
        				$this->setError($propertyName, $scenario);
        			}
        		} else {
        			foreach ($scenario as $key => $filter_scenario) {
        				if (is_numeric($key)) {
        					if (false === $this->getValidateFilter($filter_scenario, $this->getData($propertyName))) {
        						$valid = false;
                            	# write error data
        						$this->setError($propertyName, $filter_scenario);
        						break;
        					} 
        				} else {
        					if (false === $this->getValidateFilter($key, $this->getData($propertyName), $filter_scenario)) {
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
            $this->is_valid = true;
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
     * Load POST, GET, ENV, SERVER data
     * @param  array $form_data
     */
    public function load($form_data = []) {
        foreach ($form_data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * Before Validate action
     * @param callback|string $callback
     */
    public function beforeValidate($callback = '') {

    }

    /**
     * After Validate action
     * @param callback|string $callback
     */
    public function afterValidate($callback = '') {

    }

    /**
     * Get data
     * @param  string $name
     * @return mixed
     */
    public function getData($name) {
        if (property_exists($this, $name)) {
            return $this->{$name};
        } else {
            return null;
        }
    }

    /**
     * Get sanitized property
     * @param  string $name
     * @return mixed
     */
    public function clean_data($name) {
        if (property_exists($this, $name)) {
            return \Html::escape($this->{$name});
        } else {
            return null;
        }
    }

    /**
     * Get Validate Filter
     * @param  String|array $filter
     * @param  mixed $value form data
     * @param  mixed $value2 rule eg. min_length => 3
     * @return mixed
     */
    private function getValidateFilter($filter, $value, $value2 = '') {
        if (method_exists($this->validator, $filter)) {
            return $this->validator->{$filter}($value, $value2);
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
     * Is validate is success
     * @return boolean valid status
     */
    public function isValid() {
    	return $this->is_valid;
    }

    /**
     * Is validate is failure and has error?
     * @return boolean
     */
    public function hasError() {
        return !empty($this->form_error);
    }

    /**
     * Set error info
     * @param string $scenario
     * @param string $reason
     */
    public function setError($scenario, $reason) {
        if (!array_key_exists($scenario, $this->form_error)) {
            $this->form_error[$scenario] = $reason;
        }
    }

    /**
     * Get all errors
     * @return array 
     */
    public function getErrors() {
    	return $this->form_error;
    }
}