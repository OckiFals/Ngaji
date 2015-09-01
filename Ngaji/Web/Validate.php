<?php namespace Ngaji\Web;

/**
 * Validate
 *
 * @package Ngaji/web
 * @author  Ocki Bagus Pratama
 * @since   2.1
 */

class Validate {
    public function __construct() {

    }

    /**
     * Validate $value of property is not null
     * @param  mixed  $value
     * @return boolean
     */
    public function required($value) {
        $callback = function ($value) {
            if (!empty($value)) {
                return $value;
            } else {
                return false;
            }
        };

        $options = array(
            'options' => $callback
        );

        return (filter_var($value, FILTER_CALLBACK, $options)) ? true : false;
    }

    /**
     * Let nullable
     * @return bool true
     */
    public function nullable() {
        return true;
    }

    /**
     * Check that $value of property is valid numeric
     * @param  mixed  $value
     * @return boolean
     */
    public function numeric($value) {
        return is_numeric($value);
    }

    /**
     * Check that $value of property is valid int
     * @param  mixed  $value
     * @return boolean
     */
    public function int($value) {
        return (filter_var($value, FILTER_VALIDATE_INT)) ? true : false;
    }

    /**
     * Check that $value of property is valid float
     * @param  mixed  $value
     * @return boolean
     */
    public function float($value) {
        return (filter_var($value, FILTER_VALIDATE_FLOAT)) ? true : false;
    }

    /**
     * Check that $value of property is valid email
     * @param  mixed  $value
     * @return boolean
     */
    public function email($value) {
        return (filter_var($value, FILTER_VALIDATE_EMAIL)) ? true : false;
    }

    /**
     * Check that $value of property in range of minimum required(numeric)
     * @param  mixed  $value
     * @param  mixed  $value2
     * @return boolean
     */
    public function min_range($value, $value2) {
        if (is_numeric($value)) {
            return (
                (float)$value >= (float)$value2
            );
        } else {
            return false;
        }
    }

    /**
     * Check that $value of property in range of maximum required(numeric)
     * @param  mixed  $value
     * @param  mixed  $value2
     * @return boolean
     */
    public function max_range($value, $value2) {
        if (is_numeric($value)) {
            return (
                (float)$value <= (float)$value2
            );
        } else {
            return false;
        }
    }

    /**
     * Check that $value of property is minimum required(string)
     * @param  mixed  $value
     * @param  mixed  $value2
     * @return boolean
     */
    public function min_length($value, $value2) {
        $callback = function ($value, $value2) {
            if ($value2 <= strlen($value)) {
                return true;
            } else {
                return false;
            }
        };

        return (call_user_func($callback, $value, $value2)) ? true : false;
    }

    /**
     * Check that $value of property is maximum required(string)
     * @param  mixed  $value
     * @param  mixed  $value2
     * @return boolean
     */
    public function max_length($value, $value2) {
        $callback = function ($value, $value2) {
            if ($value2 >= strlen($value)) {
                return true;
            } else {
                return false;
            }
        };

        return (call_user_func($callback, $value, $value2)) ? true : false;
    }

    /**
     * Check that $value of property is valid IP address
     * @param  mixed  $value
     * @return boolean
     */
    public function ip($value) {
        return (filter_var($value, FILTER_VALIDATE_IP)) ? true : false;
    }

    /**
     * Check that $value of property is valid MAC address
     * @param  mixed  $value
     * @return boolean
     */
    public function mac($value) {
        return (filter_var($value, FILTER_VALIDATE_MAC)) ? true : false;
    }

    /**
     * Sanitize string input
     * @param $value
     * @return bool
     */
    public function string($value) {
        return (filter_var($value, FILTER_SANITIZE_ENCODED)) ? true : false;
    }
}