<?php


return array(
    "driver" => "smtp",
    "host" => "smtp.mailtrap.io",
    "port" => 2525,
    "from" => array(
        "address" => "from@example.com",
        "name" => "Example"
    ),
    "username" => "73fc7f02ada2fe",
    "password" => "d6c48a216f7751",
    "sendmail" => "/usr/sbin/sendmail -bs",
    "pretend" => false
  );

/*

return [


    'driver' => env('MAIL_DRIVER', 'smtp'),

    'host' => env('MAIL_HOST', 'smtp.mailgun.org'),

    'port' => env('MAIL_PORT', 587),


    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],

    'encryption' => env('MAIL_ENCRYPTION', 'tls'),


    'username' => env('MAIL_USERNAME'),

    'password' => env('MAIL_PASSWORD'),


    'sendmail' => '/usr/sbin/sendmail -bs',


    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],


];

*/