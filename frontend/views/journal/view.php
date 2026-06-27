<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Journal $model */

$this->title = 'Journal Entry';
$this->params['breadcrumbs'][] = ['label' => 'Journal', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container" style="max-width: 900px; margin-top: 40px; margin-bottom: 50px;">

    <!-- Top action row -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">

        <div>
            <?= Html::a('← Back to Journal', ['index'], [
                'class' => 'btn btn-outline-secondary'
            ]) ?>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <?= Html::a('Edit Entry', ['update', 'id' => $model->id], [
                'class' => 'btn btn-outline-primary'
            ]) ?>

            <?= Html::beginForm(['delete', 'id' => $model->id], 'post', [
                'style' => 'display:inline-block;'
            ]) .
                Html::submitButton('Delete Entry', [
                    'class' => 'btn btn-outline-danger',
                    'data-confirm' => 'Are you sure you want to delete this journal entry?'
                ]) .
                Html::endForm() ?>
        </div>

    </div>

    <!-- Page heading -->
    <div class="text-center mb-4">
        <h1 style="font-weight:700;">📝 Journal Entry</h1>
        <p style="color:#777; max-width:650px; margin:0 auto;">
            Review this reflection in full — what triggered you, how you responded,
            and what you learned from the moment.
        </p>
    </div>

    <!-- Main journal card -->
    <div class="card" style="
        border:none;
        border-radius:18px;
        padding:30px;
        box-shadow:0 10px 30px rgba(0,0,0,0.08);
    ">

        <!-- Entry top summary -->
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">

            <div>
                <p style="
                    margin:0;
                    color:#888;
                    font-size:13px;
                    text-transform:uppercase;
                    letter-spacing:0.5px;
                ">
                    Temptation Type
                </p>

                <h2 style="margin:8px 0 0; font-weight:700;">
                    <?= Html::encode($model->temptation_type) ?>
                </h2>

                <p style="margin:10px 0 0; color:#777;">
                    <?= date('F j, Y', strtotime($model->entry_date)) ?>
                </p>
            </div>

            <div style="
                background:#f3f6ff;
                color:#3b5bfd;
                padding:12px 16px;
                border-radius:12px;
                font-weight:600;
                font-size:14px;
            ">
                Intensity: <?= (int)$model->intensity ?>/10
            </div>

        </div>

        <!-- What happened section -->
        <div class="mb-4">
            <p style="
                margin:0;
                color:#888;
                font-size:13px;
                text-transform:uppercase;
                letter-spacing:0.5px;
            ">
                What Happened
            </p>

            <div style="
                margin-top:10px;
                padding:18px;
                background:#fafafa;
                border-radius:14px;
                line-height:1.8;
                color:#444;
            ">
                <?= nl2br(Html::encode($model->what_happened)) ?>
            </div>
        </div>

        <!-- How responded section -->
        <div class="mb-4">
            <p style="
                margin:0;
                color:#888;
                font-size:13px;
                text-transform:uppercase;
                letter-spacing:0.5px;
            ">
                How I Responded
            </p>

            <div style="
                margin-top:10px;
                padding:18px;
                background:#fafafa;
                border-radius:14px;
                line-height:1.8;
                color:#444;
            ">
                <?= nl2br(Html::encode($model->how_responded)) ?>
            </div>
        </div>

        <!-- Notes section -->
        <div>
            <p style="
                margin:0;
                color:#888;
                font-size:13px;
                text-transform:uppercase;
                letter-spacing:0.5px;
            ">
                Notes
            </p>

            <div style="
                margin-top:10px;
                padding:18px;
                background:#fafafa;
                border-radius:14px;
                line-height:1.8;
                color:#444;
                min-height:80px;
            ">
                <?= !empty($model->notes)
                    ? nl2br(Html::encode($model->notes))
                    : '<span style="color:#999;">No additional notes for this entry.</span>' ?>
            </div>
        </div>

    </div>

</div>