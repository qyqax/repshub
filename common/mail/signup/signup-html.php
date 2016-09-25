<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<div class="signup-confirmation">
    <p>Hello <?= Html::encode($user->user_name) ?>,</p>

    <p>Welcome to baseapp! You'll need to follow the link below to verify your account.</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
