<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Webboard */

$this->title = 'ตั้งคำถาม';
$this->params['breadcrumbs'][] = ['label' => 'Webboards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webboard-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
