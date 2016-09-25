<?php
use backend\models\LevelsThresholds;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\models\StatsFunctions;
use scotthuangzl\googlechart\GoogleChart;
use kartik\export\ExportMenu;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\widgets\DatePicker;
use kartik\daterange\DateRangePicker;
use yii\web\JsExpression;




?>

<style type="text/css">
  
  .graph{
    width: 100%;
    
  }
  .filter{
        
    margin-top: 100px;
  }
  #monthlyControl{
    margin:5px;
  }

</style>



<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>


<script >
var graphs = [];

 /*
      * functions which work with dates
      */
      function parseDate(str) {
          var ymd = str.split('-')
          return new Date(ymd[0], ymd[1]-1, ymd[2]);
      }

      function daydiff(first, second) {
          return Math.round((second-first)/(24*3600*1000));
      }
      //parse date to yyyy-mm-dd
      function parseDateFormat(date){

        
        switch(date_format){
          case 'Y-m-d':          

          break;
          case 'Y-d-m':
          var ymd = date.split("-");
          date =new Date(ymd[0], ymd[2]-1, ymd[1]);

          break;
          case 'd-m-Y':
          var ymd = date.split("-");
          date =new Date(ymd[2], ymd[1]-1, ymd[0]);

          break;
          case 'm-d-Y':
          var ymd = date.split("-");
          date =new Date(ymd[2], ymd[0]-1, ymd[1]);

          break;
        }

        return date;

      }

     $( document ).ready(function() {

      date_format = <?php echo "'". Yii::$app->user->identity->settings->date_format."'" ?>;
      
    
      var bootstrapButton = $.fn.button.noConflict() // return $.fn.button to previously assigned value
      $.fn.bootstrapBtn = bootstrapButton            // give $().bootstrapBtn the Bootstrap functionality
       $(".CreateModalButton").click(function(e){
      var bootstrap3_enabled = (typeof $().emulateTransitionEnd == 'function');
      if(bootstrap3_enabled){  
        $("#createModal").modal('show').find("#createModalContent").load($(this).attr('value'));
      }else{
       $.noConflict();
      $("#createModal").modal('show').find("#createModalContent").load($(this).attr('value'));

      }
  
  
    });

  $('#createModal').on('hidden.bs.modal', function (e) {

   
    
    $('#selectRangeMonthly').change(function(){
      

        range=$('#selectRangeMonthly').find('input').val();
        separatorIndex = range.indexOf(' to');
        start = range.substr(0, separatorIndex);
        end = range.substr(separatorIndex+4);

        
        var chartParams = getMonthlyChartData(start,end);
        
        if(chartParams!=0){
          salesPerDay_chart.draw(chartParams.data,chartParams.options);
          window.graphs["salesPerDay"] = salesPerDay_chart.getImageURI();
        }
        
        
  });

        $('#selectRangeClients').change(function(){

         range=$('#selectRangeClients').find('input').val();
         separatorIndex = range.indexOf(' to');
         start = range.substr(0, separatorIndex);
         end = range.substr(separatorIndex+4);

         var chartParams = getClientsChartData(start,end);
        
         if(chartParams!=0){
            clients_chart.draw(chartParams.data,chartParams.options);
            window.graphs["clients"] = clients_chart.getImageURI();
            clients_table.draw(chartParams.data, {width: '40%', height: '100%'});
          }     

          
          
          
        });


    $('#selectRangeBestsellers').change(function(){

        range=$('#selectRangeBestsellers').find('input').val();
        separatorIndex = range.indexOf(' to');
        start = range.substr(0, separatorIndex);
        end = range.substr(separatorIndex+4);

        var chartParams = getBestsellersChartData(start,end);
        
        if(chartParams!=0){
            bestsellers_chart.draw(chartParams.data,chartParams.options);
            window.graphs["bestsellers"] = bestsellers_chart.getImageURI();
            bestsellers_table.draw(chartParams.data, {width: '40%', height: '100%'});
        }     

          

          
    });
    })
  
     

    /*
    *chart navigation
    */
    
    $(".monthlyDashboard").fadeIn();
    $(".clientsDashboard").css( "display", "none" )
    $(".bestsellersDashboard").css( "display", "none" )
    


    $("#bestclients").one('click',function(e){
   
      var chartParams = getClientsChartData();        
      clients_chart.draw(chartParams.data,chartParams.options);
      window.graphs["clients"] = clients_chart.getImageURI();

      clients_table.draw(chartParams.data, {width: '40%', height: '100%'});
    });

    $("#bestproducts").one('click',function(e){
      var chartParams = getBestsellersChartData();        
      bestsellers_chart.draw(chartParams.data,chartParams.options);
      window.graphs["bestsellers"] = bestsellers_chart.getImageURI();

      bestsellers_table.draw(chartParams.data, {width: '40%', height: '100%'});
    });




    $("#bestclients").click(function(){
        $(".clientsDashboard").fadeIn();
        $(".monthlyDashboard").fadeOut();
        $(".bestsellersDashboard").fadeOut();
   
    });

    $("#bestproducts").click(function(){
        $(".clientsDashboard").fadeOut();
        $(".monthlyDashboard").fadeOut();
        $(".bestsellersDashboard").fadeIn();
  
    });
      
    $("#monthlyrevenue").click(function(){
      
        $(".clientsDashboard").fadeOut();
        $(".monthlyDashboard").fadeIn();
        $(".bestsellersDashboard").fadeOut();
     
    });

   


function loadajax(){    
    data = {};
    
         for(key in graphs){
          data[key]=graphs[key];
          
         }
            
            
var csrfToken = $('meta[name="csrf-token"]').attr("content");
data['_csrf']=csrfToken;
            $.ajax({
              type: "POST",
              url: 'graph',
              data: data,
              success: function (data, text) {
                 window.open('report','_blank');                
              },
              error: function (request, status, error) {
                  alert(request.responseText);
               
              }
              
            });
          
}
    /*
    *export
    */
    $("#export").click(function(){
      // draw monthly chart for current month
        var chartParams = getMonthlyChartData();        
        salesPerDay_chart.draw(chartParams.data,chartParams.options);
        window.graphs["salesPerDay"] = salesPerDay_chart.getImageURI();
      
      // draw clients chart for current month
        var chartParams = getClientsChartData();        
        clients_chart.draw(chartParams.data,chartParams.options);
        window.graphs["clients"] = clients_chart.getImageURI();

      // draw bestsellers chart for current month  
        var chartParams = getBestsellersChartData();        
        bestsellers_chart.draw(chartParams.data,chartParams.options);
        window.graphs["bestsellers"] = bestsellers_chart.getImageURI();
    
      loadajax();
    });
    

   
$('#monthlyControl').hide();
$('#clientsControl').hide();

$("#dayRangeMonthly").click(function(){
  $('#monthlyControl').toggle();
});

 //google.load('visualization', '1.0', {'packages':['corechart','bar','controls','table']});

 /*
  ** salesPerDate chart
  */
  var salesPerDay_div = document.getElementById('monthly');
  var salesPerDay_chart = new google.visualization.AreaChart(salesPerDay_div);

  

  //catch change range event and redraw graph

  $('#selectRangeMonthly').change(function(){

        range=$('#selectRangeMonthly').find('input').val();
        separatorIndex = range.indexOf(' to');
        start = range.substr(0, separatorIndex);
        end = range.substr(separatorIndex+4);

        
        var chartParams = getMonthlyChartData(start,end);
        
        if(chartParams!=0){
          salesPerDay_chart.draw(chartParams.data,chartParams.options);
          window.graphs["salesPerDay"] = salesPerDay_chart.getImageURI();
        }
        
        
  });
   
  //initial chart draw 
  var chartParams = getMonthlyChartData();        
  salesPerDay_chart.draw(chartParams.data,chartParams.options);
  window.graphs["salesPerDay"] = salesPerDay_chart.getImageURI();

  //end monthly grapgh


  /*
  ** clients bar chart
  */

  var clients_div = document.getElementById('clients');
  var clients_chart = new google.visualization.BarChart(clients_div);

  

   var clients_table = new google.visualization.Table(document.getElementById('table_clients'));
 

  /* google.visualization.events.addListener(table, 'sort',
      function(event) {
        data.sort([{column: event.column, desc: !event.ascending}]);
       
        clients_chart.draw(data,options);
      });
*/

    $('#selectRangeClients').change(function(){

         range=$('#selectRangeClients').find('input').val();
         separatorIndex = range.indexOf(' to');
         start = range.substr(0, separatorIndex);
         end = range.substr(separatorIndex+4);

         var chartParams = getClientsChartData(start,end);
        
         if(chartParams!=0){
            clients_chart.draw(chartParams.data,chartParams.options);
            window.graphs["clients"] = clients_chart.getImageURI();
            clients_table.draw(chartParams.data, {width: '40%', height: '100%'});
          }     

          
          
          
        });
    //end clients graph


    /*
    **Bestsellers
    */

    var bestsellers_div = document.getElementById('bestsellers');
    var bestsellers_chart = new google.visualization.PieChart(bestsellers_div);

    

    var bestsellers_table = new google.visualization.Table(document.getElementById('table_bestsellers'));


    $('#selectRangeBestsellers').change(function(){

        range=$('#selectRangeBestsellers').find('input').val();
        separatorIndex = range.indexOf(' to');
        start = range.substr(0, separatorIndex);
        end = range.substr(separatorIndex+4);

        var chartParams = getBestsellersChartData(start,end);
        
        if(chartParams!=0){
            bestsellers_chart.draw(chartParams.data,chartParams.options);
            window.graphs["bestsellers"] = bestsellers_chart.getImageURI();
            bestsellers_table.draw(chartParams.data, {width: '40%', height: '100%'});
        }     

          

          
    });

    //end bestsellers graph

    

}); //end document ready


    //set default range date to last 30 days
    //every daterange picker has 'value' => 'Last 30 Days',
    default_end_date = new Date();  
      
      
    default_start_date=new Date(default_end_date.getFullYear(), default_end_date.getMonth() ,default_end_date.getDate()-30,15); 
      
    default_start_date = default_start_date.toISOString().substr(0,10);
    default_end_date = default_end_date.toISOString().substr(0,10);
    default_daterange = "'"+ default_start_date+" to "+default_end_date+"'";

    //currency
    currency = <?= "'".Yii::$app->company->company->company_currency."'"; ?>;


 
 google.load('visualization', '1.0', {'packages':['corechart','bar','controls','table']},{'currency':'USD'});
 //prepare chart data and options
  function getMonthlyChartData(start_date,end_date){


     if(typeof start_date === 'undefined' || typeof end_date === 'undefined' ){

      
      end_date = default_end_date;
      start_date = default_start_date;  

      
      
    }else{

     // start_date = parseDateFormat(start_date); 
      //end_date = parseDateFormat(end_date);
      
    }


   
    var monthlyData = $.ajax({
          url: "monthlyrevenuedata",
          dataType:"json",
          data:{"start":start_date,'end':end_date},
          async: false
          }).responseJSON;
    
    //if there is no data send alert and finish execution of the funtcion   
    if (monthlyData.data.length==0) {
      


          //if modal generate custom report is not opened send alert else let draw empty graph
         if(!$('#createModal').hasClass('in')){ 
         
          /*alert("There is no data, please choose another date range.");
          return 0;*/
         }else{
          return 0;
         }
      

         
     }

    // Create the data table.

    var data = new google.visualization.DataTable();
      
    data.addColumn('string', 'Day');
    data.addColumn('number','Sum'); 

    
     
     
    //prepare data and labels
    first = parseDate(start_date);
    second = parseDate(end_date);


    
    var labels = [];
    i=0;
    
    while(first<=second){

        day = new Date(first);
        var dd = day.getDate();
        var mm = day.getMonth()+1; //January is 0!
        var yyyy = day.getFullYear();
        if(dd<10) {
            dd='0'+dd;
        } 

        if(mm<10) {
            mm='0'+mm;
        } 

        day= yyyy+'-'+mm+'-'+dd;
        dayMonth=dd+"."+mm;
     
        labels[i]=dayMonth;
        var flag=0;
        for(j=0;j<monthlyData.data.length;j++)
        {
          if(day==monthlyData.data[j]['day'])
          {
           
            data.addRow([dayMonth,parseInt(monthlyData.data[j]['sum'])]);
            
            flag=1;
            break;
          }
          
        }if(flag==0){
        
            data.addRow([dayMonth,0]);
          }


        var newDate = first.setDate(first.getDate() + 1);
        first = new Date(newDate);
        i++;
    }

    var formatter = new google.visualization.NumberFormat(
      {negativeColor: 'red', negativeParens: true, pattern: '###,### '+currency});
    
formatter.format(data,1);
   
   

    //set options
    var options = {'title':'Monthly Revenue',
                     'width':1000,
                     'height':400,
                     'colors':['#A8BDF8'],
                     'font': 100,
                     textStyle : {
                        fontSize: 100,
                    },
                    
                    hAxis: {
                         title: 'Days',
                        textStyle : {
                            fontSize: 12,
                         
                        },
                        format:"0",
                        showTextEvery: 0,
                        //gridlines: { count: i }
                       
                    },
                    vAxis: {
                        format : '###,### '+currency,
                       // currency:"USD",
                        title: 'Amount',
                        textStyle : {
                            fontSize: 12,
                         
                        },
                    }
             
                 };
           

    return {data:data,options:options};
  }

 //prepare chart data and options
  function getClientsChartData(start_date,end_date){
      if(typeof start_date === 'undefined' || typeof end_date === 'undefined' ){
      
      end_date = default_end_date;
      start_date = default_start_date;  

   }

   
    var clientsData = $.ajax({
          url: "clientsdata",
          dataType:"json",
          data:{"start":start_date,'end':end_date},
          async: false
          }).responseJSON;

      // Create the data table.

      var data = new google.visualization.DataTable();
     
      data.addColumn('string', 'Client');      
      data.addColumn('number','Sum');

     if (clientsData.data.length==0) {

         if(!$('#createModal').hasClass('in')){ 
          alert("There is no data, please choose another date range.");
         }else{
          return 0;
         }
   

       
     };
      var items=clientsData.data;


  for(j=0;j<clientsData.data.length;j++)
  {     
      data.addRow([clientsData.data[j]['client_name'],parseInt(clientsData.data[j]['sum'])]);
  }
  var formatter = new google.visualization.NumberFormat(
      {negativeColor: 'red', negativeParens: true, pattern: '###,### '+currency});
   formatter.format(data, 1);
     
      // Set chart options
      var options = {'title':'Best Clients',
                     'width':1000,
                     'height':400,
                     'colors':['#BFF99E'],
                     'legend': { 'position': 'top' }, 

                     hAxis: {
                      'title': 'Monthly revenue',
                      'minValue': 0,
                       //format : 'currency',
                       format: '###,### '+currency,
                    },
                    vAxis: {
                      title: 'Clients'
                    }


                 };
    return {data:data,options:options};
  }
    


    function getBestsellersChartData(start_date,end_date){
       if(typeof start_date === 'undefined' || typeof end_date === 'undefined' ){

      end_date = default_end_date;
      start_date = default_start_date;  

   }
   
    var bestsellersData = $.ajax({
          url: "bestsellersdata",
          dataType:"json",
          data:{"start":start_date,'end':end_date},
          async: false
          }).responseJSON;
      // Create the data table.

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Product');
      data.addColumn('number','Sum');  


      if (bestsellersData.data.length==0) {
       
        if(!$('#createModal').hasClass('in')){ 
          alert("There is no data, please choose another date range.");
         }
   
      return 0;
     };
     
      for(j=0;j<bestsellersData.data.length;j++)
      {   
          
          data.addRow([bestsellersData.data[j]['product_name'],parseInt(bestsellersData.data[j]['sum'])]);
      }
      var formatter = new google.visualization.NumberFormat(
      {negativeColor: 'red', negativeParens: true, pattern: '### units'});
      formatter.format(data, 1);
     
     
      // Set chart options
      var options = {'title':'Bestsellers',
                     'width':1000,
                     'height':400,
                     'colors':['#F8D669','#BD40C5','#AB9037','#C54050','#82F9E0'],

                     hAxis: {
                      'title': 'Monthly revenue',
                      'minValue': 0,

                    },
                    vAxis: {
                      title: 'Clients'
                    },
                     legend: { position: 'labeled' },pieHole: 0.5,pieSliceText: "none",


                 };

       return {data:data,options:options};      
    }

   
   
    
