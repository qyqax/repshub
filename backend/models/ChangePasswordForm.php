<?php 
    
    namespace backend\models;

    use common\models\Users;

    use Yii;

    
    
    class ChangePasswordForm extends Model{
        public $oldpass;
        public $newpass;
        public $repeatnewpass;
      
        
        public function rules(){
            return [
                [['oldpass','newpass','repeatnewpass'],'required'],
                ['oldpass','findPasswords'],
                ['repeatnewpass','compare','compareAttribute'=>'newpass'],
            ];
        }
        
        public function findPasswords($attribute, $params){
            $user = Users::find()->where([
                'id'=>Yii::$app->user->identity->id
            ])->one();
            $password = $user->user_password;
            if($password!=$this->oldpass)
                $this->addError($attribute,'Old password is incorrect');
           
        }
        
        public function attributeLabels(){
            return [
                'oldpass'=> Yii::t('app', 'Old Password'),
                'newpass'=> Yii::t('app','New Password'),
                'repeatnewpass'=> Yii::t('app','Repeat New Password'),
            ];
        }
    }