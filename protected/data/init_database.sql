-- ============================================================================
-- Полная инициализация базы данных для проекта AI Sana
-- ============================================================================
-- Использование: mysql -u root -p yii1_db < protected/data/init_database.sql
-- ============================================================================

-- Создание таблицы пользователей
CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(128) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Создание таблицы новостей
CREATE TABLE IF NOT EXISTS `tbl_news` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `content` TEXT NOT NULL,
    `excerpt` TEXT,
    `image` VARCHAR(500),
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `published` TINYINT(1) DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    INDEX `idx_published` (`published`),
    INDEX `idx_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Создание таблицы курсов
CREATE TABLE IF NOT EXISTS `tbl_courses` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `link` VARCHAR(500) NOT NULL,
    `published` TINYINT(1) DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    INDEX `idx_published` (`published`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Вставка администратора по умолчанию
-- Логин: admin
-- Пароль: admin123
-- ВАЖНО: Измените пароль после первого входа!
INSERT INTO `tbl_user` (`username`, `password`, `email`, `created_at`, `updated_at`) 
VALUES (
    'admin', 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
    'admin@ku.edu.kz', 
    NOW(), 
    NOW()
)
ON DUPLICATE KEY UPDATE `username`=`username`;



