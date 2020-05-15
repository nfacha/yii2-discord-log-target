<?php /** @noinspection PhpUnused */

namespace nfacha\discordlogtarget;

use DiscordWebhooks\Client;
use DiscordWebhooks\Embed;
use Yii;
use yii\log\Logger;

class DiscordLogTarget extends \yii\log\Target {
    public $webhookUrl = '';
    /**
     * @inheritDoc
     */

    public function export() {
        $webhook = new Client( $this->webhookUrl );
        $embed   = new Embed();
        $embed->color( '#ff0000' );
        $message = $this->messages[0];
        $embed->field( 'Level', Logger::getLevelName( $message[1] ) );
        $embed->field( 'App', Yii::$app->id );
        $embed->field( 'URL', Yii::$app->request->absoluteUrl ?? 'CONSOLE' );
        $embed->field( 'IP', Yii::$app->request->userIP ?? 'CONSOLE' );
        $embed->color( '#ff0000' );
        if ( isset( Yii::$app->request->userIP ) ) {
            /** @noinspection PhpUndefinedFieldInspection */
            $embed->field( 'User', ! Yii::$app->user->isGuest !== null ? Yii::$app->user->id . ' (' . Yii::$app->user->identity->username . ')' : 'Guest' );
            $embed->color( '#0000ff' );
        }
        $embed->field( 'Category', $message[2] );
        $embed->field( 'Timestamp', date( "Y-m-d H:i:s", $message[3] ) );
        $embed->title( '🧨 ' . $message[2] . ' - ' . strtoupper( Logger::getLevelName( $message[1] ) ) . ' 🧨' );
        $embed->timestamp( date( "Y-m-d H:i:s", $message[3] ) );
        $webhook
            ->embed( $embed )
            ->message( (string) substr( str_replace( '***', '[REDACTED]', $message[0] ), 0, 1800 ) )
            ->send();


    }
}
