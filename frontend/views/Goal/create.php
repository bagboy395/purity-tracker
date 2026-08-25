<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Goal $model */

$this->title = 'Create Goal';
$this->params['breadcrumbs'][] = ['label' => 'Goals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
