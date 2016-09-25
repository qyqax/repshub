<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use kartik\grid\GridView;
use kartik\growl\Growl;
use kartik\nav\NavX;


/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    
</head>
<body>
<?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
            <?php
            echo Growl::widget([
                'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
                'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
                'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
                'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
                'showSeparator' => true,
                'delay' => 1, //This delay is how long before the message shows
                'pluginOptions' => [
                    'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
                    'placement' => [
                        'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                        'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
                    ]
                ]
            ]);
         endforeach;   ?>
       

    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            if (Yii::$app->user->isGuest || !Yii::$app->company->hasChosen()) {
              NavBar::begin([
                  'options' => [
                      'class' => 'navbar-inverse navbar-fixed-top',
                  ],
              ]);
            } else {
                NavBar::begin([
                    'brandLabel' => Yii::$app->company->getCompanyName(),
                    'brandUrl' => ['/company'],
                    'options' => [
                        'class' => 'navbar-inverse navbar-fixed-top',
                    ],
                ]);
            }
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            } else {

                if(Yii::$app->role->hasModule('users'))
                {
                  $menuItems[] = [
                      'label' => 'Users',
                      'url' => ['/users/index']
                  ];
                }
                if(Yii::$app->role->isOwner())
                {
                  $menuItems[] = [
                      'label' => 'User Roles',
                      'url' => ['/roles/index']
                  ];
                
                }
                if(Yii::$app->role->hasModule('clients'))
                {
                  $menuItems[] = [
                      'label' => 'Clients',
                      'url' => ['/clients/index']
                  ];
                }
                if(Yii::$app->session['companies'] > 1)
                {
                  $menuItems[] = [
                      'label' => 'Change Company',
                      'url' => ['/site/choosecompany']
                  ];
                }
               // if(empty(Yii::$app->user->identity->getAccounts())){
                 if(Yii::$app->user->identity->accounts)
                 {
                       $menuItems[] = [
                    'label' => 'Purchases',
                    'url' => ['/purchases']
                ];
                $menuItems[] = [
                    'label' => 'Products',
                    'url' => ['/products']
                ];
               
                $menuItems[] = [
                    'label' => 'Profile',
                    'url' => ['/myaccount']
                ];


                $menuItems[] =[
                'label' => 'Settings',
                'items' => [                
                ['label'=>'Account','url'=>['/settings/account']],
                ['label'=>'Password','url'=>['/settings/password']],
                ['label'=>'Clients Attributes','url'=>['/settings/clients']],
                ]
                
                ];
                }
                else{

                        $menuItems[] = [
                    'label' => 'Products',
                    'url' => ['/products']
                ];
                    $menuItems[] = [
                    'label' => 'Categories',
                    'url' => ['/categories']
                ];
                         $menuItems[] = [
                    'label' => 'Levels',
                    'url' => ['/levels']
                ];
                 
                }
                
            
                

                $menuItems[] = [
                    'label' => 'Logout (' . Yii::$app->user->identity->user_name . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
               
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
