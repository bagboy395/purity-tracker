<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'About Purity Tracker';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    :root {
        --about-ink: #10251d;
        --about-muted: #617167;
        --about-forest: #174c38;
        --about-green: #277a57;
        --about-mint: #dff8e9;
        --about-cream: #f7fbf8;
        --about-border: rgba(23, 76, 56, .13);
    }

    .about-page,
    .about-page * {
        box-sizing: border-box;
    }

    .about-page {
        width: 100vw;
        min-height: 100vh;
        margin-left: calc(50% - 50vw);
        padding: 30px clamp(18px, 6vw, 110px) 75px;
        color: var(--about-ink);
        background:
            radial-gradient(circle at 5% 4%, rgba(155, 225, 93, .20), transparent 23rem),
            radial-gradient(circle at 96% 18%, rgba(48, 172, 111, .13), transparent 26rem),
            var(--about-cream);
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .about-wrap {
        width: 100%;
        max-width: 1180px;
        margin: 0 auto;
    }

    .about-page a {
        text-decoration: none;
    }

    .about-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .about-brand {
        display: inline-flex;
        align-items: center;
        gap: 11px;
        color: var(--about-ink);
        font-size: 1.05rem;
        font-weight: 830;
        letter-spacing: -.03em;
    }

    .about-brand:hover {
        color: var(--about-ink);
    }

    .about-logo {
        display: grid;
        place-items: center;
        width: 42px;
        height: 42px;
        color: #fff;
        background: linear-gradient(135deg, #2b825b, #174c38);
        border-radius: 14px 14px 14px 4px;
        box-shadow: 0 10px 22px rgba(23, 76, 56, .20);
        transform: rotate(-7deg);
    }

    .about-logo svg {
        width: 25px;
        height: 25px;
        transform: rotate(7deg);
    }

    .about-brand small {
        display: block;
        margin-top: 1px;
        color: var(--about-muted);
        font-size: .62rem;
        font-weight: 700;
        letter-spacing: .11em;
        text-transform: uppercase;
    }

    .about-home {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 43px;
        padding: 10px 15px;
        color: var(--about-forest);
        background: rgba(255, 255, 255, .75);
        border: 1px solid var(--about-border);
        border-radius: 12px;
        font-size: .87rem;
        font-weight: 750;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .about-home:hover {
        color: var(--about-forest);
        background: #fff;
        box-shadow: 0 10px 24px rgba(16, 37, 29, .08);
        transform: translateY(-2px);
    }

    .about-home:focus-visible,
    .about-cta:focus-visible {
        outline: 3px solid rgba(56, 150, 98, .32);
        outline-offset: 3px;
    }

    .about-hero {
        position: relative;
        max-width: 850px;
        margin: 90px auto 74px;
        text-align: center;
    }

    .about-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 18px;
        padding: 8px 13px;
        color: var(--about-forest);
        background: rgba(223, 248, 233, .80);
        border: 1px solid rgba(39, 122, 87, .12);
        border-radius: 999px;
        font-size: .75rem;
        font-weight: 820;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .about-eyebrow span {
        width: 8px;
        height: 8px;
        background: #4aab73;
        border-radius: 50%;
        box-shadow: 0 0 0 5px rgba(74, 171, 115, .14);
    }

    .about-hero h1 {
        margin: 0;
        font-size: clamp(2.8rem, 6vw, 5.2rem);
        font-weight: 850;
        letter-spacing: -.075em;
        line-height: .95;
    }

    .about-hero h1 span {
        color: var(--about-green);
    }

    .about-hero p {
        max-width: 670px;
        margin: 23px auto 0;
        color: var(--about-muted);
        font-size: clamp(1rem, 2vw, 1.15rem);
        line-height: 1.8;
    }

    .about-values {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 72px;
    }

    .about-value-card {
        padding: 28px;
        background: rgba(255, 255, 255, .88);
        border: 1px solid var(--about-border);
        border-radius: 22px;
        box-shadow: 0 13px 37px rgba(16, 37, 29, .06);
    }

    .about-value-icon {
        display: grid;
        place-items: center;
        width: 49px;
        height: 49px;
        margin-bottom: 19px;
        background: var(--about-mint);
        border-radius: 15px;
        font-size: 1.3rem;
    }

    .about-value-card:nth-child(2) .about-value-icon {
        background: #fff4dd;
    }

    .about-value-card:nth-child(3) .about-value-icon {
        background: #eef0ff;
    }

    .about-value-card h2 {
        margin: 0 0 9px;
        font-size: 1.08rem;
        font-weight: 830;
        letter-spacing: -.025em;
    }

    .about-value-card p {
        margin: 0;
        color: var(--about-muted);
        font-size: .92rem;
        line-height: 1.7;
    }

    .about-story {
        display: grid;
        grid-template-columns: .82fr 1.18fr;
        gap: 28px;
        align-items: center;
        padding: clamp(28px, 6vw, 60px);
        background: linear-gradient(135deg, #123d2d, #237752);
        border-radius: 28px;
        box-shadow: 0 22px 52px rgba(19, 76, 54, .22);
    }

    .about-story-mark {
        display: grid;
        place-items: center;
        width: min(190px, 100%);
        aspect-ratio: 1;
        margin: 0 auto;
        color: #fff;
        background: rgba(255, 255, 255, .10);
        border: 1px solid rgba(255, 255, 255, .13);
        border-radius: 50%;
    }

    .about-story-mark svg {
        width: 90px;
        height: 90px;
    }

    .about-story-label {
        margin: 0 0 9px;
        color: rgba(255, 255, 255, .66);
        font-size: .72rem;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .about-story h2 {
        margin: 0 0 15px;
        color: #fff;
        font-size: clamp(1.7rem, 3vw, 2.45rem);
        font-weight: 840;
        letter-spacing: -.05em;
        line-height: 1.1;
    }

    .about-story p {
        max-width: 570px;
        margin: 0;
        color: rgba(255, 255, 255, .78);
        line-height: 1.75;
    }

    .about-cta {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 49px;
        margin-top: 23px;
        padding: 12px 19px;
        color: var(--about-forest);
        background: #fff;
        border-radius: 13px;
        box-shadow: 0 10px 22px rgba(0, 0, 0, .13);
        font-size: .9rem;
        font-weight: 820;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .about-cta:hover {
        color: var(--about-forest);
        box-shadow: 0 14px 28px rgba(0, 0, 0, .19);
        transform: translateY(-2px);
    }

    @media (max-width: 760px) {
        .about-page {
            padding: 18px 16px 48px;
        }

        .about-hero {
            margin: 63px auto 52px;
        }

        .about-values,
        .about-story {
            grid-template-columns: 1fr;
        }

        .about-story {
            gap: 30px;
            border-radius: 22px;
        }

        .about-story-mark {
            width: 130px;
        }

        .about-story-mark svg {
            width: 62px;
            height: 62px;
        }
    }

    @media (max-width: 450px) {
        .about-brand small {
            display: none;
        }

        .about-home {
            min-height: 40px;
            padding: 9px 11px;
            font-size: .8rem;
        }
    }
</style>

<main class="about-page">
    <div class="about-wrap">

        <div class="about-topbar">
            <?= Html::a(
                '<span class="about-logo" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.5 3.5C13 3.4 6.7 6 5.3 12.5c-1 4.8 2.7 7.8 6.2 6.1 5-2.4 7.5-8.9 9-15.1Z"/>
                        <path d="M4 20c3.6-4.5 7.1-7.2 12.8-10.4"/>
                    </svg>
                </span>
                <span>Purity Tracker<small>One day at a time</small></span>',
                ['site/index'],
                ['class' => 'about-brand', 'encode' => false]
            ) ?>

            <?= Html::a('← Back to Home', ['site/index'], [
                'class' => 'about-home',
            ]) ?>
        </div>

        <header class="about-hero">
            <div class="about-eyebrow">
                <span></span>
                Built for intentional growth
            </div>

            <h1>Progress begins with<br><span>one honest choice.</span></h1>

            <p>
                Purity Tracker is a private, supportive space that helps you stay intentional,
                recognise your growth, and keep moving forward without shame or pressure.
            </p>
        </header>

        <section class="about-values" aria-label="What Purity Tracker offers">
            <article class="about-value-card">
                <div class="about-value-icon" aria-hidden="true">🌱</div>
                <h2>Progress, not perfection</h2>
                <p>
                    Your journey is built through small, meaningful choices—not through being perfect every day.
                </p>
            </article>

            <article class="about-value-card">
                <div class="about-value-icon" aria-hidden="true">🔒</div>
                <h2>A space for honesty</h2>
                <p>
                    Reflect on patterns, challenges, and wins in a personal space designed for your growth.
                </p>
            </article>

            <article class="about-value-card">
                <div class="about-value-icon" aria-hidden="true">✦</div>
                <h2>Strength for each day</h2>
                <p>
                    Use goals, encouragement, Scripture, and daily check-ins to stay connected to your purpose.
                </p>
            </article>
        </section>

        <section class="about-story">
            <div class="about-story-mark" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.55" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.5 3.5C13 3.4 6.7 6 5.3 12.5c-1 4.8 2.7 7.8 6.2 6.1 5-2.4 7.5-8.9 9-15.1Z"/>
                    <path d="M4 20c3.6-4.5 7.1-7.2 12.8-10.4"/>
                </svg>
            </div>

            <div>
                <p class="about-story-label">Our purpose</p>
                <h2>A gentle structure for the life you want to build.</h2>
                <p>
                    Purity Tracker helps turn intention into action. By checking in, reflecting,
                    setting goals, and returning to encouragement when things feel difficult,
                    you can make each day a meaningful part of your story.
                </p>

                <?= Html::a('Start your journey →', ['site/signup'], [
                    'class' => 'about-cta',
                ]) ?>
            </div>
        </section>

    </div>
</main>