<?php namespace app\models;

use Ngaji\Web\FormModel;

class RegisterForm extends FormModel {

    public $name;
    public $username;
    public $password;
    public $city;

    public function rules() {
        return array(
            ['username', ['required', 'min_length' => 4, 'max_length' => 20,
                # callback $this->validateUsername()
                'validateUsername'
            ]],
            ['password', ['required', 'min_length' => 5, 'max_length' => 18]],
            ['name', 'required'],
            ['city', 'required']
        );
    }

    public function validateUsername($username) {
        $dataAccount = Accounts::findOne([
            'username' => $username
        ]);

        if ($dataAccount) {
            $this->setError('username', 'username must be unique');
            return false;
        } else {
            return true;
        }
    }

    /**
     * berforeValidate callback
     * inherit from parent
     */
    public function beforeValidate() {
        # write code here
    }

    /**
     * afterValidate callback
     * inherit from parent
     */
    public function afterValidate() {
        if ($this->isValid()) {
            # echo 'sukses';
        } else {
            # echo 'gagal';
        }
    }
}