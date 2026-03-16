<?php
class Controller extends CController
{
	public $layout='//layouts/column1';
	public $menu=array();
	public $breadcrumbs=array();
	public function init()
	{
		parent::init();
		$supportedLanguages = array('ru', 'kz', 'en');
		$request = Yii::app()->request;
		if (isset($_GET['lang']) && in_array($_GET['lang'], $supportedLanguages)) {
			$language = $_GET['lang'];
			Yii::app()->language = $language;
			Yii::app()->session['language'] = $language;
		}
		elseif (isset(Yii::app()->session['language']) && in_array(Yii::app()->session['language'], $supportedLanguages)) {
			Yii::app()->language = Yii::app()->session['language'];
		}
		else {
			Yii::app()->language = 'ru';
		}
	}
}