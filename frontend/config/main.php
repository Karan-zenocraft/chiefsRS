<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'),
        //require(__DIR__ . '/../../common/config/params-local.php'),
        require(__DIR__ . '/params.php')
        //require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'defaultRoute' => 'site/index',
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'generators' => [
                'doubleModel' => [
                    'class' => 'claudejanz\mygii\generators\model\Generator',
                ],
            ],
        ],
    ],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [        
        'user' => [
            'identityClass' => 'common\models\Users',
            'enableAutoLogin' => false,
            'idParam' => '_frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'baseUrl'=> (($_SERVER['HTTP_HOST'] == "localhost") || ($_SERVER['HTTP_HOST'] == "localhost:8012")) ? '/chiefsRS' : '',
            'cookieValidationKey' => 'iAIsGHwD4Yy9srwnOWoF1BnvESKAYI63',
        ],
         'assetManager' => [
            'bundles' => [
                /* 'yii\bootstrap\BootstrapAsset' => [
                  'css' => [],
                  ], */
                'yii\web\JqueryAsset' => ['jsOptions' => ['position' => \yii\web\View::POS_HEAD]],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'scriptUrl'=>(($_SERVER['HTTP_HOST'] == "localhost") || ($_SERVER['HTTP_HOST'] == "localhost:8012")) ? '/chiefsRS' : '',
            'rules' => [
                'home/<rid>'=>'site/index',
                'home'=>'site/index',
                'restaurants' => 'site/restaurants',
                'restaurant-details/<rid>'=>'site/restaurant-details',
                'book-restaurant/<rid>' => 'reservations/create',
                'book-restaurant' => 'reservations/create',
                'update-booking/<id>' => 'reservations/update',
                'cancel-booking/<id>' => 'reservations/cancel',
                'delete-booking/<id>' => 'reservations/delete',
                'manage-reservations' => 'reservations/index',
            ]
        ]
    ],
    'params' => $params,
];
