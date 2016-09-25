<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="sub-categories-form">
<?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'category_name')->textInput(['maxlength' => true]) ?>
<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
