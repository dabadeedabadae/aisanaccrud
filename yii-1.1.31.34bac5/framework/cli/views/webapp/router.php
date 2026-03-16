<?php
/**
 * Router для PHP встроенного сервера
 * Все запросы перенаправляются на index.php
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$file = __DIR__ . $uri;

// Если запрашивается реальный файл (CSS, JS, изображения), отдаем его напрямую
if ($uri !== '/' && file_exists($file) && is_file($file)) {
    return false;
}

// Если запрашивается директория с index.php, отдаем его
if (is_dir($file) && file_exists($file . '/index.php')) {
    return false;
}

// Все остальные запросы перенаправляем на index.php
// Устанавливаем правильные значения для Yii
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/index.php';

// Вычисляем PATH_INFO из URI
if ($uri === '/' || $uri === '/index.php') {
    $pathInfo = '';
} else {
    // Убираем начальный слэш
    $pathInfo = ltrim($uri, '/');
}

// Устанавливаем PATH_INFO и обновляем REQUEST_URI
$_SERVER['PATH_INFO'] = $pathInfo;
$_SERVER['REQUEST_URI'] = '/index.php' . ($pathInfo ? '/' . $pathInfo : '');

require __DIR__ . '/index.php';

