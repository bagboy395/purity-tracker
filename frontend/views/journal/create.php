<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Journal $model */

$this->title = 'New Journal Entry';
$this->params['breadcrumbs'][] = ['label' => 'Journal', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container" style="max-width: 850px; margin-top: 40px; margin-bottom: 50px;">

    <!-- Top navigation -->
    <div class="mb-4">
        <?= Html::a('← Back to Journal', ['index'], [
            'class' => 'btn btn-outline-secondary'
        ]) ?>
    </div>

    <!-- Page heading -->
    <div class="text-center mb-4">
        <h1 style="font-weight:700;">📝 New Journal Entry</h1>
        <p style="color:#777; max-width:650px; margin:0 auto;">
            Record what happened, what you felt, and how you responded.
            Honest entries will help you notice patterns and grow in consistency.
        </p>
    </div>

    <!-- Form card -->
    <div class="card" style="
        border:none;
        border-radius:18px;
        padding:30px;
        box-shadow:0 10px 30px rgba(0,0,0,0.08);
    ">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>