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
    private $pdo;

    /**
     * Make the instance of the object
     */
    public function __construct() {
        $this->pdo = Connection::connect();
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
                $list[] = "$key = :$key";
                $param .= ', ":' . $key . '":"' . $value . '"';
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
        $this->sql .= ' like ' . "'{$like}'";

        return $this;
    }

    /**
     * Execute the current $sql statements!
     * Use ->get(false) to return PDOStatement
     * Default ->get() will return array fetch/fetchAll
     * @param bool $fetch set false to return PDOStatement
     * @return array|mixed|\PDOStatement
     */
    public function get($fetch=true) {
        $prepareStatement = $this->pdo->prepare($this->sql);
        $prepareStatement->execute($this->param);

        if (!$fetch)
            return $prepareStatement;

        if (1 == $prepareStatement->rowCount())
            return $prepareStatement->fetch();

        return $prepareStatement->fetchAll();
    }

    /**
     * Count the current $sql query!
     * @return int
     */
    public function count() {
        $prepareStatement = $this->pdo->prepare($this->sql);
        $prepareStatement->execute($this->param);

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