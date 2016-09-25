<?php

use yii\helpers\Html;

use dosamigos\datepicker\DatePicker;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\daterange\DateRangePicker;
use kartik\checkbox\CheckboxX;



?>

<style type="text/css">
	 button[type='submit']{
		
		margin-top: 1em;
	}
</style>

<script type="text/javascript">

  var selectedLabel;

  $('#selectRange').on('apply.daterangepicker', function(ev, picker) {
  selectedLabel = picker.chosenLabel;

});


  $('#submitModal').click(function(){

    add_comparision = $('#add_comparision').find('input').val();


    

  

    range=$('#selectRange').find('input').val();
    
    separatorIndex = range.indexOf(' to');
    start = range.substr(0, separatorIndex);
    end = range.substr(separatorIndex+4);

    var compare_from;
    var compare_to;

    switch(selectedLabel){
      case 'Today': 
      var start_date = new Date(start);
      date = strtotime(' -1 days',start_date);
      var new_date = new Date(date);
      compare_to = compare_from = new_date.toISOString().substr(0,10);

      break;
      case 'Yesterday': 
      var start_date = new Date(start);
      date = strtotime(' -1 days',start_date);
      var new_date = new Date(date);
      compare_to = compare_from = new_date.toISOString().substr(0,10);

      
      break;
      case 'Last 7 Days': 
      var start_date = new Date(start); 
      compare_from = new Date(start_date.getFullYear(), start_date.getMonth() ,start_date.getDate()-7,15);    
      compare_to =  new Date(start_date.getFullYear(), start_date.getMonth() ,start_date.getDate()-1,15);


       
      compare_to = compare_to.toISOString().substr(0,10);
      compare_from = compare_from.toISOString().substr(0,10);

     
     
      
      
      break;
      case 'Last 30 Days': 
      var start_date = new Date(start); 
      compare_from = new Date(start_date.getFullYear(), start_date.getMonth() ,start_date.getDate()-30,15);    
      compare_to =  new Date(start_date.getFullYear(), start_date.getMonth() ,start_date.getDate()-1,15);
       
      compare_to = compare_to.toISOString().substr(0,10);
      compare_from = compare_from.toISOString().substr(0,10);

  
      break;
      case 'This Month': 
      var start_date = new Date(start); 
      compare_from = new Date(start_date.getFullYear(), start_date.getMonth()-1 ,start_date.getDate(),15);    
      compare_to =  new Date(start_date.getFullYear(), start_date.getMonth() ,start_date.getDate()-1,15);
       
      compare_to = compare_to.toISOString().substr(0,10);
      compare_from = compare_from.toISOString().substr(0,10);

     
      break;
      case 'Last Month': 
      var start_date = new Date(start); 
      compare_from = new Date(start_date.getFullYear(), start_date.getMonth()-1 ,start_date.getDate(),15);    
      compare_to =  new Date(start_date.getFullYear(), start_date.getMonth() ,start_date.getDate()-1,15);
       
      compare_to = compare_to.toISOString().substr(0,10);
      compare_from = compare_from.toISOString().substr(0,10);

      break;
      case 'Custom Range': 
      var start_date = new Date(start); 
      var end_date = new Date(end);
      diff = Math.round((end_date-start_date)/(1000*60*60*24)) +1;

      compare_from = new Date(start_date.getFullYear(), start_date.getMonth() ,start_date.getDate()-diff,15);    
      compare_to =  new Date(start_date.getFullYear(), start_date.getMonth() ,start_date.getDate()-1,15);
       
      compare_to = compare_to.toISOString().substr(0,10);
      compare_from = compare_from.toISOString().substr(0,10);
    
      
      break;
      default:
     
       break;
    }
    


   
    selected = $("#reports-items").select2("val");
   
    newgraphs = [];
    notLoadedCharts =[];
    for (var i = selected.length - 1; i >= 0; i--) {
      switch(selected[i]){
        case 'salesPerDay': 
        result = getMonthlyChartData(start,end);

        
          if(result==0){
            notLoadedCharts.push("Monthly Revenue");
          }else{
            var salesPerDay_div = document.getElementById('salesperdatecopy');
            var salesPerDay_chart = new google.visualization.AreaChart(salesPerDay_div);
            salesPerDay_chart.draw(result.data,result.options);
            newgraphs['salesPerDay']=salesPerDay_chart.getImageURI();
            if(add_comparision==1){
              compare_result = getMonthlyChartData(compare_from,compare_to);
              var comparesalesPerDay_div = document.getElementById('comparesalesperdate');
              var comparesalesPerDay_chart = new google.visualization.AreaChart(comparesalesPerDay_div);
             if(compare_result==0){
              newgraphs['salesPerDayCompare']=null;
             }else{
              comparesalesPerDay_chart.draw(compare_result.data,compare_result.options);
              newgraphs['salesPerDayCompare']=comparesalesPerDay_chart.getImageURI();
             }
             
            }else{
              newgraphs['salesPerDayCompare']=null;
            }
           

          }
          
        break;
        case 'clients': 
         var result = getClientsChartData(start,end);
         
         if(result==0){
            notLoadedCharts.push("Best Clients");
          }else{
            var clients_div = document.getElementById('clientscopy');
            var clients_chart = new google.visualization.BarChart(clients_div);
             
            clients_chart.draw(result.data,result.options);
            newgraphs['clients']=clients_chart.getImageURI();
              
              if(add_comparision==1){
                compare_result = getClientsChartData(compare_from,compare_to);
                var compareclients_div = document.getElementById('compareclients');
                var compareclients_chart = new google.visualization.BarChart(compareclients_div);
                if(compare_result==0){
                  newgraphs['clientscompare']=null;
                }else{
                  
                  compareclients_chart.draw(compare_result.data,compare_result.options);
                  newgraphs['clientscompare']=compareclients_chart.getImageURI();
                }
                
              }else{

                newgraphs['clientscompare']=null;
              }

            

          

          //following code doesn't show clients which has been included in previous amount of time
          // but they are not included in current date range
          /*
            var colChartDiff = new google.visualization.BarChart(document.getElementById('compareclients'));

            

           var options = {'title':'Best Clients',
                     'width':1000,
                     'height':400,
                     'colors':['#BFF99E'],
                     'legend': { 'position': 'top' }, 

                     hAxis: {
                      'title': 'Monthly revenue',
                      'minValue': 0,
                       format : 'currency',
                    },
                    vAxis: {
                      title: 'Clients'
                    },
                    diff: { newData: { widthFactor: 0.8 }, oldData:{color:'5A964D'} }


                 };
            diffData = colChartDiff.computeDiff(compare_result.data, result.data);
            colChartDiff.draw(diffData, options);
            newgraphs['clients']=colChartDiff.getImageURI();*/
          }
          
        break;
        case 'bestsellers': 
        result = getBestsellersChartData(start,end);
        
        if(result==0){
            notLoadedCharts.push("Best Sold Products");
          }else{
            var bestsellers_div = document.getElementById('bestsellerscopy');
            var bestsellers_chart = new google.visualization.PieChart(bestsellers_div);
            bestsellers_chart.draw(result.data,result.options);
            newgraphs['bestsellers']=bestsellers_chart.getImageURI();

            if(add_comparision==1){
                compare_result = getBestsellersChartData(compare_from,compare_to);
                if(compare_result==0){ 
                  newgraphs['bestsellerscompare']=null;
                }else{
                  var comparebestsellers_div = document.getElementById('comparebestsellers');
                  var comparebestsellers_chart = new google.visualization.PieChart(comparebestsellers_div);
                                 
                  comparebestsellers_chart.draw(compare_result.data,compare_result.options);
                  newgraphs['bestsellerscompare']=comparebestsellers_chart.getImageURI();
                }
               
              }else{
                newgraphs['bestsellerscompare']=null;
              }
            
             

          }
          
          
        break;
        default: break;
      }
    };

    if(notLoadedCharts.length>0){
      alert("Unfortunatelly there is no data to show please chose another date range");
      /*content = 'Unfortunatelly there is no data for';
      if(notLoadedCharts.length==1){
        content = content+' a : '+notLoadedCharts[0]+" section. \n Please remove this section or change date range of the report";
      }else{
        content = content + " a following sections: \n";
        for (var i = 0; i < notLoadedCharts.length; i++) {
          index=i+1;
         content = content+index+'.'+notLoadedCharts[i]+'. \n';
        };
        content = content+"\n Please change date range of the report or remove those sections ."
      }
      
      
      alert(content);*/
      
    }else{
      data = {};
    
         for(key in newgraphs){
          
          data[key]=newgraphs[key];
          
         }
            
          
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        data['_csrf']=csrfToken;
        
        
        compare_range = compare_from+" to "+compare_to;
        
        
            $.ajax({
              type: "POST",
              url: 'graph',
              data: data,
              success: function (data, text) {
                  //firing those two lines couse a problem with daterange picker in stats view so we don't close modal
                  //if user will close modal everything work...
                  //$.noConflict();
                 //$("#createModal").modal('hide');


                 $("#comparesalesperdate").html("");
                 $("#salesperdatecopy").html("");
                 $("#bestsellerscopy").html("");
                 $("#clientscopy").html("");
                 $("#compareclients").html("");
                 $("#comparebestsellers").html("");

                  $('<input />').attr('type', 'hidden')
                      .attr('name', "range_label")
                      .attr('value', selectedLabel)
                      .appendTo('#preferences-form');
                  $('<input />').attr('type', 'hidden')
                      .attr('name', "compare_range")
                      .attr('value', compare_range)
                      .appendTo('#preferences-form');
               
                $('#preferences-form').submit();



              },
              error: function (request, status, error) {
                  alert(request.responseText);
               
              }
              
            });
  
    }
    
  });  

