-- MySQL DDL для чат-бота приемной комиссии СКУ им. М. Козыбаева
-- Версия: 1.0
-- Кодировка: utf8mb4
-- Движок: InnoDB

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- Таблица сессий чата
CREATE TABLE IF NOT EXISTS `chat_session` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `session_token` VARCHAR(64) NOT NULL,
  `user_agent` VARCHAR(255) DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_session_token` (`session_token`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица сообщений чата
CREATE TABLE IF NOT EXISTS `chat_message` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `session_id` INT(11) NOT NULL,
  `sender` ENUM('user', 'bot') NOT NULL DEFAULT 'user',
  `message_text` TEXT NOT NULL,
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_session_id` (`session_id`),
  KEY `idx_created_at` (`created_at`),
  CONSTRAINT `fk_chat_message_session` FOREIGN KEY (`session_id`) REFERENCES `chat_session` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица категорий базы знаний
CREATE TABLE IF NOT EXISTS `chat_category` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `slug` VARCHAR(50) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `language` VARCHAR(5) NOT NULL DEFAULT 'ru',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_slug_language` (`slug`, `language`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица ответов бота
CREATE TABLE IF NOT EXISTS `chat_answer` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `category_id` INT(11) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `answer_html` TEXT NOT NULL,
  `language` VARCHAR(5) NOT NULL DEFAULT 'ru',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_language` (`language`),
  KEY `idx_is_active` (`is_active`),
  CONSTRAINT `fk_chat_answer_category` FOREIGN KEY (`category_id`) REFERENCES `chat_category` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица фраз/синонимов для поиска ответов
CREATE TABLE IF NOT EXISTS `chat_phrase` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `answer_id` INT(11) NOT NULL,
  `phrase_text` VARCHAR(255) NOT NULL,
  `language` VARCHAR(5) NOT NULL DEFAULT 'ru',
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_answer_id` (`answer_id`),
  KEY `idx_phrase_text` (`phrase_text`),
  KEY `idx_language` (`language`),
  CONSTRAINT `fk_chat_phrase_answer` FOREIGN KEY (`answer_id`) REFERENCES `chat_answer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица непонятых запросов
CREATE TABLE IF NOT EXISTS `chat_unmatched_query` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `session_id` INT(11) DEFAULT NULL,
  `query_text` TEXT NOT NULL,
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_session_id` (`session_id`),
  KEY `idx_created_at` (`created_at`),
  CONSTRAINT `fk_chat_unmatched_query_session` FOREIGN KEY (`session_id`) REFERENCES `chat_session` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица статистики популярности ответов
CREATE TABLE IF NOT EXISTS `chat_answer_stats` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `answer_id` INT(11) NOT NULL,
  `requested_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_answer_id` (`answer_id`),
  KEY `idx_requested_at` (`requested_at`),
  CONSTRAINT `fk_chat_answer_stats_answer` FOREIGN KEY (`answer_id`) REFERENCES `chat_answer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- Вставка начальных данных (категории)
INSERT INTO `chat_category` (`slug`, `title`, `language`, `created_at`, `updated_at`) VALUES
('admission', 'Поступление', 'ru', NOW(), NOW()),
('specialties', 'Специальности', 'ru', NOW(), NOW()),
('finance', 'Финансы', 'ru', NOW(), NOW()),
('infrastructure', 'Инфраструктура', 'ru', NOW(), NOW());

