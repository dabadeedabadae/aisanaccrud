<?php
/**
 * ChatBotWidget
 * 
 * Виджет чат-бота для приемной комиссии
 */
class ChatBotWidget extends CWidget
{
	/**
	 * URL для API чата
	 */
	public $apiUrl;
	
	/**
	 * Язык интерфейса
	 */
	public $language = 'ru';
	
	/**
	 * Инициализация виджета
	 */
	public function init()
	{
		parent::init();
		
		if ($this->apiUrl === null) {
			$this->apiUrl = Yii::app()->createUrl('chat/widgetConfig');
		}
	}
	
	/**
	 * Запуск виджета
	 */
	public function run()
	{
		$this->render('chatBotWidget', array(
			'apiUrl' => $this->apiUrl,
			'language' => $this->language,
		));
	}
}

