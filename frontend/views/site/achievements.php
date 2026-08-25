<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var int $streak */
/** @var common\models\Achievement[] $achievements */

$this->title = 'Achievements';

$streak = isset($streak) ? (int) $streak : 0;

$milestones = [
    [
        'title' => 'First Step',
        'days' => 1,
        'icon' => '🌱',
        'message' => 'You have taken the first step!',
    ],
    [
        'title' => 'Building Momentum',
        'days' => 3,
        'icon' => '🔥',
        'message' => 'Three days strong! Keep going!',
    ],
    [
        'title' => 'One Week Strong',
        'days' => 7,
        'icon' => '🏆',
        'message' => 'You have completed one full week!',
    ],
    [
        'title' => 'Two Weeks Strong',
        'days' => 14,
        'icon' => '💪',
        'message' => 'Two weeks! Keep building!',
    ],
    [
        'title' => 'One Month Strong',
        'days' => 30,
        'icon' => '👑',
        'message' => 'One full month of consistency!',
    ],
    [
        'title' => '60-Day Champion',
        'days' => 60,
        'icon' => '🚀',
        'message' => 'Amazing! You have reached 60 days!',
    ],
    [
        'title' => '90-Day Master',
        'days' => 90,
        'icon' => '🥇',
        'message' => 'Incredible! You have reached 90 days!',
    ],
];

$unlocked = [];

foreach ($achievements as $achievement) {
    $unlocked[$achievement->achievement] = true;
}

$unlockedCount = count($unlocked);
$nextMilestone = null;
$previousMilestoneDays = 0;

foreach ($milestones as $milestone) {
    if (!isset($unlocked[$milestone['title']])) {
        $nextMilestone = $milestone;
        break;
    }

    $previousMilestoneDays = $milestone['days'];
}

$nextProgress = 100;
$daysRemaining = 0;

if ($nextMilestone !== null) {
    $range = max(1, $nextMilestone['days'] - $previousMilestoneDays);
    $nextProgress = max(0, min(100, (($streak - $previousMilestoneDays) / $range) * 100));
    $daysRemaining = max(0, $nextMilestone['days'] - $streak);
}
?>

