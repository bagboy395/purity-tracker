<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var common\models\Journal[] $journals */
/** @var int $totalEntries */
/** @var float $averageIntensity */
/** @var string|null $latestEntryDate */

$this->title = 'Journal';
?>

<div class="container" style="max-width: 1000px; margin-top: 40px; margin-bottom: 50px;">

    <!-- Top navigation row -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

        <!-- Back to dashboard/home -->
        <div>
            <?= Html::a('← Back to Home', ['site/index'], [
                'class' => 'btn btn-outline-secondary'
            ]) ?>
        </div>

        <!-- New journal entry button -->
        <div>
            <?= Html::a('+ New Journal Entry', ['create'], [
                'class' => 'btn btn-primary'
            ]) ?>
        </div>

    </div>

    <!-- Journal page header -->
    <div class="text-center mb-5">
        <h1 style="font-weight:700;">📝 Journal</h1>
        <p style="color:#777; font-size:16px; max-width:700px; margin:0 auto;">
            Reflect on temptations, identify triggers, and record how you responded.
            This is your private space to understand patterns and grow in consistency.
        </p>
    </div>

    <!-- Summary cards -->
    <div class="row mb-4">

        <div class="col-md-4 mb-3">
            <div class="card h-100" style="
                border:none;
                border-radius:16px;
                padding:24px;
                box-shadow:0 10px 30px rgba(0,0,0,0.08);
            ">
                <p style="margin:0; color:#777;">Total Entries</p>
                <h2 style="margin:10px 0 0; font-weight:700;">
                    <?= $totalEntries ?>
                </h2>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card h-100" style="
                border:none;
                border-radius:16px;
                padding:24px;
                box-shadow:0 10px 30px rgba(0,0,0,0.08);
            ">
                <p style="margin:0; color:#777;">Average Intensity</p>
                <h2 style="margin:10px 0 0; font-weight:700;">
                    <?= $averageIntensity ?>
                    <span style="font-size:18px; color:#777;">/ 10</span>
                </h2>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card h-100" style="
                border:none;
                border-radius:16px;
                padding:24px;
                box-shadow:0 10px 30px rgba(0,0,0,0.08);
            ">
                <p style="margin:0; color:#777;">Latest Entry</p>
                <h2 style="margin:10px 0 0; font-weight:700; font-size:24px;">
                    <?= $latestEntryDate ? date('M j, Y', strtotime($latestEntryDate)) : '—' ?>
                </h2>
            </div>
        </div>

    </div>

    <!-- Journal entries list -->
    <?php if (!empty($journals)): ?>

        <div class="row">
            <?php foreach ($journals as $journal): ?>
                <div class="col-12 mb-4">
                    <div class="card" style="
                        border:none;
                        border-radius:18px;
                        padding:24px;
                        box-shadow:0 10px 30px rgba(0,0,0,0.08);
                    ">

                        <!-- Entry top row -->
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-3">

                            <div>
                                <h4 style="margin:0; font-weight:600;">
                                    <?= Html::encode($journal->temptation_type) ?>
                                </h4>
                                <p style="margin:6px 0 0; color:#777;">
                                    <?= date('F j, Y', strtotime($journal->entry_date)) ?>
                                </p>
                            </div>

                            <div style="
                                background:#f3f6ff;
                                color:#3b5bfd;
                                padding:10px 14px;
                                border-radius:12px;
                                font-weight:600;
                                font-size:14px;
                            ">
                                Intensity: <?= (int)$journal->intensity ?>/10
                            </div>

                        </div>

                        <!-- What happened preview -->
                        <div class="mb-3">
                            <p style="margin:0; color:#888; font-size:13px; text-transform:uppercase; letter-spacing:0.5px;">
                                What happened
                            </p>
                            <p style="margin:8px 0 0; color:#444; line-height:1.7;">
                                <?= Html::encode(StringHelper::truncateWords($journal->what_happened, 28)) ?>
                            </p>
                        </div>

                        <!-- How responded preview -->
                        <div class="mb-4">
                            <p style="margin:0; color:#888; font-size:13px; text-transform:uppercase; letter-spacing:0.5px;">
                                How I responded
                            </p>
                            <p style="margin:8px 0 0; color:#444; line-height:1.7;">
                                <?= Html::encode(StringHelper::truncateWords($journal->how_responded, 24)) ?>
                            </p>
                        </div>

                        <!-- Action buttons -->
                        <div class="d-flex gap-2 flex-wrap">
                            <?= Html::a('View', ['view', 'id' => $journal->id], [
                                'class' => 'btn btn-outline-primary btn-sm'
                            ]) ?>

                            <?= Html::a('Edit', ['update', 'id' => $journal->id], [
                                'class' => 'btn btn-outline-secondary btn-sm'
                            ]) ?>

                            <?= Html::beginForm(['delete', 'id' => $journal->id], 'post', [
                                'style' => 'display:inline-block;'
                            ]) .
                                Html::submitButton('Delete', [
                                    'class' => 'btn btn-outline-danger btn-sm',
                                    'data-confirm' => 'Are you sure you want to delete this journal entry?'
                                ]) .
                                Html::endForm() ?>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php else: ?>

        <!-- Empty state -->
        <div class="card text-center" style="
            border:none;
            border-radius:18px;
            padding:50px 30px;
            box-shadow:0 10px 30px rgba(0,0,0,0.08);
        ">
            <h3 style="font-weight:600; margin-bottom:12px;">No journal entries yet</h3>
            <p style="color:#777; max-width:550px; margin:0 auto 25px;">
                Start recording your triggers, reflections, and responses.
                Your journal will help you understand patterns and stay more intentional.
            </p>

            <?= Html::a('Create Your First Entry', ['create'], [
                'class' => 'btn btn-primary'
            ]) ?>
        </div>

    <?php endif; ?>

</div>