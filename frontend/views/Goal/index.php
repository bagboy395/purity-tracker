<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\GoalSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var int $streak */
/** @var array|null $milestone */

$this->title = 'Goals & Rewards';
$this->params['breadcrumbs'][] = $this->title;

$streak = isset($streak) ? (int) $streak : 0;
$goals = $dataProvider->getModels();

$activeGoals = [];
$completedGoals = [];

foreach ($goals as $model) {
    $targetDays = max(1, (int) $model->target_days);
    $progress = min(100, ($streak / $targetDays) * 100);
    $remaining = max(0, $targetDays - $streak);
    $completed = (bool) $model->is_completed || $streak >= $targetDays;

    $goalData = [
        'model' => $model,
        'targetDays' => $targetDays,
        'progress' => $progress,
        'remaining' => $remaining,
        'completed' => $completed,
    ];

    if ($completed) {
        $completedGoals[] = $goalData;
    } else {
        $activeGoals[] = $goalData;
    }
}

$renderGoal = function (array $goal) use ($streak) {
    $model = $goal['model'];
    $targetDays = $goal['targetDays'];
    $progress = $goal['progress'];
    $remaining = $goal['remaining'];
    $completed = $goal['completed'];
    ?>
    <article class="goal-card <?= $completed ? 'goal-card-completed' : '' ?>">
        <div class="goal-card-header">
            <div class="goal-card-title-wrap">
                <div class="goal-card-icon" aria-hidden="true">
                    <?= $completed ? '🏆' : '🎯' ?>
                </div>

                <div>
                    <p class="goal-card-label"><?= $completed ? 'Milestone achieved' : 'Active goal' ?></p>
                    <h3><?= Html::encode($model->title) ?></h3>
                </div>
            </div>

            <?php if ($completed): ?>
                <span class="goal-status goal-status-complete">✓ Completed</span>
            <?php else: ?>
                <span class="goal-status"><?= round($progress) ?>% complete</span>
            <?php endif; ?>
        </div>

        <?php if (!empty($model->description)): ?>
            <p class="goal-description"><?= Html::encode($model->description) ?></p>
        <?php endif; ?>

        <?php if ($completed): ?>
            <div class="goal-completed-message">
                <span aria-hidden="true">🎉</span>
                <div>
                    <strong>You reached this goal!</strong>
                    <p><?= $targetDays ?> day<?= $targetDays === 1 ? '' : 's' ?> of commitment is worth celebrating.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="goal-progress-details">
                <span><strong><?= $streak ?></strong> of <?= $targetDays ?> days</span>
                <span><?= $remaining ?> day<?= $remaining === 1 ? '' : 's' ?> to go</span>
            </div>

            <div
                class="goal-progress-track"
                role="progressbar"
                aria-valuemin="0"
                aria-valuemax="100"
                aria-valuenow="<?= (int) round($progress) ?>"
                aria-label="<?= Html::encode($model->title) ?> progress"
            >
                <div class="goal-progress-fill" style="width: <?= $progress ?>%;"></div>
            </div>

            <p class="goal-next-step">
                <span aria-hidden="true">🔥</span>
                <?php if ($remaining === 1): ?>
                    One more day to reach this milestone.
                <?php else: ?>
                    Keep showing up—<?= $remaining ?> more days to go.
                <?php endif; ?>
            </p>
        <?php endif; ?>

        <footer class="goal-card-footer">
            <span class="goal-target">Target: <?= $targetDays ?> day<?= $targetDays === 1 ? '' : 's' ?></span>

            <div class="goal-actions">
                <?= Html::a('View', ['view', 'id' => $model->id], [
                    'class' => 'goal-action goal-action-view',
                ]) ?>

                <?= Html::a('Edit', ['update', 'id' => $model->id], [
                    'class' => 'goal-action goal-action-edit',
                ]) ?>

                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'goal-action goal-action-delete',
                    'data' => [
                        'method' => 'post',
                        'confirm' => 'Are you sure you want to delete this goal? This cannot be undone.',
                    ],
                ]) ?>
            </div>
        </footer>
    </article>
    <?php
};
?>

