Add the following to your application components:

```php
'log'                  => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'          => DiscordLogTarget::class,
                    'webhookUrl'     => 'https://discordapp.com/api/webhooks/<WebhookURL>>',
                    'levels'         => [ 'error' ],
                    'exportInterval' => 1,
                    'maskVars'       => [ '_SERVER', '_COOKIE' ],
                    'except'         => [
                        'yii\web\HttpException:404',
                        'yii\web\HttpException:400',
                        'yii\web\HttpException:403',
                        'yii\i18n\*',
                    ],
                ],
            ],

```