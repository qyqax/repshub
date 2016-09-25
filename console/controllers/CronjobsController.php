<?php

namespace console\controllers;
use Yii;
use yii\db\Query;
use common\models\Users;
use backend\models\Goals;
use backend\models\Brochures;


class CronjobsController extends \yii\console\Controller
{

    public function actionCheckexpiration()
    {
        echo "cron job running";
    	/*
    	* our date which we want to check (purchase.created_at)
    	*/
 		$time = strtotime('now -10 days ');
        $date = date("Y-m-d", $time);

        $today = strtotime('now');
        $todayDate = date("Y-m-d", $today);
  
        //diffrence between actual date and $time
        $diff = $today - $time;
        $interval = floor($diff/(60*60*24));

        //$interval = 10;

        
        /*
        ** pure sql sample
        */
        /*
        select 
           pu.user_id as 'user',
           p.product_name , 
            c.client_name as client,
            p.expiry_date, 
            pp.purchase_id, 
            pu.created_at, 
            (p.expiry_date - DATEDIFF(CURDATE(),pu.created_at)) as expire  , 
            DATEDIFF(CURDATE(),pu.created_at) as datediff,
           
            date(pu.created_at) as day
            from products p 
            join purchase_product pp on p.product_id = pp.product_id 
            join purchases pu on pu.purchase_id=pp.purchase_id
            
            join purchase_statuses ps on pu.purchase_id=ps.purchase_id
            join clients c on c.id = pu.client_id
            where (p.expiry_date - 10) < 400
            and ps.status_date in 
              (SELECT max(status_date) FROM `purchase_statuses` group by purchase_id ORDER by status_date DESC ) 
               and ps.status = 'delivery'   
            and pp.send_alert = 1   
            GROUP by  'user',client,product_name

            */


        $command = \Yii::$app->db->createCommand(
        "select 
           pu.user_id as 'user',
           p.product_name , 
           pp.quantity as 'quantity', 
           p.product_image as 'image',

            c.client_name as 'client',
            c.client_email as 'client_email',

            p.expiry_date, 
            pp.purchase_id,

            pu.created_at, 
            (p.expiry_date - DATEDIFF(CURDATE(),pu.created_at)) as expire  , 
            DATEDIFF(CURDATE(),pu.created_at) as datediff,
           
            date(pu.created_at) as day
            from products p 
            join purchase_product pp on p.product_id = pp.product_id 
            join purchases pu on pu.purchase_id=pp.purchase_id
            #join users u on pu.user_id = u.id
            
            join purchase_statuses ps on pu.purchase_id=ps.purchase_id
            join clients c on c.id = pu.client_id
            where (p.expiry_date - ".$interval.") < 10
            and ps.status_date in 
              (SELECT max(status_date) FROM `purchase_statuses` group by purchase_id ORDER by status_date DESC ) 
               and ps.status = 'delivery'   
            #and pp.send_alert = 1   
           # and ps.status_date like '".$date."%'
            GROUP by  'user',client,product_name

            
        ");


        $result = $command->queryAll();


        //if some expired product found
           if(count($result)){
           echo "\n amount of expired products: ". count($result);

           }



       // var_dump($groups);
        $data = array();
        foreach ($result as $item) {
            
            $data[$item['user']][$item['client']][] = $item['product_name']." (". $item['quantity']." ordered products)";
            }

      // var_dump($data);
       /* $data = array();
        
        foreach ($products as $item) {
        	echo $item;    
        	$data[$item['email']][$item['client']][] = $item['product_name'];
        	/*$mail = \Yii::$app->mailer->compose()
        	    ->setFrom(['sender@sender.com'=> 'Expire product'])
        		->setTo($item['email'])
        		->setSubject("Don't forget about your clients")
        		->setTextBody('yeah');
*/
        		//echo $item['product_name'].' '.$item['user']."\n";
    //    }
        
        foreach ($data as $user => $clients) {
        	
        	$user = Users::find(['id'=>$user])->one();
        	$content = 'Hey '.$user->user_name." do not forget about your clients!\n\n";
        	
        	foreach ($clients as $client => $products) {
        	$content = $content.'Client: '.$client." ordered this products which probably expired: \n\n";
        		//echo $client."\n";
        	
        	foreach ($products as $i => $product) {
                $index = $i;
        		$content = $content.++$index.". ".$product."\n";
        		//echo $product."\n";
        	}
        }
        $mail = \Yii::$app->mailer->compose()
        	    ->setFrom(['sender@sender.com'=> 'Reminder'])
        		->setTo($user->user_email)
        		->setSubject("Don't forget about your clients")
        		->setTextBody($content)
        		->send();
        echo $content."\n\n";
        }

     
       
    }
    /*
	* set time_of_receive to NULL at the end of the day,week,month
    */
    public function actionUnsetdailygoals()
    {
    	Goals::updateAll(['time_of_receive'=>NULL],"goal_type = 'daily'");
    }

    public function actionUnsetweeklygoals()
    {
    	Goals::updateAll(['time_of_receive'=>NULL],"goal_type = 'weekly'");
    }

    public function actionUnsetmonthlygoals()
    {
    	Goals::updateAll(['time_of_receive'=>NULL],"goal_type = 'monthly'");
    }

    /*
    * If brochure gonna expire send email
    */
/************
**** TODO
*/
 /*   public function actionCheckbrochures()
    {
        $date = date("Y-m-d");
        
      
         $command = \Yii::$app->db->createCommand(
        "
            SELECT * FROM brochures  
          
            where expire_date like '".$date."';
        ");

         $results = $command->queryAll();
         $data = array();
//         echo $results;

         foreach ($results as $result) {
            $data[$result['user_id']][]=$result['brochure_id'];
           
         }

         foreach ($data as $user_id => $brochures) {
            
            $user = Users::findOne($user_id);

            $content = "Hey ".$user->user_name." some brochure are going to expire today: "."\n";

            foreach ($brochures as $brochure_id) {
                $brochure = Brochures::findOne($brochure_id);
                $location = $brochure->location;
                $content = $content.$brochure->description." located at: ".$location->location_name;
                $content = $content." address: ".$location->city." ".$location->address." \n";
                $content = $content."Phone number: ".$location->phone."\n";
            }

             $mail = \Yii::$app->mailer->compose()
                ->setFrom(['sender@sender.com' => 'Reminder'])
                ->setTo($user->user_email)
                ->setSubject("Don't forget to send new brochure")
                ->setTextBody($content)
                ->send();
           echo $content;
         }

    }*/     
}
