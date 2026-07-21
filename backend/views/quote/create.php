<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Quote $model */

$this->title = 'Create Quote';
$this->params['breadcrumbs'][] = ['label' => 'Quotes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quote-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
