<?php

use yii\helpers\Html;

/** @var bool $hasCheckedInToday */
/** @var int $totalCheckins */
/** @var int $streak */
/** @var int $longestStreak */
/** @var common\models\Checkin[] $checkins */

$totalCheckins = isset($totalCheckins) ? (int) $totalCheckins : 0;
$streak = isset($streak) ? (int) $streak : 0;
$longestStreak = isset($longestStreak) ? (int) $longestStreak : 0;
?>

<style>
    :root {
        --ci-ink: #10251d;
        --ci-muted: #617167;
        --ci-forest: #174c38;
        --ci-green: #277a57;
        --ci-mint: #dff8e9;
        --ci-lime: #9be15d;
        --ci-cream: #f7fbf8;
        --ci-border: rgba(23, 76, 56, .13);
    }

    .checkin-page,
    .checkin-page * {
        box-sizing: border-box;
    }

    .checkin-page {
        width: 100vw;
        min-height: 100vh;
        margin-left: calc(50% - 50vw);
        padding: 30px clamp(18px, 6vw, 110px) 75px;
        color: var(--ci-ink);
        background:
            radial-gradient(circle at 5% 4%, rgba(155, 225, 93, .20), transparent 23rem),
            radial-gradient(circle at 96% 18%, rgba(48, 172, 111, .13), transparent 25rem),
            var(--ci-cream);
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .checkin-wrap {
        width: 100%;
        max-width: 1080px;
        margin: 0 auto;
    }

    .checkin-page a {
        text-decoration: none;
    }

    .checkin-topbar {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 38px;
    }

    .checkin-home {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 43px;
        padding: 10px 15px;
        color: var(--ci-forest);
        background: rgba(255, 255, 255, .75);
        border: 1px solid var(--ci-border);
        border-radius: 12px;
        font-size: .87rem;
        font-weight: 750;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .checkin-home:hover {
        color: var(--ci-forest);
        background: #fff;
        box-shadow: 0 10px 24px rgba(16, 37, 29, .08);
        transform: translateY(-2px);
    }

    .checkin-home:focus-visible,
    .checkin-submit:focus-visible {
        outline: 3px solid rgba(56, 150, 98, .32);
        outline-offset: 3px;
    }

    .checkin-hero {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 30px;
        align-items: end;
        margin-bottom: 29px;
    }

    .checkin-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
        color: var(--ci-forest);
        font-size: .74rem;
        font-weight: 820;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .checkin-eyebrow span {
        width: 8px;
        height: 8px;
        background: #4aab73;
        border-radius: 50%;
        box-shadow: 0 0 0 5px rgba(74, 171, 115, .14);
    }

    .checkin-hero h1 {
        margin: 0;
        font-size: clamp(2.5rem, 5vw, 4.25rem);
        font-weight: 850;
        letter-spacing: -.07em;
        line-height: .98;
    }

    .checkin-hero h1 span {
        color: var(--ci-green);
    }

    .checkin-hero p {
        max-width: 610px;
        margin: 17px 0 0;
        color: var(--ci-muted);
        font-size: 1rem;
        line-height: 1.75;
    }

    .checkin-date {
        padding: 10px 13px;
        color: var(--ci-forest);
        background: rgba(223, 248, 233, .82);
        border-radius: 10px;
        font-size: .82rem;
        font-weight: 750;
        white-space: nowrap;
    }

    .checkin-main-grid {
        display: grid;
        grid-template-columns: 1.2fr .8fr;
        gap: 20px;
        margin-bottom: 21px;
    }

    .checkin-card {
        background: rgba(255, 255, 255, .89);
        border: 1px solid var(--ci-border);
        border-radius: 24px;
        box-shadow: 0 15px 42px rgba(16, 37, 29, .07);
    }

    .checkin-action-card {
        position: relative;
        min-height: 337px;
        overflow: hidden;
        padding: clamp(27px, 5vw, 40px);
        color: #fff;
        background: linear-gradient(135deg, #123d2d 0%, #1f7652 62%, #329564 100%);
        border: 0;
        box-shadow: 0 22px 52px rgba(19, 76, 54, .24);
    }

    .checkin-action-card::before,
    .checkin-action-card::after {
        position: absolute;
        border: 1px solid rgba(255, 255, 255, .13);
        border-radius: 50%;
        content: "";
    }

    .checkin-action-card::before {
        top: -175px;
        right: -95px;
        width: 340px;
        height: 340px;
    }

    .checkin-action-card::after {
        bottom: -160px;
        left: 33%;
        width: 220px;
        height: 220px;
    }

    .checkin-action-content {
        position: relative;
        z-index: 1;
    }

    .checkin-action-card .checkin-label {
        color: rgba(255, 255, 255, .68);
    }

    .checkin-label {
        margin: 0;
        font-size: .72rem;
        font-weight: 820;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .checkin-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 15px;
        padding: 8px 11px;
        border: 1px solid rgba(255, 255, 255, .17);
        border-radius: 999px;
        background: rgba(255, 255, 255, .11);
        font-size: .81rem;
        font-weight: 720;
    }

    .checkin-status-dot {
        width: 8px;
        height: 8px;
        background: var(--ci-lime);
        border-radius: 50%;
        box-shadow: 0 0 0 4px rgba(155, 225, 93, .14);
    }

    .checkin-status-pending .checkin-status-dot {
        background: #f7cd62;
        box-shadow: 0 0 0 4px rgba(247, 205, 98, .14);
    }

    .checkin-action-card h2 {
        margin: 24px 0 9px;
        font-size: clamp(1.65rem, 4vw, 2.2rem);
        font-weight: 840;
        letter-spacing: -.05em;
    }

    .checkin-action-card p {
        max-width: 510px;
        margin: 0 0 25px;
        color: rgba(255, 255, 255, .78);
        line-height: 1.65;
    }

    .checkin-submit {
        width: 100%;
        min-height: 53px;
        color: var(--ci-forest);
        background: #fff;
        border: 0;
        border-radius: 13px;
        box-shadow: 0 11px 24px rgba(0, 0, 0, .15);
        cursor: pointer;
        font-size: .94rem;
        font-weight: 830;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .checkin-submit:hover:not(:disabled) {
        box-shadow: 0 15px 29px rgba(0, 0, 0, .21);
        transform: translateY(-2px);
    }

    .checkin-submit:disabled {
        color: rgba(255, 255, 255, .8);
        background: rgba(255, 255, 255, .15);
        border: 1px solid rgba(255, 255, 255, .18);
        box-shadow: none;
        cursor: default;
    }

    .checkin-stats-card {
        padding: 26px;
    }

    .checkin-stats-card h2 {
        margin: 5px 0 21px;
        font-size: 1.22rem;
        font-weight: 830;
        letter-spacing: -.03em;
    }

    .checkin-stat-row {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 16px 0;
        border-top: 1px solid var(--ci-border);
    }

    .checkin-stat-icon {
        display: grid;
        place-items: center;
        width: 42px;
        height: 42px;
        flex: 0 0 auto;
        background: #edf8f0;
        border-radius: 13px;
        font-size: 1.05rem;
    }

    .checkin-stat-row:nth-child(3) .checkin-stat-icon {
        background: #fff4dd;
    }

    .checkin-stat-copy {
        flex: 1;
    }

    .checkin-stat-copy span {
        display: block;
        color: var(--ci-muted);
        font-size: .78rem;
        font-weight: 700;
    }

    .checkin-stat-copy strong {
        display: block;
        margin-top: 2px;
        font-size: .96rem;
        font-weight: 810;
    }

    .checkin-stat-value {
        color: var(--ci-forest);
        font-size: 1.3rem;
        font-weight: 850;
        letter-spacing: -.05em;
    }

    .checkin-history-card {
        padding: 28px;
    }

    .checkin-history-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 19px;
    }

    .checkin-history-head h2 {
        margin: 0;
        font-size: 1.22rem;
        font-weight: 830;
        letter-spacing: -.03em;
    }

    .checkin-history-count {
        padding: 7px 11px;
        color: var(--ci-forest);
        background: rgba(223, 248, 233, .82);
        border-radius: 999px;
        font-size: .74rem;
        font-weight: 800;
    }

    .checkin-history-list {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 11px;
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .checkin-history-item {
        padding: 13px 11px;
        color: var(--ci-forest);
        background: #f4fbf6;
        border: 1px solid rgba(39, 122, 87, .10);
        border-radius: 12px;
        font-size: .8rem;
        font-weight: 730;
        text-align: center;
    }

    .checkin-history-item::before {
        display: block;
        margin-bottom: 5px;
        content: "✓";
        color: var(--ci-green);
        font-size: 1rem;
        font-weight: 900;
    }

    .checkin-history-empty {
        margin: 0;
        padding: 28px;
        color: var(--ci-muted);
        background: #fbfefc;
        border: 1px dashed rgba(23, 76, 56, .20);
        border-radius: 15px;
        text-align: center;
    }

    @media (max-width: 760px) {
        .checkin-page {
            padding: 18px 16px 48px;
        }

        .checkin-topbar {
            margin-bottom: 34px;
        }

        .checkin-hero {
            grid-template-columns: 1fr;
            gap: 17px;
        }

        .checkin-date {
            width: fit-content;
        }

        .checkin-main-grid {
            grid-template-columns: 1fr;
        }

        .checkin-action-card,
        .checkin-stats-card,
        .checkin-history-card {
            border-radius: 20px;
        }

        .checkin-history-list {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<main class="checkin-page">
    <div class="checkin-wrap">

        <div class="checkin-topbar">
            <?= Html::a('← Back to Dashboard', ['/site/index'], [
                'class' => 'checkin-home',
            ]) ?>
        </div>

        <header class="checkin-hero">
            <div>
                <div class="checkin-eyebrow">
                    <span></span>
                    Daily commitment
                </div>

                <h1>One decision.<br><span>One stronger day.</span></h1>

                <p>
                    Your commitment journey is built in small moments.
                    Check in today and honour the progress you are making.
                </p>
            </div>

            <div class="checkin-date"><?= date('l, F j') ?></div>
        </header>

        <section class="checkin-main-grid">
            <article class="checkin-card checkin-action-card">
                <div class="checkin-action-content">
                    <p class="checkin-label">Today’s check-in</p>

                    <?php if ($hasCheckedInToday): ?>
                        <div class="checkin-status">
                            <span class="checkin-status-dot"></span>
                            You have checked in today
                        </div>

                        <h2>You showed up today. 🌱</h2>
                        <p>
                            Your consistency matters. Let this be one more reminder
                            that you are capable of choosing what is good for you.
                        </p>
                    <?php else: ?>
                        <div class="checkin-status checkin-status-pending">
                            <span class="checkin-status-dot"></span>
                            Your check-in is waiting
                        </div>

                        <h2>Ready to conquer today?</h2>
                        <p>
                            Take a moment to recognise your commitment.
                            This simple check-in keeps your journey moving forward.
                        </p>
                    <?php endif; ?>

                    <?= Html::beginForm('index.php?r=checkin/create', 'post') ?>

                    <?= Html::submitButton(
                        $hasCheckedInToday ? '✓ Checked in today' : '✓ I conquered today',
                        [
                            'class' => 'checkin-submit',
                            'disabled' => $hasCheckedInToday,
                        ]
                    ) ?>

                    <?= Html::endForm() ?>
                </div>
            </article>

            <aside class="checkin-card checkin-stats-card">
                <p class="checkin-label">Your progress</p>
                <h2>Every day counts.</h2>

                <div class="checkin-stat-row">
                    <div class="checkin-stat-icon" aria-hidden="true">🔥</div>
                    <div class="checkin-stat-copy">
                        <span>Current streak</span>
                        <strong>Building momentum</strong>
                    </div>
                    <div class="checkin-stat-value"><?= $streak ?></div>
                </div>

                <div class="checkin-stat-row">
                    <div class="checkin-stat-icon" aria-hidden="true">🏆</div>
                    <div class="checkin-stat-copy">
                        <span>Best streak</span>
                        <strong>Your personal record</strong>
                    </div>
                    <div class="checkin-stat-value"><?= $longestStreak ?></div>
                </div>

                <div class="checkin-stat-row">
                    <div class="checkin-stat-icon" aria-hidden="true">📅</div>
                    <div class="checkin-stat-copy">
                        <span>Total check-ins</span>
                        <strong>Days you chose progress</strong>
                    </div>
                    <div class="checkin-stat-value"><?= $totalCheckins ?></div>
                </div>
            </aside>
        </section>

        <section class="checkin-card checkin-history-card" aria-labelledby="history-title">
            <div class="checkin-history-head">
                <h2 id="history-title">Your recent check-ins</h2>
                <span class="checkin-history-count"><?= $totalCheckins ?> total</span>
            </div>

            <?php if (!empty($checkins)): ?>
                <ul class="checkin-history-list">
                    <?php foreach ($checkins as $checkin): ?>
                        <li class="checkin-history-item">
                            <?= Html::encode(date('M j, Y', strtotime($checkin->checkin_date))) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="checkin-history-empty">
                    Your completed check-ins will appear here as you build your streak.
                </p>
            <?php endif; ?>
        </section>

    </div>
</main>