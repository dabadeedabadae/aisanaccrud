<?php

// This is the database connection configuration.
// Для локального MySQL используйте: 'mysql:host=localhost;dbname=chatbot'
// Для удаленного MySQL укажите IP или домен: 'mysql:host=your-server.com;dbname=chatbot'
return array(
	// MySQL database configuration for chatbot
	'connectionString' => 'mysql:host=localhost;dbname=chatbot',
	'emulatePrepare' => true,
	'username' => 'root', // Измените на ваш MySQL пользователь (например, 'admin')
	'password' => '',     // Измените на ваш пароль MySQL
	'charset' => 'utf8mb4',
	'tablePrefix' => '',
);