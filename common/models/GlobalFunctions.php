<?php

namespace common\models;
use backend\models\LevelsThresholds;

use Yii;

class GlobalFunctions
{
    /**
    * Generate a unique ID
    *
    * @return String Unique ID
    */
    public static function generateUniqueId() {
      return bin2hex(openssl_random_pseudo_bytes(8)) . uniqid();
    }

    /**
    * Generate a random password
    *
    * @return String Random
    */
    public static function generateRandomPassword() {
      return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 10 );
    }

    /**
     * Generates new password reset token
     */
    public static function generatePasswordResetToken()
    {
        return Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Transforms a given string into a URL string
     *
     * @param  string $text     Text to slugify
     * @return string           Slugified text
     */
     public static function slugify($text) {
        if (empty($text)) {
          return null;
        }

        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        // trim
        $text = trim($text, '-');
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // lowercase
        $text = strtolower($text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        return $text;
    }

    public static function getOS() {
      $user_agent = $_SERVER['HTTP_USER_AGENT'];

      $os_platform    =   "Unknown OS Platform";

      $os_array       =   array(
                              '/windows nt 10/i'     =>  'Windows 10',
                              '/windows nt 6.3/i'     =>  'Windows 8.1',
                              '/windows nt 6.2/i'     =>  'Windows 8',
                              '/windows nt 6.1/i'     =>  'Windows 7',
                              '/windows nt 6.0/i'     =>  'Windows Vista',
                              '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                              '/windows nt 5.1/i'     =>  'Windows XP',
                              '/windows xp/i'         =>  'Windows XP',
                              '/windows nt 5.0/i'     =>  'Windows 2000',
                              '/windows me/i'         =>  'Windows ME',
                              '/win98/i'              =>  'Windows 98',
                              '/win95/i'              =>  'Windows 95',
                              '/win16/i'              =>  'Windows 3.11',
                              '/macintosh|mac os x/i' =>  'Mac OS X',
                              '/mac_powerpc/i'        =>  'Mac OS 9',
                              '/linux/i'              =>  'Linux',
                              '/ubuntu/i'             =>  'Ubuntu',
                              '/iphone/i'             =>  'iPhone',
                              '/ipod/i'               =>  'iPod',
                              '/ipad/i'               =>  'iPad',
                              '/android/i'            =>  'Android',
                              '/blackberry/i'         =>  'BlackBerry',
                              '/webos/i'              =>  'Mobile'
                          );

      foreach ($os_array as $regex => $value) {

          if (preg_match($regex, $user_agent)) {
              $os_platform    =   $value;
          }

      }

      return $os_platform;

  }

  public static function getBrowser() {
      $user_agent = $_SERVER['HTTP_USER_AGENT'];
      $browser        =   "Unknown Browser";

      $browser_array  =   array(
                              '/msie/i'       =>  'Internet Explorer',
                              '/firefox/i'    =>  'Firefox',
                              '/safari/i'     =>  'Safari',
                              '/chrome/i'     =>  'Chrome',
                              '/opera/i'      =>  'Opera',
                              '/netscape/i'   =>  'Netscape',
                              '/maxthon/i'    =>  'Maxthon',
                              '/konqueror/i'  =>  'Konqueror',
                              '/mobile/i'     =>  'Handheld Browser'
                          );

      foreach ($browser_array as $regex => $value) {

          if (preg_match($regex, $user_agent)) {
              $browser    =   $value;
          }

      }

      return $browser;

  }

  public static function getDevice() {
    $device = "Unknown";
    $tablet_browser = 0;
    $mobile_browser = 0;

    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
      $tablet_browser++;
    }

    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
      $mobile_browser++;
    }

    if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
      $mobile_browser++;
    }

    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
    $mobile_agents = array(
      'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
      'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
      'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
      'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
      'newt','noki','palm','pana','pant','phil','play','port','prox',
      'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
      'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
      'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
      'wapr','webc','winw','winw','xda ','xda-');

    if (in_array($mobile_ua,$mobile_agents)) {
      $mobile_browser++;
    }

    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
      $mobile_browser++;
      //Check for tablets on opera mini alternative headers
      $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
      if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
        $tablet_browser++;
      }
    }

    if ($tablet_browser > 0) {
      $device = "Tablet";
    }
    else if ($mobile_browser > 0) {
      $device = "Mobile";
    }
    else {
      $device = "Desktop";
    }
    return $device;
  }

  public static function getLevel()
  {

    if(!empty(StatsFunctions::currentMonthRevenue())){
      $revenue=StatsFunctions::currentMonthRevenue();
    }
    else {
      $revenue = 0;
    }
    
   return LevelsThresholds::find()
->where('threshold <='.$revenue)
->orderBy(['threshold' => SORT_DESC])
->limit(1)
->one();

  }

  public static function getNextLevel()
  {
    $currentLevel = self::getLevel();
    return LevelsThresholds::find()
->where('commision_percent >'.$currentLevel->commision_percent)
->orderBy(['threshold' => SORT_ASC])
->limit(1)
->one();
  }
}
