<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Goal $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Goals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);

$targetDays = (int) $model->target_days;
$isCompleted = (bool) $model->is_completed;

$formatDate = function ($date) {
    if (empty($date)) {
        return '—';
    }

    $timestamp = is_numeric($date) ? (int) $date : strtotime($date);

    return $timestamp ? date('F j, Y', $timestamp) : '—';
};
?>

<style>
    :root {
        --gv-ink: #10251d;
        --gv-muted: #617167;
        --gv-forest: #174c38;
        --gv-green: #277a57;
        --gv-mint: #dff8e9;
        --gv-cream: #f7fbf8;
        --gv-border: rgba(23, 76, 56, .13);
    }

    .goal-view-page,
    .goal-view-page * {
        box-sizing: border-box;
    }

    .goal-view-page {
        width: 100vw;
        min-height: 100vh;
        margin-left: calc(50% - 50vw);
        padding: 30px clamp(18px, 6vw, 110px) 75px;
        color: var(--gv-ink);
        background:
            radial-gradient(circle at 5% 4%, rgba(155, 225, 93, .20), transparent 23rem),
            radial-gradient(circle at 96% 18%, rgba(48, 172, 111, .13), transparent 25rem),
            var(--gv-cream);
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .goal-view-wrap {
        width: 100%;
        max-width: 1060px;
        margin: 0 auto;
    }

    .goal-view-page a {
        text-decoration: none;
    }

    .goal-view-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 42px;
    }

    .goal-view-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 9px;
    }

    .goal-view-back,
    .goal-view-edit,
    .goal-view-delete {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 43px;
        padding: 10px 15px;
        border-radius: 12px;
        font-size: .86rem;
        font-weight: 750;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .goal-view-back {
        color: var(--gv-forest);
        background: rgba(255, 255, 255, .75);
        border: 1px solid var(--gv-border);
    }

    .goal-view-edit {
        color: #fff;
        background: linear-gradient(135deg, #2b825b, #174c38);
        box-shadow: 0 10px 22px rgba(23, 76, 56, .20);
    }

    .goal-view-delete {
        color: #a13d3d;
        background: #fffafa;
        border: 1px solid rgba(161, 61, 61, .18);
    }

    .goal-view-back:hover,
    .goal-view-edit:hover,
    .goal-view-delete:hover {
        transform: translateY(-2px);
    }

    .goal-view-back:hover {
        color: var(--gv-forest);
        background: #fff;
        box-shadow: 0 10px 24px rgba(16, 37, 29, .08);
    }

    .goal-view-edit:hover {
        color: #fff;
        box-shadow: 0 14px 28px rgba(23, 76, 56, .29);
    }

    .goal-view-delete:hover {
        color: #8d2929;
        background: #fff0f0;
    }

    .goal-view-back:focus-visible,
    .goal-view-edit:focus-visible,
    .goal-view-delete:focus-visible {
        outline: 3px solid rgba(56, 150, 98, .32);
        outline-offset: 3px;
    }

    .goal-delete-form {
        display: inline;
        margin: 0;
    }

    .goal-view-hero {
        max-width: 780px;
        margin: 0 auto 30px;
        text-align: center;
    }

    .goal-view-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
        color: var(--gv-forest);
        font-size: .74rem;
        font-weight: 820;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .goal-view-eyebrow span {
        width: 8px;
        height: 8px;
        background: #4aab73;
        border-radius: 50%;
        box-shadow: 0 0 0 5px rgba(74, 171, 115, .14);
    }

    .goal-view-hero h1 {
        margin: 0;
        font-size: clamp(2.35rem, 5vw, 4rem);
        font-weight: 850;
        letter-spacing: -.065em;
        line-height: 1;
    }

    .goal-view-hero p {
        max-width: 620px;
        margin: 17px auto 0;
        color: var(--gv-muted);
        font-size: .98rem;
        line-height: 1.7;
    }

    .goal-detail-card {
        overflow: hidden;
        background: rgba(255, 255, 255, .9);
        border: 1px solid var(--gv-border);
        border-radius: 26px;
        box-shadow: 0 20px 55px rgba(18, 58, 42, .10);
    }

    .goal-detail-card::before {
        display: block;
        width: 100%;
        height: 5px;
        content: "";
        background: linear-gradient(90deg, #9be15d, #277a57, #174c38);
    }

    .goal-detail-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 22px;
        padding: clamp(25px, 5vw, 42px);
        background: linear-gradient(135deg, rgba(223, 248, 233, .75), rgba(255, 255, 255, .9));
        border-bottom: 1px solid var(--gv-border);
    }

    .goal-summary-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .goal-summary-icon {
        display: grid;
        place-items: center;
        width: 55px;
        height: 55px;
        flex: 0 0 auto;
        background: var(--gv-mint);
        border-radius: 17px;
        font-size: 1.5rem;
    }

    .goal-complete .goal-summary-icon {
        background: #fff1c8;
    }

    .goal-summary-label {
        margin: 0 0 4px;
        color: var(--gv-muted);
        font-size: .7rem;
        font-weight: 820;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .goal-summary-left h2 {
        margin: 0;
        font-size: clamp(1.3rem, 3vw, 1.85rem);
        font-weight: 840;
        letter-spacing: -.04em;
    }

    .goal-completion-status {
        flex: 0 0 auto;
        padding: 10px 13px;
        color: var(--gv-forest);
        background: #edf8f0;
        border-radius: 11px;
        font-size: .79rem;
        font-weight: 800;
    }

    .goal-complete .goal-completion-status {
        color: #765208;
        background: #fff3cc;
    }

    .goal-detail-content {
        padding: clamp(25px, 5vw, 42px);
    }

    .goal-metrics {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-bottom: 26px;
    }

    .goal-metric {
        padding: 20px;
        background: #fbfefc;
        border: 1px solid rgba(23, 76, 56, .10);
        border-radius: 17px;
    }

    .goal-metric-label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 9px;
        color: var(--gv-muted);
        font-size: .77rem;
        font-weight: 750;
    }

    .goal-metric-label span {
        display: grid;
        place-items: center;
        width: 27px;
        height: 27px;
        background: #edf8f0;
        border-radius: 8px;
        font-size: .8rem;
    }

    .goal-metric-value {
        font-size: 1.42rem;
        font-weight: 850;
        letter-spacing: -.05em;
    }

    .goal-description-block {
        padding: 24px;
        background: #fbfefc;
        border: 1px solid rgba(23, 76, 56, .10);
        border-radius: 18px;
    }

    .goal-description-head {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 13px;
    }

    .goal-description-icon {
        display: grid;
        place-items: center;
        width: 38px;
        height: 38px;
        background: #eef0ff;
        border-radius: 11px;
        font-size: 1rem;
    }

    .goal-description-head h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 820;
    }

    .goal-description-text {
        margin: 0;
        color: #40564b;
        line-height: 1.75;
        white-space: pre-line;
    }

    .goal-description-empty {
        color: #8a988f;
        font-style: italic;
    }

    .goal-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 18px;
        margin-top: 23px;
        padding-top: 19px;
        border-top: 1px solid var(--gv-border);
        color: var(--gv-muted);
        font-size: .78rem;
        font-weight: 650;
    }

    @media (max-width: 600px) {
        .goal-view-page {
            padding: 18px 16px 48px;
        }

        .goal-view-topbar {
            align-items: flex-start;
            flex-direction: column;
            margin-bottom: 35px;
        }

        .goal-view-actions {
            width: 100%;
        }

        .goal-view-back,
        .goal-view-edit,
        .goal-view-delete {
            min-height: 40px;
            padding: 9px 11px;
            font-size: .79rem;
        }

        .goal-detail-card {
            border-radius: 20px;
        }

        .goal-detail-summary {
            align-items: flex-start;
            flex-direction: column;
        }

        .goal-metrics {
            grid-template-columns: 1fr;
        }

        .goal-summary-icon {
            width: 47px;
            height: 47px;
        }
    }
