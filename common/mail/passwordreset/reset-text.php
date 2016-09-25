<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->user_name) ?>,</p>

    <p>There has been a password reset request for your account. If you wish to procceed click the following link:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>

    <p>If it wasn't you who request this reset, please click the link below:</p>

    <p><?= Html::a(Html::encode($ignoreLink), $ignoreLink) ?></p>
</div>
