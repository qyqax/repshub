<?php

namespace common\models;

use Yii;

class StatsFunctions
{	

		
        /*
        * return the sum of all orders values in current week month and year for logged in user
        */
	public static function currentWeekRevenue()
	{
		$today = new \DateTime();
        $current_week = $today->format("W");

		$current_month=date("m");
        $current_year=date("Y");
        $user_id = Yii::$app->user->id;


        $command = Yii::$app->db->createCommand("SELECT round(sum(p.sum),2) FROM purchases p join purchase_statuses ps 
            on p.purchase_id = ps.purchase_id 
            where user_id='".$user_id."' 
            and ps.status_date in 
              (SELECT max(status_date) FROM `purchase_statuses` group by purchase_id ORDER by status_date DESC ) 
               and ps.status = 'delivery'

            and year(ps.status_date) = ".$current_year."
            and month(ps.status_date) = ".$current_month."
        	and week(ps.status_date,3) = ".$current_week);
        if($command->queryScalar()==NULL){
            return 0;
        }else{
          return $command->queryScalar();  
        }

        
	}
        /*
        * return the sum of all orders values in current day month and year for logged in user
        */

    public static function currentDayRevenue()
    {
        $current_day = date("d");
        $current_month=date("m");
        $current_year=date("Y");
        $user_id = Yii::$app->user->id;

        $command = Yii::$app->db->createCommand("SELECT round(sum(p.sum),2)FROM purchases p join purchase_statuses ps 
            on p.purchase_id = ps.purchase_id 
            where user_id='".$user_id."' 
             and ps.status_date in 
              (SELECT max(status_date) FROM `purchase_statuses` group by purchase_id ORDER by status_date DESC ) 
               and ps.status = 'delivery'
            and year(ps.status_date) = ".$current_year."
            and month(ps.status_date) = ".$current_month."
            and day(ps.status_date) = ".$current_day);
        
if($command->queryScalar()==NULL){
            return 0;
        }else{
          return $command->queryScalar();  
        }
    }
        
        /*
        * return the sum of all orders values in current month and year for logged in user
        */

	public static function currentMonthRevenue()
	{
		$current_month=date("m");
        $current_year=date("Y");
        $user_id = Yii::$app->user->id;



        $command = Yii::$app->db->createCommand("SELECT round(sum(p.sum),2) FROM purchases p join purchase_statuses ps 
            on p.purchase_id = ps.purchase_id 
            where user_id='".$user_id."' 
             and ps.status_date in 
              (SELECT max(status_date) FROM `purchase_statuses` group by purchase_id ORDER by status_date DESC ) 
               and ps.status = 'delivery'
            and year(ps.status_date) = ".$current_year."
            and month(ps.status_date) = ".$current_month);
if($command->queryScalar()==NULL){
            return 0;
        }else{
          return $command->queryScalar();  
        }
	}
       

        /*
        * return the sum of all orders values in current year for logged in user
        */
	
	public static function currentYearRevenue()
	{
		
        $current_year=date("Y");
        $user_id = Yii::$app->user->id;

        $command = Yii::$app->db->createCommand("SELECT round(sum(p.sum),2) FROM purchases p join purchase_statuses ps 
            on p.purchase_id = ps.purchase_id 
            where user_id='".$user_id."'
             and ps.status_date in 
              (SELECT max(status_date) FROM `purchase_statuses` group by purchase_id ORDER by status_date DESC ) 
               and ps.status = 'delivery' 
            and year(ps.status_date) = ".$current_year);
           
if($command->queryScalar()==NULL){
            return 0;
        }else{
          return $command->queryScalar();  
        }
	}	
		
		/*
        * return the sum of all orders values for logged in user
        */
    public static function userTotalRevenue()
    {
		$user_id = Yii::$app->user->id;
		$command = Yii::$app->db->createCommand("SELECT round(sum(p.sum),2) FROM purchases where user_id='".$user_id."'
 and ps.status_date in 
              (SELECT max(status_date) FROM `purchase_statuses` group by purchase_id ORDER by status_date DESC ) 
               and ps.status = 'delivery'
            ");
		return $command->queryScalar();
    }
    	/*
        * return array of information about all brochures and their order values for logged in user
        */
    public static function eachBrochureSum($given_month=NULL)
    {
        if($given_month==NULL)
        {
            $month=date('m');
        }
        else
        {
            $month=$given_month;
        }
        $current_year=date("Y");
    	$user_id = Yii::$app->user->id;
    	$command = Yii::$app->db->createCommand("
    		select round(sum(p.sum),2) as sum ,b.* ,l.*,day(ps.status_date) as day
            from purchases p join brochures b on p.brochure_id=b.brochure_id 
            join purchase_statuses ps on p.purchase_id=ps.purchase_id
            join locations l on b.location_id = l.location_id
            where p.user_id= '".$user_id."'
             and ps.status_date in 
              (SELECT max(status_date) FROM `purchase_statuses` group by purchase_id ORDER by status_date DESC ) 
               and ps.status = 'delivery'
            and year(ps.status_date) = ".$current_year."
            and month(ps.status_date) = ".$month."
            group by p.brochure_id
            ORDER by p.sum desc");

       	return $command->queryAll();
    }

    /*
        * return array of information about all brochures and their order values for logged in user
        */
    public static function eachBrochureSumRange($start_date,$end_date)
    {
      
        $user_id = Yii::$app->user->id;
        $command = Yii::$app->db->createCommand("
            select round(sum(p.sum),2) as sum ,b.* ,l.*,day(ps.status_date) as day
            from purchases p join brochures b on p.brochure_id=b.brochure_id 
            join purchase_statuses ps on p.purchase_id=ps.purchase_id
            join locations l on b.location_id = l.location_id
            where p.user_id= '".$user_id."'
             and ps.status_date in 
              (SELECT max(status_date) FROM `purchase_statuses` group by purchase_id ORDER by status_date DESC ) 
              and ps.status = 'delivery'
            and date(ps.status_date) between '".$start_date."' and '".$end_date."'
            group by p.brochure_id
            ORDER by p.sum desc");

        return $command->queryAll();
    }

    /*
        * return array of information about all sells in each day of given month (string), current month by default for logged in user
     */
    
    public static function salesPerDay($given_month=NULL)
    {
    	if($given_month==NULL)
        {
    		$month=date('m');
        }
        else
        {
            $month=$given_month;
        }
    	$current_year=date("Y");

		$user_id = Yii::$app->user->id;
    	$command = Yii::$app->db->createCommand("
			SELECT round(sum(p.sum),2) as sum ,day(ps.status_date) as day from purchases p join purchase_statuses ps 
			on p.purchase_id = ps.purchase_id  
			where p.user_id = '".$user_id."'
			 and ps.status_date in 
              (SELECT max(status_date) FROM `purchase_statuses` group by purchase_id ORDER by status_date DESC ) 
               and ps.status = 'delivery'
			and year(ps.status_date) = ".$current_year."
            and month(ps.status_date) = ".$month."
			group by day(ps.status_date)
			order by day(ps.status_date)");

    	return $command->queryAll();
    }

    /*
        * return array of information about all sells in each day of given range for logged in user
     */
    
    public static function salesPerDayRange($start_date,$end_date)
    {
        
        

        $user_id = Yii::$app->user->id;
        $command = Yii::$app->db->createCommand("
            SELECT round(sum(p.sum),2) as sum ,date(ps.status_date) as day from purchases p join purchase_statuses ps 
            on p.purchase_id = ps.purchase_id  
            where p.user_id = '".$user_id."'
             and ps.status_date in 
              (SELECT max(status_date) FROM `purchase_statuses` group by purchase_id ORDER by status_date DESC ) 
               and ps.status = 'delivery'
            and date(ps.status_date) between '".$start_date."' and '".$end_date."'
            group by day(ps.status_date)
            order by day(ps.status_date)");

        return $command->queryAll();
    }

    /*
     * return array of information about clients and thier's orders values in current year for logged in user
    */

    public static function clientsInfo($given_month=NULL)
    {

        if($given_month==NULL)
        {
            $month=date('m');
        }
        else
        {
            $month=$given_month;
        }
    	$user_id = Yii::$app->user->id;
    	$current_year=date("Y");

    	$command = Yii::$app->db->createCommand("
			SELECT c.client_name,round(sum(p.sum),2) as sum,day(ps.status_date) as day FROM purchases p join clients c on p.client_id=c.id 
			join purchase_statuses ps on p.purchase_id=ps.purchase_id
			where p.user_id = '".$user_id."'
             and ps.status_date in 
              (SELECT max(status_date) FROM `purchase_statuses` group by purchase_id ORDER by status_date DESC ) 
               and ps.status = 'delivery'
			and year(ps.status_date) = ".$current_year."
            and month(ps.status_date) = ".$month."
           # and c.status = 1
			group by p.client_id 
			order by sum DESC
			");

    	return $command->queryAll();
    }

 /*
     * return array of information about clients and thier's orders values in current year for logged in user
    */

    public static function clientsInfoRange($start_date,$end_date)
    {

        $user_id = Yii::$app->user->id;
        $current_year=date("Y");

        $command = Yii::$app->db->createCommand("
            SELECT c.client_name,round(sum(p.sum),2) as sum,day(ps.status_date) as day FROM purchases p join clients c on p.client_id=c.id 
            join purchase_statuses ps on p.purchase_id=ps.purchase_id
            where p.user_id = '".$user_id."'
             and ps.status_date in 
              (SELECT max(status_date) FROM `purchase_statuses` group by purchase_id ORDER by status_date DESC ) 
               and ps.status = 'delivery'
            and date(ps.status_date) between '".$start_date."' and '".$end_date."'
            group by p.client_id 
            order by sum DESC
            ");

        return $command->queryAll();
    }
    /*
    *	return bestsellers products ever
    */
    public static function bestsellers($given_month=NULL)
    {
    	if($given_month==NULL)
        {
            $month=date('m');
        }
        else
        {
            $month=$given_month;
        }

        $user_id = Yii::$app->user->id;
    	$current_year=date("Y");

    	$command = Yii::$app->db->createCommand("
    		select p.product_name,sum(pp.quantity) as sum,day(ps.status_date) as day from purchase_product pp join products p on p.product_id=pp.product_id join purchases pur on pur.purchase_id = pp.purchase_id
			join purchase_statuses ps on pur.purchase_id=ps.purchase_id
            where pur.user_id = '".$user_id."'
             and ps.status_date in 
              (SELECT max(status_date) FROM `purchase_statuses` group by purchase_id ORDER by status_date DESC ) 
               and ps.status = 'delivery'
            and year(ps.status_date) = ".$current_year."
            and month(ps.status_date) = ".$month."
			group by pp.product_id 
			order by sum DESC
            limit 5
    			");

    	return $command->queryAll();

    }	

    /*
    *   return bestsellers products ever
    */
    public static function bestsellersRange($start_date,$end_date)
    {
       
        $user_id = Yii::$app->user->id;
       
        $command = Yii::$app->db->createCommand("
            select p.product_name,sum(pp.quantity) as sum,day(ps.status_date) as day from purchase_product pp join products p on p.product_id=pp.product_id join purchases pur on pur.purchase_id = pp.purchase_id
            join purchase_statuses ps on pur.purchase_id=ps.purchase_id
            where pur.user_id = '".$user_id."'
             and ps.status_date in 
              (SELECT max(status_date) FROM `purchase_statuses` group by purchase_id ORDER by status_date DESC ) 
               and ps.status = 'delivery'
            and date(ps.status_date) between '".$start_date."' and '".$end_date."'
            group by pp.product_id 
            order by sum DESC
            limit 5
                ");

        return $command->queryAll();

    }   

    /*
    *   return all products sold in current month
    */
    public static function productsSold()
    {
       
        $user_id = Yii::$app->user->id;

        $current_month=date("m");
        $current_year=date("Y");

       
       
        $command = Yii::$app->db->createCommand("
            select p.product_name as name,p.product_code as code,product_price as price,sum(pp.quantity) as sum from purchase_product pp join products p on p.product_id=pp.product_id join purchases pur on pur.purchase_id = pp.purchase_id
            join purchase_statuses ps on pur.purchase_id=ps.purchase_id
            where pur.user_id = '".$user_id."'
             and ps.status_date in 
              (SELECT max(status_date) FROM `purchase_statuses` group by purchase_id ORDER by status_date DESC ) 
               and ps.status = 'delivery'
            and year(ps.status_date) = ".$current_year."
            and month(ps.status_date) = ".$current_month."
            group by pp.product_id 
            order by sum DESC
            
                ");

        return $command->queryAll();

    }   


    /*
    * return number of products which have been sold in current month
    */
      public static function numberOfProducts()
    {
        $user_id = Yii::$app->user->id;
        $current_month=date('m');
        $current_year=date("Y");

        $command = Yii::$app->db->createCommand("
            select sum(pp.quantity) as sum from purchase_product pp 
            join products p on p.product_id=pp.product_id join purchases pur on pur.purchase_id = pp.purchase_id 
            join purchase_statuses ps on pp.purchase_id = ps.purchase_id 
            where pur.user_id = '".$user_id."'
             and ps.status_date in 
              (SELECT max(status_date) FROM `purchase_statuses` group by purchase_id ORDER by status_date DESC ) 
               and ps.status = 'delivery'
            and month(ps.status_date) = ".$current_month."
            and year(ps.status_date) = ".$current_year."        
            order by sum DESC
                ");
if($command->queryScalar()==NULL){
            return 0;
        }else{
          return $command->queryScalar();  
        }
    }


    /*
    ** return purchases in given date range
     */
    
    public static function purchasesDayRange($start_date,$end_date,$statuses)
    {
        $condition="";

        switch(count($statuses)){
            case 1 :
            $condition="and ps.status = '".$statuses[0]."'";
            break;
            
            case 2:
            case 3:
            $string = " '".implode ("', '", $statuses)."'";
            $condition = " and  ps.status in (".$string.")"; 
            break;             
            
            default: break;
        }

        $user_id = Yii::$app->user->id;
        $command = Yii::$app->db->createCommand("
            SELECT p.purchase_id from purchases p 
            join purchase_statuses ps on p.purchase_id=ps.purchase_id
            where p.user_id = '".$user_id."'
            and ps.status_date in 
              (SELECT max(status_date) FROM `purchase_statuses` group by purchase_id ORDER by status_date DESC )"
              .$condition."             
            and date(ps.status_date) between '".$start_date."' and '".$end_date."'
            ");

     

        return $command->queryAll();
    }   
}