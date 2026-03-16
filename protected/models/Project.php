<?php
class Project extends CActiveRecord
{
	public $logoFile;
	public $screenshotFiles;
	
	public function tableName()
	{
		return '{{projects}}';
	}
	
	public function rules()
	{
		return array(
			array('title, description', 'required'),
			array('published', 'boolean'),
			array('title', 'length', 'max'=>255),
			array('logo', 'safe'),
			array('goals, developers, contacts', 'safe'),
			array('logoFile', 'file', 'types'=>'jpg, jpeg, png, gif, webp, svg', 'allowEmpty'=>true, 'maxSize'=>5242880),
			array('screenshotFiles', 'file', 'types'=>'jpg, jpeg, png, gif, webp', 'allowEmpty'=>true, 'maxSize'=>5242880, 'maxFiles'=>10),
			array('screenshots', 'safe'),
			array('created_at, updated_at', 'safe'),
			array('id, title, description, goals, developers, contacts, logo, screenshots, published, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Название',
			'description' => 'Описание',
			'goals' => 'Цели',
			'developers' => 'Разработчики',
			'contacts' => 'Контакты для сотрудничества',
			'logo' => 'Логотип',
			'logoFile' => 'Логотип (файл)',
			'screenshots' => 'Скриншоты',
			'screenshotFiles' => 'Скриншоты (файлы)',
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
			
			if(isset($_POST['Project']['logo']) && !empty($_POST['Project']['logo']) && strpos($_POST['Project']['logo'], 'data:') === 0)
			{
				$this->logo = $_POST['Project']['logo'];
			}
			elseif($this->logoFile instanceof CUploadedFile)
			{
				$fileContent = file_get_contents($this->logoFile->getTempName());
				$base64 = base64_encode($fileContent);
				$mimeType = $this->logoFile->getType();
				$this->logo = 'data:' . $mimeType . ';base64,' . $base64;
			}
			
			$screenshots = $this->getScreenshotsArray();
			
			$screenshotFiles = CUploadedFile::getInstancesByName('Project[screenshotFiles]');
			if(!empty($screenshotFiles))
			{
				foreach($screenshotFiles as $file)
				{
					if($file instanceof CUploadedFile)
					{
						$fileContent = file_get_contents($file->getTempName());
						$base64 = base64_encode($fileContent);
						$mimeType = $file->getType();
						$screenshots[] = 'data:' . $mimeType . ';base64,' . $base64;
					}
				}
			}
			
			if(!empty($screenshots))
			{
				$this->screenshots = json_encode($screenshots);
			}
			elseif($this->isNewRecord)
			{
				$this->screenshots = null;
			}
			
			return true;
		}
		return false;
	}
	
	public function deleteScreenshot($index)
	{
		$screenshots = $this->getScreenshotsArray();
		if(isset($screenshots[$index]))
		{
			unset($screenshots[$index]);
			$this->screenshots = !empty($screenshots) ? json_encode(array_values($screenshots)) : null;
			return $this->save(false);
		}
		return false;
	}
	
	public function getLogoUrl()
	{
		if(empty($this->logo))
			return null;
		
		if(strpos($this->logo, 'data:') === 0)
			return $this->logo;
		
		if(strpos($this->logo, '/') === 0)
			return Yii::app()->baseUrl . $this->logo;
		
		return $this->logo;
	}
	
	public function getScreenshotsArray()
	{
		if(empty($this->screenshots))
		{
			return array();
		}
		$screenshots = json_decode($this->screenshots, true);
		if(!is_array($screenshots))
		{
			return array();
		}
		
		$result = array();
		foreach($screenshots as $screenshot)
		{
			if(strpos($screenshot, 'data:') === 0)
			{
				$result[] = $screenshot;
			}
			elseif(strpos($screenshot, '/') === 0)
			{
				$result[] = Yii::app()->baseUrl . $screenshot;
			}
			else
			{
				$result[] = $screenshot;
			}
		}
		
		return $result;
	}
	
	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('published', $this->published);
		$criteria->order = 'created_at DESC';
		
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