<style>
    :root {
        --ac-ink: #10251d;
        --ac-muted: #617167;
        --ac-forest: #174c38;
        --ac-green: #277a57;
        --ac-mint: #dff8e9;
        --ac-lime: #9be15d;
        --ac-cream: #f7fbf8;
        --ac-border: rgba(23, 76, 56, .13);
    }

    .achievements-page,
    .achievements-page * {
        box-sizing: border-box;
    }

    .achievements-page {
        width: 100vw;
        min-height: 100vh;
        margin-left: calc(50% - 50vw);
        padding: 30px clamp(18px, 6vw, 110px) 75px;
        color: var(--ac-ink);
        background:
            radial-gradient(circle at 5% 4%, rgba(155, 225, 93, .20), transparent 23rem),
            radial-gradient(circle at 96% 18%, rgba(48, 172, 111, .13), transparent 26rem),
            var(--ac-cream);
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .achievements-wrap {
        width: 100%;
        max-width: 1180px;
        margin: 0 auto;
    }

    .achievements-page a {
        text-decoration: none;
    }

    .achievements-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 43px;
        padding: 10px 15px;
        color: var(--ac-forest);
        background: rgba(255, 255, 255, .75);
        border: 1px solid var(--ac-border);
        border-radius: 12px;
        font-size: .87rem;
        font-weight: 750;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .achievements-back:hover {
        color: var(--ac-forest);
        background: #fff;
        box-shadow: 0 10px 24px rgba(16, 37, 29, .08);
        transform: translateY(-2px);
    }

    .achievements-back:focus-visible {
        outline: 3px solid rgba(56, 150, 98, .32);
        outline-offset: 3px;
    }

    .achievements-hero {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 30px;
        align-items: end;
        margin: 47px 0 30px;
    }

    .achievements-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
        color: var(--ac-forest);
        font-size: .74rem;
        font-weight: 820;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .achievements-eyebrow span {
        width: 8px;
        height: 8px;
        background: #4aab73;
        border-radius: 50%;
        box-shadow: 0 0 0 5px rgba(74, 171, 115, .14);
    }

    .achievements-hero h1 {
        margin: 0;
        font-size: clamp(2.5rem, 5vw, 4.25rem);
        font-weight: 850;
        letter-spacing: -.07em;
        line-height: .98;
    }

    .achievements-hero h1 span {
        color: var(--ac-green);
    }

    .achievements-hero p {
        max-width: 610px;
        margin: 17px 0 0;
        color: var(--ac-muted);
        font-size: 1rem;
        line-height: 1.75;
    }

    .achievements-streak-card {
        min-width: 185px;
        padding: 18px 21px;
        color: #fff;
        background: linear-gradient(135deg, #123d2d, #287c57);
        border-radius: 18px;
        box-shadow: 0 14px 34px rgba(23, 76, 56, .20);
    }

    .achievements-streak-card span {
        display: block;
        color: rgba(255, 255, 255, .70);
        font-size: .73rem;
        font-weight: 780;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .achievements-streak-card strong {
        display: block;
        margin-top: 5px;
        font-size: 2rem;
        font-weight: 850;
        letter-spacing: -.06em;
        line-height: 1;
    }

    .achievements-next-card {
        position: relative;
        overflow: hidden;
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 19px;
        align-items: center;
        margin-bottom: 31px;
        padding: 27px 29px;
        color: #fff;
        background: linear-gradient(135deg, #123d2d 0%, #1f7652 62%, #329564 100%);
        border-radius: 24px;
        box-shadow: 0 21px 50px rgba(19, 76, 54, .22);
    }

    .achievements-next-card::after {
        position: absolute;
        top: -130px;
        right: -72px;
        width: 280px;
        height: 280px;
        border: 1px solid rgba(255, 255, 255, .13);
        border-radius: 50%;
        content: "";
    }

    .achievements-next-icon,
    .achievements-next-content {
        position: relative;
        z-index: 1;
    }

    .achievements-next-icon {
        display: grid;
        place-items: center;
        width: 61px;
        height: 61px;
        background: rgba(255, 255, 255, .14);
        border-radius: 18px;
        font-size: 1.75rem;
    }

    .achievements-next-label {
        margin: 0 0 4px;
        color: rgba(255, 255, 255, .68);
        font-size: .7rem;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .achievements-next-card h2 {
        margin: 0 0 5px;
        font-size: 1.25rem;
        font-weight: 830;
    }

    .achievements-next-card p {
        margin: 0;
        color: rgba(255, 255, 255, .80);
        font-size: .9rem;
    }

    .achievements-progress-track {
        height: 9px;
        margin-top: 15px;
        overflow: hidden;
        background: rgba(255, 255, 255, .16);
        border-radius: 999px;
    }

    .achievements-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--ac-lime), #fff);
        border-radius: inherit;
    }

    .achievements-all-unlocked {
        background: linear-gradient(135deg, #5e429d, #835bd0);
    }

    .achievements-section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 16px;
    }

    .achievements-section-head h2 {
        margin: 0;
        font-size: 1.35rem;
        font-weight: 830;
        letter-spacing: -.04em;
    }

    .achievements-count {
        padding: 7px 11px;
        color: var(--ac-forest);
        background: rgba(223, 248, 233, .82);
        border-radius: 999px;
        font-size: .74rem;
        font-weight: 800;
    }

    .achievements-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 17px;
    }

    .achievement-card {
        position: relative;
        min-height: 247px;
        padding: 24px;
        overflow: hidden;
        background: rgba(255, 255, 255, .88);
        border: 1px solid var(--ac-border);
        border-radius: 21px;
        box-shadow: 0 12px 35px rgba(16, 37, 29, .05);
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .achievement-card:hover {
        border-color: rgba(39, 122, 87, .24);
        box-shadow: 0 18px 40px rgba(16, 37, 29, .09);
        transform: translateY(-3px);
    }

    .achievement-card-unlocked {
        background: linear-gradient(145deg, #f0fff4, #ffffff);
        border-color: rgba(39, 122, 87, .20);
    }

    .achievement-card-locked {
        opacity: .8;
    }

    .achievement-card-icon {
        display: grid;
        place-items: center;
        width: 51px;
        height: 51px;
        margin-bottom: 18px;
        background: var(--ac-mint);
        border-radius: 15px;
        font-size: 1.4rem;
    }

    .achievement-card-unlocked .achievement-card-icon {
        background: #fff0c7;
    }

    .achievement-card-locked .achievement-card-icon {
        filter: grayscale(.55);
        opacity: .74;
    }

    .achievement-card h3 {
        margin: 0;
        font-size: 1.06rem;
        font-weight: 830;
        letter-spacing: -.025em;
    }

    .achievement-days {
        display: inline-block;
        margin-top: 8px;
        color: var(--ac-forest);
        font-size: .79rem;
        font-weight: 800;
    }

    .achievement-card p {
        margin: 11px 0 18px;
        color: var(--ac-muted);
        font-size: .87rem;
        line-height: 1.55;
    }

    .achievement-status {
        position: absolute;
        right: 21px;
        bottom: 21px;
        display: inline-flex;
        align-items: center;
        min-height: 30px;
        padding: 7px 10px;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 800;
    }

    .achievement-status-unlocked {
        color: #17623e;
        background: #dff8e9;
    }

    .achievement-status-locked {
        color: #737d77;
        background: #edf1ee;
    }

    @media (max-width: 850px) {
        .achievements-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 650px) {
        .achievements-page {
            padding: 18px 16px 48px;
        }

        .achievements-hero {
            grid-template-columns: 1fr;
            gap: 20px;
            margin-top: 36px;
        }

        .achievements-streak-card {
            width: fit-content;
        }

        .achievements-next-card {
            grid-template-columns: 1fr;
            padding: 23px;
            border-radius: 20px;
        }

        .achievements-grid {
            grid-template-columns: 1fr;
        }

        .achievement-card {
            min-height: 220px;
        }
    }
</style>

<main class="achievements-page">
    <div class="achievements-wrap">

        <?= Html::a('← Back to Dashboard', ['/site/index'], [
            'class' => 'achievements-back',
        ]) ?>

        <header class="achievements-hero">
            <div>
                <div class="achievements-eyebrow">
                    <span></span>
                    Your milestones
                </div>

                <h1>Celebrate every<br><span>step forward.</span></h1>

                <p>
                    Your achievements are proof that the small choices count.
                    Keep going and unlock each milestone on your journey.
                </p>
            </div>

            <aside class="achievements-streak-card" aria-label="Current streak">
                <span>Current streak 🔥</span>
                <strong><?= $streak ?> day<?= $streak === 1 ? '' : 's' ?></strong>
            </aside>
        </header>

        <?php if ($nextMilestone !== null): ?>
            <section class="achievements-next-card" aria-labelledby="next-milestone-title">
                <div class="achievements-next-icon" aria-hidden="true"><?= $nextMilestone['icon'] ?></div>

                <div class="achievements-next-content">
                    <p class="achievements-next-label">Next milestone</p>
                    <h2 id="next-milestone-title"><?= Html::encode($nextMilestone['title']) ?></h2>
                    <p>
                        <?= $daysRemaining === 1
                            ? 'Just 1 more day until this achievement unlocks.'
                            : $daysRemaining . ' more days until this achievement unlocks.' ?>
                    </p>

                    <div
                        class="achievements-progress-track"
                        role="progressbar"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        aria-valuenow="<?= (int) round($nextProgress) ?>"
                        aria-label="Progress to <?= Html::encode($nextMilestone['title']) ?>"
                    >
                        <div class="achievements-progress-fill" style="width: <?= $nextProgress ?>%;"></div>
                    </div>
                </div>
            </section>
        <?php else: ?>
            <section class="achievements-next-card achievements-all-unlocked">
                <div class="achievements-next-icon" aria-hidden="true">👑</div>

                <div class="achievements-next-content">
                    <p class="achievements-next-label">Outstanding work</p>
                    <h2>Every milestone is unlocked.</h2>
                    <p>You have completed the full achievement journey. Keep protecting your progress.</p>
                </div>
            </section>
        <?php endif; ?>

        <section aria-labelledby="achievement-list-title">
            <div class="achievements-section-head">
                <h2 id="achievement-list-title">Achievement collection</h2>
                <span class="achievements-count"><?= $unlockedCount ?> / <?= count($milestones) ?> unlocked</span>
            </div>

            <div class="achievements-grid">
                <?php foreach ($milestones as $milestone): ?>
                    <?php $isUnlocked = isset($unlocked[$milestone['title']]); ?>

                    <article class="achievement-card <?= $isUnlocked ? 'achievement-card-unlocked' : 'achievement-card-locked' ?>">
                        <div class="achievement-card-icon" aria-hidden="true">
                            <?= $milestone['icon'] ?>
                        </div>

                        <h3><?= Html::encode($milestone['title']) ?></h3>

                        <span class="achievement-days">
                            <?= $milestone['days'] ?> day<?= $milestone['days'] === 1 ? '' : 's' ?>
                        </span>

                        <p><?= Html::encode($milestone['message']) ?></p>

                        <?php if ($isUnlocked): ?>
                            <span class="achievement-status achievement-status-unlocked">✓ Unlocked</span>
                        <?php else: ?>
                            <span class="achievement-status achievement-status-locked">🔒 Locked</span>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

    </div>
</main>