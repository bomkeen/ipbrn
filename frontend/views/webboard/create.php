<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Webboard */

$this->title = 'Create Webboard';
$this->params['breadcrumbs'][] = ['label' => 'Webboards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webboard-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
