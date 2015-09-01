<?php namespace app\models;

use Ngaji\Database\ActiveRecord;

/**
 * Class Accounts
 * @package app\models
 * @property int $id
 * @property String $username
 * @property String $password
 * @property String $name
 * @property int $city
 */
class Accounts extends ActiveRecord {

    public function __construct($datamodel = []) {
        parent::__construct($datamodel);
    }

    public function tableName() {
        return 'accounts';
    }

    public function attributes() {
        return array(
            ['id', ['required', 'int', 'auto_increment']],
            ['username', ['required', 'string', 'max_length' => 80, 'validateUsername']],
            ['password', ['required', 'max_length' => 16]],
            ['name', ['required']],
            ['created_at', ['nullable', 'default' => '@CURRENT_TIMESTAMP']],
            ['city', ['nullable']],
            ['photo', ['nullable']]
        );
    }

    public function rules() {
        return array(
            'primary_key' => 'id',
            'belongs_to' => [
                'city@id' => 'city'
            ]
        );
    }

    /**
     * Function validate callback
     * @param  string $username get from validate property name(username)
     * @return bool
     */
    public function validateUsername($username) {
        if (Accounts::findOne(['username' => $username])) {
            $this->setError('username', 'username must be unique!');
            return false;
        }
        else {
            return true;
        }
    }
}