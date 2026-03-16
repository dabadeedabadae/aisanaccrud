<?php
class News extends CActiveRecord
{
	public $imageFile;
	public function tableName()
	{
		return '{{news}}';
	}
	public function rules()
	{
		return array(
			array('title, content', 'required'),
			array('excerpt', 'safe'),
			array('published', 'boolean'),
			array('title', 'length', 'max'=>255),
			array('image', 'safe'),
			array('slug', 'length', 'max'=>255),
			array('imageFile', 'file', 'types'=>'jpg, jpeg, png, gif, webp', 'allowEmpty'=>true, 'maxSize'=>5242880),
			array('created_at, updated_at', 'safe'),
			array('id, title, content, excerpt, image, slug, published, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}
		public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Название',
			'content' => 'Описание',
			'excerpt' => 'Краткое описание',
			'image' => 'Изображение (Base64)',
			'imageFile' => 'Фото',
			'slug' => 'URL (slug)',
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
			if(empty($this->slug))
			{
				$this->slug = $this->generateSlug($this->title);
			}
			if($this->imageFile instanceof CUploadedFile)
			{
				$fileContent = file_get_contents($this->imageFile->getTempName());
				$base64 = base64_encode($fileContent);
				$mimeType = $this->imageFile->getType();
				$this->image = 'data:' . $mimeType . ';base64,' . $base64;
			}
			return true;
		}
		return false;
	}
	private function generateSlug($title)
	{
		$slug = strtolower($title);
		$slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
		$slug = trim($slug, '-');
		$baseSlug = $slug;
		$counter = 1;
		while(self::model()->exists('slug=:slug', array(':slug'=>$slug)))
		{
			$slug = $baseSlug . '-' . $counter;
			$counter++;
		}
		return $slug;
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
	public function getImageUrl()
	{
		if(empty($this->image))
			return null;
		
		if(strpos($this->image, 'data:') === 0)
			return $this->image;
		
		if(strpos($this->image, '/') === 0)
			return Yii::app()->baseUrl . $this->image;
		
		return $this->image;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}