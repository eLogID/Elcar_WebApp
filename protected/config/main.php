<?php
return array(
    'name'=>'Elcar',

    'defaultController'=>'front',

    'import'=>array(
        'application.models.*',
        'application.models.admin.*',
        'application.components.*',
        'application.vendor.*',
    ),

    'language'=>'en',

    'components'=>array(
        'urlManager'=>array(
            'class' => 'UrlManager',
            'urlFormat'=>'path',
            'showScriptName'=>false,
            'caseSensitive'=>false,
            'rules'=>array(
                '/app/' => array('/app/index/'),
                'admin/' => "admin/index",
                'viewer/' => "viewer/index",
                'api/' => "api/index",
                'install/' => "install/index",
                '<_c:(front)>' => '<_c>/index',
                '<lang:\w+>/<controller:\w+>/<action:\w+>/'=>'<controller>/<action>',
                '<action:[\w\-]+>' => 'front/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            )
        ),

        'db'=>array(
            'class'            => 'CDbConnection' ,
            'connectionString' => 'mysql:host=10.26.0.159;dbname=elcar_main',
            'emulatePrepare'   => true,
            'username'         => 'root',
            'password'         => 'aaa123##',
            'charset'          => 'utf8',
            'tablePrefix'      => 'el_',
        ),


        'functions'=> array(
            'class'=>'Functions'
        ),
        'validator'=>array(
            'class'=>'Validator'
        ),
        'Smtpmail'=>array(
            'class'=>'application.extensions.smtpmail.PHPMailer',
            'Host'=>"sav-server.dyndns.org",
            'Username'=>'smtp@123.abc',
            'Password'=>'123@abc',
            'Mailer'=>'smtp',
            'Port'=>13025,
            'SMTPAuth'=>true,
        ),
    ),
);