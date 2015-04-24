<?php namespace Ngaji\Database;

use PDO;
use PDOStatement;

/**
 * Class ActiveRecord
 * @package Ngaji\Database
 * @author Ocki Bagus Pratama
 * @since 1.0
 */
abstract class ActiveRecord extends Connection {
    var $classModel = [];

    public function __construct() {
        /* FIXME */
    }

    /**
     * Name of the specifict table
     * Child must override this function
     * and return String: table name on the database
     * @return mixed
     */
    public abstract function tableName();

    public abstract function attributes();

    /**
     * Save the new object models
     */
    public function save() {

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
        $attrs = static::attributes();
        foreach ($attrs as $attr => $value) {
            if (is_array($value))
                $found = in_array('primary_key', $value);
            else
                continue; 
            //     $found = strcmp('primary_key', $value);
            
            if ($found) return $attr;
        }
        return false;
    }


    /**
     * Get all data!
     * @return PDOStatement: fetchAll query
     */
    public static function all() {
        $pdo = parent::connect();


        $sql = "SELECT * FROM " . static::tableName();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        parent::disconnect();
        return $pdo->query($sql);
    }

    /**
     * TODO tambahkan spesifik kalusa LIKE
     * @param $param : the array('table-name' => 'value')
     * @return mixed
     */
    public static function find($param) {
        $command = "SELECT * FROM " . static::tableName();

        $list = Array();
        $parameter = null;
        foreach ($param as $key => $value) {
            $list[] = "$key = :$key";
            $parameter .= ', ":' . $key . '":"' . $value . '"';
        }

        $command .= ' WHERE ' . implode(' AND ', $list);

        $json = "{" . substr($parameter, 1) . "}";
        $param = json_decode($json, true);

        $pdo = parent::connect();

        $prepareStatement = $pdo->prepare($command);
        $prepareStatement->execute($param);

        parent::disconnect();

        # if row columns greater than 1
        if (1 < $prepareStatement->rowCount())
            return $prepareStatement->fetchAll();

        return $prepareStatement->fetch();
    }

    /**
     * Get model data by them primary keys
     * @param $id : primary key ID
     * @return mixed
     */ 
    public static function findByPK($id) {
        if (false == static::has_PK())
            die(get_called_class() . " Has no Primary Key!");
        
        $pdo = parent::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM " . static::tableName() . " WHERE " . static::has_PK() . "=" . $id ;
        $data = $pdo->query($sql);

        parent::disconnect();
        return $data->fetch();
    }

    /**
     * Execute complex sql statements
     * @param $sql : sql query
     * @param $bindParam: an prepared bind arrays for specifict column
     * example array(':name' => 'wisrawa')
     * @return PDOStatement
     */
    public static function query($sql, $bindParam=NULL) {
        $pdo = parent::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (is_array($bindParam)) {
            $prepareStatement = $pdo->prepare($sql);
            $prepareStatement->execute($bindParam);
        } else {
            $prepareStatement = $pdo->query($sql);
        }

        parent::disconnect();
        return $prepareStatement;
    }

    public function count() {

    }

    /**
     * @param $param
     * @return mixed
     */
    public static function get_object_or_404($param) {
        $data = static::find($param);

        # if no data are return
        if (empty($data))
            header("Location: " . HOSTNAME . "/index.php");

        return $data;
    }

    /**
     * @param $param
     * @param $page
     * @return mixed
     */
    public static function get_object_or_redirect($param, $page) {
        $data = static::find($param);

        if (empty($data))
            header("Location: " . HOSTNAME . "/$page");

        return $data;
    }

    public static function getOrFail($param) {
        $self::get_object_or_404($param);
    }

    public static function getOrRedirect($param, $page) {
        $self::get_object_or_redirect($param, $page);
    }


    public function __toString() {
        return $this->tableName();
    }
}