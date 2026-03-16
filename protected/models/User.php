<?php
class User extends CActiveRecord
{
	public function tableName()
	{
		return 'tbl_user';
	}
	public function rules()
	{
		return array(
			array('username, password, email', 'required'),
			array('username', 'length', 'max'=>128),
			array('password', 'length', 'max'=>255),
			array('email', 'length', 'max'=>128),
			array('email', 'email'),
			array('username', 'unique', 'message'=>'Этот логин уже занят.'),
			array('email', 'unique', 'message'=>'Этот email уже занят.'),
			array('username, password, email, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}
	public function relations()
	{
		return array(
		);
	}
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Логин',
			'password' => 'Пароль',
			'email' => 'Email',
			'created_at' => 'Создан',
			'updated_at' => 'Обновлен',
		);
	}
	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->created_at = new CDbExpression('NOW()');
			}
			$this->updated_at = new CDbExpression('NOW()');
			if(!empty($this->password) && strlen($this->password) < 60)
			{
				$this->password = password_hash($this->password, PASSWORD_DEFAULT);
			}
			return true;
		}
		return false;
	}
	public function verifyPassword($password)
	{
		return password_verify($password, $this->password);
	}
	public static function findByUsername($username)
	{
		return self::model()->find('username=:username', array(':username'=>$username));
	}
}

