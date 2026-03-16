<?php
/**
 * View для ChatBotWidget
 * 
 * @var string $apiUrl
 * @var string $language
 */
$baseUrl = Yii::app()->baseUrl;
$chatApiUrl = Yii::app()->createUrl('chat/send');
$historyApiUrl = Yii::app()->createUrl('chat/getHistory');
$widgetId = 'chatbot-widget-' . uniqid();
?>

<style>
/* Стили чат-бота */
#<?php echo $widgetId; ?> {
	font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
	font-size: 14px;
	line-height: 1.5;
	color: #333333;
}

#<?php echo $widgetId; ?> .chatbot-toggle {
	position: fixed;
	bottom: 20px;
	right: 20px;
	width: 60px;
	height: 60px;
	background: #ffffff;
	border: 1px solid #e0e0e0;
	border-radius: 50%;
	cursor: pointer;
	box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
	display: flex;
	align-items: center;
	justify-content: center;
	z-index: 9998;
	transition: all 0.3s ease;
}

#<?php echo $widgetId; ?> .chatbot-toggle:hover {
	box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
	transform: scale(1.05);
}

#<?php echo $widgetId; ?> .chatbot-toggle-icon {
	font-size: 24px;
	color: #4a90e2;
}

#<?php echo $widgetId; ?> .chatbot-window {
	position: fixed;
	bottom: 90px;
	right: 20px;
	width: 380px;
	height: 600px;
	background: #ffffff;
	border: 1px solid #e0e0e0;
	border-radius: 8px;
	box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
	display: none;
	flex-direction: column;
	z-index: 9999;
	overflow: hidden;
}

#<?php echo $widgetId; ?> .chatbot-window.active {
	display: flex;
}

#<?php echo $widgetId; ?> .chatbot-header {
	background: #f8f9fa;
	border-bottom: 1px solid #e0e0e0;
	padding: 16px;
	display: flex;
	justify-content: space-between;
	align-items: center;
}

#<?php echo $widgetId; ?> .chatbot-header-title {
	font-weight: 600;
	font-size: 16px;
	color: #333333;
	margin: 0;
}

#<?php echo $widgetId; ?> .chatbot-close {
	background: none;
	border: none;
	font-size: 24px;
	cursor: pointer;
	color: #666666;
	padding: 0;
	width: 30px;
	height: 30px;
	display: flex;
	align-items: center;
	justify-content: center;
	border-radius: 4px;
	transition: background 0.2s;
}

#<?php echo $widgetId; ?> .chatbot-close:hover {
	background: #e0e0e0;
}

#<?php echo $widgetId; ?> .chatbot-messages {
	flex: 1;
	overflow-y: auto;
	padding: 16px;
	background: #ffffff;
}

#<?php echo $widgetId; ?> .chatbot-message {
	margin-bottom: 16px;
	display: flex;
	align-items: flex-start;
}

#<?php echo $widgetId; ?> .chatbot-message.user {
	justify-content: flex-end;
}

#<?php echo $widgetId; ?> .chatbot-message.bot {
	justify-content: flex-start;
}

#<?php echo $widgetId; ?> .chatbot-message-content {
	max-width: 75%;
	padding: 10px 14px;
	border-radius: 12px;
	word-wrap: break-word;
}

#<?php echo $widgetId; ?> .chatbot-message.user .chatbot-message-content {
	background: #4a90e2;
	color: #ffffff;
	border-bottom-right-radius: 4px;
}

#<?php echo $widgetId; ?> .chatbot-message.bot .chatbot-message-content {
	background: #f0f0f0;
	color: #333333;
	border-bottom-left-radius: 4px;
}

#<?php echo $widgetId; ?> .chatbot-message-content ul,
#<?php echo $widgetId; ?> .chatbot-message-content ol {
	margin: 8px 0;
	padding-left: 20px;
}

#<?php echo $widgetId; ?> .chatbot-message-content a {
	color: #4a90e2;
	text-decoration: underline;
}

#<?php echo $widgetId; ?> .chatbot-message.user .chatbot-message-content a {
	color: #ffffff;
	text-decoration: underline;
}

#<?php echo $widgetId; ?> .chatbot-menu {
	padding: 16px;
	border-top: 1px solid #e0e0e0;
	background: #ffffff;
}

#<?php echo $widgetId; ?> .chatbot-menu-buttons {
	display: grid;
	grid-template-columns: repeat(2, 1fr);
	gap: 8px;
	margin-bottom: 12px;
}

#<?php echo $widgetId; ?> .chatbot-menu-button {
	padding: 10px 12px;
	background: #f8f9fa;
	border: 1px solid #e0e0e0;
	border-radius: 6px;
	cursor: pointer;
	text-align: center;
	font-size: 13px;
	color: #333333;
	transition: all 0.2s;
}

#<?php echo $widgetId; ?> .chatbot-menu-button:hover {
	background: #e9ecef;
	border-color: #4a90e2;
}

