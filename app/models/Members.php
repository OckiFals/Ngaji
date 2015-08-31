<?php namespace app\models;

use Ngaji\Database\ActiveRecord;

/**
 * Class Members
 *
 * @property int $account_id
 * @property string $city
 * @property int $age
 *
 * @package app\models
 * @author Ocki Bagus Pratama
 */
class Members extends ActiveRecord {

    public function __construct($className=__CLASS__) {
        parent::__construct();
        class_parents($className);
    }

    public function tableName() {
        return 'members';
    }

    public function attributes() {
        return array(
            ['account_id', ['required', 'int']],
            ['city', ['required', 'string', 'max_length' => 20]],
            ['age', ['required', 'int']],
        );
    }

    public function rules() {
        return array(
            'primary_key' => 'account_id',
            'belongs_to' => [
                'accounts@id' => 'account_id',
                'city@id' => 'city'
            ]
        );
    }
}