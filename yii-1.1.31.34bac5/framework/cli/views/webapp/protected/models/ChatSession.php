<?php
/**
 * ChatSession model
 * 
 * Модель для работы с сессиями чата
 * 
 * @property integer $id
 * @property string $session_token
 * @property string $user_agent
 * @property string $ip_address
 * @property string $created_at
 * @property string $updated_at
 * 
 * @property ChatMessage[] $messages
 */
class ChatSession extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ChatSession the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{chat_session}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('session_token, created_at, updated_at', 'required'),
			array('session_token', 'length', 'max'=>64),
			array('session_token', 'unique'),
			array('user_agent', 'length', 'max'=>255),
			array('ip_address', 'length', 'max'=>45),
			array('session_token, user_agent, ip_address', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'messages' => array(self::HAS_MANY, 'ChatMessage', 'session_id', 'order'=>'created_at ASC'),
			'unmatchedQueries' => array(self::HAS_MANY, 'ChatUnmatchedQuery', 'session_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'session_token' => 'Токен сессии',
			'user_agent' => 'User Agent',
			'ip_address' => 'IP адрес',
			'created_at' => 'Создано',
			'updated_at' => 'Обновлено',
		);
	}

	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->created_at = date('Y-m-d H:i:s');
			}
			$this->updated_at = date('Y-m-d H:i:s');
			return true;
		}
		else
			return false;
	}
}

