<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// change the following paths if necessary
// Путь к framework относительно webapp
// Из framework/cli/views/webapp/ нужно подняться на 3 уровня вверх до framework/
// dirname(__FILE__) = framework/cli/views/webapp
// dirname(dirname(__FILE__)) = framework/cli/views
// dirname(dirname(dirname(__FILE__))) = framework/cli
// dirname(dirname(dirname(dirname(__FILE__)))) = framework
$yii=dirname(dirname(dirname(dirname(__FILE__)))).'/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