<style>
    :root {
        --goal-ink: #10251d;
        --goal-muted: #617167;
        --goal-forest: #174c38;
        --goal-green: #277a57;
        --goal-mint: #dff8e9;
        --goal-lime: #9be15d;
        --goal-cream: #f7fbf8;
        --goal-border: rgba(23, 76, 56, .13);
    }

    .goals-page,
    .goals-page * {
        box-sizing: border-box;
    }

    .goals-page {
        width: 100vw;
        min-height: 100vh;
        margin-left: calc(50% - 50vw);
        padding: 30px clamp(18px, 6vw, 110px) 75px;
        color: var(--goal-ink);
        background:
            radial-gradient(circle at 5% 4%, rgba(155, 225, 93, .20), transparent 23rem),
            radial-gradient(circle at 96% 17%, rgba(48, 172, 111, .13), transparent 26rem),
            var(--goal-cream);
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .goals-wrap {
        width: 100%;
        max-width: 1180px;
        margin: 0 auto;
    }

    .goals-page a {
        text-decoration: none;
    }

    .goals-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .goals-back,
    .goals-create,
    .goal-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 43px;
        padding: 10px 15px;
        border-radius: 12px;
        font-size: .87rem;
        font-weight: 760;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .goals-back {
        color: var(--goal-forest);
        background: rgba(255, 255, 255, .76);
        border: 1px solid var(--goal-border);
    }

    .goals-create {
        color: #fff;
        background: linear-gradient(135deg, #2b825b, #174c38);
        box-shadow: 0 10px 24px rgba(23, 76, 56, .22);
    }

    .goals-back:hover,
    .goals-create:hover,
    .goal-action:hover {
        transform: translateY(-2px);
    }

    .goals-back:hover {
        color: var(--goal-forest);
        background: #fff;
        box-shadow: 0 10px 24px rgba(16, 37, 29, .08);
    }

    .goals-create:hover {
        color: #fff;
        box-shadow: 0 15px 29px rgba(23, 76, 56, .30);
    }

    .goals-back:focus-visible,
    .goals-create:focus-visible,
    .goal-action:focus-visible {
        outline: 3px solid rgba(56, 150, 98, .32);
        outline-offset: 3px;
    }

    .goals-hero {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 30px;
        align-items: end;
        margin: 47px 0 30px;
    }

    .goals-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
        color: var(--goal-forest);
        font-size: .74rem;
        font-weight: 820;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .goals-eyebrow span {
        width: 8px;
        height: 8px;
        background: #4aab73;
        border-radius: 50%;
        box-shadow: 0 0 0 5px rgba(74, 171, 115, .14);
    }

    .goals-hero h1 {
        margin: 0;
        font-size: clamp(2.5rem, 5vw, 4.25rem);
        font-weight: 850;
        letter-spacing: -.07em;
        line-height: .98;
    }

    .goals-hero h1 span {
        color: var(--goal-green);
    }

    .goals-hero p {
        max-width: 610px;
        margin: 17px 0 0;
        color: var(--goal-muted);
        font-size: 1rem;
        line-height: 1.75;
    }

    .goals-streak-card {
        min-width: 185px;
        padding: 18px 21px;
        color: #fff;
        background: linear-gradient(135deg, #123d2d, #287c57);
        border-radius: 18px;
        box-shadow: 0 14px 34px rgba(23, 76, 56, .20);
    }

    .goals-streak-card span {
        display: block;
        color: rgba(255, 255, 255, .70);
        font-size: .73rem;
        font-weight: 780;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .goals-streak-card strong {
        display: block;
        margin-top: 5px;
        font-size: 2rem;
        font-weight: 850;
        letter-spacing: -.06em;
        line-height: 1;
    }

    .goals-milestone {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 24px;
        padding: 21px 24px;
        background: linear-gradient(135deg, #fff9e8, #fffdf6);
        border: 1px solid rgba(184, 132, 30, .17);
        border-radius: 19px;
        box-shadow: 0 10px 28px rgba(106, 75, 17, .06);
    }

    .goals-milestone-icon {
        display: grid;
        place-items: center;
        width: 43px;
        height: 43px;
        flex: 0 0 auto;
        background: #fff0c1;
        border-radius: 13px;
        font-size: 1.15rem;
    }

    .goals-milestone h2 {
        margin: 2px 0 5px;
        font-size: 1.05rem;
        font-weight: 830;
    }

    .goals-milestone p {
        margin: 0;
        color: #685a34;
        font-size: .91rem;
        line-height: 1.6;
    }

    .goals-section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin: 32px 0 16px;
    }

    .goals-section-head h2 {
        margin: 0;
        font-size: 1.35rem;
        font-weight: 830;
        letter-spacing: -.04em;
    }

    .goals-section-count {
        padding: 7px 11px;
        color: var(--goal-forest);
        background: rgba(223, 248, 233, .8);
        border-radius: 999px;
        font-size: .74rem;
        font-weight: 800;
    }

    .goals-list {
        display: grid;
        gap: 17px;
    }

    .goal-card {
        padding: 27px 29px;
        background: rgba(255, 255, 255, .89);
        border: 1px solid var(--goal-border);
        border-radius: 22px;
        box-shadow: 0 13px 37px rgba(16, 37, 29, .06);
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .goal-card:hover {
        border-color: rgba(39, 122, 87, .25);
        box-shadow: 0 18px 42px rgba(16, 37, 29, .10);
        transform: translateY(-3px);
    }

    .goal-card-completed {
        background: linear-gradient(135deg, rgba(247, 255, 249, .92), rgba(255, 255, 255, .92));
    }

    .goal-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 17px;
    }

    .goal-card-title-wrap {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .goal-card-icon {
        display: grid;
        place-items: center;
        width: 45px;
        height: 45px;
        flex: 0 0 auto;
        background: var(--goal-mint);
        border-radius: 14px;
        font-size: 1.18rem;
    }

    .goal-card-completed .goal-card-icon {
        background: #fff1c8;
    }

    .goal-card-label {
        margin: 0 0 3px;
        color: var(--goal-muted);
        font-size: .7rem;
        font-weight: 820;
        letter-spacing: .09em;
        text-transform: uppercase;
    }

    .goal-card h3 {
        margin: 0;
        font-size: 1.14rem;
        font-weight: 830;
        letter-spacing: -.025em;
    }

    .goal-status {
        flex: 0 0 auto;
        padding: 8px 11px;
        color: var(--goal-forest);
        background: #edf8f0;
        border-radius: 10px;
        font-size: .75rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .goal-status-complete {
        color: #765208;
        background: #fff3cc;
    }

    .goal-description {
        margin: 19px 0 0;
        color: var(--goal-muted);
        font-size: .92rem;
        line-height: 1.65;
    }

    .goal-progress-details {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        margin: 22px 0 9px;
        color: var(--goal-muted);
        font-size: .84rem;
    }

    .goal-progress-details strong {
        color: var(--goal-ink);
    }

    .goal-progress-track {
        width: 100%;
        height: 11px;
        overflow: hidden;
        background: #e8f0eb;
        border-radius: 999px;
    }

    .goal-progress-fill {
        height: 100%;
        min-width: 4px;
        background: linear-gradient(90deg, var(--goal-lime), var(--goal-green));
        border-radius: inherit;
        transition: width .45s ease;
    }

    .goal-next-step {
        margin: 13px 0 0;
        color: var(--goal-green);
        font-size: .86rem;
        font-weight: 700;
    }

    .goal-completed-message {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        margin-top: 21px;
        padding: 16px;
        background: #edf9f1;
        border: 1px solid rgba(39, 122, 87, .13);
        border-radius: 14px;
    }

    .goal-completed-message strong {
        font-size: .9rem;
    }

    .goal-completed-message p {
        margin: 4px 0 0;
        color: var(--goal-muted);
        font-size: .84rem;
    }

    .goal-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-top: 23px;
        padding-top: 18px;
        border-top: 1px solid var(--goal-border);
    }

    .goal-target {
        color: var(--goal-muted);
        font-size: .79rem;
        font-weight: 700;
    }

    .goal-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .goal-action {
        min-height: 36px;
        padding: 8px 11px;
        border: 1px solid var(--goal-border);
        font-size: .76rem;
    }

    .goal-action-view {
        color: #fff;
        background: var(--goal-forest);
        border-color: var(--goal-forest);
    }

    .goal-action-view:hover {
        color: #fff;
        background: #103d2c;
    }

    .goal-action-edit {
        color: var(--goal-forest);
        background: #fff;
    }

    .goal-action-edit:hover {
        color: var(--goal-forest);
        background: #f2faf4;
    }

    .goal-action-delete {
        color: #a13d3d;
        background: #fffafa;
        border-color: rgba(161, 61, 61, .18);
    }

    .goal-action-delete:hover {
        color: #8c2b2b;
        background: #fff0f0;
    }

    .goals-empty {
        padding: clamp(44px, 8vw, 78px) 28px;
        text-align: center;
        background: rgba(255, 255, 255, .88);
        border: 1px solid var(--goal-border);
        border-radius: 24px;
        box-shadow: 0 16px 42px rgba(16, 37, 29, .07);
    }

    .goals-empty-icon {
        display: grid;
        place-items: center;
        width: 68px;
        height: 68px;
        margin: 0 auto 19px;
        background: var(--goal-mint);
        border-radius: 21px;
        font-size: 1.8rem;
    }

    .goals-empty h2 {
        margin: 0 0 10px;
        font-size: 1.5rem;
        font-weight: 830;
        letter-spacing: -.04em;
    }

    .goals-empty p {
        max-width: 535px;
        margin: 0 auto 25px;
        color: var(--goal-muted);
        line-height: 1.7;
    }

    @media (max-width: 700px) {
        .goals-page {
            padding: 18px 16px 48px;
        }

        .goals-hero {
            grid-template-columns: 1fr;
            gap: 20px;
            margin-top: 36px;
        }

        .goals-streak-card {
            width: fit-content;
        }

        .goal-card {
            padding: 22px;
            border-radius: 19px;
        }

        .goal-card-header,
        .goal-card-footer {
            align-items: flex-start;
            flex-direction: column;
        }

        .goal-progress-details {
            align-items: flex-start;
            flex-direction: column;
            gap: 4px;
        }
    }

    @media (max-width: 420px) {
        .goals-topbar {
            align-items: stretch;
            flex-direction: column;
        }

        .goals-back,
        .goals-create {
            width: 100%;
        }
    }
</style>

<main class="goals-page">
    <div class="goals-wrap">

        <div class="goals-topbar">
            <?= Html::a('← Back to Dashboard', ['/site/index'], [
                'class' => 'goals-back',
            ]) ?>

            <?= Html::a('+ Create a Goal', ['create'], [
                'class' => 'goals-create',
            ]) ?>
        </div>

        <header class="goals-hero">
            <div>
                <div class="goals-eyebrow">
                    <span></span>
                    Intentional progress
                </div>

                <h1>Goals that keep<br><span>you moving forward.</span></h1>

                <p>
                    Set meaningful milestones, see your real progress, and celebrate every
                    commitment you keep along the way.
                </p>
            </div>

            <aside class="goals-streak-card" aria-label="Current streak">
                <span>Current streak 🔥</span>
                <strong><?= $streak ?> day<?= $streak === 1 ? '' : 's' ?></strong>
            </aside>
        </header>

        <?php if ($milestone !== null): ?>
            <section class="goals-milestone" aria-label="Milestone reward">
                <div class="goals-milestone-icon" aria-hidden="true">🏆</div>
                <div>
                    <h2><?= Html::encode($milestone['title']) ?></h2>
                    <p><?= Html::encode($milestone['message']) ?></p>
                </div>
            </section>
        <?php endif; ?>

        <?php if (empty($goals)): ?>
            <section class="goals-empty">
                <div class="goals-empty-icon" aria-hidden="true">🎯</div>
                <h2>Choose your first milestone.</h2>
                <p>
                    A goal gives your streak a clear purpose. Start with something meaningful
                    and let each daily check-in move you closer to it.
                </p>

                <?= Html::a('+ Create your first goal', ['create'], [
                    'class' => 'goals-create',
                ]) ?>
            </section>

        <?php else: ?>
            <?php if (!empty($activeGoals)): ?>
                <section aria-labelledby="active-goals-title">
                    <div class="goals-section-head">
                        <h2 id="active-goals-title">Active goals</h2>
                        <span class="goals-section-count"><?= count($activeGoals) ?> in progress</span>
                    </div>

                    <div class="goals-list">
                        <?php foreach ($activeGoals as $goal): ?>
                            <?php $renderGoal($goal); ?>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (!empty($completedGoals)): ?>
                <section aria-labelledby="completed-goals-title">
                    <div class="goals-section-head">
                        <h2 id="completed-goals-title">Completed goals</h2>
                        <span class="goals-section-count"><?= count($completedGoals) ?> achieved</span>
                    </div>

                    <div class="goals-list">
                        <?php foreach ($completedGoals as $goal): ?>
                            <?php $renderGoal($goal); ?>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</main>