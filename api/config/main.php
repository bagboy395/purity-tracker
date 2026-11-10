
<?php

$config = [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\\controllers',

    'components' => [

        // Format API responses as JSON
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
        ],

        // Configure incoming requests
        'request' => [
            'cookieValidationKey' => 'purity-tracker-api-secret-key',
        ],

        // Connect to the existing user identity system
        'user' => [
            'identityClass' => common\models\User::class,
            'enableSession' => false,
            'enableAutoLogin' => false,
        ],


       'urlManager' => [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'enableStrictParsing' => false,

    'rules' => [
        '' => 'site/index',
        'POST site/login' => 'site/login',
        'GET site/profile' => 'site/profile',
        'GET site/checkins' => 'site/checkins',
        'POST site/checkin' => 'site/create-checkin',
    ],
],


    ],
];

return $config;
