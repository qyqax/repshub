<?php
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome to the MiniCrm!</h1>

        <p class="lead">Place where your client reletions boosts.</p>

        <p><a class="btn btn-lg btn-success" href="../myaccount/index">Your Profile</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h3>Manage your orderds</h3>

                <p>With miniCrm you can manage purchasase wherever you are! You can change a status of the order, give a discount and do a lot of nice stuff! </p>

                <p><a class="btn btn-default" href="../purchases/index">Manage Purchases &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h3>Make your clients distinguish</h3>

                <p>Add custom information about your clients, like height, favorite drink or whatever you find useful!</p>
                <br/>
                <p><a class="btn btn-default" href="../attributes">Add Clients Attributes &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h3>Achieve your goals</h3>

                <p>With miniCrm you can set your daily, weekly or even monthly goals! Boost your productavity to gain valuable commission</p>

                <p><a class="btn btn-default" href="../goals">Set your goals &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
