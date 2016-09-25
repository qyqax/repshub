<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\SignupForm;
use common\models\CreateAccountForm;
use common\models\LoginForm;
use common\models\ChooseCompanyForm;
use common\models\UserPasswordResets;
use common\models\Users;
use common\models\GlobalFunctions;
use common\models\Mailer;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'reset', 'signup', 'authenticate','createaccount'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'verification', 'authenticate', 'choosecompany'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionAuthenticate($email, $authkey)
    {

        $user = Users::findByEmail($email);
        if($user->validateAuthKey($authkey)) {
          $user->user_verified = 1;
          if($user->save())
          {
            // Yii::$app->session->destroy();
             Yii::$app->user->logout();

            // Yii::$app->cache->flush();
            // Yii::$app->user->login($user,  3600 * 24 * 30 );

            //Mailer::sendAuthenticatedEmail($user);

            return $this->actionLogin();
          } else {
              throw new NotFoundHttpException('The requested page does not exist.');
          }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionReset()
    {
        $model = new Users;
        if (Yii::$app->request->post()) {
          $user = Users::findByEmail(Yii::$app->request->post()['Users']['user_email']);
          if($user != null)
          {
            $reset = new UserPasswordResets();
            $reset->id = GlobalFunctions::generateUniqueId();
            $reset->user_id = $user->id;
            $reset->upr_token = GlobalFunctions::generatePasswordResetToken();
            $reset->status = 1;
            $reset->upr_request_time = date('Y-m-d H:i:s');
            if($reset->save())
            {
              //reset URL to send on email
              $resetUrl = "http://localhost/repshub/backend/web/reset?id=".$reset->id."&token=".$reset->upr_token;
              //"not me" URL to send on email
              $ignoreUrl = "http://localhost/repshub/backend/web/reset/ignore?id=".$reset->id."&token=".$reset->upr_token;
              //Mailer::sendPasswordResetEmail($user, $resetUrl, $ignoreUrl);
              return $this->actionIndex();
            }
            else {
              return $this->render('error', [
                  'name' => 'Server Error',
                  'message' => 'There was an error while processing your request, please try again.'
              ]);
            }
          }
          else {
            return $this->render('error', [
                'name' => 'Wrong email',
                'message' => 'There is no user with that email.'
            ]);
          }
        }
        else {
          return $this->render('reset', [
              'model' => $model,
          ]);
        }
    }

    public function actionVerification()
    {
        return $this->render('verification');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if($model->login()){

            }else{
               
            Yii::$app->getSession()->setFlash('danger', [
                    'type' => 'danger',
                    'duration' => 12000,
                    'icon' => 'fa fa-level-down',
                    'message' => Yii::t('app',Html::encode('Password or email incorrect !')),
                    'title' => Yii::t('app', Html::encode('Login failed!')),
                    'positonY' => 'top',
                    'positonX' => 'right'
                ]);

               return $this->render('login', [
                'model' => $model,
            ]);
            }

          
            $this->redirect(\Yii::$app->urlManager->createUrl("site/choosecompany"));
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionChoosecompany()
    {

      if(isset(Yii::$app->user->identity) && Yii::$app->user->identity->user_verified != 1)
      {
        $this->redirect(\Yii::$app->urlManager->createUrl("site/verification"));
      }
      $model = new ChooseCompanyForm();
      $model->getUserCompanies();
      if(count($model->companies) == 1)
      {
        $model->company_id = $model->companies[0]->company->id;
        $model->chooseCompany();
        return $this->goHome();
      }
      if(count($model->companies) == 0)
      {
        return $this->render('error', [
            'name' => 'No Companies',
            'message' => 'This account is no longer associated to any companies.'
        ]);
      } else {
        if ($model->load(Yii::$app->request->post()) && $model->chooseCompany()) {
            return $this->goHome();
        } else {
            return $this->render('choosecompany', [
                'model' => $model,
            ]);
        }
      }

    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
              $authUrl="http://localhost/repshub/backend/web/site/authenticate?email=".$model->user_email."&authkey=".$model->user_auth_key;
                  // if(isset($password))
                  // {
                    
                  //   Mailer::sendUserAddedEmail($model, $authUrl);
                  // } else {
                   Mailer::sendSignupEmail($user, $authUrl);
                       return $this->render('index');
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionCreateaccount()
    {
      $model = new CreateAccountForm();

      if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                      return $this->redirect(array('myaccount/index/'));
                }
            }
        }

        return $this->render('createAccount', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
  }
}
