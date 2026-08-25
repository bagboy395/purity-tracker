<?php

use yii\helpers\Html;

$this->title = 'Emergency Help';
?>

<style>
    :root {
        --eh-ink: #1e2625;
        --eh-muted: #68736f;
        --eh-forest: #174c38;
        --eh-green: #277a57;
        --eh-mint: #dff8e9;
        --eh-cream: #f8fbf8;
        --eh-red: #b5433e;
        --eh-border: rgba(23, 76, 56, .12);
    }

    .emergency-page,
    .emergency-page * {
        box-sizing: border-box;
    }

    .emergency-page {
        width: 100vw;
        min-height: 100vh;
        margin-left: calc(50% - 50vw);
        padding: 30px clamp(18px, 6vw, 110px) 75px;
        color: var(--eh-ink);
        background:
            radial-gradient(circle at 5% 4%, rgba(255, 184, 169, .20), transparent 23rem),
            radial-gradient(circle at 95% 18%, rgba(155, 225, 93, .16), transparent 25rem),
            var(--eh-cream);
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .emergency-wrap {
        width: 100%;
        max-width: 1050px;
        margin: 0 auto;
    }

    .emergency-page a {
        text-decoration: none;
    }

    .emergency-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 43px;
        padding: 10px 15px;
        color: var(--eh-forest);
        background: rgba(255, 255, 255, .75);
        border: 1px solid var(--eh-border);
        border-radius: 12px;
        font-size: .88rem;
        font-weight: 750;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .emergency-back:hover {
        color: var(--eh-forest);
        background: #fff;
        box-shadow: 0 10px 24px rgba(16, 37, 29, .08);
        transform: translateY(-2px);
    }

    .emergency-back:focus-visible,
    .emergency-page button:focus-visible {
        outline: 3px solid rgba(56, 150, 98, .32);
        outline-offset: 3px;
    }

    .emergency-hero {
        max-width: 700px;
        margin: 45px auto 31px;
        text-align: center;
    }

    .emergency-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 15px;
        padding: 8px 12px;
        color: #9b3935;
        background: #fff0ed;
        border: 1px solid rgba(181, 67, 62, .15);
        border-radius: 999px;
        font-size: .75rem;
        font-weight: 820;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .emergency-badge span {
        width: 8px;
        height: 8px;
        background: var(--eh-red);
        border-radius: 50%;
        box-shadow: 0 0 0 5px rgba(181, 67, 62, .12);
    }

    .emergency-hero h1 {
        margin: 0;
        font-size: clamp(2.55rem, 5vw, 4.35rem);
        font-weight: 850;
        letter-spacing: -.07em;
        line-height: .96;
    }

    .emergency-hero h1 span {
        color: var(--eh-green);
    }

    .emergency-hero p {
        margin: 18px auto 0;
        color: var(--eh-muted);
        font-size: 1.05rem;
        line-height: 1.7;
    }

    .emergency-card {
        background: rgba(255, 255, 255, .89);
        border: 1px solid var(--eh-border);
        border-radius: 22px;
        box-shadow: 0 14px 40px rgba(16, 37, 29, .06);
    }

    .emergency-reminder {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 20px;
        align-items: start;
        margin-bottom: 20px;
        padding: 28px;
    }

    .emergency-icon {
        display: grid;
        place-items: center;
        width: 49px;
        height: 49px;
        background: var(--eh-mint);
        border-radius: 15px;
        font-size: 1.3rem;
    }

    .emergency-reminder h2,
    .emergency-scripture h2,
    .emergency-prayer h2 {
        margin: 2px 0 10px;
        font-size: 1.15rem;
        font-weight: 830;
        letter-spacing: -.03em;
    }

    .emergency-reminder p,
    .emergency-prayer p {
        max-width: 800px;
        margin: 0;
        color: #40564b;
        line-height: 1.75;
    }

    .emergency-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .emergency-scripture,
    .emergency-prayer {
        padding: 28px;
    }

    .emergency-scripture .emergency-icon {
        background: #eef0ff;
    }

    .emergency-prayer .emergency-icon {
        background: #fff4de;
    }

    .emergency-scripture blockquote {
        margin: 17px 0 12px;
        color: #40564b;
        font-size: 1rem;
        font-style: italic;
        line-height: 1.75;
    }

    .emergency-scripture small {
        color: var(--eh-muted);
        font-size: .8rem;
        font-weight: 700;
    }

    .emergency-prayer p {
        white-space: pre-line;
    }

    .emergency-timer-card {
        position: relative;
        overflow: hidden;
        padding: clamp(30px, 6vw, 55px);
        color: #fff;
        text-align: center;
        background: linear-gradient(135deg, #123d2d 0%, #1f7652 60%, #329564 100%);
        border-radius: 26px;
        box-shadow: 0 22px 52px rgba(19, 76, 54, .24);
    }

    .emergency-timer-card::before,
    .emergency-timer-card::after {
        position: absolute;
        border: 1px solid rgba(255, 255, 255, .13);
        border-radius: 50%;
        content: "";
    }

    .emergency-timer-card::before {
        top: -170px;
        right: -100px;
        width: 340px;
        height: 340px;
    }

    .emergency-timer-card::after {
        bottom: -160px;
        left: -80px;
        width: 250px;
        height: 250px;
    }

    .emergency-timer-content {
        position: relative;
        z-index: 1;
    }

    .emergency-timer-icon {
        display: grid;
        place-items: center;
        width: 52px;
        height: 52px;
        margin: 0 auto 17px;
        background: rgba(255, 255, 255, .14);
        border-radius: 16px;
        font-size: 1.45rem;
    }

    .emergency-timer-card h2 {
        margin: 0 0 10px;
        font-size: 1.5rem;
        font-weight: 830;
        letter-spacing: -.04em;
    }

    .emergency-timer-card p {
        margin: 0;
        color: rgba(255, 255, 255, .77);
        line-height: 1.65;
    }

    #countdown {
        margin: 27px 0;
        font-size: clamp(4.1rem, 10vw, 6.2rem);
        font-weight: 850;
        letter-spacing: -.09em;
        line-height: .85;
        font-variant-numeric: tabular-nums;
    }

    #startTimer {
        min-width: 185px;
        min-height: 51px;
        padding: 12px 21px;
        color: var(--eh-forest);
        background: #fff;
        border: 0;
        border-radius: 13px;
        box-shadow: 0 11px 23px rgba(0, 0, 0, .14);
        cursor: pointer;
        font-size: .92rem;
        font-weight: 820;
        transition: transform .2s ease, box-shadow .2s ease, opacity .2s ease;
    }

    #startTimer:hover:not(:disabled) {
        box-shadow: 0 15px 28px rgba(0, 0, 0, .2);
        transform: translateY(-2px);
    }

    #startTimer:disabled {
        color: rgba(255, 255, 255, .8);
        background: rgba(255, 255, 255, .15);
        border: 1px solid rgba(255, 255, 255, .18);
        box-shadow: none;
        cursor: default;
    }

    #finishedMessage {
        max-width: 610px;
        margin: 26px auto 0;
        padding: 15px 18px;
        color: #154d30;
        background: #e0f8e9;
        border: 1px solid rgba(39, 122, 87, .18);
        border-radius: 13px;
        font-size: .9rem;
        font-weight: 700;
        line-height: 1.55;
    }

    @media (max-width: 700px) {
        .emergency-page {
            padding: 18px 16px 48px;
        }

        .emergency-hero {
            margin-top: 36px;
        }

        .emergency-grid {
            grid-template-columns: 1fr;
        }

        .emergency-reminder,
        .emergency-scripture,
        .emergency-prayer {
            padding: 23px;
            border-radius: 19px;
        }

        .emergency-timer-card {
            border-radius: 21px;
        }

        .emergency-reminder {
            grid-template-columns: 1fr;
            gap: 13px;
        }
    }
