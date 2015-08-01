<?php namespace Ngaji\Database;

use PDO;
use PDOStatement;
use Ngaji\Http\Response;
use Ngaji\Database\Connection as Database;

/**
 * Class ActiveRecord
 * @package Ngaji\Database
 * @author Ocki Bagus Pratama
 * @since 1.0
 */
abstract class ActiveRecord extends Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Save the new object models
     *
     */
    public function save() {

    }

    /**
     *
     * @param $id: primary key
     */
    public static function delete($id) {
        $sql = sprintf(
            "DELETE FROM %s WHERE %s=:id",
            static::tableName(), self::has_PK()
        );

        $bindArray = [
            'id' => $id
        ];

        self::query($sql, $bindArray);
    }

    /**
     * Get Models SQL Command
     * You can Override this func. if child model has complex SQL 
     */
    public function getSQL() {
        # TODO
        if (self::hasRelations())
            $sql = self::makeRelations();
        else
            $sql = (new QueryBuilder)
                ->select()
                ->from(static::tableName());

        return $sql;
    }

    /**
     * Get all data!
     * @return PDOStatement: fetchAll query
     */
    public static function all() {
        $sql = (new QueryBuilder)
                ->select()
                ->from(static::tableName());

        return self::query($sql)
            ->fetchAll(
                PDO::FETCH_CLASS, 'Ngaji\Database\NgajiStdClass', array([
                    'target_table' => 'accounts',
                    'property' => 'account',
                    'self_domain' => 'id',
                    'target_domain' => 'account_id'
                ]
            ));
    }

    /**
     * Find and get all rows data of the table
     * This will return records in a stdClass array
     * @param $param : the array('table-name' => 'value') or none
     * @return \stdClass array
     */
    public static function findAll($param) {
        $command = static::getSQL();
        
        if (is_array($param)) {
            $command .= self::get_where($param)['sql'];
            $param = self::get_where($param)['params'];
        } else { # if param is String or QueryBuilder instance
            $command .= $param;
            $param=[];
        }

        $prepareStatement = self::query($command, $param);

        return $prepareStatement
            ->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE);
    }

    /**
     * Find one record
     *
     * Uses:
     * 1. findOne(1)
     * equivalent to SELECT ... WHERE PK=1
     *
     * 2. findOne([
     *          'username' => 'john',
     *          'jobs' => [
     *              '!=' => 'PM'
     *           ],
     * ])
     * equivalent to SELECT ... WHERE `username`='john' AND `jobs` != 'PM'
     *
     * @param $param : the array('table-name' => 'value')
     * @return mixed
     */
    public static function findOne($param=null) {

        $command = static::getSQL();

        /*
         * Check if $param vars is an array object
         * Eg. $param = array('username' => 'john', 'jobs' => 'PM')
         */
        if (is_array($param)) {
            $sql_where = self::get_where($param);

            $command .= $sql_where['sql'];
            $param = $sql_where['params'];
        }
        /*
         * When $param is an integer, find by the PK
         */
        else if (is_numeric($param)) {
            $sql_where = self::get_where([
                self::has_PK() => $param
            ]);

            $command .= $sql_where['sql'];
            $param = $sql_where['params'];
        }
        /*
         * When $param is a String or a QueryBuilder instance
         */
        else {
            $command .= $param;
            $param=[];
        }

        /*
         * Fecth first row on these table
         */
        $prepareStatement = self::query($command, $param);

        return $prepareStatement->fetchObject();
    }

    /**
     * Build the query object by calling QuertBuilder class
     * By the ActiveRecord Model
     *
     * NO RELATIONS
     *
     * @return QueryBuilder
     */
    public static function find() {
        $dao = new QueryBuilder();
        $dao->select()
            ->from(static::tableName());

        return $dao;
    }

    /**
     * Make the relation queries
     * @return string
     */
    public function makeRelations() {
        /*
         * Get belongs_to relations from rules() func.
         */
        $belongs_to = self::hasRelations();

        /*
         * Separate string into an array with delimiter @
         * from foreign key target table(belongs_to rules)
         *
         * example:
         * ...
         *  'belongs_to' => [
         *     # Schedules.id => self.id
         *      schedules@id' => 'id'
         *  ]
         * ...
         *
         * Will produce:
         * array(
         *    [0] => 'schedules',
         *    [1] => 'id'
         * )
         *
         */
        $target_source = explode('@', array_keys($belongs_to)[0]);

        $target_table = $target_source[0];
        # if the domain name is defined, use that domain's name, 'id' otherwise  
        $target_domain = (array_key_exists(1, $target_source)) ? 
            $target_source[1] : 'id';

        # this table foreign key 
        $self_domain = $belongs_to[
            array_keys($belongs_to)[0]
        ];

        # eg: select a.*, b.* from accounts a RIGHT join ustadzs b on a.id = b.account_id
        return sprintf('SELECT `%1$s`.*, `%2$s`.* 
                FROM `%1$s` 
                LEFT JOIN `%2$s` 
                    ON `%1$s`.`%3$s` = `%2$s`.`%4$s`',
            static::tableName(), $target_table, $self_domain, $target_domain
        );
    }

    /**
     * Get where condition
     * @param $condition
     * @return array
     */
    public function get_where($condition) {
        $queryBuilder = new QueryBuilder();

        $queryBuilder->where($condition);

        return [
            'sql' => $queryBuilder->get_sql(),
            'params' => $queryBuilder->get_params()
        ];
    }

    /**
     * Execute complex sql statements
     * @param $sql : sql query
     * @param $bindParam : an prepared bind arrays for specifict column
     * example array(':name' => 'wisrawa')
     * @return PDOStatement
     */
    public static function query($sql, $bindParam = NULL) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $prepareStatement = null;

        try {
            if (is_array($bindParam)) {
                $prepareStatement = $pdo->prepare($sql);
                $prepareStatement->execute($bindParam);
            } else {
                $prepareStatement = $pdo->query($sql);
            }
        } catch(\Exception $e) {
            print_r($e);
        } finally {
            Database::disconnect();
        }

        return $prepareStatement;
    }

    public function count() {

    }

    /**
     * @param $param
     * @return \stdClass
     */
    public static function get_object_or_404($param) {
        $data = self::findOne($param);

        # if no data are return
        if (empty($data))
            Response::redirect('');

        return $data;
    }

    /**
     * @param $param
     * @param $page
     * @return \stdClass
     */
    public static function get_object_or_redirect($param, $page) {
        $data = self::findOne($param);

        if (empty($data))
            Response::redirect("$page");

        return $data;
    }

    /**
     * Shortcut to get_object_or_404
     * @param $param
     * @return \stdClass
     */
    public static function getOrFail($param) {
        return self::get_object_or_404($param);
    }

    /**
     * Shortcut to get_object_or_redirect
     * @param $param:
     * @param $page: redirect to?
     * @return \stdClass
     */
    public static function getOrRedirect($param, $page) {
        return self::get_object_or_redirect($param, $page);
    }

    public function __toString() {
        return $this->tableName();
    }
}