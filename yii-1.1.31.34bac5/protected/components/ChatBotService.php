<?php
/**
 * ChatBotService
 * 
 * Сервис для работы с чат-ботом приемной комиссии
 */
class ChatBotService
{
	/**
	 * Контакты приёмной комиссии
	 */
	public $admissionOfficePhone = '+7 (7172) 55-55-55';
	public $admissionOfficeEmail = 'admission@sku.edu.kz';
	
	/**
	 * Получить или создать сессию по токену
	 * @param string $sessionToken
	 * @return ChatSession
	 */
	public function getOrCreateSession($sessionToken)
	{
		$session = ChatSession::model()->findByAttributes(array('session_token' => $sessionToken));
		
		if (!$session) {
			$session = new ChatSession();
			$session->session_token = $sessionToken;
			$session->user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
			$session->ip_address = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
			$session->save();
		} else {
			// Обновляем updated_at при каждом обращении
			$session->updated_at = date('Y-m-d H:i:s');
			$session->save(false);
		}
		
		return $session;
	}
	
	/**
	 * Нормализация текста запроса
	 * @param string $text
	 * @return string
	 */
	protected function normalizeText($text)
	{
		$text = mb_strtolower(trim($text), 'UTF-8');
		// Удаление лишних пробелов
		$text = preg_replace('/\s+/', ' ', $text);
		// Удаление пунктуации (опционально, можно оставить для более точного поиска)
		// $text = preg_replace('/[^\p{L}\p{N}\s]/u', '', $text);
		return $text;
	}
	
	/**
	 * Поиск ответа по тексту запроса
	 * @param string $queryText
	 * @param string $language
	 * @return ChatAnswer|null
	 */
	protected function findAnswerByQuery($queryText, $language = 'ru')
	{
		$normalizedQuery = $this->normalizeText($queryText);
		
		// Сначала ищем точное совпадение по фразам
		$criteria = new CDbCriteria();
		$criteria->with = array('answer');
		$criteria->compare('phrase_text', $normalizedQuery, true);
		$criteria->compare('answer.language', $language);
		$criteria->compare('answer.is_active', 1);
		$criteria->order = 'answer.id ASC';
		$criteria->limit = 1;
		
		$phrase = ChatPhrase::model()->find($criteria);
		
		if ($phrase && $phrase->answer) {
			return $phrase->answer;
		}
		
		// Если точного совпадения нет, ищем по частичному совпадению
		$criteria = new CDbCriteria();
		$criteria->with = array('answer');
		$criteria->addCondition('phrase_text LIKE :query');
		$criteria->params[':query'] = '%' . $normalizedQuery . '%';
		$criteria->compare('answer.language', $language);
		$criteria->compare('answer.is_active', 1);
		$criteria->order = 'answer.id ASC';
		$criteria->limit = 1;
		
		$phrase = ChatPhrase::model()->find($criteria);
		
		if ($phrase && $phrase->answer) {
			return $phrase->answer;
		}
		
		// Также проверяем совпадение по названию ответа
		$criteria = new CDbCriteria();
		$criteria->compare('title', $normalizedQuery, true);
		$criteria->compare('language', $language);
		$criteria->compare('is_active', 1);
		$criteria->limit = 1;
		
		$answer = ChatAnswer::model()->find($criteria);
		
		if ($answer) {
			return $answer;
		}
		
		return null;
	}
	
	/**
	 * Обработка сообщения пользователя
	 * @param ChatSession $session
	 * @param string $userText
	 * @return array
	 */
	public function handleUserMessage(ChatSession $session, $userText)
	{
		// Сохраняем сообщение пользователя
		$userMessage = new ChatMessage();
		$userMessage->session_id = $session->id;
		$userMessage->sender = ChatMessage::SENDER_USER;
		$userMessage->message_text = $userText;
		$userMessage->save();
		
		// Ищем ответ
		$answer = $this->findAnswerByQuery($userText, 'ru');
		
		if ($answer) {
			// Логируем статистику
			$stats = new ChatAnswerStats();
			$stats->answer_id = $answer->id;
			$stats->save();
			
			// Сохраняем ответ бота
			$botMessage = new ChatMessage();
			$botMessage->session_id = $session->id;
			$botMessage->sender = ChatMessage::SENDER_BOT;
			$botMessage->message_text = $answer->answer_html;
			$botMessage->save();
			
			return array(
				'type' => 'answer',
				'answer_html' => $answer->answer_html,
				'category' => $answer->category ? $answer->category->title : '',
				'title' => $answer->title,
			);
		} else {
			// Сохраняем непонятый запрос
			$unmatched = new ChatUnmatchedQuery();
			$unmatched->session_id = $session->id;
			$unmatched->query_text = $userText;
			$unmatched->save();
			
			// Формируем ответ с контактами
			$handoffText = '<p>К сожалению, я пока не могу ответить на этот вопрос.</p>';
			$handoffText .= '<p>Пожалуйста, свяжитесь с приёмной комиссией:</p>';
			$handoffText .= '<ul>';
			$handoffText .= '<li><strong>Телефон:</strong> <a href="tel:' . htmlspecialchars($this->admissionOfficePhone) . '">' . htmlspecialchars($this->admissionOfficePhone) . '</a></li>';
			$handoffText .= '<li><strong>Email:</strong> <a href="mailto:' . htmlspecialchars($this->admissionOfficeEmail) . '">' . htmlspecialchars($this->admissionOfficeEmail) . '</a></li>';
			$handoffText .= '</ul>';
			
			// Сохраняем ответ бота
			$botMessage = new ChatMessage();
			$botMessage->session_id = $session->id;
			$botMessage->sender = ChatMessage::SENDER_BOT;
			$botMessage->message_text = $handoffText;
			$botMessage->save();
			
			return array(
				'type' => 'handoff',
				'answer_html' => $handoffText,
			);
		}
	}
	
	/**
	 * Получить главное меню (кнопки категорий)
	 * @param string $language
	 * @return array
	 */
	public function getMainMenuButtons($language = 'ru')
	{
		$categories = ChatCategory::model()->findAllByAttributes(
			array('language' => $language),
			array('order' => 'id ASC')
		);
		
		$buttons = array();
		
		foreach ($categories as $category) {
			$buttons[] = array(
				'slug' => $category->slug,
				'title' => $category->title,
				'answers' => array(),
			);
			
			// Получаем активные ответы категории
			$answers = ChatAnswer::model()->findAllByAttributes(
				array('category_id' => $category->id, 'language' => $language, 'is_active' => 1),
				array('order' => 'title ASC', 'limit' => 5) // Ограничиваем до 5 основных вопросов
			);
			
			foreach ($answers as $answer) {
				$buttons[count($buttons) - 1]['answers'][] = array(
					'id' => $answer->id,
					'title' => $answer->title,
				);
			}
		}
		
		return $buttons;
	}
	
	/**
	 * Получить приветственное сообщение
	 * @param string $language
	 * @return string
	 */
	public function getWelcomeMessage($language = 'ru')
	{
		if ($language == 'ru') {
			return '<p>Здравствуйте! Я виртуальный помощник приёмной комиссии СКУ им. М. Козыбаева.</p><p>Я могу помочь вам с информацией о:</p><ul><li>Поступлении</li><li>Специальностях</li><li>Финансах</li><li>Инфраструктуре</li></ul><p>Выберите интересующий раздел или задайте вопрос в свободной форме.</p>';
		}
		return '<p>Hello! I am a virtual assistant of the admission office.</p>';
	}
}

