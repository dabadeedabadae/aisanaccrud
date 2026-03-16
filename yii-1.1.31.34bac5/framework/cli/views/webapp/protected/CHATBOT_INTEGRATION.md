# Инструкция по интеграции чат-бота

## Быстрый старт

### 1. Импорт базы данных

Выполните SQL-скрипт через Adminer:
```
protected/data/chatbot_schema.sql
```

### 2. Настройка config/main.php

Убедитесь, что MySQL подключен:

```php
'db'=>array(
    'connectionString' => 'mysql:host=localhost;dbname=your_db',
    'emulatePrepare' => true,
    'username' => 'your_user',
    'password' => 'your_pass',
    'charset' => 'utf8mb4',
),
```

### 3. Подключение виджета

В `protected/views/layouts/main.php` перед `</body>`:

```php
<?php $this->widget('application.components.ChatBotWidget'); ?>
```

### 4. Настройка контактов

В `protected/components/ChatBotService.php` измените:

```php
public $admissionOfficePhone = '+7 (7172) 55-55-55';
public $admissionOfficeEmail = 'admission@sku.edu.kz';
```

### 5. Доступ к админке

По умолчанию требуется роль `admin`. Если нет системы ролей, измените в `ChatAdminController::accessRules()`:

```php
'users'=>array('@'), // Для всех авторизованных
```

Админка доступна по адресу: `/chatAdmin/stats`

## Структура файлов

Все файлы находятся в структуре `webapp/protected/`:

- **Модели**: `models/Chat*.php` (7 файлов)
- **Компоненты**: `components/ChatBotService.php`, `components/ChatBotWidget.php`
- **View виджета**: `components/views/chatBotWidget.php`
- **Контроллеры**: `controllers/ChatController.php`, `controllers/ChatAdminController.php`
- **Views админки**: `views/chatAdmin/`
- **SQL**: `data/chatbot_schema.sql`

## Первоначальная настройка

1. Создайте категории через админку: `/chatAdmin/categoryCreate`
2. Создайте ответы: `/chatAdmin/answerCreate`
3. При создании ответа добавьте фразы для поиска (каждая строка - отдельная фраза)

## Готово!

Виджет автоматически появится на всех страницах сайта в правом нижнем углу.

