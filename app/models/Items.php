<?php namespace app\models;

use Ngaji\Database\ActiveRecord;

class Items extends ActiveRecord {

    public function __construct($className=__CLASS__) {
        class_parents($className);
    }

    public function tableName() {
        return 'items';
    }

    public function attributes() {
        return array(
            # example attributes
            'id' => [
                'integer',
                'auto_increment',
                'primary_key'
            ],
            'name' => 'text',
            'price' => 'real'
        );
    }

    public function rules() {
        // TODO: Implement rules() method.
    }
}