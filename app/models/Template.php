<?php namespace app\models;

use Ngaji\Database\ActiveRecord;

class YourModel extends ActiveRecord {

    public function __construct($datamodel = []) {
        parent::__construct($datamodel);
    }

    public function tableName() {
        return 'your_table_name';
    }

    public function attributes() {
        return array(
            ['column_name', ['column_rule 1', 'column_rule n']],

            /*
             * Example
             */
            ['id', ['required', 'int', 'auto_increment']],
            ['username', ['required', 'min_length' => 4, 'max_length' => 25]],
            ['type', ['required', 'default' => '1']],
            /* Use identifier @ if default is SQL Command */
            ['created_at', ['nullable', 'default' => '@CURRENT_TIMESTAMP']]
        );
    }

    public function rules() {
        // TODO: Implement rules() method.
    }
}