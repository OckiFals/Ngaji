<?php namespace app\models;

use Ngaji\Database\ActiveRecord;

class Accounts extends ActiveRecord {

    public function __construct($className=__CLASS__) {
        class_parents($className);
    }

    public function tableName() {
        return 'accounts';
    }

    public function attributes() {
        return array(
            'id' => [
                'integer',
                'auto_increment',
                'primary_key'
            ],
            'username' => 'varchar_80',
            'password' => 'varchar_80',
            'name' => 'integer'
        );
    }

    public function rules() {
        // TODO: Implement rules() method.
    }
}