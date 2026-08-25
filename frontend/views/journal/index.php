<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var common\models\Journal[] $journals */
/** @var int $totalEntries */
/** @var float $averageIntensity */
/** @var string|null $latestEntryDate */

$this->title = 'Journal';

$totalEntries = isset($totalEntries) ? (int) $totalEntries : 0;
$averageIntensity = isset($averageIntensity) ? (float) $averageIntensity : 0;
?>

<style>
    :root {
        --journal-ink: #10251d;
        --journal-muted: #617167;
        --journal-forest: #174c38;
        --journal-green: #277a57;
        --journal-mint: #dff8e9;
        --journal-cream: #f7fbf8;
        --journal-border: rgba(23, 76, 56, .11);
        --journal-shadow: 0 18px 45px rgba(18, 58, 42, .09);
    }

    .journal-page,
    .journal-page * {
        box-sizing: border-box;
    }

    .journal-page {
        width: 100vw;
        min-height: 100vh;
        margin-left: calc(50% - 50vw);
        padding: 28px clamp(18px, 6vw, 110px) 70px;
        color: var(--journal-ink);
        background:
            radial-gradient(circle at 4% 5%, rgba(155, 225, 93, .19), transparent 23rem),
            radial-gradient(circle at 94% 16%, rgba(48, 172, 111, .12), transparent 25rem),
            var(--journal-cream);
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .journal-wrap {
        width: 100%;
        max-width: 1280px;
        margin: 0 auto;
    }

    .journal-page a {
        text-decoration: none;
    }

    .journal-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 42px;
    }

    .journal-back,
    .journal-new-entry,
    .journal-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 43px;
        padding: 10px 15px;
        border-radius: 12px;
        font-size: .88rem;
        font-weight: 750;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .journal-back {
        color: var(--journal-forest);
        background: rgba(255, 255, 255, .7);
        border: 1px solid var(--journal-border);
    }

    .journal-new-entry {
        color: #fff;
        background: linear-gradient(135deg, #2b825b, #174c38);
        box-shadow: 0 10px 24px rgba(23, 76, 56, .22);
    }

    .journal-back:hover,
    .journal-new-entry:hover,
    .journal-action:hover {
        transform: translateY(-2px);
    }

    .journal-back:hover {
        color: var(--journal-forest);
        background: #fff;
        box-shadow: 0 10px 24px rgba(16, 37, 29, .08);
    }

    .journal-new-entry:hover {
        color: #fff;
        box-shadow: 0 15px 28px rgba(23, 76, 56, .31);
    }

    .journal-back:focus-visible,
    .journal-new-entry:focus-visible,
    .journal-action:focus-visible {
        outline: 3px solid rgba(56, 150, 98, .35);
        outline-offset: 3px;
    }

    .journal-hero {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 30px;
        align-items: end;
        margin-bottom: 30px;
    }

    .journal-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
        color: var(--journal-forest);
        font-size: .76rem;
        font-weight: 800;
        letter-spacing: .09em;
        text-transform: uppercase;
    }

    .journal-eyebrow span {
        width: 8px;
        height: 8px;
        background: #4aab73;
        border-radius: 50%;
        box-shadow: 0 0 0 5px rgba(74, 171, 115, .14);
    }

    .journal-hero h1 {
        margin: 0;
        font-size: clamp(2.45rem, 5vw, 4.25rem);
        font-weight: 850;
        letter-spacing: -.065em;
        line-height: .98;
    }

    .journal-hero h1 em {
        color: var(--journal-green);
        font-style: normal;
    }

    .journal-hero p {
        max-width: 650px;
        margin: 17px 0 0;
        color: var(--journal-muted);
        font-size: 1rem;
        line-height: 1.75;
    }

    .journal-private-note {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 13px 15px;
        color: var(--journal-forest);
        background: rgba(223, 248, 233, .8);
        border: 1px solid rgba(39, 122, 87, .12);
        border-radius: 14px;
        font-size: .82rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .journal-summary-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 35px;
    }

    .journal-stat {
        position: relative;
        min-height: 158px;
        padding: 25px;
        overflow: hidden;
        background: rgba(255, 255, 255, .85);
        border: 1px solid var(--journal-border);
        border-radius: 21px;
        box-shadow: 0 12px 35px rgba(16, 37, 29, .05);
    }

    .journal-stat::after {
        position: absolute;
        right: -24px;
        bottom: -35px;
        width: 115px;
        height: 115px;
        content: "";
        background: rgba(223, 248, 233, .72);
        border-radius: 50%;
    }

    .journal-stat:nth-child(2)::after {
        background: rgba(255, 238, 193, .62);
    }

    .journal-stat:nth-child(3)::after {
        background: rgba(224, 232, 255, .68);
    }

    .journal-stat-label {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 9px;
        color: var(--journal-muted);
        font-size: .8rem;
        font-weight: 750;
    }

    .journal-stat-icon {
        display: grid;
        place-items: center;
        width: 29px;
        height: 29px;
        background: #edf8f0;
        border-radius: 9px;
        font-size: .92rem;
    }

    .journal-stat:nth-child(2) .journal-stat-icon {
        background: #fff6de;
    }

    .journal-stat:nth-child(3) .journal-stat-icon {
        background: #eef2ff;
    }

    .journal-stat-value {
        position: relative;
        z-index: 1;
        margin-top: 20px;
        color: var(--journal-ink);
        font-size: clamp(2rem, 3vw, 2.7rem);
        font-weight: 850;
        letter-spacing: -.065em;
        line-height: 1;
    }

    .journal-stat-value small {
        color: var(--journal-muted);
        font-size: .98rem;
        font-weight: 700;
        letter-spacing: 0;
    }

    .journal-stat-date {
        font-size: clamp(1.35rem, 2vw, 1.72rem);
        letter-spacing: -.045em;
    }

    .journal-list-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 16px;
    }

    .journal-list-heading h2 {
        margin: 0;
        font-size: 1.35rem;
        font-weight: 830;
        letter-spacing: -.035em;
    }

    .journal-entry-count {
        padding: 7px 11px;
        color: var(--journal-forest);
        background: rgba(223, 248, 233, .8);
        border-radius: 999px;
        font-size: .75rem;
        font-weight: 800;
    }

    .journal-entries {
        display: grid;
        gap: 16px;
    }

    .journal-entry {
        padding: 27px 29px;
        background: rgba(255, 255, 255, .88);
        border: 1px solid var(--journal-border);
        border-radius: 22px;
        box-shadow: 0 12px 35px rgba(16, 37, 29, .05);
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .journal-entry:hover {
        border-color: rgba(39, 122, 87, .25);
        box-shadow: var(--journal-shadow);
        transform: translateY(-3px);
    }

    .journal-entry-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--journal-border);
    }

    .journal-entry-type {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .journal-entry-mark {
        display: grid;
        place-items: center;
        width: 42px;
        height: 42px;
        flex: 0 0 auto;
        background: var(--journal-mint);
        border-radius: 13px;
        font-size: 1.12rem;
    }

    .journal-entry h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 820;
        letter-spacing: -.025em;
    }

    .journal-entry-date {
        margin: 4px 0 0;
        color: var(--journal-muted);
        font-size: .83rem;
    }

    .journal-intensity {
        flex: 0 0 auto;
        padding: 9px 12px;
        color: #9b6510;
        background: #fff6df;
        border: 1px solid rgba(183, 130, 31, .12);
        border-radius: 11px;
        font-size: .78rem;
        font-weight: 800;
    }

    .journal-entry-body {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 26px;
        padding: 22px 0;
    }

    .journal-entry-section-label {
        margin: 0 0 8px;
        color: var(--journal-muted);
        font-size: .69rem;
        font-weight: 820;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .journal-entry-body p:last-child {
        margin: 0;
        color: #40564b;
        font-size: .91rem;
        line-height: 1.7;
    }

    .journal-entry-actions {
        display: flex;
        align-items: center;
        gap: 9px;
        padding-top: 2px;
    }

    .journal-action {
        min-height: 37px;
        padding: 8px 12px;
        border: 1px solid var(--journal-border);
        font-size: .78rem;
    }

    .journal-view {
        color: #fff;
        background: var(--journal-forest);
        border-color: var(--journal-forest);
    }

    .journal-view:hover {
        color: #fff;
        background: #0f3929;
    }

    .journal-edit {
        color: var(--journal-forest);
        background: #fff;
    }

    .journal-edit:hover {
        color: var(--journal-forest);
        background: #f2faf4;
    }

    .journal-delete-form {
        display: inline;
        margin: 0;
    }

    .journal-delete {
        color: #a03c3c;
        background: #fffafa;
        border-color: rgba(160, 60, 60, .18);
        cursor: pointer;
    }

    .journal-delete:hover {
        color: #8a2929;
        background: #fff0f0;
    }

    .journal-empty {
        padding: clamp(45px, 8vw, 86px) 28px;
        text-align: center;
        background: rgba(255, 255, 255, .85);
        border: 1px solid var(--journal-border);
        border-radius: 24px;
        box-shadow: var(--journal-shadow);
    }

    .journal-empty-icon {
        display: grid;
        place-items: center;
        width: 70px;
        height: 70px;
        margin: 0 auto 21px;
        font-size: 2rem;
        background: var(--journal-mint);
        border-radius: 23px;
        box-shadow: 0 12px 27px rgba(39, 122, 87, .12);
    }

    .journal-empty h2 {
        margin: 0 0 10px;
        font-size: 1.55rem;
        font-weight: 830;
        letter-spacing: -.04em;
    }

    .journal-empty p {
        max-width: 550px;
        margin: 0 auto 25px;
        color: var(--journal-muted);
        line-height: 1.7;
    }

    @media (max-width: 800px) {
        .journal-page {
            padding-right: 26px;
            padding-left: 26px;
        }

        .journal-hero {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .journal-private-note {
            width: fit-content;
        }

        .journal-summary-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .journal-page {
            padding: 18px 16px 48px;
        }

        .journal-topbar {
            margin-bottom: 31px;
        }

        .journal-back,
        .journal-new-entry {
            min-height: 40px;
            padding: 9px 11px;
            font-size: .8rem;
        }

        .journal-hero h1 {
            font-size: 2.55rem;
        }

        .journal-hero p {
            font-size: .93rem;
        }

        .journal-stat,
        .journal-entry {
            padding: 21px;
            border-radius: 18px;
        }

        .journal-entry-head {
            align-items: flex-start;
            flex-direction: column;
            gap: 14px;
        }

        .journal-entry-body {
            grid-template-columns: 1fr;
            gap: 20px;
            padding: 19px 0;
        }

        .journal-entry-actions {
            flex-wrap: wrap;
        }

        .journal-private-note {
            white-space: normal;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .journal-page *,
        .journal-page *::before,
        .journal-page *::after {
            transition-duration: .01ms !important;
        }
    }
</style>

<main class="journal-page">
    <div class="journal-wrap">

        <div class="journal-topbar">
            <?= Html::a('← Back to Home', ['site/index'], [
                'class' => 'journal-back',
            ]) ?>

            <?= Html::a('+ New Journal Entry', ['create'], [
                'class' => 'journal-new-entry',
            ]) ?>
        </div>

        <header class="journal-hero">
            <div>
                <div class="journal-eyebrow"><span></span> Your private reflection space</div>
                <h1>Notice the pattern.<br><em>Choose your response.</em></h1>
                <p>
                    Your journal is a calm place to reflect on triggers, understand your responses,
                    and recognise the progress you are making—one honest entry at a time.
                </p>
            </div>

            <div class="journal-private-note">
                <span aria-hidden="true">🔒</span>
                Your reflections stay private
            </div>
        </header>

        <section class="journal-summary-grid" aria-label="Journal summary">
            <article class="journal-stat">
                <div class="journal-stat-label">
                    <span class="journal-stat-icon">📝</span>
                    Total entries
                </div>
                <div class="journal-stat-value"><?= $totalEntries ?></div>
            </article>

            <article class="journal-stat">
                <div class="journal-stat-label">
                    <span class="journal-stat-icon">〰️</span>
                    Average intensity
                </div>
                <div class="journal-stat-value">
                    <?= number_format($averageIntensity, 1) ?> <small>/ 10</small>
                </div>
            </article>

            <article class="journal-stat">
                <div class="journal-stat-label">
                    <span class="journal-stat-icon">📅</span>
                    Latest entry
                </div>
                <div class="journal-stat-value journal-stat-date">
                    <?= $latestEntryDate ? Html::encode(date('M j, Y', strtotime($latestEntryDate))) : '—' ?>
                </div>
            </article>
        </section>

        <?php if (!empty($journals)): ?>
            <section aria-labelledby="journal-entries-title">
                <div class="journal-list-heading">
                    <h2 id="journal-entries-title">Your reflections</h2>
                    <span class="journal-entry-count"><?= $totalEntries ?> entr<?= $totalEntries === 1 ? 'y' : 'ies' ?></span>
                </div>

                <div class="journal-entries">
                    <?php foreach ($journals as $journal): ?>
                        <article class="journal-entry">
                            <div class="journal-entry-head">
                                <div class="journal-entry-type">
                                    <div class="journal-entry-mark" aria-hidden="true">✦</div>
                                    <div>
                                        <h3><?= Html::encode($journal->temptation_type) ?></h3>
                                        <p class="journal-entry-date">
                                            <?= Html::encode(date('l, F j, Y', strtotime($journal->entry_date))) ?>
                                        </p>
                                    </div>
                                </div>

                                <span class="journal-intensity">
                                    Intensity <?= (int) $journal->intensity ?>/10
                                </span>
                            </div>

                            <div class="journal-entry-body">
                                <div>
                                    <p class="journal-entry-section-label">What happened</p>
                                    <p><?= Html::encode(StringHelper::truncateWords($journal->what_happened, 28)) ?></p>
                                </div>

                                <div>
                                    <p class="journal-entry-section-label">How I responded</p>
                                    <p><?= Html::encode(StringHelper::truncateWords($journal->how_responded, 24)) ?></p>
                                </div>
                            </div>

                            <div class="journal-entry-actions">
                                <?= Html::a('View entry →', ['view', 'id' => $journal->id], [
                                    'class' => 'journal-action journal-view',
                                ]) ?>

                                <?= Html::a('Edit', ['update', 'id' => $journal->id], [
                                    'class' => 'journal-action journal-edit',
                                ]) ?>

                                <?= Html::beginForm(['delete', 'id' => $journal->id], 'post', [
                                    'class' => 'journal-delete-form',
                                ]) ?>

                                <?= Html::submitButton('Delete', [
                                    'class' => 'journal-action journal-delete',
                                    'data-confirm' => 'Are you sure you want to delete this journal entry?',
                                ]) ?>

                                <?= Html::endForm() ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>

        <?php else: ?>
            <section class="journal-empty">
                <div class="journal-empty-icon" aria-hidden="true">📝</div>
                <h2>Your journal is ready when you are.</h2>
                <p>
                    Start with a simple reflection. Recording triggers, thoughts, and responses
                    helps you see your growth clearly and respond with more intention.
                </p>

                <?= Html::a('+ Create your first entry', ['create'], [
                    'class' => 'journal-new-entry',
                ]) ?>
            </section>
        <?php endif; ?>

    </div>
</main>