</style>

<main class="emergency-page">
    <div class="emergency-wrap">

        <?= Html::a('← Back to Motivation Center', ['motivation/index'], [
            'class' => 'emergency-back',
        ]) ?>

        <header class="emergency-hero">
            <div class="emergency-badge">
                <span></span>
                Pause with purpose
            </div>

            <h1>This moment<br><span>will pass.</span></h1>

            <p>
                Take a breath. You do not have to act on every thought or feeling.
                Stay here, slow down, and choose your next ten minutes.
            </p>
        </header>

        <section class="emergency-card emergency-reminder" aria-labelledby="remember-title">
            <div class="emergency-icon" aria-hidden="true">💬</div>
            <div>
                <h2 id="remember-title">Remember</h2>
                <p>
                    Urges come and go. They are temporary. You do not have to act on every thought.
                    Give yourself time, breathe, and let this moment pass.
                </p>
            </div>
        </section>

        <section class="emergency-timer-card" aria-labelledby="reset-title">
            <div class="emergency-timer-content">
                <div class="emergency-timer-icon" aria-hidden="true">⏱</div>
                <h2 id="reset-title">10-minute reset</h2>
                <p>Before making any decision, give yourself ten quiet minutes.</p>

                <div id="countdown" aria-live="polite">10:00</div>

                <button id="startTimer" type="button">Start Timer</button>

                <div id="finishedMessage" style="display:none;" role="status">
                    🎉 Great job! You stayed present for ten minutes. Every minute you choose
                    self-control makes you stronger.
                </div>
            </div>
        </section>

        <section class="emergency-grid" style="margin-top:20px;">
            <article class="emergency-card emergency-scripture">
                <div class="emergency-icon" aria-hidden="true">📖</div>
                <h2>Scripture</h2>

                <blockquote>
                    “No temptation has overtaken you except what is common to mankind.
                    And God is faithful; He will not let you be tempted beyond what you can bear.”
                </blockquote>

                <small>— 1 Corinthians 10:13</small>
            </article>

            <article class="emergency-card emergency-prayer">
                <div class="emergency-icon" aria-hidden="true">🙏</div>
                <h2>Prayer</h2>

                <p>Father,

Give me strength for this moment.

Help me make one good decision at a time.

Remind me that this feeling will pass.

Amen.</p>
            </article>
        </section>

    </div>
</main>

<script>
    const countdown = document.getElementById('countdown');
    const startButton = document.getElementById('startTimer');
    const finishedMessage = document.getElementById('finishedMessage');

    startButton.addEventListener('click', function () {
        let timeLeft = 600;

        startButton.disabled = true;
        startButton.textContent = 'Timer Running...';

        const timer = setInterval(function () {
            timeLeft--;

            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;

            countdown.textContent =
                `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            if (timeLeft <= 0) {
                clearInterval(timer);
                countdown.textContent = '00:00';
                finishedMessage.style.display = 'block';
                startButton.textContent = 'Completed';
            }
        }, 1000);
    });
</script>