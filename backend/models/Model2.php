<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

class Model2 extends \yii\base\Model
{
    /**
     * Creates and populates a set of models.
     *
     * @param string $modelClass
     * @param array $multipleModels
     * @return array
     */
    public static function createMultiple($modelClass, $multipleModels = [],$flag=0)
    {
        $model    = new $modelClass;
        $formName = $model->formName();
        $post     = Yii::$app->request->post($formName);
        $models   = [];

        if (! empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, 'id', 'id'));
            $multipleModels = array_combine($keys, $multipleModels);
        }

        if($flag==0){

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                //var_dump($multipleModels[$item['id']]);die;
                if (isset($item['id']) && !empty($item['id']) && isset($multipleModels[$item['id']])) {

                    $models[] = $multipleModels[$item['id']];
                } else {
                    $models[] = new $modelClass;                   
                }
            }
        }
    }
    else{

        if ($post && is_array($post)) {

            foreach ($post as $i => $item) {
              
                if (isset($item['id']) && !empty($item['id']) ) {
                    //var_dump($multipleModels);die;

                    foreach ($multipleModels as $im) 
                    {

                        //var_dump($im);die ;         
                        if($im->id==$item['id']){
                        array_push($models, $im);
                          }                   
                    }
                                
                    
                } else {
                    $models[] = new $modelClass;                   
                }
            }
        }
    }
        
        unset($model, $formName, $post);
//var_dump($models);die;
        return $models;
    }
}