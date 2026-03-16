# Чат-бот для приемной комиссии СКУ им. М. Козыбаева

## Описание

Виртуальный помощник для автоматизации ответов на частые вопросы абитуриентов. Работает как виджет на официальном сайте университета.

## Структура файлов

### Модели (protected/models/)
- `ChatSession.php` - сессии чата
- `ChatMessage.php` - сообщения пользователей и бота
- `ChatCategory.php` - категории базы знаний
- `ChatAnswer.php` - ответы бота
- `ChatPhrase.php` - фразы/синонимы для поиска ответов
- `ChatUnmatchedQuery.php` - непонятые запросы
- `ChatAnswerStats.php` - статистика популярности ответов

### Компоненты (protected/components/)
- `ChatBotService.php` - сервис логики чат-бота
- `ChatBotWidget.php` - виджет для отображения чата
- `views/chatBotWidget.php` - view виджета с HTML/CSS/JS

### Контроллеры (protected/controllers/)
- `ChatController.php` - API для виджета (AJAX)
- `ChatAdminController.php` - админ-панель для управления

### Views админки (protected/views/chatAdmin/)
- `stats.php` - страница статистики
- `category/` - CRUD для категорий
- `answer/` - CRUD для ответов

### База данных
- `protected/data/chatbot_schema.sql` - SQL DDL для создания таблиц

## Установка

### 1. Импорт базы данных

Выполните SQL-скрипт `protected/data/chatbot_schema.sql` через Adminer или другой инструмент MySQL:

```sql
-- Скрипт создаст все необходимые таблицы и вставит начальные категории
```

### 2. Настройка config/main.php

Убедитесь, что в `protected/config/main.php` настроено подключение к MySQL:

```php
'db'=>array(
    'connectionString' => 'mysql:host=localhost;dbname=your_database',
    'emulatePrepare' => true,
    'username' => 'your_username',
    'password' => 'your_password',
    'charset' => 'utf8mb4',
    'tablePrefix' => '', // или ваш префикс таблиц
),
```

Также убедитесь, что в секции `import` есть:

```php
'import'=>array(
    'application.models.*',
    'application.components.*',
),
```

### 3. Настройка контактов приёмной комиссии

Отредактируйте `protected/components/ChatBotService.php`:

```php
public $admissionOfficePhone = '+7 (7172) 55-55-55'; // Ваш телефон
public $admissionOfficeEmail = 'admission@sku.edu.kz'; // Ваш email
```

### 4. Подключение виджета на сайте

В вашем главном layout файле (например, `protected/views/layouts/main.php`) добавьте перед закрывающим тегом `</body>`:

```php
<?php $this->widget('application.components.ChatBotWidget'); ?>
```

### 5. Настройка доступа к админке

В `ChatAdminController` используется проверка роли `admin`. Убедитесь, что у вас настроена система ролей, или измените проверку доступа:

```php
// В ChatAdminController::accessRules()
'expression'=>'Yii::app()->user->checkAccess("admin")',
```

Если у вас нет системы ролей, можно временно использовать:

```php
'users'=>array('@'), // Доступ для всех авторизованных
```

## Использование

### Добавление ответов через админку

1. Перейдите в админку: `/chatAdmin/answerIndex`
2. Создайте категорию: `/chatAdmin/categoryCreate`
3. Создайте ответ: `/chatAdmin/answerCreate`
4. При создании ответа укажите:
   - Категорию
   - Название вопроса
   - HTML-текст ответа (можно использовать списки, ссылки)
   - Фразы для поиска (каждая строка - отдельная фраза)

### Просмотр статистики

Перейдите в `/chatAdmin/stats` для просмотра:
- Общей статистики сессий
- Популярных ответов
- Непонятых запросов

### Обучение бота

Когда бот не понимает запрос:
1. Зайдите в статистику → "Непонятые запросы"
2. Найдите нужный запрос
3. Создайте новый ответ или добавьте фразу к существующему ответу

## API Endpoints

### GET /chat/widgetConfig
Получить конфигурацию виджета (приветствие и меню)

**Параметры:**
- `language` (опционально) - язык интерфейса (по умолчанию 'ru')

**Ответ:**
```json
{
  "welcomeMessage": "<p>Здравствуйте!...</p>",
  "menuButtons": [...]
}
```

### POST /chat/send
Отправить сообщение от пользователя

**Параметры:**
- `sessionToken` - токен сессии (генерируется автоматически)
- `message` - текст сообщения пользователя

**Ответ:**
```json
{
  "success": true,
  "sessionToken": "...",
  "type": "answer",
  "messages": [...]
}
```

### GET /chat/getHistory
Получить историю сообщений сессии

**Параметры:**
- `sessionToken` - токен сессии

## Структура базы данных

- `chat_session` - сессии пользователей
- `chat_message` - все сообщения (пользователь + бот)
- `chat_category` - категории базы знаний
- `chat_answer` - ответы бота
- `chat_phrase` - фразы для поиска ответов
- `chat_unmatched_query` - непонятые запросы
- `chat_answer_stats` - статистика запросов

## Особенности

- Виджет автоматически сохраняет токен сессии в localStorage браузера
- История сообщений сохраняется в базе данных
- Поддержка HTML в ответах (списки, ссылки)
- Система поиска по фразам с нормализацией текста
- Логирование всех непонятых запросов для обучения бота

## Чек-лист для запуска

- [ ] Импортирован SQL-скрипт через Adminer
- [ ] Настроено подключение к БД в `config/main.php`
- [ ] Обновлены контакты в `ChatBotService.php`
- [ ] Добавлен виджет в layout (`$this->widget('application.components.ChatBotWidget')`)
- [ ] Настроен доступ к админке (роли или проверка авторизации)
- [ ] Созданы начальные категории и ответы через админку
- [ ] Протестирован виджет на сайте

## Поддержка

При возникновении проблем проверьте:
1. Логи Yii в `protected/runtime/application.log`
2. Консоль браузера (F12) для ошибок JavaScript
3. Правильность путей к контроллерам в URL Manager (если используется)

