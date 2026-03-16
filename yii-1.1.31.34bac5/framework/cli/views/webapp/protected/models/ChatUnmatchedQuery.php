<?php
/**
 * ChatUnmatchedQuery model
 * 
 * Модель для работы с непонятыми запросами
 * 
 * @property integer $id
 * @property integer $session_id
 * @property string $query_text
 * @property string $created_at
 * 
 * @property ChatSession $session
 */
class ChatUnmatchedQuery extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ChatUnmatchedQuery the static model class
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
		return '{{chat_unmatched_query}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('query_text, created_at', 'required'),
			array('session_id', 'numerical', 'integerOnly'=>true, 'allowEmpty'=>true),
			array('query_text', 'length', 'min'=>1),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'session' => array(self::BELONGS_TO, 'ChatSession', 'session_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'session_id' => 'Сессия',
			'query_text' => 'Текст запроса',
			'created_at' => 'Создано',
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
			return true;
		}
		else
			return false;
	}
}

