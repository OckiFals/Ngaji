<?php namespace app\models;

use Ngaji\Database\ActiveRecord;

class YourModel extends ActiveRecord {

    public function __construct($className=__CLASS__) {
        class_parents($className);
    }

    public function tableName() {
        return 'your_table_name';
    }

    public function attributes() {
        return array(
            # example attributes
            'id' => [
                'integer',
                'auto_increment',
                'primary_key'
            ],
            'name' => 'varchar_80',
            'slug' => 'varchar_80',
            'locality' => 'integer',
            'price' => 'double',
            'foto' => 'varchar_100'
        );
    }
}