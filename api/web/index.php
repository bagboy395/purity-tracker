
<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

// Load Composer and Yii2
require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';

// Load shared and API bootstrap files
require __DIR__ . '/../../common/config/bootstrap.php';
require dirname(__DIR__) . '/config/bootstrap.php';

// Merge shared and API configuration
$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    require __DIR__ . '/../../common/config/main-local.php',
    require __DIR__ . '/../config/main.php'
);

// Launch the API application
(new yii\web\Application($config))->run();
