<?php namespace Ngaji\Database;

use stdClass;

/**
 * An improved stdClass
 *
 * Class NgajiStdClass
 * @package Ngaji\Database
 * @author Ocki Bagus Pratama <ocki.bagus.p@gmail.com>
 * @since 2.1
 */
class NgajiStdClass extends stdClass {

    /**
     * Constructor.
     * The default implementation does two things:
     *
     * - Initializes the object with the given configuration `$config`.
     * - Call [[init()]].
     *
     * If this method is overridden in a child class, it is recommended that
     *
     * - the last parameter of the constructor is a configuration array, like `$config` here.
     * - call the parent implementation at the end of the constructor.
     *
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
	public function __construct($config=[]) {
        # $this->test = new $config['self'];
        if (!empty($config)) {
            # $table_name, $property, $self_domain, $target_domain
            $this->{$config['property']} = $this->getRelation(
                $config['target_table'],
                $config['self_domain'],
                $config['target_domain']
            );
        }

        $this->init();
	}

    /**
     * Initializes the object.
     * This method is invoked at the end of the constructor after the object is initialized with the
     * given configuration.
     */
    public function init() {

    }

    /**
     * Fetch relation object
     *
     * @param $table_name
     * @param $self
     * @param $target
     * @return mixed
     */
	private function getRelation($table_name, $self, $target) {
		$sql = (new QueryBuilder)
                ->select()
                ->from($table_name)
                ->where("{$self}=" . $this->{$target});

        return ActiveRecord::query($sql)
            ->fetchObject();
	}

    /**
     * Save new instance to database
     *
     * The default implementation does two things:
     *
     * - Create model class instace.
     * - Validate model property.
     * - If property valid, save as new record
     */
    public function save() {

    }

    /**
     * Delete a record with their PK
     */
    public function delete() {

    }
}