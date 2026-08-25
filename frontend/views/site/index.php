<?php
use yii\helpers\Html;

/** @var bool $hasCheckedInToday */
/** @var int $currentStreak */
?>

<!--seperating landing page from logged in users Dashboard-->
<!--landing page for firsttime users still to access-->
<?php if (Yii::$app->user->isGuest):?>
    <div class="landing-page">

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <span class="navbar-brand fw-bold">
                Daily Streak
            </span>

            <div>
                <?= Html::a(
                    'Login',
                    ['site/login'],
                    ['class'=>'btn btn-light me-2']
                )?>
                
                <?= Html::a(
                    'Get started',
                    ['site/signup'],
                    ['class'=>'btn btn-primary',])
                ?>
            </div>
        </div>
    </nav>

    <div class="container text-center" style="margin-top:100px; padding-left:20px; padding-right:20px;">

        <div class="hero-badge">
    ✨ Daily streak tracking for self-improvement
       </div>

        <h1 style="
            font-size:60px;
            font-weight:700;
            line-height:1.2;
        ">
            Build consistency<br>
            one day at a time.
        </h1>

        <p style="
            max-width:650px;
            margin:25px auto;
            font-size:20px;
            color:#666;
        ">
            A calm and modern streak tracker designed
            to help you stay accountable, focused,
            and consistent every single day.
        </p>

        <div style="margin-top:35px;">
              <?= Html::a(
    'Start Tracking',
    ['site/signup'],
    [
        'class'=>'btn btn-primary btn-lg me-3',
        'style'=>'padding:12px 30px; border-radius:12px;'
    ]
) ?>

<?= Html::a(
    'Login',
    ['site/login'],
    ['class'=>'btn btn-outline-secondary btn-lg']
) ?>
            
        </div>

        <div class="dashboard-preview mx-auto">

    <div style="text-align:center;">

      <div style="
    max-width: 320px;
    margin: 60px auto;
    padding: 30px 20px;
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    text-align: center;
">

    <small style="color:#777;">
        Your Progress Preview
    </small>

    <h2 style="
        font-size:52px;
        margin-top:15px;
        margin-bottom:5px;
    ">
        12
    </h2>

    <p style="
        color:#555;
        margin-top:0;
    ">
        Day Streak 🔥
    </p>

    <div style="
        margin-top:20px;
        padding:12px 16px;
        background:#f3f6ff;
        border-radius:12px;
        display:inline-block;
        color:#3b5bfd;
        font-weight:500;
        font-size:14px;
    ">
        Keep going — one day at a time
    </div>

</div>

</div>

    </div>


<div class="benefits-section">

    <h2>Why people use Daily Streak</h2>

    <div class="benefit-grid">

        <div class="benefit-card">
            <div class="benefit-icon">🔥</div>
            <h4>Build Streaks</h4>
            <p>Stay motivated by maintaining daily consistency.</p>
        </div>

        <div class="benefit-card">
            <div class="benefit-icon">📅</div>
            <h4>Check In Daily</h4>
            <p>Create a simple routine that keeps you accountable.</p>
        </div>

        <div class="benefit-card">
            <div class="benefit-icon">📈</div>
            <h4>Track Progress</h4>
            <p>See how your efforts compound over time.</p>
        </div>

    </div>

</div>

<!-- Start your journey button-->
    <div style="margin-top: 30px; text-align:center;">
        <?= \yii\helpers\Html::a(
            'Start Your Journey',
            ['site/signup'],
            [
                'class'=>'btn btn-primary btn-lg',
                'style'=>'padding:12px 30px; border-radius:12px;'
            ]
        )?>
    </div>

</div>


<?php else:?> <!--if user logged in , it now shows the dashboard-->
    <div class="text-end mb-3" style="margin-top:10px">
        <?=Html::beginForm(['/site/logout'],'post')?>
        <?=Html::submitButton(
            'Logout',
            ['class'=>'btn btn-outline-danger']
        )?>
        <?= Html::endForm()?>
    </div>

<div class="container" style="margin-top:50px; max-width:900px;">

    <!-- HEADER -->
    <div class="text-center mb-4">
        <h1 style="font-weight:600;">🔥 Streak Dashboard</h1>
        <p style="color:#777;">Stay consistent. One day at a time.</p>
    </div>

    <!-- MAIN CARD -->
    <div class="card" style="
        border-radius:16px;
        padding:30px;
        box-shadow:0 10px 30px rgba(0,0,0,0.08);
        border:none;
    ">

        <!-- STREAK -->
        <div class="text-center mb-4">
            <h2 style="font-size:48px; margin:0; font-weight:700;">
                <?= (int)$streak ?>
            </h2>
            <p style="margin:0; color:#666;">Day Streak 🔥</p>
        </div>

        <!-- STATUS -->
        <div class="text-center mb-4">
            <?php if ($hasCheckedInToday): ?>
                <div class="alert alert-success" style="border-radius:10px;">
                    ✔ You’ve checked in today. Keep it going!
                </div>
            <?php else: ?>
                <div class="alert alert-warning" style="border-radius:10px;">
                    ⚠ You haven’t checked in today yet.
                </div>
            <?php endif; ?>
        </div>

        <!-- ACTION BUTTON -->
        <div class="text-center">
            <?= Html::beginForm(['checkin/create'], 'post') ?>

                <button type="submit" class="btn btn-primary" style="
                    width:100%;
                    padding:14px;
                    border-radius:12px;
                    font-size:16px;
                    font-weight:500;
                ">
                    Check In Today
                </button>

            <?= Html::endForm() ?>
        </div>

    </div>

    <!-- FOOTER STATS -->
    <div class="row text-center mt-4">

        <div class="col-md-6 mb-3">
            <div class="card" style="padding:20px; border-radius:12px;">
                <h4 style="margin:0;">📅 Total Check-ins</h4>
                <p style="font-size:22px; margin:0;">
                    <?= isset($totalCheckins) ? $totalCheckins : 0 ?>
                </p>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card" style="padding:20px; border-radius:12px;">
                <h4 style="margin:0;">🏆 Best Streak</h4>
                <p style="font-size:22px; margin:0;">
                    <?= isset($longestStreak) ? $longestStreak : 0 ?>
                </p>
            </div>
        </div>

    </div>

</div>


<!-- DAILY MOTIVATION -->

<div class="card mt-4" style="
    border:none;
    border-radius:16px;
    padding:30px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
">

    <div class="text-center">

        <h4 style="margin-bottom:15px;">
            ✨ Daily Motivation
        </h4>

        <p style="
            font-size:18px;
            color:#555;
            margin-bottom:0;
            font-style:italic;
        ">
            "<?= $dailyQuote ?>"
        </p>

    </div>

</div>

<!-- OTHER PAGE BUTTONS -->
<div class="row mt-4">

    <div class="col-md-4 mb-3">
        <?= Html::a(
            '📝 Journal',
            ['journal/index'],
            ['class' => 'btn btn-outline-primary w-100 py-3']
        ) ?>
    </div>

    <div class="col-md-4 mb-3">
        <?= Html::a(
            '📖 Motivation Center',
            ['/motivation/index'],
            ['class' => 'btn btn-outline-primary w-100 py-3']
        ) ?>
    </div>

    <div class="col-md-4 mb-3">
        <?= Html::a(
            '🎯 Goals & Rewards',
            ['/goal/index'],
            ['class' => 'btn btn-outline-primary w-100 py-3']
        ) ?>
    </div>

</div>

<?php endif; ?>
