<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\MotivationQuote|null $quote */

$this->title = 'Motivation Center';
?>

<style>
    :root {
        --mc-ink: #10251d;
        --mc-muted: #617167;
        --mc-forest: #174c38;
        --mc-green: #277a57;
        --mc-mint: #dff8e9;
        --mc-cream: #f7fbf8;
        --mc-border: rgba(23, 76, 56, .13);
    }

    .motivation-page,
    .motivation-page * {
        box-sizing: border-box;
    }

    .motivation-page {
        width: 100vw;
        min-height: 100vh;
        margin-left: calc(50% - 50vw);
        padding: 30px clamp(18px, 6vw, 110px) 75px;
        color: var(--mc-ink);
        background:
            radial-gradient(circle at 4% 3%, rgba(155, 225, 93, .20), transparent 24rem),
            radial-gradient(circle at 96% 17%, rgba(48, 172, 111, .13), transparent 26rem),
            var(--mc-cream);
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .motivation-wrap {
        width: 100%;
        max-width: 1180px;
        margin: 0 auto;
    }

    .motivation-page a {
        text-decoration: none;
    }

    .motivation-back,
    .motivation-emergency-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 43px;
        padding: 10px 15px;
        border-radius: 12px;
        font-size: .88rem;
        font-weight: 750;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .motivation-back {
        color: var(--mc-forest);
        background: rgba(255, 255, 255, .75);
        border: 1px solid var(--mc-border);
    }

    .motivation-back:hover {
        color: var(--mc-forest);
        background: #fff;
        box-shadow: 0 10px 24px rgba(16, 37, 29, .08);
        transform: translateY(-2px);
    }

    .motivation-back:focus-visible,
    .motivation-emergency-button:focus-visible {
        outline: 3px solid rgba(56, 150, 98, .32);
        outline-offset: 3px;
    }

    .motivation-hero {
        margin: 47px 0 30px;
        text-align: center;
    }

    .motivation-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
        color: var(--mc-forest);
        font-size: .74rem;
        font-weight: 820;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .motivation-eyebrow span {
        width: 8px;
        height: 8px;
        background: #4aab73;
        border-radius: 50%;
        box-shadow: 0 0 0 5px rgba(74, 171, 115, .14);
    }

    .motivation-hero h1 {
        margin: 0;
        font-size: clamp(2.5rem, 5vw, 4.3rem);
        font-weight: 850;
        letter-spacing: -.07em;
        line-height: .98;
    }

    .motivation-hero h1 span {
        color: var(--mc-green);
    }

    .motivation-hero p {
        max-width: 610px;
        margin: 17px auto 0;
        color: var(--mc-muted);
        font-size: 1rem;
        line-height: 1.75;
    }

    .motivation-quote-card {
        position: relative;
        overflow: hidden;
        margin-bottom: 21px;
        padding: clamp(30px, 6vw, 62px);
        color: #fff;
        text-align: center;
        background: linear-gradient(135deg, #123d2d 0%, #1f7652 60%, #329564 100%);
        border-radius: 27px;
        box-shadow: 0 22px 52px rgba(19, 76, 54, .24);
    }

    .motivation-quote-card::before,
    .motivation-quote-card::after {
        position: absolute;
        border: 1px solid rgba(255, 255, 255, .13);
        border-radius: 50%;
        content: "";
    }

    .motivation-quote-card::before {
        top: -180px;
        right: -95px;
        width: 355px;
        height: 355px;
    }

    .motivation-quote-card::after {
        bottom: -165px;
        left: -60px;
        width: 250px;
        height: 250px;
    }

    .motivation-quote-content {
        position: relative;
        z-index: 1;
        max-width: 780px;
        margin: 0 auto;
    }

    .motivation-star {
        display: grid;
        place-items: center;
        width: 55px;
        height: 55px;
        margin: 0 auto 19px;
        background: rgba(255, 255, 255, .14);
        border: 1px solid rgba(255, 255, 255, .14);
        border-radius: 17px;
        font-size: 1.65rem;
    }

    .motivation-quote-label {
        margin: 0;
        color: rgba(255, 255, 255, .72);
        font-size: .73rem;
        font-weight: 800;
        letter-spacing: .11em;
        text-transform: uppercase;
    }

    .motivation-quote-card h2 {
        margin: 9px 0 20px;
        font-size: 1.45rem;
        font-weight: 820;
        letter-spacing: -.04em;
    }

    .motivation-quote-card blockquote {
        margin: 0;
        font-size: clamp(1.28rem, 3vw, 2rem);
        font-style: italic;
        font-weight: 650;
        letter-spacing: -.025em;
        line-height: 1.48;
    }

    .motivation-quote-author {
        margin: 22px 0 0;
        color: rgba(255, 255, 255, .74);
        font-size: .9rem;
        font-weight: 700;
    }

    .motivation-support-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .motivation-support-card,
    .motivation-reflection {
        background: rgba(255, 255, 255, .88);
        border: 1px solid var(--mc-border);
        border-radius: 22px;
        box-shadow: 0 14px 40px rgba(16, 37, 29, .06);
    }

    .motivation-support-card {
        min-height: 255px;
        padding: 28px;
    }

    .motivation-support-icon {
        display: grid;
        place-items: center;
        width: 48px;
        height: 48px;
        margin-bottom: 19px;
        background: var(--mc-mint);
        border-radius: 15px;
        font-size: 1.3rem;
    }

    .motivation-emergency .motivation-support-icon {
        background: #fff0ed;
    }

    .motivation-support-card h2 {
        margin: 0 0 13px;
        font-size: 1.12rem;
        font-weight: 830;
        letter-spacing: -.025em;
    }

    .motivation-support-card p {
        margin: 0;
        color: var(--mc-muted);
        font-size: .93rem;
        line-height: 1.7;
    }

    .motivation-scripture-reference {
        display: inline-block;
        margin-bottom: 11px !important;
        color: var(--mc-forest) !important;
        font-size: .84rem !important;
        font-weight: 820;
    }

    .motivation-scripture-text {
        color: #40564b !important;
        font-size: 1rem !important;
        font-style: italic;
    }

    .motivation-emergency {
        background: linear-gradient(145deg, #fffafa, #fff4f1);
        border-color: rgba(184, 72, 61, .16);
    }

    .motivation-emergency-button {
        margin-top: 22px;
        color: #fff;
        background: linear-gradient(135deg, #c94d42, #a83535);
        box-shadow: 0 10px 22px rgba(169, 53, 53, .20);
    }

    .motivation-emergency-button:hover {
        color: #fff;
        box-shadow: 0 14px 27px rgba(169, 53, 53, .29);
        transform: translateY(-2px);
    }

    .motivation-reflection {
        padding: 30px;
    }

    .motivation-reflection-head {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
    }

    .motivation-reflection-icon {
        display: grid;
        place-items: center;
        width: 43px;
        height: 43px;
        background: #f0edff;
        border-radius: 13px;
        font-size: 1.1rem;
    }

    .motivation-reflection h2 {
        margin: 0;
        font-size: 1.12rem;
        font-weight: 830;
        letter-spacing: -.025em;
    }

    .motivation-reflection p {
        max-width: 810px;
        margin: 0;
        color: #40564b;
        font-size: .97rem;
        line-height: 1.85;
    }

    @media (max-width: 700px) {
        .motivation-page {
            padding: 18px 16px 48px;
        }

        .motivation-hero {
            margin-top: 36px;
        }

        .motivation-support-grid {
            grid-template-columns: 1fr;
        }

        .motivation-support-card,
        .motivation-reflection {
            padding: 23px;
            border-radius: 19px;
        }

        .motivation-quote-card {
            border-radius: 21px;
        }
    }
</style>

<main class="motivation-page">
    <div class="motivation-wrap">

        <?= Html::a('← Back to Dashboard', ['/site/index'], [
            'class' => 'motivation-back',
        ]) ?>

        <header class="motivation-hero">
            <div class="motivation-eyebrow">
                <span></span>
                Encouragement for this moment
            </div>

            <h1>Strength for today.<br><span>Hope for the next step.</span></h1>

            <p>
                Take a breath, refocus your mind, and remember that every good choice
                is helping you become stronger.
            </p>
        </header>

        <section class="motivation-quote-card" aria-labelledby="today-motivation-title">
            <div class="motivation-quote-content">
                <div class="motivation-star" aria-hidden="true">✦</div>
                <p class="motivation-quote-label">A word for today</p>
                <h2 id="today-motivation-title">Today’s Motivation</h2>

                <?php if ($quote): ?>
                    <blockquote>“<?= Html::encode($quote->quote) ?>”</blockquote>

                    <?php if (!empty($quote->author)): ?>
                        <p class="motivation-quote-author">— <?= Html::encode($quote->author) ?></p>
                    <?php endif; ?>
                <?php else: ?>
                    <blockquote>“Take today one choice at a time. Your progress still matters.”</blockquote>
                    <p class="motivation-quote-author">Return tomorrow for a new encouragement.</p>
                <?php endif; ?>
            </div>
        </section>

        <section class="motivation-support-grid">
            <article class="motivation-support-card">
                <div class="motivation-support-icon" aria-hidden="true">📖</div>
                <h2>Scripture</h2>
                <p class="motivation-scripture-reference">1 Corinthians 10:13</p>
                <p class="motivation-scripture-text">
                    God is faithful. He will not let you be tempted beyond what you can bear.
                </p>
            </article>

            <article class="motivation-support-card motivation-emergency">
                <div class="motivation-support-icon" aria-hidden="true">🚨</div>
                <h2>Need help right now?</h2>
                <p>
                    If this moment feels difficult, do not fight it alone.
                    Open emergency support for immediate encouragement and a clear next step.
                </p>

                <?= Html::a('Open Emergency Help →', ['motivation/emergency'], [
                    'class' => 'motivation-emergency-button',
                ]) ?>
            </article>
        </section>

        <section class="motivation-reflection" aria-labelledby="reflection-title">
            <div class="motivation-reflection-head">
                <div class="motivation-reflection-icon" aria-hidden="true">💭</div>
                <h2 id="reflection-title">A reflection for your journey</h2>
            </div>

            <p>
                Progress is not about being perfect. It is about making one good decision after another.
                Every day you choose consistency, you are becoming stronger than you were yesterday.
            </p>
        </section>

    </div>
</main>