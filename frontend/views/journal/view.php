<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Journal $model */

$this->title = 'Journal Entry';
$this->params['breadcrumbs'][] = ['label' => 'Journal', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$intensity = (int) $model->intensity;
?>

<style>
    :root {
        --jv-ink: #10251d;
        --jv-muted: #617167;
        --jv-forest: #174c38;
        --jv-green: #277a57;
        --jv-mint: #dff8e9;
        --jv-cream: #f7fbf8;
        --jv-border: rgba(23, 76, 56, .13);
    }

    .journal-view-page,
    .journal-view-page * {
        box-sizing: border-box;
    }

    .journal-view-page {
        width: 100vw;
        min-height: 100vh;
        margin-left: calc(50% - 50vw);
        padding: 30px clamp(18px, 6vw, 110px) 75px;
        color: var(--jv-ink);
        background:
            radial-gradient(circle at 5% 4%, rgba(155, 225, 93, .19), transparent 23rem),
            radial-gradient(circle at 96% 19%, rgba(48, 172, 111, .13), transparent 25rem),
            var(--jv-cream);
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .journal-view-wrap {
        width: 100%;
        max-width: 1040px;
        margin: 0 auto;
    }

    .journal-view-page a {
        text-decoration: none;
    }

    .journal-view-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 42px;
    }

    .journal-view-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 9px;
    }

    .journal-view-back,
    .journal-view-edit,
    .journal-view-delete {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 43px;
        padding: 10px 15px;
        border-radius: 12px;
        font-size: .86rem;
        font-weight: 750;
        transition: transform .2s ease, background .2s ease, box-shadow .2s ease;
    }

    .journal-view-back {
        color: var(--jv-forest);
        background: rgba(255, 255, 255, .74);
        border: 1px solid var(--jv-border);
    }

    .journal-view-edit {
        color: var(--jv-forest);
        background: rgba(223, 248, 233, .88);
        border: 1px solid rgba(39, 122, 87, .16);
    }

    .journal-view-delete {
        color: #a13d3d;
        background: #fffafa;
        border: 1px solid rgba(161, 61, 61, .18);
        cursor: pointer;
    }

    .journal-view-back:hover,
    .journal-view-edit:hover,
    .journal-view-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(16, 37, 29, .08);
    }

    .journal-view-back:hover,
    .journal-view-edit:hover {
        color: var(--jv-forest);
        background: #fff;
    }

    .journal-view-delete:hover {
        color: #8e2929;
        background: #fff0f0;
    }

    .journal-view-back:focus-visible,
    .journal-view-edit:focus-visible,
    .journal-view-delete:focus-visible {
        outline: 3px solid rgba(56, 150, 98, .32);
        outline-offset: 3px;
    }

    .journal-view-delete-form {
        display: inline;
        margin: 0;
    }

    .journal-view-hero {
        margin-bottom: 29px;
        text-align: center;
    }

    .journal-view-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
        color: var(--jv-forest);
        font-size: .74rem;
        font-weight: 820;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .journal-view-eyebrow span {
        width: 8px;
        height: 8px;
        background: #4aab73;
        border-radius: 50%;
        box-shadow: 0 0 0 5px rgba(74, 171, 115, .14);
    }

    .journal-view-hero h1 {
        margin: 0;
        font-size: clamp(2.35rem, 5vw, 3.9rem);
        font-weight: 850;
        letter-spacing: -.065em;
        line-height: 1;
    }

    .journal-view-hero h1 span {
        color: var(--jv-green);
    }

    .journal-view-hero p {
        max-width: 620px;
        margin: 17px auto 0;
        color: var(--jv-muted);
        font-size: .98rem;
        line-height: 1.7;
    }

    .journal-entry-card {
        position: relative;
        overflow: hidden;
        background: rgba(255, 255, 255, .9);
        border: 1px solid var(--jv-border);
        border-radius: 26px;
        box-shadow: 0 20px 55px rgba(18, 58, 42, .10);
    }

    .journal-entry-card::before {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        content: "";
        background: linear-gradient(90deg, #9be15d, #277a57, #174c38);
    }

    .journal-entry-summary {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 22px;
        padding: clamp(25px, 5vw, 43px);
        background: linear-gradient(135deg, rgba(223, 248, 233, .74), rgba(255, 255, 255, .9));
        border-bottom: 1px solid var(--jv-border);
    }

    .journal-entry-label {
        margin: 0 0 9px;
        color: var(--jv-muted);
        font-size: .7rem;
        font-weight: 820;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .journal-entry-summary h2 {
        margin: 0;
        font-size: clamp(1.6rem, 3vw, 2.25rem);
        font-weight: 850;
        letter-spacing: -.05em;
        line-height: 1.1;
    }

    .journal-entry-date {
        margin: 10px 0 0;
        color: var(--jv-muted);
        font-size: .9rem;
    }

    .journal-entry-intensity {
        flex: 0 0 auto;
        min-width: 118px;
        padding: 13px 15px;
        color: #96600a;
        background: #fff6df;
        border: 1px solid rgba(183, 130, 31, .12);
        border-radius: 14px;
        font-size: .83rem;
        font-weight: 800;
        text-align: center;
    }

    .journal-entry-intensity strong {
        display: block;
        margin-top: 3px;
        color: #744702;
        font-size: 1.2rem;
        letter-spacing: -.04em;
    }

    .journal-entry-content {
        display: grid;
        gap: 24px;
        padding: clamp(25px, 5vw, 43px);
    }

    .journal-reflection {
        padding: 23px;
        background: #fbfefc;
        border: 1px solid rgba(23, 76, 56, .10);
        border-radius: 18px;
    }

    .journal-reflection-head {
        display: flex;
        align-items: center;
        gap: 11px;
        margin-bottom: 15px;
    }

    .journal-reflection-icon {
        display: grid;
        place-items: center;
        width: 37px;
        height: 37px;
        background: var(--jv-mint);
        border-radius: 11px;
        font-size: 1rem;
    }

    .journal-reflection:nth-child(2) .journal-reflection-icon {
        background: #edf0ff;
    }

    .journal-reflection:nth-child(3) .journal-reflection-icon {
        background: #fff5df;
    }

    .journal-reflection h3 {
        margin: 0;
        font-size: .96rem;
        font-weight: 820;
        letter-spacing: -.02em;
    }

    .journal-reflection-body {
        color: #3f574a;
        font-size: .95rem;
        line-height: 1.8;
    }

    .journal-reflection-body p {
        margin: 0;
    }

    .journal-empty-notes {
        color: #8a988f;
        font-style: italic;
    }

    @media (max-width: 600px) {
        .journal-view-page {
            padding: 18px 16px 48px;
        }

        .journal-view-topbar {
            align-items: flex-start;
            flex-direction: column;
            margin-bottom: 35px;
        }

        .journal-view-actions {
            width: 100%;
        }

        .journal-view-back,
        .journal-view-edit,
        .journal-view-delete {
            min-height: 40px;
            padding: 9px 11px;
            font-size: .79rem;
        }

        .journal-entry-summary {
            align-items: flex-start;
            flex-direction: column;
        }

        .journal-entry-intensity {
            min-width: 0;
        }

        .journal-entry-card {
            border-radius: 20px;
        }

        .journal-reflection {
            padding: 19px;
            border-radius: 15px;
        }
    }
</style>

<main class="journal-view-page">
    <div class="journal-view-wrap">

        <div class="journal-view-topbar">
            <?= Html::a('← Back to Journal', ['index'], [
                'class' => 'journal-view-back',
            ]) ?>

            <div class="journal-view-actions">
                <?= Html::a('Edit Entry', ['update', 'id' => $model->id], [
                    'class' => 'journal-view-edit',
                ]) ?>

                <?= Html::beginForm(['delete', 'id' => $model->id], 'post', [
                    'class' => 'journal-view-delete-form',
                ]) ?>

                <?= Html::submitButton('Delete Entry', [
                    'class' => 'journal-view-delete',
                    'data-confirm' => 'Are you sure you want to delete this journal entry?',
                ]) ?>

                <?= Html::endForm() ?>
            </div>
        </div>

        <header class="journal-view-hero">
            <div class="journal-view-eyebrow">
                <span></span>
                Your private reflection
            </div>

            <h1>See the moment.<br><span>Keep the lesson.</span></h1>

            <p>
                Review this reflection in full—what triggered you, how you responded,
                and the insight you can carry into your next choice.
            </p>
        </header>

        <article class="journal-entry-card">
            <header class="journal-entry-summary">
                <div>
                    <p class="journal-entry-label">Temptation type</p>
                    <h2><?= Html::encode($model->temptation_type) ?></h2>
                    <p class="journal-entry-date">
                        <?= Html::encode(date('l, F j, Y', strtotime($model->entry_date))) ?>
                    </p>
                </div>

                <div class="journal-entry-intensity">
                    Intensity
                    <strong><?= $intensity ?>/10</strong>
                </div>
            </header>

            <div class="journal-entry-content">
                <section class="journal-reflection">
                    <div class="journal-reflection-head">
                        <div class="journal-reflection-icon" aria-hidden="true">✦</div>
                        <h3>What happened</h3>
                    </div>
                    <div class="journal-reflection-body">
                        <?= nl2br(Html::encode($model->what_happened)) ?>
                    </div>
                </section>

                <section class="journal-reflection">
                    <div class="journal-reflection-head">
                        <div class="journal-reflection-icon" aria-hidden="true">↗</div>
                        <h3>How I responded</h3>
                    </div>
                    <div class="journal-reflection-body">
                        <?= nl2br(Html::encode($model->how_responded)) ?>
                    </div>
                </section>

                <section class="journal-reflection">
                    <div class="journal-reflection-head">
                        <div class="journal-reflection-icon" aria-hidden="true">📝</div>
                        <h3>Notes</h3>
                    </div>
                    <div class="journal-reflection-body">
                        <?php if (!empty($model->notes)): ?>
                            <?= nl2br(Html::encode($model->notes)) ?>
                        <?php else: ?>
                            <p class="journal-empty-notes">No additional notes for this entry.</p>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </article>

    </div>
</main>