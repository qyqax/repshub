<?php

namespace backend\models;

use common\models\Users;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property string $id
 * @property string $company_id
 * @property string $user_id
 * @property string $client_name
 * @property string $client_email
 * @property string $client_phone
 * @property string $client_city
 * @property string $client_country
 * @property string $client_address
 * @property string $client_postal_code
 * @property string $NIF
 * @property string $client_photo
 * @property integer $client_gender
 * @property string $client_birthdate
 * @property integer $status
 * @property string $client_create_time
 * @property string $client_update_time
 * @property string $card_id_number
 * @property string $client_fb
 * @property string $client_tw
 *
 * @property ClientAttributes[] $clientAttributes
 * @property Companies $company
 * @property Users $user
 * @property Purchases[] $purchases
 */
class Clients extends \yii\db\ActiveRecord
{
     const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    public $client_new_photo;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ['client_email', 'unique', 'targetAttribute' => ['client_email', 'company_id']],
            [['id', 'client_name', 'client_email', 'client_phone', 'status'], 'required'],
            [['client_gender', 'status'], 'integer'],
            [['client_birthdate', 'client_create_time', 'client_update_time', 'client_photo'], 'safe'],
            [['id', 'company_id', 'user_id', 'client_name', 'client_email', 'client_phone', 'client_city', 'client_country', 'client_postal_code'], 'string', 'max' => 50],
            [['client_address', 'client_photo', 'client_fb', 'client_tw'], 'string', 'max' => 250],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['client_photo'], 'file', 'extensions'=>'jpg, gif, png'],
            [['NIF'], 'string', 'max' => 12],
            [['card_id_number'], 'string', 'max' => 15]
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'client_name' => Yii::t('app', 'Client Name'),
            'client_email' => Yii::t('app', 'Client Email'),
            'client_phone' => Yii::t('app', 'Client Phone'),
            'client_city' => Yii::t('app', 'Client City'),
            'client_country' => Yii::t('app', 'Client Country'),
            'client_address' => Yii::t('app', 'Client Address'),
            'client_postal_code' => Yii::t('app', 'Client Postal Code'),
            'NIF' => Yii::t('app', 'Nif'),
            'client_photo' => Yii::t('app', 'Client Photo'),
            'client_gender' => Yii::t('app', 'Client Gender'),
            'client_birthdate' => Yii::t('app', 'Client Birthdate'),
            'status' => Yii::t('app', 'Status'),
            'client_create_time' => Yii::t('app', 'Client Create Time'),
            'client_update_time' => Yii::t('app', 'Client Update Time'),
            'card_id_number' => Yii::t('app', 'Card Id Number'),
            'client_fb' => Yii::t('app', 'Client Fb'),
            'client_tw' => Yii::t('app', 'Client Tw'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientAttributes()
    {
       
        $account_id = empty(Yii::$app->user->identity->accounts->account_id) ? NULL : Yii::$app->user->identity->accounts->account_id;
       
        return $this->hasMany(ClientAttributes::className(), ['client_id' => 'id'])
        ->join('inner join','attributes','client_attributes.attribute_id=attributes.id')
        ->andWhere(['attributes.account_id' => NULL])
        ->orWhere(['attributes.account_id' =>$account_id])->all();
    }
    public function getPhoto()
    {
      return($this->client_photo == '' || !isset($this->client_photo)) ? 'default.jpg' : $this->client_photo;
    }
     public function getGender()
    {
      return ($this->client_gender != null) ? (($this->client_gender == 1) ? 'Male' : 'Female') : 'Unknown';
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Companies::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchases()
    {
        return $this->hasMany(Purchases::className(), ['client_id' => 'id']);
    }

    public function getBirthdate()
    {
        return date_create_from_format('Y-m-d',$this->client_birthdate );         
    }

}
