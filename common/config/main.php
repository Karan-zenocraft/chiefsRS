<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
      /*      'dsn' => 'mysql:host=localhost;dbname=pms_live',
            'username' => 'root',
            'password' => 'inx@!123',*/
            'dsn'      => 'mysql:host=localhost;dbname=ChiefsRS',
            'username' => 'root',
            'password' => 'rutusha@123',
            'charset' => 'utf8',
        ],
   /*     'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            //'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            //'useFileTransport' => false,//to send mails to real email addresses else will get stored in your mail/runtime folder
            //comment the following array to send mail using php's mail function
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'inx.email001@gmail.com',
                'password' => 'mail@001',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],*/
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            //'useFileTransport' => false,//to send mails to real email addresses else will get stored in your mail/runtime folder
            //comment the following array to send mail using php's mail function
            'transport' => [
                'class' => 'Swift_SmtpTransport',
               'host' => 'smtp.gmail.com',
               'username' => 'chefsrs123@gmail.com',
               'password' => 'Admin@123',
               'port' => '587',
               'encryption' => 'tls',
            ],
        ],
    ],
];
