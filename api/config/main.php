<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    //require(__DIR__ . '/../../common/config/params-local.php'),
   require(__DIR__ . '/params.php')
    //require(__DIR__ . '/params-local.php')
);
return [
 	 'id' => 'api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
   'bootstrap' => ['log'],
      'components' => [
        'user' => [
            'identityClass' => 'common\models\Users',
            'enableAutoLogin' => false,
            'idParam' => '_api'
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'login'=>'site/login',
                'dashboard'=>'site/index',
                'manage-users'=>'users/index',
                'create-user'=>'users/create',
                'update-user/<id>'=>'users/update',
                'delete-user/<id>'=>'users/delete',
                'manage-tags'=>'tags/index',
                'create-tag'=>'tags/create',
                'update-tag/<id>'=>'tags/update',
                'delete-tag/<id>'=>'tags/delete',
                'manage-menu-categories'=>'menu-categories/index',
                'create-menu-category'=>'menu-categories/create',
                'update-menu-category/<id>'=>'menu-categories/update',
                'delete-menu-category/<id>'=>'menu-categories/delete',
                'manage-restaurants'=>'restaurants/index',
                'create-restaurant'=>'restaurants/create',
                'update-restaurant/<id>'=>'restaurants/update',
                'delete-restaurant/<id>'=>'restaurants/delete',
                'manage-restaurants-gallery/<rid>'=>'restaurants-gallery/index',
                'create-restaurant-gallery/<rid>'=>'restaurants-gallery/create',
                'update-restaurant-gallery/<id>/<rid>'=>'restaurants-gallery/update',
                'delete-restaurant-gallery/<id>/<rid>'=>'restaurants-gallery/delete',
                'manage-restaurants-menu/<rid>'=>'restaurant-menu/index',
                'create-restaurant-menu/<rid>'=>'restaurant-menu/create',
                'update-restaurant-menu/<id>/<rid>'=>'restaurant-menu/update',
                'delete-restaurant-menu/<id>/<rid>'=>'restaurant-menu/delete',
                'update-restaurant-mealtimes/<id>/<rid>'=>'restaurant-meal-times/update',
                'manage-restaurant-working-hours/<rid>'=>'restaurant-working-hours/index',
                'update-restaurant-working-hours/<id>/<rid>'=>'restaurant-working-hours/update',

            ]
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'pbB0NvlmxlWRk7XFCN_7XUC2uvX0vyCD',
        ],
    ],

];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = 'yii\debug\Module';
}

return $params;
