<?php namespace app\models;

use Ngaji\Database\ActiveRecord;

class City extends ActiveRecord {
	public function tableName() {
		return 'city';
	}

	public function attributes() {
		return array(
			['id', ['required', 'int', 'auto_increment']],
			['name', ['required', 'string']
		);
	}

	public function rules() {
		return array(
			'primary_key' => 'id'
		);
	}
}