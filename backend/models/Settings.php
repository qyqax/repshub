<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tmps_users_settings".
 *
 * @property string $user_id
 * @property integer $dismiss_tooltips
 * @property string $date_format
 * @property integer $time_format
 * @property string $language
 * @property string $timezone
 * @property integer $units
 * @property string $currency
 *
 * @property Users $user
 */
class Settings extends \yii\db\ActiveRecord
{
    // Integer representatives of time format
    const TIME_24_FORMAT = 0;
    const TIME_12_FORMAT = 1;

 

    // Available languages
    public static $LANGUAGES = [
        "en-US" => "English",
        // "pt-PT" => "Português",
        // "es-ES" => "Español",
        // "fr-FR" => "Français",
    ];

    public function __construct()
    {
        $this->loadDefaultValues();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id',  'date_format', 'time_format', 'language', 'timezone',  'currency'], 'required'],
            [[ 'time_format'], 'integer'],
            [['user_id', 'timezone'], 'string', 'max' => 50],
            [['language', 'currency'], 'string', 'max' => 5],
            [['language'], 'in', 'range' => array_keys(self::$LANGUAGES)],
            [['date_format'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User'),
            
            'date_format' => Yii::t('app', 'Date format'),
            'time_format' => Yii::t('app', 'Time format'),
            'timezone' => Yii::t('app', 'Timezone'),
            
            'currency' => Yii::t('app', 'Currency'),
        ];
    }

    // Available currencies
    public static function getAvailableCurrencies() {
        return [
            "EUR" => Yii::t('app', 'Euro'),
            "USD" => Yii::t('app', 'Dollar'),
        ];
    }

    public static function getLanguages() {
        return self::$LANGUAGES; 
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * Get date format with PHP format
     * @return string
     */
    public function getDatePhpFormat()
    {
        return "php:" . $this->date_format;
    }

    /**
     * Get date time format with PHP format
     * @return string
     */
    public function getDateTimePhpFormat()
    {
        return "php:" . $this->getDateTimeFormat();
    }

    /**
     * Get date time format
     * @return string
     */
    public function getDateTimeFormat()
    {
        return ($this->time_format == UsersSettings::TIME_24_FORMAT) ? $this->date_format . ' H:i' : $this->date_format . ' h:i';
    }

    /**
     * Get all avalaible formats for dates
     * @return array
     */
    public static function getDateFormats()
    {
        return [
            'Y-m-d' => date('Y-m-d'),
            'Y-d-m' => date('Y-d-m'),
            'd-m-Y' => date('d-m-Y'),
            'm-d-Y' => date('m-d-Y'),
        ];
    }

    /**
     * Get a given date with user format and converted to user timezone
     * 
     * @param  string   $value              String to convert
     * @param  boolean  $time               Whether or not to include time
     * @param  boolean  $timezone           Whether or not to convert to user timezone
     * @return string
     */
    public function parseValue($value, $time = false, $timezone = false)
    {
        if (empty($value) || is_null($value)) return '<i>' . Yii::t('app', 'Not available') . '</i>';

        $date = new \DateTime($value, new \DateTimezone(Yii::$app->formatter->timeZone));
        if ($timezone) {
            $date->setTimezone(new \DateTimeZone($this->timezone));
        }
        return $date->format(($time) ? $this->getDateTimeFormat() : $this->date_format);
    }

    /**
     * Get current datetime in default timezone
     * 
     * @return string
     */
    public static function getNowDefaultTimezone()
    {
        $date = new \DateTime("now", new \DateTimezone(Yii::$app->formatter->timeZone));
        return $date->format("Y-m-d H:i:s");
    }

    /**
     * Get current date in default timezone
     * 
     * @return string
     */
    public static function getCurrentDateDefaultTimezone()
    {
        $date = new \DateTime("now", new \DateTimezone(Yii::$app->formatter->timeZone));
        return $date->format("Y-m-d");
    }

    public function getDateFormat(){
       
        return str_replace("Y", "yyyy",$this->date_format);      
    }

    /*
    ** parse given string to dateFormat specified by a User
    */
    public static function parseDateTime($datetime)
    {
        $date = substr($datetime,0,10);
      
        $time = substr($datetime,11);

        $datetime =  date_create_from_format(Yii::$app->user->identity->settings->date_format, $datetime);
//var_dump(Yii::$app->user->identity->settings->date_format);die;
    //    $date = date_format(date_create_from_format('Y-m-d',$date), Yii::$app->user->identity->settings->date_format);
      
        return $datetime;
    }

    
}