#<?php echo $widgetId; ?> .chatbot-input-area {
	padding: 16px;
	border-top: 1px solid #e0e0e0;
	background: #ffffff;
	display: flex;
	gap: 8px;
}

#<?php echo $widgetId; ?> .chatbot-input {
	flex: 1;
	padding: 10px 12px;
	border: 1px solid #e0e0e0;
	border-radius: 6px;
	font-size: 14px;
	outline: none;
}

#<?php echo $widgetId; ?> .chatbot-input:focus {
	border-color: #4a90e2;
}

#<?php echo $widgetId; ?> .chatbot-send {
	padding: 10px 20px;
	background: #4a90e2;
	color: #ffffff;
	border: none;
	border-radius: 6px;
	cursor: pointer;
	font-size: 14px;
	font-weight: 500;
	transition: background 0.2s;
}

#<?php echo $widgetId; ?> .chatbot-send:hover {
	background: #357abd;
}

#<?php echo $widgetId; ?> .chatbot-send:disabled {
	background: #cccccc;
	cursor: not-allowed;
}

#<?php echo $widgetId; ?> .chatbot-loading {
	text-align: center;
	padding: 20px;
	color: #666666;
	font-size: 13px;
}

@media (max-width: 480px) {
	#<?php echo $widgetId; ?> .chatbot-window {
		width: calc(100% - 40px);
		height: calc(100vh - 100px);
		right: 20px;
		left: 20px;
		bottom: 90px;
	}
}
</style>

<div id="<?php echo $widgetId; ?>">
	<div class="chatbot-toggle" id="<?php echo $widgetId; ?>-toggle">
		<span class="chatbot-toggle-icon">💬</span>
	</div>
	
	<div class="chatbot-window" id="<?php echo $widgetId; ?>-window">
		<div class="chatbot-header">
			<h3 class="chatbot-header-title">Виртуальный помощник СКУ</h3>
			<button class="chatbot-close" id="<?php echo $widgetId; ?>-close">×</button>
		</div>
		
		<div class="chatbot-messages" id="<?php echo $widgetId; ?>-messages">
			<div class="chatbot-loading">Загрузка...</div>
		</div>
		
		<div class="chatbot-menu" id="<?php echo $widgetId; ?>-menu" style="display: none;">
			<div class="chatbot-menu-buttons" id="<?php echo $widgetId; ?>-menu-buttons"></div>
		</div>
		
		<div class="chatbot-input-area">
			<input type="text" class="chatbot-input" id="<?php echo $widgetId; ?>-input" placeholder="Введите ваш вопрос...">
			<button class="chatbot-send" id="<?php echo $widgetId; ?>-send">Отправить</button>
		</div>
	</div>
</div>

