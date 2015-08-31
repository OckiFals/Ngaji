<?php namespace app\models;

use Ngaji\Database\ActiveRecord;

class Accounts extends ActiveRecord {

    public function __construct($className=__CLASS__) {
        parent::__construct();
        class_parents($className);
    }

    public function tableName() {
        return 'accounts';
    }

    public function attributes() {
        return array(
            ['id', ['required', 'int', 'auto_increment']],
            ['username', ['required', 'string', 'max_length' => 80, 'validateUsername']],
            ['password', ['required', 'max_length' => 16]],
            ['name', 'required'],
            ['created_at', 'required']
        );
    }

    public function rules() {
        return array(
            'primary_key' => 'id'
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