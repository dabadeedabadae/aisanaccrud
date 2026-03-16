<?php
/**
 * ChatadminController
 * 
 * Админ-контроллер для управления базой знаний чат-бота и аналитики
 */
class ChatadminController extends Controller
{
	public $layout='//layouts/column2';
	
	/**
	 * Фильтры доступа
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	
	/**
	 * Правила доступа
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow all users (временно для тестирования)
				'users'=>array('*'),
			),
			// Для продакшена раскомментируйте:
			/*
			array('allow', // allow authenticated admin users
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->checkAccess("admin")',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
			*/
		);
	}
	
	/**
	 * Главная страница админки
	 */
	public function actionIndex()
	{
		$this->redirect(array('stats'));
	}
	
	/**
	 * Статистика чат-бота
	 */
	public function actionStats()
	{
		try {
			// Общая статистика сессий
			$totalSessions = ChatSession::model()->count();
			
			// Уникальные сессии за последние 30 дней
			$days = isset($_GET['days']) ? (int)$_GET['days'] : 30;
			$dateFrom = date('Y-m-d H:i:s', strtotime("-{$days} days"));
			$uniqueSessions = ChatSession::model()->count(array(
				'condition' => 'created_at >= :dateFrom',
				'params' => array(':dateFrom' => $dateFrom),
			));
			
			// Популярные ответы
			$popularAnswers = Yii::app()->db->createCommand()
				->select('a.id, a.title, a.category_id, c.title as category_title, COUNT(s.id) as request_count')
				->from('{{chat_answer}} a')
				->leftJoin('{{chat_answer_stats}} s', 's.answer_id = a.id')
				->leftJoin('{{chat_category}} c', 'c.id = a.category_id')
				->group('a.id')
				->order('request_count DESC')
				->limit(20)
				->queryAll();
			
			// Непонятые запросы (последние 50)
			$unmatchedQueries = ChatUnmatchedQuery::model()->findAll(array(
				'order' => 'created_at DESC',
				'limit' => 50,
			));
		} catch (CDbException $e) {
			// Если БД недоступна, показываем пустые данные
			$totalSessions = 0;
			$uniqueSessions = 0;
			$days = isset($_GET['days']) ? (int)$_GET['days'] : 30;
			$popularAnswers = array();
			$unmatchedQueries = array();
			
			Yii::app()->user->setFlash('error', 'База данных недоступна. Пожалуйста, проверьте подключение к MySQL.');
		}
		
		$this->render('stats', array(
			'totalSessions' => $totalSessions,
			'uniqueSessions' => $uniqueSessions,
			'days' => $days,
			'popularAnswers' => $popularAnswers,
			'unmatchedQueries' => $unmatchedQueries,
		));
	}
	
	// ========== CRUD для ChatCategory ==========
	
	/**
	 * Список категорий
	 */
	public function actionCategoryIndex()
	{
		$model = new ChatCategory('search');
		$model->unsetAttributes();
		if(isset($_GET['ChatCategory']))
			$model->attributes = $_GET['ChatCategory'];
		
		$this->render('category/index', array(
			'model' => $model,
		));
	}
	
	/**
	 * Просмотр категории
	 */
	public function actionCategoryView($id)
	{
		$this->render('category/view', array(
			'model' => $this->loadCategoryModel($id),
		));
	}
	
	/**
	 * Создание категории
	 */
	public function actionCategoryCreate()
	{
		$model = new ChatCategory;
		
		if(isset($_POST['ChatCategory']))
		{
			$model->attributes = $_POST['ChatCategory'];
			if($model->save())
				$this->redirect(array('categoryView', 'id'=>$model->id));
		}
		
		$this->render('category/create', array(
			'model' => $model,
		));
	}
	
	/**
	 * Редактирование категории
	 */
	public function actionCategoryUpdate($id)
	{
		$model = $this->loadCategoryModel($id);
		
		if(isset($_POST['ChatCategory']))
		{
			$model->attributes = $_POST['ChatCategory'];
			if($model->save())
				$this->redirect(array('categoryView', 'id'=>$model->id));
		}
		
		$this->render('category/update', array(
			'model' => $model,
		));
	}
	
	/**
	 * Удаление категории
	 */
	public function actionCategoryDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadCategoryModel($id)->delete();
			
			if(!isset($_GET['ajax']))
				$this->redirect(array('categoryIndex'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/**
	 * Загрузка модели категории
	 */
	protected function loadCategoryModel($id)
	{
		$model = ChatCategory::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	// ========== CRUD для ChatAnswer ==========
	
	/**
	 * Список ответов
	 */
	public function actionAnswerIndex()
	{
		$model = new ChatAnswer('search');
		$model->unsetAttributes();
		if(isset($_GET['ChatAnswer']))
			$model->attributes = $_GET['ChatAnswer'];
		
		$this->render('answer/index', array(
			'model' => $model,
		));
	}
	
	/**
	 * Просмотр ответа
	 */
	public function actionAnswerView($id)
	{
		$this->render('answer/view', array(
			'model' => $this->loadAnswerModel($id),
		));
	}
	
	/**
	 * Создание ответа
	 */
	public function actionAnswerCreate()
	{
		$model = new ChatAnswer;
		
		if(isset($_POST['ChatAnswer']))
		{
			$model->attributes = $_POST['ChatAnswer'];
			if($model->save())
			{
			// Сохранение фраз (разбиваем по строкам)
			if(isset($_POST['phrases']) && is_array($_POST['phrases']) && !empty($_POST['phrases'][0]))
			{
				$phrasesText = $_POST['phrases'][0];
				$phrasesArray = explode("\n", $phrasesText);
				foreach($phrasesArray as $phraseText)
				{
					$phraseText = trim($phraseText);
					if(!empty($phraseText))
					{
						$phrase = new ChatPhrase();
						$phrase->answer_id = $model->id;
						$phrase->phrase_text = $phraseText;
						$phrase->language = $model->language;
						$phrase->save();
					}
				}
			}
				$this->redirect(array('answerView', 'id'=>$model->id));
			}
		}
		
		$categories = ChatCategory::model()->findAll(array('order' => 'title ASC'));
		
		$this->render('answer/create', array(
			'model' => $model,
			'categories' => $categories,
		));
	}
	
	/**
	 * Редактирование ответа
	 */
	public function actionAnswerUpdate($id)
	{
		$model = $this->loadAnswerModel($id);
		
		if(isset($_POST['ChatAnswer']))
		{
			$model->attributes = $_POST['ChatAnswer'];
			if($model->save())
			{
				// Удаляем старые фразы
				ChatPhrase::model()->deleteAll('answer_id = :id', array(':id' => $model->id));
				
				// Сохраняем новые фразы (разбиваем по строкам)
				if(isset($_POST['phrases']) && is_array($_POST['phrases']) && !empty($_POST['phrases'][0]))
				{
					$phrasesText = $_POST['phrases'][0];
					$phrasesArray = explode("\n", $phrasesText);
					foreach($phrasesArray as $phraseText)
					{
						$phraseText = trim($phraseText);
						if(!empty($phraseText))
						{
							$phrase = new ChatPhrase();
							$phrase->answer_id = $model->id;
							$phrase->phrase_text = $phraseText;
							$phrase->language = $model->language;
							$phrase->save();
						}
					}
				}
				$this->redirect(array('answerView', 'id'=>$model->id));
			}
		}
		
		$categories = ChatCategory::model()->findAll(array('order' => 'title ASC'));
		$phrases = ChatPhrase::model()->findAllByAttributes(
			array('answer_id' => $model->id),
			array('order' => 'phrase_text ASC')
		);
		
		$this->render('answer/update', array(
			'model' => $model,
			'categories' => $categories,
			'phrases' => $phrases,
		));
	}
	
	/**
	 * Удаление ответа
	 */
	public function actionAnswerDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadAnswerModel($id)->delete();
			
			if(!isset($_GET['ajax']))
				$this->redirect(array('answerIndex'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/**
	 * Загрузка модели ответа
	 */
	protected function loadAnswerModel($id)
	{
		$model = ChatAnswer::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}

