<?php
/**
 * ChatController
 * 
 * Контроллер для API чат-бота виджета
 */
class ChatController extends Controller
{
	/**
	 * @var ChatBotService
	 */
	private $_chatBotService;
	
	/**
	 * Инициализация контроллера
	 */
	public function init()
	{
		parent::init();
		$this->_chatBotService = new ChatBotService();
	}
	
	/**
	 * Фильтры доступа
	 */
	public function filters()
	{
		return array(
			// Убираем ajaxOnly для widgetConfig, чтобы работало через обычные GET запросы
			'ajaxOnly + send',
		);
	}
	
	/**
	 * Получить конфигурацию виджета (главное меню и приветствие)
	 */
	public function actionWidgetConfig()
	{
		$language = isset($_GET['language']) ? $_GET['language'] : 'ru';
		
		try {
			$response = array(
				'welcomeMessage' => $this->_chatBotService->getWelcomeMessage($language),
				'menuButtons' => $this->_chatBotService->getMainMenuButtons($language),
			);
		} catch (Exception $e) {
			// Если БД недоступна, возвращаем базовую конфигурацию
			$response = array(
				'welcomeMessage' => 'Здравствуйте! Я виртуальный помощник приемной комиссии СКУ им. М. Козыбаева. Чем могу помочь?',
				'menuButtons' => array(),
			);
		}
		
		header('Content-Type: application/json; charset=utf-8');
		echo CJSON::encode($response);
		Yii::app()->end();
	}
	
	/**
	 * Отправить сообщение от пользователя
	 */
	public function actionSend()
	{
		try {
			$sessionToken = isset($_POST['sessionToken']) ? $_POST['sessionToken'] : null;
			$message = isset($_POST['message']) ? trim($_POST['message']) : '';
			
			if (empty($sessionToken)) {
				// Генерируем новый токен, если его нет
				$sessionToken = $this->generateSessionToken();
			}
			
			if (empty($message)) {
				$this->sendJsonError('Сообщение не может быть пустым');
				return;
			}
			
			// Получаем или создаем сессию
			$session = $this->_chatBotService->getOrCreateSession($sessionToken);
			
			// Обрабатываем сообщение
			$result = $this->_chatBotService->handleUserMessage($session, $message);
			
			// Получаем все сообщения сессии для отображения
			$messages = ChatMessage::model()->findAllByAttributes(
				array('session_id' => $session->id),
				array('order' => 'created_at ASC')
			);
			
			$messagesData = array();
			foreach ($messages as $msg) {
				$messagesData[] = array(
					'sender' => $msg->sender,
					'text' => $msg->message_text,
					'created_at' => $msg->created_at,
				);
			}
			
			$response = array(
				'success' => true,
				'sessionToken' => $session->session_token,
				'type' => $result['type'],
				'messages' => $messagesData,
			);
			
			if (isset($result['answer_html'])) {
				$response['answer_html'] = $result['answer_html'];
			}
			
			if (isset($result['category'])) {
				$response['category'] = $result['category'];
			}
			
			if (isset($result['title'])) {
				$response['title'] = $result['title'];
			}
			
			header('Content-Type: application/json; charset=utf-8');
			echo CJSON::encode($response);
			Yii::app()->end();
		} catch (CDbException $e) {
			// Если БД недоступна, возвращаем базовый ответ
			$response = array(
				'success' => true,
				'sessionToken' => isset($sessionToken) ? $sessionToken : $this->generateSessionToken(),
				'type' => 'text',
				'messages' => array(
					array(
						'sender' => 'user',
						'text' => isset($message) ? $message : '',
						'created_at' => date('Y-m-d H:i:s'),
					),
					array(
						'sender' => 'bot',
						'text' => 'Извините, база данных временно недоступна. Пожалуйста, обратитесь в приемную комиссию по телефону: +7 (7172) 55-55-55',
						'created_at' => date('Y-m-d H:i:s'),
					),
				),
			);
			
			header('Content-Type: application/json; charset=utf-8');
			echo CJSON::encode($response);
			Yii::app()->end();
		}
	}
	
	/**
	 * Получить историю сообщений сессии
	 */
	public function actionGetHistory()
	{
		$sessionToken = isset($_GET['sessionToken']) ? $_GET['sessionToken'] : null;
		
		if (empty($sessionToken)) {
			$this->sendJsonError('Токен сессии не указан');
			return;
		}
		
		$session = ChatSession::model()->findByAttributes(array('session_token' => $sessionToken));
		
		if (!$session) {
			$this->sendJsonSuccess(array('messages' => array()));
			return;
		}
		
		$messages = ChatMessage::model()->findAllByAttributes(
			array('session_id' => $session->id),
			array('order' => 'created_at ASC')
		);
		
		$messagesData = array();
		foreach ($messages as $msg) {
			$messagesData[] = array(
				'sender' => $msg->sender,
				'text' => $msg->message_text,
				'created_at' => $msg->created_at,
			);
		}
		
		$this->sendJsonSuccess(array('messages' => $messagesData));
	}
	
	/**
	 * Генерация токена сессии
	 * @return string
	 */
	protected function generateSessionToken()
	{
		return md5(uniqid(rand(), true) . time() . (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ''));
	}
	
	/**
	 * Отправить JSON ответ с ошибкой
	 * @param string $message
	 */
	protected function sendJsonError($message)
	{
		header('Content-Type: application/json; charset=utf-8');
		echo CJSON::encode(array('success' => false, 'error' => $message));
		Yii::app()->end();
	}
	
	/**
	 * Отправить JSON ответ с успехом
	 * @param array $data
	 */
	protected function sendJsonSuccess($data = array())
	{
		$response = array_merge(array('success' => true), $data);
		header('Content-Type: application/json; charset=utf-8');
		echo CJSON::encode($response);
		Yii::app()->end();
	}
}

