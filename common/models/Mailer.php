<?php

namespace common\models;

use Yii;
use sendwithus\API;

class Mailer
{
      const APIKEY = 'live_8332ccd98793f83de0d8a2642b85cbb5ad51859f';
      public static function sendAuthenticatedEmail($user)
      {
          $api = new API(self::APIKEY);

          $api->send(
              'tem_gpgte6PXJjXKSNgNstiL75',
              array(
                  'address' => $user->user_email,
              ),
              array(
                  'email_data' => array(
                      'user_name' => $user->user_name,
                  )
              )
          );
      }


      public static function sendPasswordResetEmail($user, $resetUrl, $ignoreUrl)
      {
          $api = new API(self::APIKEY);

          $api->send(
              'tem_AKDBBy2y4S2h6yryeXJCtW',
              array(
                  'address' => $user->user_email,
              ),
              array(
                  'email_data' => array(
                      'user_name' => $user->user_name,
                      'reset_Url' => $resetUrl,
                      'ignore_Url' => $ignoreUrl,
                  )
              )
          );
      }

      public static function sendSignupEmail($user, $authUrl)
      {
        $api = new API(self::APIKEY);

        $api->send(
            'tem_k988BoLeRfaPtdnDSbsAQZ',
            array(
                'address' => $user->user_email,
            ),
            array(
                'email_data' => array(
                    'user_name' => $user->user_name,
                   
                    'button_text' => "Activate Account",
                    'button_url' => $authUrl,
                )
            )
        );

      }

     /* public static function sendUserAddedEmail($user, $authUrl)
      {
        $api = new API(self::APIKEY);

        $api->send(
            'tem_gpgte6PXJjXKSNgNstiL75',
            array(
                'address' => $user->user_email,
            ),
            array(
                'email_data' => array(
                    'user_name' => $user->user_name,
                    'password' => $password,
                    'button_text' => "Activate Account",
                    'button_url' => $authUrl,
                )
            )
        );

      }*/

      public static function sendUserAddedEmail($user, $authUrl, $password)
      {
        $api = new API(self::APIKEY);

        $api->send(
            'tem_AKDBBy2y4S2h6yryeXJCtW',
            array(
                'address' => $user->user_email,
            ),
            array(
                'email_data' => array(
                    'user_name' => $user->user_name,
                    'password' => $password,
                    'button_text' => "Activate Account",
                    'button_url' => $authUrl,
                )
            )
        );

      }

}