</script>

<div>
<?php

    Modal::begin([
            'header'=>'<h2 style="text-align:center">Fell free to customize your report</h2>',
            'id' => 'createModal',
            'size' => 'modal-lg',
        ]);

echo "<div id='createModalContent'></div>";

    Modal::end();

    ?>
<?php   echo

 Html::button(Yii::t('app', '<i class="fa glyphicon glyphicon-list-alt"></i> Generate report'), [ 'value'=>Url::to(['/myaccount/customreport']) , 'class' => 'btn btn-success CreateModalButton']) 
    ?>
 


	<h1>Statistics</h1>
	<div>
		<div>
			<p><b>In this month you have earned <?= StatsFunctions::currentMonthRevenue()." ".Yii::$app->company->company->company_currency ?> </b> </p>
			<p><b>You have sold <?= StatsFunctions::numberOfProducts(); ?> products </b> </p>
           <?php 
           /*echo Html::a('<i class="fa glyphicon glyphicon-list-alt"></i> Generate Report', ['/myaccount/report'], [
                'class'=>'btn btn-success', 
                'id' => 'export',
                'target'=>'_blank', 
                'data-toggle'=>'tooltip', 
                'title'=>'Will open the generated PDF file in a new window'
            ]); */
            ?>  
		</div>
        <div style='float:right'> 
            <div style='float:left' ><button class="btn btn-info " type="button" id='monthlyrevenue'>Purchases</button></div>
            <div style='float:left'><button class="btn btn-danger " type="button"  id='bestproducts'>Products</button></div>
            <div style='float:left'><button class="btn btn-success " type="button"  id='bestclients'>Best Clients</button></div>
        </div>
        <div style="clear: both"></div>

	</div>