</style>

<main class="goal-view-page">
    <div class="goal-view-wrap">

        <div class="goal-view-topbar">
            <?= Html::a('← Back to Goals', ['index'], [
                'class' => 'goal-view-back',
            ]) ?>

            <div class="goal-view-actions">
                <?= Html::a('Edit Goal', ['update', 'id' => $model->id], [
                    'class' => 'goal-view-edit',
                ]) ?>

                <?= Html::beginForm(['delete', 'id' => $model->id], 'post', [
                    'class' => 'goal-delete-form',
                ]) ?>

                <?= Html::submitButton('Delete', [
                    'class' => 'goal-view-delete',
                    'data-confirm' => 'Are you sure you want to delete this goal? This cannot be undone.',
                ]) ?>

                <?= Html::endForm() ?>
            </div>
        </div>

        <header class="goal-view-hero">
            <div class="goal-view-eyebrow">
                <span></span>
                Your milestone
            </div>

            <h1><?= Html::encode($model->title) ?></h1>

            <p>
                Keep this goal visible, meaningful, and connected to the daily choices
                that move you forward.
            </p>
        </header>

        <article class="goal-detail-card <?= $isCompleted ? 'goal-complete' : '' ?>">
            <header class="goal-detail-summary">
                <div class="goal-summary-left">
                    <div class="goal-summary-icon" aria-hidden="true">
                        <?= $isCompleted ? '🏆' : '🎯' ?>
                    </div>

                    <div>
                        <p class="goal-summary-label"><?= $isCompleted ? 'Milestone achieved' : 'Active goal' ?></p>
                        <h2><?= Html::encode($model->title) ?></h2>
                    </div>
                </div>

                <span class="goal-completion-status">
                    <?= $isCompleted ? '✓ Completed' : 'In progress' ?>
                </span>
            </header>

            <div class="goal-detail-content">
                <section class="goal-metrics" aria-label="Goal details">
                    <div class="goal-metric">
                        <div class="goal-metric-label">
                            <span aria-hidden="true">🎯</span>
                            Target
                        </div>
                        <div class="goal-metric-value">
                            <?= $targetDays ?> day<?= $targetDays === 1 ? '' : 's' ?>
                        </div>
                    </div>

                    <div class="goal-metric">
                        <div class="goal-metric-label">
                            <span aria-hidden="true"><?= $isCompleted ? '🏆' : '🌱' ?></span>
                            Status
                        </div>
                        <div class="goal-metric-value">
                            <?= $isCompleted ? 'Achieved' : 'Active' ?>
                        </div>
                    </div>
                </section>

                <section class="goal-description-block">
                    <div class="goal-description-head">
                        <div class="goal-description-icon" aria-hidden="true">📝</div>
                        <h3>Why this goal matters</h3>
                    </div>

                    <?php if (!empty($model->description)): ?>
                        <p class="goal-description-text"><?= Html::encode($model->description) ?></p>
                    <?php else: ?>
                        <p class="goal-description-text goal-description-empty">
                            No description has been added to this goal yet.
                        </p>
                    <?php endif; ?>
                </section>

                <footer class="goal-meta">
                    <span>Created <?= Html::encode($formatDate($model->created_at)) ?></span>
                    <span>Last updated <?= Html::encode($formatDate($model->updated_at)) ?></span>
                </footer>
            </div>
        </article>

    </div>
</main>