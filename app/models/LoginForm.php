<?php namespace app\models;

use Ngaji\Web\FormModel;

class LoginForm extends FormModel {

    public $username;
    public $password;

    public function rules() {
        return array(
            ['username', 'required'],
            ['password', 'required']
        );
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