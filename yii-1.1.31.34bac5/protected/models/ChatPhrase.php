<?php
/**
 * ChatPhrase model
 * 
 * Модель для работы с фразами/синонимами для поиска ответов
 * 
 * @property integer $id
 * @property integer $answer_id
 * @property string $phrase_text
 * @property string $language
 * @property string $created_at
 * 
 * @property ChatAnswer $answer
 */
class ChatPhrase extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ChatPhrase the static model class
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
		return '{{chat_phrase}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('answer_id, phrase_text, language, created_at', 'required'),
			array('answer_id', 'numerical', 'integerOnly'=>true),
			array('phrase_text', 'length', 'max'=>255, 'min'=>1),
			array('language', 'length', 'max'=>5),
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
			'phrase_text' => 'Текст фразы',
			'language' => 'Язык',
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

