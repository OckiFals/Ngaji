<?php namespace Ngaji\Database;

class NgajiStdClass extends \stdClass {

	public function __construct($config=[]) {
		# $table_name, $property, $self_domain, $target_domain
		$this->{$config['property']} = $this->getRelation(
            $config['target_table'], $config['self_domain'], $config['target_domain']
        );
	}

	private function getRelation($table_name, $self, $target) {
		$sql = (new QueryBuilder)
                ->select()
                ->from($table_name)
                ->where("{$self}=" . $this->{$target});

        return ActiveRecord::query($sql)
            ->fetchObject();
	}
}