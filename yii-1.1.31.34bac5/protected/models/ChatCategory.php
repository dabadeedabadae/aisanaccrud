<?php
/**
 * ChatCategory model
 * 
 * Модель для работы с категориями базы знаний
 * 
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $language
 * @property string $created_at
 * @property string $updated_at
 * 
 * @property ChatAnswer[] $answers
 */
class ChatCategory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ChatCategory the static model class
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
		return '{{chat_category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('slug, title, language, created_at, updated_at', 'required'),
			array('slug', 'length', 'max'=>50),
			array('slug', 'match', 'pattern'=>'/^[a-z0-9_-]+$/', 'message'=>'Slug может содержать только латинские буквы, цифры, дефисы и подчеркивания'),
			array('title', 'length', 'max'=>255),
			array('language', 'length', 'max'=>5),
			array('slug, title, language', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'answers' => array(self::HAS_MANY, 'ChatAnswer', 'category_id', 'order'=>'title ASC'),
			'activeAnswers' => array(self::HAS_MANY, 'ChatAnswer', 'category_id', 'condition'=>'is_active=1', 'order'=>'title ASC'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'slug' => 'Slug',
			'title' => 'Название',
			'language' => 'Язык',
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

