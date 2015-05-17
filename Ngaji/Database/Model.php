<?php namespace Ngaji\Database;
/**
 * Class Model
 * @package Ngaji\Database
 * @author Ocki Bagus Pratama
 * @since 2.0
 */

abstract class Model extends Connection {
    private $dataModel;

    public function __construct($dataModel = []) {
        $this->dataModel = $dataModel;
    }

    public function __set($key, $value) {
        $this->dataModel[$key] = $value;
    }

    public function __get($key) {
        return $this->dataModel[$key];
    }

    public abstract function tableName();

    public abstract function attributes();

    public abstract function rules();

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