<?php
/**
 * ChatAnswerStats model
 * 
 * Модель для работы со статистикой популярности ответов
 * 
 * @property integer $id
 * @property integer $answer_id
 * @property string $requested_at
 * 
 * @property ChatAnswer $answer
 */
class ChatAnswerStats extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ChatAnswerStats the static model class
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
		return '{{chat_answer_stats}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('answer_id, requested_at', 'required'),
			array('answer_id', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'answer' => array(self::BELONGS_TO, 'ChatAnswer', 'answer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'answer_id' => 'Ответ',
			'requested_at' => 'Время запроса',
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
				$this->requested_at = date('Y-m-d H:i:s');
			}
			return true;
		}
		else
			return false;
	}
}

