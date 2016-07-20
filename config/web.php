<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'baseUrl' => '',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'V4ePf1B4nZ8LLSicjfz3xBFPO3gOJ-ui',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        /*'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],*/
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            /*'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.spaceweb.ru',
                'username' => 'admin@efir.cityt',
                'password' => 'KWI5Y1Mqea',
                'port' => '25', // '587',
                //'encryption' => 'tls',
            ],*/
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                '' => 'site/index',
                '<cityId:\d+>' => 'site/cityt',
                '<cityId:\d+>/<categoryId:\d+>' => 'site/category',
                'get/all/regions' => 'get/regions',
                'get/all/cities' => 'get/cities',
                'ajax/getMessages/<cityId:\d+>/<categoryId:\d+>/<lastMessageId:\d+>' => 'get/ajaxmessages',
                'admin/ssh/E191Wpbt5P' => 'admin/default/ssh',
                'ajax/getAjaxScroll/<cityId:\d+>/<categoryId:\d+>/<firstMessageId:\d+>' => 'get/infinitescroll',
                
                'new/message/<cityId:\d+>/<categoryId:\d+>' => 'get/newmessage',
                'removeAllCookies' => 'site/removecookies',

                'admin' => 'admin/default/index',
                'admin/index/lasttenmessages' => 'admin/default/lasttenmessages',
                'admin/index/deletemessage' => 'admin/default/deletemessage',
                'admin/category' => 'admin/category/index',
                'admin/categorydefault' => 'admin/categorydefault/index',
                'admin/city' => 'admin/cityt/index',
                'admin/country' => 'admin/country/index',
                'admin/messages' => 'admin/messages/index',
                'admin/region' => 'admin/region/index',
                'admin/seo' => 'admin/seo/index',
                'admin/sitesettings' => 'admin/sitesettings/index',
                'admin/statics' => 'admin/statics/index',

                'instructions' => 'static/instructions',
                'cost' => 'static/cost',
                'rules' => 'static/rules',
                'faq' => 'static/faq',
            ],
        ],

    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            /*'enableGeneratingPassword' => true,
            'enableConfirmation' => true,*/
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['sergey_zaicev'], // pass KWI5Y1Mqea
            'mailer' => [
                'sender'                => 'admin@efir.cityt', // or ['no-reply@myhost.com' => 'Sender name']
                'welcomeSubject'        => 'Welcome subject',
                'confirmationSubject'   => 'Confirmation subject',
                'reconfirmationSubject' => 'Email change subject',
                'recoverySubject'       => 'Recovery subject',
            ],
        ],
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => [
                '93.74.83.107',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
