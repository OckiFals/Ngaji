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

    public function __construct($modelData = []) {
        parent::__construct($modelData);
    }

    /**
     * Save the new object models
     *
     */
    public function save() {
        if ($this->validate()) {
            $bindArray = [];

            foreach ($this->_attributes as $attr => $value) {
                if(!empty($value)) {
                    $bindArray[':'.$attr] = $value;
                } else {
                    $rules = self::getAttr($attr);
                    if(array_key_exists('default', $rules)) {
                        $bindArray[':'.$attr] = $rules['default'];
                    } else {
                        $bindArray[':'.$attr] = NULL;
                    }

                }
            }

            $create = sprintf(
                "INSERT INTO `%s`(`%s`) VALUES(:%s)", static::tableName(),
                implode('`, `', array_keys($this->_attributes)),
                implode(', :', array_keys($this->_attributes))
            );

            echo "Query SQL yang dihasilkan \n";
            print $create;
            echo "\n\nPrepareStatement Bind Array  \n";
            print_r($bindArray);

            self::query($create, $bindArray)
                ->execute();
        } else {
            print_r($this->getErrors());
        }
    }

    /**
     *
     * @param $id : primary key
     */
    public static function delete($id) {
        $sql = sprintf(
            "DELETE FROM %s WHERE %s=:id",
            static::tableName(), self::hasPK()
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
        return (new QueryBuilder)
            ->select()
            ->from(static::tableName());
    }

    /**
     * Get all data!
     * @return PDOStatement: fetchAll query
     */
    public static function all() {
        if (self::hasRelations()) {
            $initial = self::getRelations();
        } else {
            $initial = [];
        }

        return self::query(self::getSQL())
            ->fetchAll(PDO::FETCH_CLASS, 'Ngaji\Database\NgajiStdClass', $initial);
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
            # get_where sql and param
            $get_where = self::get_where($param);

            $command .= $get_where['sql'];
            $param = $get_where['params'];
        } else { # if param is String or QueryBuilder instance
            $command .= $param;
            $param = [];
        }

        if (self::hasRelations()) {
            $initial = self::getRelations();
        } else {
            $initial = [];
        }

        $prepareStatement = self::query($command, $param);

        return $prepareStatement
            ->fetchAll(PDO::FETCH_CLASS, 'Ngaji\Database\NgajiStdClass', $initial);
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
    public static function findOne($param = null) {

        $command = static::getSQL();

        /*
         * Check if $param vars is an array object
         * Eg. $param = array('username' => 'john', 'jobs' => 'PM')
         */
        if (is_array($param)) {
            $param1 = [];
            $param2 = [];
            foreach ($param as $key => $value) {
                if (self::getAttr($key)) {
                    $param1[$key] = $value; 
                } else {
                    $param2[$key] = $value;
                }
            }

            # get_where sql and param
            $sql_where = self::get_where($param);

            $command .= $sql_where['sql'];
            $param = $sql_where['params'];

            var_dump($param1);
            var_dump($param2);
        } /*
         * When $param is an integer, find by their PK
         */
        else if (is_numeric($param)) {
            $sql_where = self::get_where([
                self::hasPK() => $param
            ]);

            $command .= $sql_where['sql'];
            $param = $sql_where['params'];
        } /*
         * When $param is a String or a QueryBuilder instance
         */
        else {
            $command .= $param;
            $param = [];
        }

        if (self::hasRelations()) {
            $initial = self::getRelations();
        } else {
            $initial = [];
        }

        /*
         * Fecth first row on these table
         */
        $prepareStatement = self::query($command, $param);

        return $prepareStatement
            ->fetchObject('Ngaji\Database\NgajiStdClass', $initial);
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
     * Return array config if models has relation defined
     * @return array
     */
    public function getRelations() {
        /*
         * Get belongs_to relations from rules() func.
         */
        $belongs_to = self::hasRelations();

        if (false !== $belongs_to) {
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

            /*
             * This statement does two things:
             *
             * - Remove 's' on string when the last of character $target_table contain 's'
             * - Or let $target_table has default defined value
             */
            $property = ('s' === $target_table[strlen($target_table)-1] ) ?
                'account' : $target_table;

            # if the domain name is defined, use that domain's name, 'id' otherwise
            $target_domain = (array_key_exists(1, $target_source)) ?
                $target_source[1] : 'id';

            # this table foreign key
            $self_domain = $belongs_to[array_keys($belongs_to)[0]];

            return array([
                'self' => get_called_class(),
                'target_table' => $target_table,
                'property' => $property,
                'self_domain' => $target_domain,
                'target_domain' => $self_domain
            ]);
        } else {
            return [];
        }
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
        } catch (\Exception $e) {
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
     * @param $param :
     * @param $page : redirect to?
     * @return \stdClass
     */
    public static function getOrRedirect($param, $page) {
        return self::get_object_or_redirect($param, $page);
    }

    public function __toString() {
        return $this->tableName();
    }
}