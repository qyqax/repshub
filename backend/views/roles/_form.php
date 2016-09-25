<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserRoles */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">
td
{
    padding:0 15px 0 15px;
}
table, th, td {
   border: 1px solid black;
}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
jQuery(document).ready(function($){
  if($('input[name="UserRoles[module_clients]"][value="1"]:checked').length ==0)
  {
    $('div[name="client_permissions"]').hide();
  }
  $('input[name="UserRoles[module_clients]"][value="1"]').change(function() {
      $('div[name="client_permissions"]').show();
  });
  $('input[name="UserRoles[module_clients]"][value="0"]').change(function() {
      $('div[name="client_permissions"]').hide();
  });
  if($('input[name="UserRoles[module_users]"][value="1"]:checked').length==0)
  {
    $('div[name="user_permissions"]').hide();
  }
  $('input[name="UserRoles[module_users]"][value="1"]').change(function() {
      $('div[name="user_permissions"]').show();
  });
  $('input[name="UserRoles[module_users]"][value="0"]').change(function() {
      $('div[name="user_permissions"]').hide();
  });
})
</script>
<div class="user-roles-form">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'user_role_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'module_clients')->radioList(array('1'=>'Yes',0=>'No'))->label('Clients'); ?>

    <div name="client_permissions" class="form-group" style="display:none;">
      <table>
        <tr>
          <td>
            <?= $form->field($model, 'clients_create')->radioList(array('1'=>'Yes',0=>'No'))->label('Create'); ?>
          </td>
          <td>
            <?= $form->field($model, 'clients_read')->radioList(array('1'=>'Yes',0=>'No'))->label('View'); ?>
          </td>
          <td>
            <?= $form->field($model, 'clients_update')->radioList(array('1'=>'Yes',0=>'No'))->label('Update'); ?>
          </td>
          <td>
            <?= $form->field($model, 'clients_delete')->radioList(array('1'=>'Yes',0=>'No'))->label('Delete'); ?>
          </td>
        </tr>
      </table>
    </div>

    <?= $form->field($model, 'module_users')->radioList(array('1'=>'Yes',0=>'No'))->label('Users'); ?>

    <div name="user_permissions" class="form-group" style="display:none;">
      <table>
        <tr>
          <td>
            <?= $form->field($model, 'users_create')->radioList(array('1'=>'Yes',0=>'No'))->label('Create'); ?>
          </td>
          <td>
            <?= $form->field($model, 'users_read')->radioList(array('1'=>'Yes',0=>'No'))->label('View'); ?>
          </td>
          <td>
            <?= $form->field($model, 'users_update')->radioList(array('1'=>'Yes',0=>'No'))->label('Update'); ?>
          </td>
          <td>
            <?= $form->field($model, 'users_delete')->radioList(array('1'=>'Yes',0=>'No'))->label('Delete'); ?>
          </td>
        </tr>
      </table>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