function strtotime(text, now) {
  //  discuss at: http://phpjs.org/functions/strtotime/
  //     version: 1109.2016
  // original by: Caio Ariede (http://caioariede.com)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Caio Ariede (http://caioariede.com)
  // improved by: A. Matías Quezada (http://amatiasq.com)
  // improved by: preuter
  // improved by: Brett Zamir (http://brett-zamir.me)
  // improved by: Mirko Faber
  //    input by: David
  // bugfixed by: Wagner B. Soares
  // bugfixed by: Artur Tchernychev
  // bugfixed by: Stephan Bösch-Plepelits (http://github.com/plepe)
  //        note: Examples all have a fixed timestamp to prevent tests to fail because of variable time(zones)
  //   example 1: strtotime('+1 day', 1129633200);
  //   returns 1: 1129719600
  //   example 2: strtotime('+1 week 2 days 4 hours 2 seconds', 1129633200);
  //   returns 2: 1130425202
  //   example 3: strtotime('last month', 1129633200);
  //   returns 3: 1127041200
  //   example 4: strtotime('2009-05-04 08:30:00 GMT');
  //   returns 4: 1241425800
  //   example 5: strtotime('2009-05-04 08:30:00+00');
  //   returns 5: 1241425800
  //   example 6: strtotime('2009-05-04 08:30:00+02:00');
  //   returns 6: 1241418600
  //   example 7: strtotime('2009-05-04T08:30:00Z');
  //   returns 7: 1241425800

  var parsed, match, today, year, date, days, ranges, len, times, regex, i, fail = false;

  if (!text) {
    return fail;
  }

  // Unecessary spaces
  text = text.replace(/^\s+|\s+$/g, '')
    .replace(/\s{2,}/g, ' ')
    .replace(/[\t\r\n]/g, '')
    .toLowerCase();

  // in contrast to php, js Date.parse function interprets:
  // dates given as yyyy-mm-dd as in timezone: UTC,
  // dates with "." or "-" as MDY instead of DMY
  // dates with two-digit years differently
  // etc...etc...
  // ...therefore we manually parse lots of common date formats
  match = text.match(
    /^(\d{1,4})([\-\.\/\:])(\d{1,2})([\-\.\/\:])(\d{1,4})(?:\s(\d{1,2}):(\d{2})?:?(\d{2})?)?(?:\s([A-Z]+)?)?$/);

  if (match && match[2] === match[4]) {
    if (match[1] > 1901) {
      switch (match[2]) {
      case '-': {
        // YYYY-M-D
        if (match[3] > 12 || match[5] > 31) {
          return fail;
        }

        return new Date(match[1], parseInt(match[3], 10) - 1, match[5],
          match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
      }
      case '.': {
        // YYYY.M.D is not parsed by strtotime()
        return fail;
      }
      case '/': {
        // YYYY/M/D
        if (match[3] > 12 || match[5] > 31) {
          return fail;
        }

        return new Date(match[1], parseInt(match[3], 10) - 1, match[5],
          match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
      }
      }
    } else if (match[5] > 1901) {
      switch (match[2]) {
      case '-': {
        // D-M-YYYY
        if (match[3] > 12 || match[1] > 31) {
          return fail;
        }

        return new Date(match[5], parseInt(match[3], 10) - 1, match[1],
          match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
      }
      case '.': {
        // D.M.YYYY
        if (match[3] > 12 || match[1] > 31) {
          return fail;
        }

        return new Date(match[5], parseInt(match[3], 10) - 1, match[1],
          match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
      }
      case '/': {
        // M/D/YYYY
        if (match[1] > 12 || match[3] > 31) {
          return fail;
        }

        return new Date(match[5], parseInt(match[1], 10) - 1, match[3],
          match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
      }
      }
    } else {
      switch (match[2]) {
      case '-': {
        // YY-M-D
        if (match[3] > 12 || match[5] > 31 || (match[1] < 70 && match[1] > 38)) {
          return fail;
        }

        year = match[1] >= 0 && match[1] <= 38 ? +match[1] + 2000 : match[1];
        return new Date(year, parseInt(match[3], 10) - 1, match[5],
          match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
      }
      case '.': {
        // D.M.YY or H.MM.SS
        if (match[5] >= 70) {
          // D.M.YY
          if (match[3] > 12 || match[1] > 31) {
            return fail;
          }

          return new Date(match[5], parseInt(match[3], 10) - 1, match[1],
            match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
        }
        if (match[5] < 60 && !match[6]) {
          // H.MM.SS
          if (match[1] > 23 || match[3] > 59) {
            return fail;
          }

          today = new Date();
          return new Date(today.getFullYear(), today.getMonth(), today.getDate(),
            match[1] || 0, match[3] || 0, match[5] || 0, match[9] || 0) / 1000;
        }

        // invalid format, cannot be parsed
        return fail;
      }
      case '/': {
        // M/D/YY
        if (match[1] > 12 || match[3] > 31 || (match[5] < 70 && match[5] > 38)) {
          return fail;
        }

        year = match[5] >= 0 && match[5] <= 38 ? +match[5] + 2000 : match[5];
        return new Date(year, parseInt(match[1], 10) - 1, match[3],
          match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
      }
      case ':': {
        // HH:MM:SS
        if (match[1] > 23 || match[3] > 59 || match[5] > 59) {
          return fail;
        }

        today = new Date();
        return new Date(today.getFullYear(), today.getMonth(), today.getDate(),
          match[1] || 0, match[3] || 0, match[5] || 0) / 1000;
      }
      }
    }
  }

  // other formats and "now" should be parsed by Date.parse()
  if (text === 'now') {
    return now === null || isNaN(now) ? new Date()
      .getTime() / 1000 | 0 : now | 0;
  }
  if (!isNaN(parsed = Date.parse(text))) {
    return parsed / 1000 | 0;
  }
  // Browsers != Chrome have problems parsing ISO 8601 date strings, as they do
  // not accept lower case characters, space, or shortened time zones.
  // Therefore, fix these problems and try again.
  // Examples:
  //   2015-04-15 20:33:59+02
  //   2015-04-15 20:33:59z
  //   2015-04-15t20:33:59+02:00
  if (match = text.match(
      /^([0-9]{4}-[0-9]{2}-[0-9]{2})[ t]([0-9]{2}:[0-9]{2}:[0-9]{2}(\.[0-9]+)?)([\+-][0-9]{2}(:[0-9]{2})?|z)/)) {
    // fix time zone information
    if (match[4] == 'z') {
      match[4] = 'Z';
    } else if (match[4].match(/^([\+-][0-9]{2})$/)) {
      match[4] = match[4] + ':00';
    }

    if (!isNaN(parsed = Date.parse(match[1] + 'T' + match[2] + match[4]))) {
      return parsed / 1000 | 0;
    }
  }

  date = now ? new Date(now * 1000) : new Date();
  days = {
    'sun' : 0,
    'mon' : 1,
    'tue' : 2,
    'wed' : 3,
    'thu' : 4,
    'fri' : 5,
    'sat' : 6
  };
  ranges = {
    'yea' : 'FullYear',
    'mon' : 'Month',
    'day' : 'Date',
    'hou' : 'Hours',
    'min' : 'Minutes',
    'sec' : 'Seconds'
  };

  function lastNext(type, range, modifier) {
    var diff, day = days[range];

    if (typeof day !== 'undefined') {
      diff = day - date.getDay();

      if (diff === 0) {
        diff = 7 * modifier;
      } else if (diff > 0 && type === 'last') {
        diff -= 7;
      } else if (diff < 0 && type === 'next') {
        diff += 7;
      }

      date.setDate(date.getDate() + diff);
    }
  }

  function process(val) {
    var splt = val.split(' '), // Todo: Reconcile this with regex using \s, taking into account browser issues with split and regexes
      type = splt[0],
      range = splt[1].substring(0, 3),
      typeIsNumber = /\d+/.test(type),
      ago = splt[2] === 'ago',
      num = (type === 'last' ? -1 : 1) * (ago ? -1 : 1);

    if (typeIsNumber) {
      num *= parseInt(type, 10);
    }

    if (ranges.hasOwnProperty(range) && !splt[1].match(/^mon(day|\.)?$/i)) {
      return date['set' + ranges[range]](date['get' + ranges[range]]() + num);
    }

    if (range === 'wee') {
      return date.setDate(date.getDate() + (num * 7));
    }

    if (type === 'next' || type === 'last') {
      lastNext(type, range, num);
    } else if (!typeIsNumber) {
      return false;
    }

    return true;
  }

  times = '(years?|months?|weeks?|days?|hours?|minutes?|min|seconds?|sec' +
    '|sunday|sun\\.?|monday|mon\\.?|tuesday|tue\\.?|wednesday|wed\\.?' +
    '|thursday|thu\\.?|friday|fri\\.?|saturday|sat\\.?)';
  regex = '([+-]?\\d+\\s' + times + '|' + '(last|next)\\s' + times + ')(\\sago)?';

  match = text.match(new RegExp(regex, 'gi'));
  if (!match) {
    return fail;
  }

  for (i = 0, len = match.length; i < len; i++) {
    if (!process(match[i])) {
      return fail;
    }
  }

  // ECMAScript 5 only
  // if (!match.every(process))
  //    return false;

  return (date.getTime() / 1000);
}
</script>

<div class="preference-form">

 

  <?php $form = ActiveForm::begin(['id'=>'preferences-form','options'=>['target'=>'_blank']]); ?>

    

    <?= $form->field($model, 'title')->textInput() ?>

   
   
  <?php  
echo $form->field($model, 'date_range',['options'=> ['class '=>'drp-container form-group','id'=>'selectRange']])->widget(
    DateRangePicker::classname(),[
    'name'=>'selectRange',
    'presetDropdown'=>true,
    
    'hideInput'=>true,
    'pluginOptions'=>[
       'locale'=>[
        'separator'=>' to ',
        ],
        
    ]
])->label("Report Date Range");

?>
  <?php 
  $data=[
    'salesPerDay'=>'Monthly Revenue',
  'clients'=>'Best Clients',
  'bestsellers'=>'Best Sold Products',
  ];

  echo $form->field($model, 'items')->widget(Select2::classname(),[
    'model' => $model,
    'attribute' => 'items','value'=> $model->items=[
  'salesPerDay',
  'clients',
  'bestsellers',
  ], 

    
    'data' => $data,
    'options' => ['placeholder' => 'Select report elements...', 'multiple' => true,'class'=>'form group'],
    'pluginOptions' => [
        'tags' => false,
        'maximumInputLength' => 10
    ],
])->label("Select report elements");

?>
<?php $model->add_comparision = true;
echo $form->field($model, 'add_comparision',['options'=>['id'=>'add_comparision']])->widget(CheckboxX::classname(), [
  'pluginOptions' => [ 'inline'=>false, 
    //'iconChecked'=>'<i class="glyphicon glyphicon-plus"></i>',    
    'threeState'=>false,]
  ])->label('Do you wish to compare your data ?');
?>

    <!--div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Generate'), ['class' => 'btn btn-success' ]) ?>
    </div-->

    

    <?php ActiveForm::end(); ?>
<button class="btn btn-success" type="text" id='submitModal'>Generate</button>

