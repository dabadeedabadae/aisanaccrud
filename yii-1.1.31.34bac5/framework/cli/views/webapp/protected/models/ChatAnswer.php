<?php
/**
 * ChatAnswer model
 * 
 * Модель для работы с ответами бота
 * 
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $answer_html
 * @property string $language
 * @property integer $is_active
 * @property string $created_at
 * @property string $updated_at
 * 
 * @property ChatCategory $category
 * @property ChatPhrase[] $phrases
 * @property ChatAnswerStats[] $stats
 */
class ChatAnswer extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ChatAnswer the static model class
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
		return '{{chat_answer}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('category_id, title, answer_html, language, created_at, updated_at', 'required'),
			array('category_id', 'numerical', 'integerOnly'=>true),
			array('is_active', 'boolean'),
			array('title', 'length', 'max'=>255),
			array('language', 'length', 'max'=>5),
			array('answer_html', 'length', 'min'=>1),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'category' => array(self::BELONGS_TO, 'ChatCategory', 'category_id'),
			'phrases' => array(self::HAS_MANY, 'ChatPhrase', 'answer_id', 'order'=>'phrase_text ASC'),
			'stats' => array(self::HAS_MANY, 'ChatAnswerStats', 'answer_id'),
			'statsCount' => array(self::STAT, 'ChatAnswerStats', 'answer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category_id' => 'Категория',
			'title' => 'Название вопроса/темы',
			'answer_html' => 'HTML ответа',
			'language' => 'Язык',
			'is_active' => 'Активен',
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

	/**
	 * Получить популярность ответа (количество запросов)
	 * @return integer
	 */
	public function getPopularity()
	{
		return $this->statsCount;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('is_active',$this->is_active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'id DESC',
			),
		));
	}
}

