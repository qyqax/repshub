<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\UserRoles */

$this->title = $model->user_role_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-roles-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php
        $size = count($model->permissions);
        if($size > 0)
        {
          echo '<table class="table table-striped table-bordered detail-view">';
          echo '<tr><th>Module</th><th>Create</th><th>View</th><th>Update</th><th>Delete</th></tr>';


          for($i = 0; $i < $size; $i++)
          {
            echo '<tr>';
            echo '<td>'.ucfirst($model->permissions[$i]->attributes['module']).'</td>';
            for($j = 0; $j < 4; $j++)
            {
              echo '<td>';
              echo ($model->permissions[$i]->attributes['crud'][$j] == 1 ? '&#10004;' : '-');
              echo '</td>';
            }
            echo '</tr>';
          }
          echo '</table>';
        }
        else
        {
          echo "<h3>This role has no permissions.</h3>";
        }
    ?>

</div>
