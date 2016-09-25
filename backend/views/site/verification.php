<?php
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-verification">

    <div class="jumbotron">
        <h2>Hello, <?= Yii::$app->user->identity->user_name ?></h4>

        <p class="lead">You must verify your account to procceed.</p>
        <p><h5>If you haven't seen your email, check your spam or <a href="#">click here</a>.</h5></p>
    </div>

</div>
