<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Journal $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="journal-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Journal date -->
    <?= $form->field($model, 'entry_date')->input('date') ?>

    <!-- Type of temptation / trigger -->
    <?= $form->field($model, 'temptation_type')->textInput([
        'maxlength' => true,
        'placeholder' => 'e.g. loneliness, boredom, porn, fantasy, social media trigger'
    ]) ?>

    <!-- Intensity level from 1 to 10 -->
    <?= $form->field($model, 'intensity')->dropDownList([
        1 => '1',
        2 => '2',
        3 => '3',
        4 => '4',
        5 => '5',
        6 => '6',
        7 => '7',
        8 => '8',
        9 => '9',
        10 => '10',
    ], ['prompt' => 'Select intensity']) ?>

    <!-- What happened / trigger / context -->
    <?= $form->field($model, 'what_happened')->textarea([
        'rows' => 4,
        'placeholder' => 'What happened? What triggered you? What was the situation?'
    ]) ?>

    <!-- How the user responded -->
    <?= $form->field($model, 'how_responded')->textarea([
        'rows' => 4,
        'placeholder' => 'How did you respond in that moment?'
    ]) ?>

    <!-- Optional extra notes -->
    <?= $form->field($model, 'notes')->textarea([
        'rows' => 4,
        'placeholder' => 'Any extra reflections, lessons, or observations'
    ]) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Save Journal Entry' : 'Update Journal Entry',
            ['class' => 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>