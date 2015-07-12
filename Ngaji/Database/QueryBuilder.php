<?php namespace Ngaji\Database;
/**
 * Class QueryBuilder
 *
 * Build your own SQL queries without model class!
 *
 * @package Ngaji\Database
 * @author Ocki Bagus Pratama
 * @since  2.0.1
 */

use PDO;

class QueryBuilder {
    private $sql = '';
    private $param = [];
    private $fetch = PDO::FETCH_CLASS;
    private $pdo;

    /**
     * Make the instance of the object
     */
    public function __construct() {
        $this->pdo = Connection::connect();
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Get the sql command
     * @return string
     */
    public function get_sql() {
        return $this->sql;
    }

    /**
     * Get the sql param
     * @return array
     */
    public function get_params() {
        return $this->param;
    }

    /**
     * @param string $field null for fect all columns
     * @return $this
     */
    public function select($field = '*') {
        if (is_array($field))
            $field = implode(', ', $field);

        $this->sql .= "SELECT $field ";
        return $this;
    }

    public function from($table) {
        $this->sql .= "FROM $table ";
        return $this;
    }

    public function where($condition) {
        if (is_array($condition)) {
            $list = Array();
            $param = null;
            foreach ($condition as $key => $value) {
                if (is_array($value)) {
                    /*
                     * Model::findOne[
                     *     ...
                     *     'type' = [
                     *          '!=' => 1
                     *      ],
                     *      ...
                     * ]
                     *
                     * SELECT ... FROM Model
                     *      ... WHERE ... `type` != 1
                     * LIMIT 1
                     */
                    $list[] = "$key " . array_keys($value)[0] . " :$key";

                    $param .= ', ":' . $key . '":"' . array_values($value)[0] . '"';
                } else {
                    $list[] = "$key = :$key";

                    $param .= ', ":' . $key . '":"' . $value . '"';
                }
            }

            $json = "{" . substr($param, 1) . "}";
            $this->param = json_decode($json, true);
            $this->sql .= ' WHERE ' . implode(' AND ', $list);
        } else {
            $this->sql .= ' WHERE ' . $condition;
        }

        return $this;
    }

    public function like($like) {
        $this->sql .= ' LIKE ' . "'{$like}'";

        return $this;
    }

    public function orderBy($criteria) {
        $this->sql .= ' ORDER BY ' . "'{$criteria}'";

        return $this;
    }

    public function asArray() {
        $this->fetch = PDO::FETCH_ASSOC;

        return $this;
    }

    /**
     * Execute the current $sql statements that return one record data!
     * @return array | \stdClass
     */
    public function getOne() {
        $prepareStatement = $this->pdo->prepare($this->sql);
        $prepareStatement->execute($this->param);

        Connection::disconnect();

        if ($this->fetch !== PDO::FETCH_CLASS) {
            if (1 == $prepareStatement->columnCount())
                return $prepareStatement->fetch(PDO::FETCH_COLUMN);
            return $prepareStatement->fetch($this->fetch);
        }

        return $prepareStatement->fetchObject();
    }

    /**
     * Execute the current $sql statements that return many records data!
     * @return array stdClass | array in array
     */
    public function getAll() {
        $prepareStatement = $this->pdo->prepare($this->sql);
        $prepareStatement->execute($this->param);

        # close connection
        Connection::disconnect();

        return $prepareStatement->fetchAll($this->fetch);
    }

    /**
     * Count the current $sql query!
     * @return int
     */
    public function count() {
        $prepareStatement = $this->pdo->prepare($this->sql);
        $prepareStatement->execute($this->param);

        # close connection
        Connection::disconnect();

        return $prepareStatement->rowCount();
    }

    /**
     * Return representated of the instance with $sql String
     * @return string
     */
    public function __toString() {
        return str_replace(array_keys($this->param), array_values($this->param), $this->sql);
    }
}