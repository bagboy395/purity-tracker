<?php

use yii\helpers\Html;

$this->title = 'Motivation Center';
?>

<div class="container" style="max-width:900px; margin-top:40px; margin-bottom:50px;">

    <!-- Back Button -->
    <div class="mb-4">
        <?= Html::a(
            '← Back to Dashboard',
            ['/site/index'],
            ['class' => 'btn btn-outline-secondary']
        ) ?>
    </div>

    <!-- Page Header -->
    <div class="text-center mb-5">

        <h1 style="font-weight:700;">
            💡 Motivation Center
        </h1>

        <p style="color:#777; font-size:18px;">
            Find strength and encouragement for today's journey.
        </p>

    </div>

    <!-- Today's Motivation -->
    <div class="card mb-4" style="
        border:none;
        border-radius:18px;
        padding:35px;
        box-shadow:0 10px 30px rgba(0,0,0,.08);
        text-align:center;
    ">

        <div style="font-size:45px;">🌟</div>

        <h3 style="margin-top:20px;">
            Today's Motivation
        </h3>

    <?php if ($quote): ?>
        <blockquote style="
            font-size:22px;
            font-style:italic;
            color:#444;
            margin-top:25px;
        ">
            "<?= Html::encode($quote->quote) ?>"
        </blockquote>

        <p style="color:#888; margin-top:15px;">
            — <?= Html::encode($quote->author)?>
        </p>

    <?php else: ?>
         <blockquote style="
             font-size:22px;
             font-style:italic;
             color:#444;
             margin-top:25px;
         ">
            No Motivational quote is available today.
         </blockquote>
    <?php endif; ?>

    </div>

    <!-- Two Cards -->
    <div class="row">

        <!-- Scripture -->
        <div class="col-md-6 mb-4">

            <div class="card h-100" style="
                border:none;
                border-radius:18px;
                padding:25px;
                box-shadow:0 8px 25px rgba(0,0,0,.06);
            ">

                <h4>📖 Scripture</h4>

                <p style="margin-top:20px;">
                    <strong>1 Corinthians 10:13</strong>
                </p>

                <p style="color:#666;">
                    God is faithful. He will not let you be tempted beyond what you can bear.
                </p>

            </div>

        </div>

        <!-- Emergency -->
        <div class="col-md-6 mb-4">

            <div class="card h-100" style="
                border:none;
                border-radius:18px;
                padding:25px;
                box-shadow:0 8px 25px rgba(0,0,0,.06);
            ">

                <h4>🚨 Need Help Right Now?</h4>

                <p style="color:#666;">
                    If you're struggling in this moment, don't fight alone.
                    Open your emergency motivation page for immediate encouragement.
                </p>

                <?= Html::a(
                    'Open Emergency Help',
                    ['motivation/emergency'],
                    ['class'=>'btn btn-danger mt-2']
                ) ?>

            </div>

        </div>

    </div>

    <!-- Reflection -->
    <div class="card" style="
        border:none;
        border-radius:18px;
        padding:30px;
        box-shadow:0 10px 30px rgba(0,0,0,.08);
    ">

        <h4>💭 Reflection</h4>

        <p style="
            color:#666;
            line-height:1.8;
            margin-top:15px;
        ">
            Progress isn't about being perfect.
            It's about making one good decision after another.
            Every day you choose consistency, you're becoming stronger than yesterday.
        </p>

    </div>

</div>