<div class='monthlyDashboard' style="width: 30%">
                <?php 

      echo '<label class="control-label">Date Range</label>';
      echo '<div class="drp-container" id="selectRangeMonthly">';
      echo DateRangePicker::widget([
          'name'=>'selectRangeMonthly',
          'presetDropdown'=>true,
          'value' => 'Last 30 Days',
          'convertFormat'=>true,

          
          'hideInput'=>true,
          'pluginOptions'=>[
            'locale'=>[

              //'format' => Yii::$app->user->identity->settings->date_format,             
              'separator'=>' to ',

            ]

              
          ],

      ]);
      echo '</div>';


      ?>
</div>
    
    <div class='clientsDashboard' style="width: 30%;display: none">

     <?php 


echo '<label class="control-label">Date Range</label>';
echo '<div class="drp-container" id="selectRangeClients">';
echo DateRangePicker::widget([
    'name'=>'selectRangeClients',
    'presetDropdown'=>true,
    'value' => 'Last 30 Days',
    'hideInput'=>true,
    'pluginOptions'=>[
       'locale'=>[
        'separator'=>' to ',
        ],
     
    ]
]);
echo '</div>';


?>
   
    </div>

    <div class='bestsellersDashboard' style="width: 30%;display: none">
                <?php 


echo '<label class="control-label">Date Range</label>';
echo '<div class="drp-container" id="selectRangeBestsellers">';
echo DateRangePicker::widget([
    'name'=>'selectRangeBestsellers',
    'presetDropdown'=>true,
    'value' => 'Last 30 Days',
    'hideInput'=>true,
    'pluginOptions'=>[
       
        'locale'=>[
        'separator'=>' to ',
        ],
        
    ]
]);
echo '</div>';


?>
           </div>

 


  
    <div class='monthlyDashboard'>
     <div class='graph' id='monthly'></div> 
            

     
      
     
    </div> 
    <div class='clientsDashboard'>

      <div  id='clients'  ></div>
       
      <div id='table_clients'></div>


            
     
      
    </div>
    <div class='bestsellersDashboard'>
      <div id='bestsellers'></div>
        
    <div id='table_bestsellers' ></div>
   
    </div>


</div>
<div style="width:100%">
<div id='comparesalesperdate' style='display: none'></div>
</div>
<div style="width:100%">
<div id='salesperdatecopy' style='display: none'></div>
</div>
<div  id='clientscopy' style='display: none' ></div>
<div id='compareclients' style='display: none'></div>
</div>

</div>
<div id='bestsellerscopy' style='display: none'></div>
<div id='comparebestsellers' style='display: none'></div>
</div>