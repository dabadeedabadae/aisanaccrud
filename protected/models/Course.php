<?php
class Course extends CActiveRecord
{
	public function tableName()
	{
		return '{{courses}}';
	}
	public function rules()
	{
		return array(
			array('title, description, link', 'required'),
			array('published', 'boolean'),
			array('title', 'length', 'max'=>255),
			array('description', 'length', 'max'=>500),
			array('link', 'length', 'max'=>500),
			array('link', 'url'),
			array('created_at, updated_at', 'safe'),
			array('id, title, description, link, published, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Название курса',
			'description' => 'Описание',
			'link' => 'Ссылка на курс',
			'published' => 'Опубликовано',
			'created_at' => 'Дата создания',
			'updated_at' => 'Дата обновления',
		);
	}
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			$now = date('Y-m-d H:i:s');
			if($this->isNewRecord)
			{
				$this->created_at = $now;
			}
			$this->updated_at = $now;
			return true;
		}
		return false;
	}
	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('published',$this->published);
		$criteria->order = 'created_at DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}