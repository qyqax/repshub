<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../backend/config/main.php'),
    require(__DIR__ . '/../../backend/config/main-local.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/main-local.php')
);

$application = new yii\web\Application($config);
$application->run();


use Yii;
use yii\db\Query;
use common\models\Users;

$time = strtotime('now -10 days ');
        $date = date("Y-m-d", $time);

        $today = strtotime('now');
        $todayDate = date("Y-m-d", $today);
  
        //diffrence between actual date and $time
        $diff = $today - $time;
        $interval = floor($diff/(60*60*24));

 

        $command = \Yii::$app->db->createCommand(
    	"
			select 
			p.product_name , 
			c.client_name as client,
			p.expiry_date, 
			pp.purchase_id, 
			pu.created_at, 
			(p.expiry_date - DATEDIFF(CURDATE(),pu.created_at)) as expire  , 
			DATEDIFF(CURDATE(),pu.created_at) as datediff,
			u.user_name as 'user',
			u.user_email as email,
			date(pu.created_at) as day
			from products p 
			join purchase_product pp on p.product_id = pp.product_id 
			join purchases pu on pu.purchase_id=pp.purchase_id
			join users u on u.id = pu.user_id
			join clients c on c.id = pu.client_id
			where pu.created_at like '".$date."%'
			and (p.expiry_date - ".$interval.") < 4   
			GROUP by  email,client,product_name
		");


        $products = $command->queryAll();
       
        $data = array();
        
        foreach ($products as $item) {
        	
        	$data[$item['email']][$item['client']][] = $item['product_name'];
        	/*$mail = \Yii::$app->mailer->compose()
        	    ->setFrom(['sender@sender.com'=> 'Expire product'])
        		->setTo($item['email'])
        		->setSubject("Don't forget about your clients")
        		->setTextBody('yeah');
*/
        		//echo $item['product_name'].' '.$item['user']."\n";
        }
        
        foreach ($data as $email => $clients) {
        	//echo $email."\n";
        	//$setTo = $email;
        	$user = Users::findByEmail($email);
        	$content = 'Hey '.$user->user_name." do not forget about your clients!\n\n";
        	
        	foreach ($clients as $client => $products) {
        	$content = $content.'Client: '.$client." ordered this products which probably expired: \n\n";
        		//echo $client."\n";
        	
        	foreach ($products as $i => $product) {
        		$content = $content.$i.". ".$product."\n";
        		//echo $product."\n";
        	}
        }
        $mail = \Yii::$app->mailer->compose()
        	    ->setFrom(['sender@sender.com'=> 'Reminder'])
        		->setTo($email)
        		->setSubject("Don't forget about your clients")
        		->setTextBody($content)
        		->send();
        echo $content."\n\n";
        }
  