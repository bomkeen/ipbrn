<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Webboard */

$this->title = 'Update Webboard: ' . $model->Name;
$this->params['breadcrumbs'][] = ['label' => 'Webboards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Name, 'url' => ['view', 'id' => $model->QuestionID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="webboard-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