<script>
(function() {
	var widgetId = '<?php echo $widgetId; ?>';
	var sessionToken = localStorage.getItem('chatbot_session_token') || '';
	var apiUrl = '<?php echo $chatApiUrl; ?>';
	var historyUrl = '<?php echo $historyApiUrl; ?>';
	var configUrl = '<?php echo $apiUrl; ?>';
	var isOpen = false;
	var isInitialized = false;
	
	var toggleBtn = document.getElementById(widgetId + '-toggle');
	var windowEl = document.getElementById(widgetId + '-window');
	var closeBtn = document.getElementById(widgetId + '-close');
	var messagesEl = document.getElementById(widgetId + '-messages');
	var menuEl = document.getElementById(widgetId + '-menu');
	var menuButtonsEl = document.getElementById(widgetId + '-menu-buttons');
	var inputEl = document.getElementById(widgetId + '-input');
	var sendBtn = document.getElementById(widgetId + '-send');
	
	// Открытие/закрытие окна
	toggleBtn.addEventListener('click', function() {
		if (!isOpen) {
			openChat();
		} else {
			closeChat();
		}
	});
	
	closeBtn.addEventListener('click', function() {
		closeChat();
	});
	
	function openChat() {
		windowEl.classList.add('active');
		isOpen = true;
		
		if (!isInitialized) {
			initializeChat();
		} else {
			loadHistory();
		}
	}
	
	function closeChat() {
		windowEl.classList.remove('active');
		isOpen = false;
	}
	
	// Инициализация чата
	function initializeChat() {
		messagesEl.innerHTML = '<div class="chatbot-loading">Загрузка...</div>';
		
		// Загружаем конфигурацию
		var xhr = new XMLHttpRequest();
		xhr.open('GET', configUrl + '?language=ru', true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4) {
				if (xhr.status === 200) {
					try {
						var config = JSON.parse(xhr.responseText);
						messagesEl.innerHTML = '';
						
						// Показываем приветственное сообщение
						addMessage('bot', config.welcomeMessage);
						
						// Показываем меню кнопок
						if (config.menuButtons && config.menuButtons.length > 0) {
							renderMenuButtons(config.menuButtons);
							menuEl.style.display = 'block';
						}
						
						// Загружаем историю, если есть
						if (sessionToken) {
							loadHistory();
						}
						
						isInitialized = true;
					} catch (e) {
						console.error('Error parsing config:', e);
						messagesEl.innerHTML = '<div class="chatbot-loading">Ошибка загрузки</div>';
					}
				} else {
					messagesEl.innerHTML = '<div class="chatbot-loading">Ошибка загрузки</div>';
				}
			}
		};
		xhr.send();
	}
	
	// Рендеринг меню кнопок
	function renderMenuButtons(buttons) {
		menuButtonsEl.innerHTML = '';
		
		buttons.forEach(function(category) {
			var btn = document.createElement('button');
			btn.className = 'chatbot-menu-button';
			btn.textContent = category.title;
			btn.addEventListener('click', function() {
				sendMessage(category.title);
			});
			menuButtonsEl.appendChild(btn);
			
			// Добавляем кнопки для основных вопросов категории
			if (category.answers && category.answers.length > 0) {
				category.answers.forEach(function(answer) {
					var answerBtn = document.createElement('button');
					answerBtn.className = 'chatbot-menu-button';
					answerBtn.textContent = answer.title;
					answerBtn.addEventListener('click', function() {
						sendMessage(answer.title);
					});
					menuButtonsEl.appendChild(answerBtn);
				});
			}
		});
	}
	
	// Загрузка истории
	function loadHistory() {
		if (!sessionToken) return;
		
		var xhr = new XMLHttpRequest();
		xhr.open('GET', historyUrl + '?sessionToken=' + encodeURIComponent(sessionToken), true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4 && xhr.status === 200) {
				try {
					var data = JSON.parse(xhr.responseText);
					if (data.success && data.messages && data.messages.length > 0) {
						// Очищаем только приветствие, если есть история
						var welcomeMsg = messagesEl.querySelector('.chatbot-message.bot:first-child');
						if (welcomeMsg && welcomeMsg.textContent.indexOf('Здравствуйте') !== -1) {
							messagesEl.innerHTML = '';
						}
						
						data.messages.forEach(function(msg) {
							addMessage(msg.sender, msg.text, false);
						});
						
						scrollToBottom();
					}
				} catch (e) {
					console.error('Error loading history:', e);
				}
			}
		};
		xhr.send();
	}
	
	// Отправка сообщения
	function sendMessage(text) {
		if (!text || !text.trim()) return;
		
		// Добавляем сообщение пользователя
		addMessage('user', text);
		
		// Очищаем поле ввода
		inputEl.value = '';
		
		// Показываем индикатор загрузки
		var loadingMsg = addMessage('bot', '<div class="chatbot-loading">Отправка...</div>', false);
		
		// Отправляем на сервер
		var formData = new FormData();
		formData.append('sessionToken', sessionToken);
		formData.append('message', text);
		
		var xhr = new XMLHttpRequest();
		xhr.open('POST', apiUrl, true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4) {
				// Удаляем индикатор загрузки
				if (loadingMsg && loadingMsg.parentNode) {
					loadingMsg.parentNode.removeChild(loadingMsg);
				}
				
				if (xhr.status === 200) {
					try {
						var response = JSON.parse(xhr.responseText);
						
						if (response.success) {
							// Сохраняем токен сессии
							if (response.sessionToken) {
								sessionToken = response.sessionToken;
								localStorage.setItem('chatbot_session_token', sessionToken);
							}
							
							// Обновляем сообщения из ответа
							if (response.messages && response.messages.length > 0) {
								messagesEl.innerHTML = '';
								response.messages.forEach(function(msg) {
									addMessage(msg.sender, msg.text, false);
								});
							}
							
							scrollToBottom();
						} else {
							addMessage('bot', 'Произошла ошибка. Попробуйте еще раз.');
						}
					} catch (e) {
						console.error('Error parsing response:', e);
						addMessage('bot', 'Произошла ошибка при обработке ответа.');
					}
				} else {
					addMessage('bot', 'Ошибка соединения с сервером.');
				}
			}
		};
		xhr.send(formData);
	}
	
	// Добавление сообщения в чат
	function addMessage(sender, text, scroll) {
		var messageDiv = document.createElement('div');
		messageDiv.className = 'chatbot-message ' + sender;
		
		var contentDiv = document.createElement('div');
		contentDiv.className = 'chatbot-message-content';
		contentDiv.innerHTML = text;
		
		messageDiv.appendChild(contentDiv);
		messagesEl.appendChild(messageDiv);
		
		if (scroll !== false) {
			scrollToBottom();
		}
		
		return messageDiv;
	}
	
	// Прокрутка вниз
	function scrollToBottom() {
		messagesEl.scrollTop = messagesEl.scrollHeight;
	}
	
	// Обработка отправки по Enter
	inputEl.addEventListener('keypress', function(e) {
		if (e.key === 'Enter') {
			sendMessage(inputEl.value);
		}
	});
	
	// Обработка кнопки отправки
	sendBtn.addEventListener('click', function() {
		sendMessage(inputEl.value);
	});
})();
</script>

