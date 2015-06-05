<?php namespace Ngaji\Database;

use Ngaji\Http\Response;
use PDO;
use PDOStatement;

/**
 * Class ActiveRecord
 * @package Ngaji\Database
 * @author Ocki Bagus Pratama
 * @since 1.0
 */
abstract class ActiveRecord extends Model {
    var $classModel;

    public function __construct($datamodel = []) {
        parent::__construct($datamodel);
    }

    /**
     * Save the new object models
     */
    public function save() {
        $sql = sprintf("INSERT INTO `%s`.`%s` (%s) VALUES (%s)",
            self::$dbName,
            static::tableName(),
            implode(', ', array_keys(static::attributes())),
            'NULL, :id, :post, now(), CURRENT_TIMESTAMP'
        );

        die($sql);

        self::query($sql);
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


    /**
     * Get all data!
     * @return PDOStatement: fetchAll query
     */
    public static function all() {

        # TODO
        if (self::hasRelations())
            $sql = self::makeRelations();
        else
            $sql = (new QueryBuilder)->select()->from(static::tableName());

        return self::query($sql);
    }

    /**
     * @param $param : the array('table-name' => 'value')
     * @param bool $action
     * @return mixed
     */
    public static function find($param, $action=false) {

        if (static::hasRelations())
            $command = self::makeRelations();
        else
            $command = (new QueryBuilder)->select()->from(static::tableName());

        $list = Array();
        $parameter = null;
        foreach ($param as $key => $value) {
            $list[] = "$key = :$key";
            $parameter .= ', ":' . $key . '":"' . $value . '"';
        }

        $command .= ' WHERE ' . implode(' AND ', $list);

        $json = "{" . substr($parameter, 1) . "}";
        $param = json_decode($json, true);

        $prepareStatement = self::query($command, $param);

        if ($action)
            return $prepareStatement;

        # if row columns more than 1
        if (1 < $prepareStatement->rowCount())
            return $prepareStatement->fetchAll();

        return $prepareStatement->fetch();
    }

    /**
     * Make the relation queries
     * @return string
     */
    public function makeRelations() {
        $belongs_to = self::hasRelations();
        $target_table = array_keys($belongs_to)[0];
        $target_domain = $belongs_to[$target_table];

        # select a.*, b.* from accounts a RIGHT join ustadzs b on a.id = b.account_id
        return sprintf("SELECT A.*, B.* FROM %s A LEFT JOIN %s B ON A.%s = B.%s",
            static::tableName(), $target_table, self::has_PK(), $target_domain
        );
    }

    /**
     * Get model data by them primary keys
     * @param $id : primary key ID
     * @return mixed
     */
    public static function findByPK($id) {
        if (false == self::has_PK())
            die(get_called_class() . " Has no Primary Key!");

        if (self::hasRelations())
            $sql = self::makeRelations();
        else
            $sql = (new QueryBuilder)->select()->from(static::tableName());

        $sql .= sprintf(" WHERE %s=%d", self::has_PK(), $id);
        $data = self::query($sql);

        return $data->fetch();
    }

    /**
     *
     * @param $id: primary key
     */
    public static function delete($id) {
        $sql = sprintf(
            "DELETE FROM `%s`.`%s`
            WHERE `%s` = :id", self::$dbName,
            static::tableName(),
            self::has_PK()
        );

        $bindArray = [
            ':id' => $id
        ];

        self::query($sql, $bindArray);
    }

    /**
     * Execute complex sql statements
     * @param $sql : sql query
     * @param $bindParam : an prepared bind arrays for specifict column
     * example array(':name' => 'wisrawa')
     * @return PDOStatement
     */
    public static function query($sql, $bindParam = NULL) {
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
        $data = self::find($param);

        # if no data are return
        if (empty($data))
            Response::render('app/views/404.php');

        return $data;
    }

    /**
     * @param $param
     * @param $page
     * @return mixed
     */
    public static function get_object_or_redirect($param, $page) {
        $data = self::find($param);

        if (empty($data))
            Response::redirect("/$page");

        return $data;
    }

    public static function getOrFail($param) {
        return self::get_object_or_404($param);
    }

    public static function getOrRedirect($param, $page) {
        return self::get_object_or_redirect($param, $page);
    }
}