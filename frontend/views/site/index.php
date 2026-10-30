<?php

use yii\helpers\Html;

/** @var bool $hasCheckedInToday */
/** @var int $currentStreak */
/** @var int $streak */
/** @var int $totalCheckins */
/** @var int $longestStreak */
/** @var string $dailyQuote */

$currentStreak = isset($currentStreak) ? (int) $currentStreak : (isset($streak) ? (int) $streak : 0);
$totalCheckins = isset($totalCheckins) ? (int) $totalCheckins : 0;
$longestStreak = isset($longestStreak) ? (int) $longestStreak : 0;
$dailyQuote = isset($dailyQuote) && $dailyQuote !== ''
    ? $dailyQuote
    : 'Small, faithful choices today create a stronger tomorrow.';

$userName = Yii::$app->user->isGuest
    ? ''
    : (Yii::$app->user->identity->username ?? 'Friend');

$firstName = trim(explode(' ', $userName)[0]);
$hour = (int) date('G');
$greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');
?>

<style>
    :root {
        --pt-ink: #10251d;
        --pt-ink-soft: #50645a;
        --pt-forest: #174c38;
        --pt-green: #237453;
        --pt-mint: #dff8e9;
        --pt-lime: #9be15d;
        --pt-gold: #f8c65a;
        --pt-cream: #f7fbf8;
        --pt-white: #ffffff;
        --pt-border: rgba(23, 76, 56, .11);
        --pt-shadow: 0 20px 55px rgba(19, 66, 46, .11);
    }

    .purity-page,
    .purity-page * {
        box-sizing: border-box;
    }

   .purity-page {
    width: 100vw;
    min-height: 100vh;
    margin-left: calc(50% - 50vw);
    color: var(--pt-ink);
    background:
        radial-gradient(circle at 8% 5%, rgba(155, 225, 93, .20), transparent 23rem),
        radial-gradient(circle at 96% 18%, rgba(52, 180, 122, .14), transparent 26rem),
        var(--pt-cream);
    font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    overflow: hidden;
}

    .purity-page a {
        text-decoration: none;
    }

    .pt-shell {
    width: 100%;
    max-width: none;
    margin: 0 auto;
    padding: 0 clamp(20px, 6vw, 110px);
}

    .pt-navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 24px 0;
    }

    .pt-brand {
        display: inline-flex;
        align-items: center;
        gap: 11px;
        color: var(--pt-ink);
        font-size: 1.08rem;
        font-weight: 800;
        letter-spacing: -.03em;
    }

    .pt-logo {
        position: relative;
        display: grid;
        place-items: center;
        width: 42px;
        height: 42px;
        color: #fff;
        background: linear-gradient(140deg, #2e925f, #174c38);
        border-radius: 14px 14px 14px 4px;
        box-shadow: 0 10px 24px rgba(26, 111, 72, .27);
        transform: rotate(-7deg);
    }

    .pt-logo svg {
        width: 25px;
        height: 25px;
        transform: rotate(7deg);
    }

    .pt-brand-copy small {
        display: block;
        margin-top: 1px;
        color: var(--pt-ink-soft);
        font-size: .64rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .pt-nav-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .pt-button,
    .pt-nav-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 44px;
        padding: 10px 17px;
        border: 1px solid transparent;
        border-radius: 12px;
        font-size: .92rem;
        font-weight: 750;
        line-height: 1;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease, border-color .2s ease;
    }

    .pt-button:hover,
    .pt-nav-button:hover {
        transform: translateY(-2px);
    }

    .pt-button:focus-visible,
    .pt-nav-button:focus-visible,
    .pt-action-card:focus-visible,
    .pt-achievement-card:focus-visible {
        outline: 3px solid rgba(64, 164, 104, .35);
        outline-offset: 3px;
    }

    .pt-button-primary {
        color: #fff;
        background: linear-gradient(135deg, #287e59, #174c38);
        box-shadow: 0 10px 22px rgba(23, 76, 56, .22);
    }

    .pt-button-primary:hover {
        color: #fff;
        box-shadow: 0 15px 30px rgba(23, 76, 56, .30);
    }

    .pt-button-light {
        color: var(--pt-forest);
        background: rgba(255, 255, 255, .7);
        border-color: var(--pt-border);
    }

    .pt-button-light:hover {
        color: var(--pt-forest);
        background: #fff;
        box-shadow: 0 10px 24px rgba(16, 37, 29, .08);
    }

    .pt-logout-form {
        margin: 0;
    }

    .pt-logout {
        color: #9d3434;
        background: transparent;
        border: 1px solid rgba(157, 52, 52, .18);
        cursor: pointer;
    }

    .pt-logout:hover {
        color: #842525;
        background: #fff5f5;
    }


    /* Premium profile control */
    .pt-profile-link {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        min-height: 48px;
        padding: 5px 12px 5px 6px;
        color: var(--pt-forest);
        background: rgba(255, 255, 255, .78);
        border: 1px solid var(--pt-border);
        border-radius: 999px;
        box-shadow: 0 8px 22px rgba(16, 37, 29, .055);
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease, background .2s ease;
    }

    .pt-profile-link:hover {
        color: var(--pt-forest);
        background: #fff;
        border-color: rgba(35, 116, 83, .24);
        box-shadow: 0 13px 30px rgba(16, 37, 29, .10);
        transform: translateY(-2px);
    }

    .pt-profile-link:focus-visible {
        outline: 3px solid rgba(64, 164, 104, .30);
        outline-offset: 3px;
    }

    .pt-profile-avatar {
        position: relative;
        display: grid;
        place-items: center;
        width: 38px;
        height: 38px;
        flex: 0 0 auto;
        color: #fff;
        background: linear-gradient(145deg, #3ba66f 0%, #174c38 100%);
        border: 2px solid rgba(255, 255, 255, .92);
        border-radius: 50%;
        box-shadow:
            0 7px 17px rgba(23, 76, 56, .24),
            inset 0 1px 1px rgba(255, 255, 255, .25);
    }

    .pt-profile-avatar svg {
        width: 21px;
        height: 21px;
        stroke: currentColor;
    }

    .pt-profile-online {
        position: absolute;
        right: -1px;
        bottom: 1px;
        width: 10px;
        height: 10px;
        background: var(--pt-lime);
        border: 2px solid #fff;
        border-radius: 50%;
        box-shadow: 0 2px 7px rgba(23, 76, 56, .20);
    }

    .pt-profile-copy {
        display: flex;
        flex-direction: column;
        min-width: 0;
        line-height: 1.05;
    }

    .pt-profile-copy strong {
        max-width: 120px;
        overflow: hidden;
        color: var(--pt-ink);
        font-size: .82rem;
        font-weight: 800;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .pt-profile-copy span {
        margin-top: 4px;
        color: var(--pt-ink-soft);
        font-size: .64rem;
        font-weight: 700;
        letter-spacing: .045em;
        text-transform: uppercase;
    }

    .pt-profile-chevron {
        width: 14px;
        height: 14px;
        margin-left: 1px;
        color: #789087;
        transition: transform .2s ease;
    }

    .pt-profile-link:hover .pt-profile-chevron {
        transform: translateY(2px);
    }

    /* Guest landing page */
    .pt-hero {
        position: relative;
        padding: 66px 0 82px;
        text-align: center;
    }

    .pt-orb {
        position: absolute;
        z-index: 0;
        border-radius: 50%;
        filter: blur(2px);
        pointer-events: none;
    }

    .pt-orb-one {
        width: 300px;
        height: 300px;
        top: 50px;
        left: -170px;
        background: rgba(155, 225, 93, .17);
    }

    .pt-orb-two {
        width: 270px;
        height: 270px;
        top: 150px;
        right: -150px;
        background: rgba(52, 180, 122, .12);
    }

    .pt-hero-content {
        position: relative;
        z-index: 1;
        max-width: 800px;
        margin: 0 auto;
    }

    .pt-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 13px;
        color: var(--pt-forest);
        background: rgba(223, 248, 233, .78);
        border: 1px solid rgba(35, 116, 83, .14);
        border-radius: 999px;
        font-size: .79rem;
        font-weight: 800;
        letter-spacing: .025em;
    }

    .pt-eyebrow-dot {
        width: 8px;
        height: 8px;
        background: var(--pt-green);
        border-radius: 50%;
        box-shadow: 0 0 0 5px rgba(35, 116, 83, .12);
    }

    .pt-hero h1 {
        max-width: 790px;
        margin: 24px auto 18px;
        font-size: clamp(2.8rem, 6.5vw, 5.25rem);
        font-weight: 850;
        letter-spacing: -.065em;
        line-height: .98;
    }

    .pt-hero h1 span {
        color: var(--pt-green);
    }

    .pt-hero p {
        max-width: 620px;
        margin: 0 auto;
        color: var(--pt-ink-soft);
        font-size: clamp(1rem, 2vw, 1.18rem);
        line-height: 1.75;
    }

    .pt-hero-actions {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 32px;
    }

    .pt-hero-actions .pt-button {
        min-height: 52px;
        padding: 14px 22px;
    }

    .pt-preview {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: 1.1fr .9fr;
        gap: 18px;
        max-width: 880px;
        margin: 64px auto 0;
        padding: 20px;
        text-align: left;
        background: rgba(255, 255, 255, .62);
        border: 1px solid rgba(255, 255, 255, .85);
        border-radius: 28px;
        box-shadow: var(--pt-shadow);
        backdrop-filter: blur(16px);
    }

    .pt-preview-main,
    .pt-preview-side {
        padding: 27px;
        background: #fff;
        border: 1px solid var(--pt-border);
        border-radius: 21px;
    }

    .pt-preview-label,
    .pt-card-label {
        margin: 0 0 5px;
        color: var(--pt-ink-soft);
        font-size: .73rem;
        font-weight: 800;
        letter-spacing: .09em;
        text-transform: uppercase;
    }

    .pt-preview-streak {
        display: flex;
        align-items: flex-end;
        gap: 8px;
        margin: 14px 0 20px;
    }

    .pt-preview-streak strong {
        font-size: 4rem;
        font-weight: 850;
        letter-spacing: -.07em;
        line-height: .8;
    }

    .pt-preview-streak span {
        padding-bottom: 6px;
        color: var(--pt-ink-soft);
        font-weight: 700;
    }

    .pt-mini-progress {
        height: 10px;
        overflow: hidden;
        background: #e9f2ec;
        border-radius: 99px;
    }

    .pt-mini-progress span {
        display: block;
        width: 67%;
        height: 100%;
        background: linear-gradient(90deg, var(--pt-lime), var(--pt-green));
        border-radius: inherit;
    }

    .pt-preview-note {
        margin: 13px 0 0;
        color: var(--pt-green);
        font-size: .88rem;
        font-weight: 750;
    }

    .pt-preview-side {
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: linear-gradient(145deg, #174c38, #287e59);
        color: #fff;
    }

    .pt-preview-side .pt-card-label {
        color: rgba(255, 255, 255, .68);
    }

    .pt-preview-side blockquote {
        margin: 12px 0 18px;
        font-size: 1.08rem;
        font-weight: 650;
        line-height: 1.55;
    }

    .pt-preview-side small {
        color: rgba(255, 255, 255, .73);
    }

    .pt-benefits {
        padding: 10px 0 78px;
    }

    .pt-section-heading {
        max-width: 570px;
        margin: 0 auto 32px;
        text-align: center;
    }

    .pt-section-heading h2 {
        margin: 0 0 10px;
        font-size: clamp(1.8rem, 3vw, 2.5rem);
        font-weight: 820;
        letter-spacing: -.045em;
    }

    .pt-section-heading p {
        margin: 0;
        color: var(--pt-ink-soft);
        line-height: 1.65;
    }

    .pt-benefit-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }

    .pt-benefit {
        padding: 26px;
        background: rgba(255, 255, 255, .76);
        border: 1px solid var(--pt-border);
        border-radius: 20px;
        box-shadow: 0 12px 35px rgba(16, 37, 29, .05);
    }

    .pt-benefit-icon {
        display: grid;
        place-items: center;
        width: 48px;
        height: 48px;
        margin-bottom: 18px;
        font-size: 1.4rem;
        background: var(--pt-mint);
        border-radius: 15px;
    }

    .pt-benefit h3 {
        margin: 0 0 8px;
        font-size: 1.05rem;
        font-weight: 800;
    }

    .pt-benefit p {
        margin: 0;
        color: var(--pt-ink-soft);
        font-size: .93rem;
        line-height: 1.65;
    }

    /* Signed-in dashboard */
    .pt-dashboard {
        padding: 22px 0 66px;
    }

    .pt-welcome {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 24px;
        margin: 30px 0 27px;
    }

    .pt-welcome h1 {
        margin: 5px 0 0;
        font-size: clamp(2rem, 4vw, 3.2rem);
        font-weight: 850;
        letter-spacing: -.06em;
    }

    .pt-welcome p {
        margin: 0;
        color: var(--pt-ink-soft);
        font-size: .93rem;
    }

    .pt-date-chip {
        padding: 10px 13px;
        color: var(--pt-forest);
        background: rgba(223, 248, 233, .82);
        border-radius: 10px;
        font-size: .82rem;
        font-weight: 750;
        white-space: nowrap;
    }

    .pt-dashboard-grid {
        display: grid;
        grid-template-columns: 1.26fr .74fr;
        gap: 20px;
    }

    .pt-card {
        background: rgba(255, 255, 255, .86);
        border: 1px solid var(--pt-border);
        border-radius: 24px;
        box-shadow: 0 14px 40px rgba(16, 37, 29, .06);
    }

    .pt-streak-card {
        position: relative;
        min-height: 355px;
        padding: 34px;
        overflow: hidden;
        color: #fff;
        background: linear-gradient(135deg, #123d2d 0%, #1f7652 62%, #2e965f 100%);
        border: none;
        box-shadow: 0 22px 50px rgba(19, 76, 54, .24);
    }

    .pt-streak-card::before,
    .pt-streak-card::after {
        position: absolute;
        content: "";
        border: 1px solid rgba(255, 255, 255, .13);
        border-radius: 50%;
    }

    .pt-streak-card::before {
        width: 350px;
        height: 350px;
        top: -180px;
        right: -105px;
    }

    .pt-streak-card::after {
        width: 220px;
        height: 220px;
        right: 90px;
        bottom: -155px;
    }

    .pt-streak-content {
        position: relative;
        z-index: 1;
    }

    .pt-streak-card .pt-card-label {
        color: rgba(255, 255, 255, .7);
    }

    .pt-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 13px;
        padding: 8px 11px;
        border: 1px solid rgba(255, 255, 255, .17);
        border-radius: 999px;
        background: rgba(255, 255, 255, .11);
        font-size: .81rem;
        font-weight: 700;
    }

    .pt-status-dot {
        width: 8px;
        height: 8px;
        background: var(--pt-lime);
        border-radius: 50%;
        box-shadow: 0 0 0 4px rgba(155, 225, 93, .14);
    }

    .pt-status-pending .pt-status-dot {
        background: var(--pt-gold);
        box-shadow: 0 0 0 4px rgba(248, 198, 90, .14);
    }

    .pt-streak-number {
        display: flex;
        align-items: flex-end;
        gap: 10px;
        margin: 25px 0 5px;
    }

    .pt-streak-number strong {
        font-size: clamp(4.8rem, 10vw, 6.7rem);
        font-weight: 850;
        letter-spacing: -.09em;
        line-height: .82;
    }

    .pt-streak-number span {
        padding-bottom: 9px;
        color: rgba(255, 255, 255, .82);
        font-size: 1rem;
        font-weight: 700;
    }

    .pt-streak-message {
        margin: 0 0 24px;
        color: rgba(255, 255, 255, .78);
    }

    .pt-checkin-button {
        width: 100%;
        min-height: 53px;
        color: var(--pt-forest);
        background: #fff;
        border: none;
        border-radius: 13px;
        cursor: pointer;
        font-size: .96rem;
        font-weight: 850;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .pt-checkin-button:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, .15);
    }

    .pt-checkin-button:focus-visible {
        outline: 3px solid rgba(255, 255, 255, .65);
        outline-offset: 3px;
    }

    .pt-checkin-button:disabled {
        color: rgba(255, 255, 255, .75);
        background: rgba(255, 255, 255, .16);
        border: 1px solid rgba(255, 255, 255, .2);
        cursor: default;
    }

    .pt-summary-card {
        padding: 25px;
    }

    .pt-summary-card h2 {
        margin: 4px 0 22px;
        font-size: 1.28rem;
        font-weight: 820;
        letter-spacing: -.03em;
    }

    .pt-stat-row {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 15px 0;
        border-top: 1px solid var(--pt-border);
    }

    .pt-stat-icon {
        display: grid;
        place-items: center;
        width: 41px;
        height: 41px;
        flex: 0 0 auto;
        background: #edf8f0;
        border-radius: 13px;
        font-size: 1.1rem;
    }

    .pt-stat-row:nth-of-type(3) .pt-stat-icon {
        background: #fff6df;
    }

    .pt-stat-copy {
        flex: 1;
    }

    .pt-stat-copy span {
        display: block;
        color: var(--pt-ink-soft);
        font-size: .78rem;
        font-weight: 700;
    }

    .pt-stat-copy strong {
        display: block;
        margin-top: 2px;
        font-size: 1rem;
        font-weight: 800;
    }

    .pt-stat-value {
        color: var(--pt-forest);
        font-size: 1.25rem;
        font-weight: 850;
        letter-spacing: -.04em;
    }

    .pt-motivation-card {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 18px;
        align-items: start;
        margin-top: 20px;
        padding: 26px 29px;
    }

    .pt-quote-icon {
        display: grid;
        place-items: center;
        width: 48px;
        height: 48px;
        color: var(--pt-green);
        background: var(--pt-mint);
        border-radius: 15px;
        font-size: 1.6rem;
    }

    .pt-motivation-card h2 {
        margin: 2px 0 9px;
        font-size: 1.05rem;
        font-weight: 820;
    }

    .pt-motivation-card blockquote {
        margin: 0;
        color: #355145;
        font-size: clamp(1rem, 2vw, 1.14rem);
        font-style: italic;
        line-height: 1.6;
    }

    .pt-achievement-card {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-top: 20px;
        padding: 26px 29px;
        color: #fff;
        background: linear-gradient(135deg, #60419d, #855bd0);
        border-radius: 23px;
        box-shadow: 0 18px 42px rgba(100, 64, 162, .19);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .pt-achievement-card:hover {
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 23px 46px rgba(100, 64, 162, .27);
    }

    .pt-achievement-icon {
        display: grid;
        place-items: center;
        width: 55px;
        height: 55px;
        flex: 0 0 auto;
        background: rgba(255, 255, 255, .16);
        border-radius: 17px;
        font-size: 1.65rem;
    }

    .pt-achievement-card h2 {
        margin: 0 0 4px;
        font-size: 1.15rem;
        font-weight: 820;
    }

    .pt-achievement-card p {
        margin: 0;
        color: rgba(255, 255, 255, .8);
        font-size: .9rem;
    }

    .pt-arrow {
        margin-left: auto;
        font-size: 1.7rem;
        transition: transform .2s ease;
    }

    .pt-achievement-card:hover .pt-arrow {
        transform: translateX(5px);
    }

    .pt-quick-heading {
        margin: 34px 0 15px;
        font-size: 1.2rem;
        font-weight: 820;
        letter-spacing: -.03em;
    }

    .pt-actions-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }

    .pt-action-card {
        min-height: 148px;
        padding: 22px;
        color: var(--pt-ink);
        background: rgba(255, 255, 255, .83);
        border: 1px solid var(--pt-border);
        border-radius: 19px;
        box-shadow: 0 10px 28px rgba(16, 37, 29, .04);
        transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease;
    }

    .pt-action-card:hover {
        color: var(--pt-ink);
        border-color: rgba(35, 116, 83, .27);
        box-shadow: 0 16px 34px rgba(16, 37, 29, .09);
        transform: translateY(-4px);
    }

    .pt-action-icon {
        display: grid;
        place-items: center;
        width: 41px;
        height: 41px;
        margin-bottom: 16px;
        background: #eef8f1;
        border-radius: 13px;
        font-size: 1.15rem;
    }

    .pt-action-card:nth-child(2) .pt-action-icon {
        background: #f0edff;
    }

    .pt-action-card:nth-child(3) .pt-action-icon {
        background: #fff5df;
    }

    .pt-action-card h3 {
        margin: 0 0 5px;
        font-size: .98rem;
        font-weight: 820;
    }

    .pt-action-card p {
        margin: 0;
        color: var(--pt-ink-soft);
        font-size: .82rem;
        line-height: 1.45;
    }

    @media (max-width: 800px) {
        .pt-preview,
        .pt-dashboard-grid {
            grid-template-columns: 1fr;
        }

        .pt-preview-side {
            min-height: 190px;
        }

        .pt-benefit-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
    .pt-shell {
        width: 100%;
        padding: 0 16px;
    }

        .pt-navbar {
            padding: 17px 0;
        }

        .pt-brand-copy small {
            display: none;
        }

        .pt-nav-actions {
            gap: 7px;
        }

        .pt-nav-button,
        .pt-logout {
            min-height: 40px;
            padding: 9px 11px;
            font-size: .82rem;
        }

        .pt-profile-link {
            min-height: 40px;
            padding: 4px 8px 4px 4px;
        }

        .pt-profile-avatar {
            width: 32px;
            height: 32px;
        }

        .pt-profile-avatar svg {
            width: 18px;
            height: 18px;
        }

        .pt-profile-copy {
            display: none;
        }

        .pt-profile-chevron {
            display: none;
        }

        .pt-hero {
            padding: 42px 0 58px;
        }

        .pt-preview {
            margin-top: 45px;
            padding: 11px;
            border-radius: 22px;
        }

        .pt-preview-main,
        .pt-preview-side {
            padding: 22px;
        }

        .pt-welcome {
            align-items: flex-start;
            flex-direction: column;
            gap: 12px;
            margin: 17px 0 21px;
        }

        .pt-streak-card {
            min-height: 330px;
            padding: 26px;
            border-radius: 21px;
        }

        .pt-summary-card,
        .pt-motivation-card,
        .pt-achievement-card {
            padding: 22px;
            border-radius: 20px;
        }

        .pt-actions-grid {
            grid-template-columns: 1fr;
        }

        .pt-action-card {
            min-height: 118px;
        }

        
    }

    @media (prefers-reduced-motion: reduce) {
        .purity-page *,
        .purity-page *::before,
        .purity-page *::after {
            scroll-behavior: auto !important;
            transition-duration: .01ms !important;
            animation-duration: .01ms !important;
        }
    }

    
/* Notification bell */
.pt-notification-link {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 46px;
    height: 46px;
    flex: 0 0 auto;
    color: var(--pt-forest);
    background: rgba(255, 255, 255, .78);
    border: 1px solid var(--pt-border);
    border-radius: 50%;
    box-shadow: 0 8px 22px rgba(16, 37, 29, .055);
    transition: transform .2s ease, background .2s ease;
}

.pt-notification-link:hover {
    color: var(--pt-forest);
    background: #fff;
    transform: translateY(-2px);
}

.pt-notification-link svg {
    width: 22px;
    height: 22px;
}

.pt-notification-count {
    position: absolute;
    top: -4px;
    right: -4px;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 19px;
    height: 19px;
    padding: 0 5px;
    color: #fff;
    background: #dc3545;
    border: 2px solid #fff;
    border-radius: 999px;
    font-size: 10px;
    font-weight: 800;
    line-height: 1;
}

</style>

<div class="purity-page">
    <div class="pt-shell">
        

        <?php if (Yii::$app->user->isGuest): ?>
            <main>
                <section class="pt-hero">
                    <div class="pt-orb pt-orb-one"></div>
                    <div class="pt-orb pt-orb-two"></div>

                    <div class="pt-hero-content">
                        <div class="pt-eyebrow">
                            <span class="pt-eyebrow-dot"></span>
                            A calmer way to stay accountable
                        </div>

                        <h1>Protect your peace.<br><span>Build a stronger life.</span></h1>

                        <p>
                            Purity Tracker gives you one clear place to stay intentional,
                            celebrate your growth, and keep moving forward—one meaningful day at a time.
                        </p>

                        <div class="pt-hero-actions">
                            <?= Html::a('Start your journey <span aria-hidden="true">→</span>', ['site/signup'], [
                                'class' => 'pt-button pt-button-primary',
                                'encode' => false,
                            ]) ?>

                            <?= Html::a('I already have an account', ['site/login'], [
                                'class' => 'pt-button pt-button-light',
                            ]) ?>
                        </div>
                    </div>

                    <div class="pt-preview" aria-label="Purity Tracker dashboard preview">
                        <div class="pt-preview-main">
                            <p class="pt-preview-label">Your progress</p>
                            <div class="pt-preview-streak">
                                <strong>12</strong>
                                <span>day streak 🔥</span>
                            </div>
                            <div class="pt-mini-progress" aria-hidden="true"><span></span></div>
                            <p class="pt-preview-note">You are building something lasting.</p>
                        </div>

                        <div class="pt-preview-side">
                            <p class="pt-card-label">Daily encouragement</p>
                            <blockquote>“Every day you choose progress, you become stronger.”</blockquote>
                            <small>Made for your quiet, consistent wins.</small>
                        </div>
                    </div>
                </section>

                <section class="pt-benefits">
                    <div class="pt-section-heading">
                        <h2>Support for the journey, not pressure.</h2>
                        <p>Simple tools that help you focus on what matters and return with confidence every day.</p>
                    </div>

                    <div class="pt-benefit-grid">
                        <article class="pt-benefit">
                            <div class="pt-benefit-icon">🔥</div>
                            <h3>Build your streak</h3>
                            <p>Make daily consistency visible and celebrate each step forward.</p>
                        </article>

                        <article class="pt-benefit">
                            <div class="pt-benefit-icon">✦</div>
                            <h3>Find encouragement</h3>
                            <p>Use thoughtful motivation and faith-based support when you need it most.</p>
                        </article>

                        <article class="pt-benefit">
                            <div class="pt-benefit-icon">🌱</div>
                            <h3>Grow with purpose</h3>
                            <p>Set meaningful goals, reflect in your journal, and honour your progress.</p>
                        </article>
                    </div>
                </section>
            </main>

        <?php else: ?>
            <main class="pt-dashboard">
                <header class="pt-welcome">
                    <div>
                        <p><?= Html::encode($greeting) ?>, <?= Html::encode($firstName) ?> 👋</p>
                        <h1>Your journey, today.</h1>
                    </div>
                    <div class="pt-date-chip"><?= date('l, F j') ?></div>
                </header>

                <section class="pt-dashboard-grid">
                    <article class="pt-card pt-streak-card">
                        <div class="pt-streak-content">
                            <p class="pt-card-label">Current streak</p>

                            <?php if ($hasCheckedInToday): ?>
                                <div class="pt-status">
                                    <span class="pt-status-dot"></span>
                                    Checked in for today
                                </div>
                            <?php else: ?>
                                <div class="pt-status pt-status-pending">
                                    <span class="pt-status-dot"></span>
                                    Your check-in is waiting
                                </div>
                            <?php endif; ?>

                            <div class="pt-streak-number">
                                <strong><?= $currentStreak ?></strong>
                                <span>day<?= $currentStreak === 1 ? '' : 's' ?> strong</span>
                            </div>

                            <p class="pt-streak-message">
                                <?= $hasCheckedInToday
                                    ? 'You showed up today. Keep protecting the momentum you have built.'
                                    : 'A small commitment today keeps your journey moving forward.' ?>
                            </p>

                            <?= Html::beginForm(['checkin/create'], 'post') ?>
                            <button
                                type="submit"
                                class="pt-checkin-button"
                                <?= $hasCheckedInToday ? 'disabled aria-disabled="true"' : '' ?>
                            >
                                <?= $hasCheckedInToday ? '✓ Checked in today' : '✓ Check in today' ?>
                            </button>
                            <?= Html::endForm() ?>
                        </div>
                    </article>

                    <aside class="pt-card pt-summary-card">
                        <p class="pt-card-label">Your progress</p>
                        <h2>Every day counts.</h2>

                        <div class="pt-stat-row">
                            <div class="pt-stat-icon">📅</div>
                            <div class="pt-stat-copy">
                                <span>Total check-ins</span>
                                <strong>Days you showed up</strong>
                            </div>
                            <div class="pt-stat-value"><?= $totalCheckins ?></div>
                        </div>

                        <div class="pt-stat-row">
                            <div class="pt-stat-icon">🏆</div>
                            <div class="pt-stat-copy">
                                <span>Best streak</span>
                                <strong>Your personal record</strong>
                            </div>
                            <div class="pt-stat-value"><?= $longestStreak ?></div>
                        </div>
                    </aside>
                </section>

                <section class="pt-card pt-motivation-card" aria-labelledby="daily-motivation-title">
                    <div class="pt-quote-icon" aria-hidden="true">“</div>
                    <div>
                        <p class="pt-card-label">A moment for you</p>
                        <h2 id="daily-motivation-title">Daily motivation</h2>
                        <blockquote>“<?= Html::encode($dailyQuote) ?>”</blockquote>
                    </div>
                </section>

                <?= Html::a(
                    '<div class="pt-achievement-icon" aria-hidden="true">🏆</div>
                    <div>
                        <h2>Achievements</h2>
                        <p>Celebrate every milestone and see how far you have come.</p>
                    </div>
                    <span class="pt-arrow" aria-hidden="true">→</span>',
                    ['site/achievements'],
                    [
                        'class' => 'pt-achievement-card',
                        'encode' => false,
                        'aria-label' => 'View achievements',
                    ]
                ) ?>

                <h2 class="pt-quick-heading">Keep growing</h2>

                <section class="pt-actions-grid" aria-label="Journey tools">
                    <?= Html::a(
                        '<div class="pt-action-icon" aria-hidden="true">📝</div>
                        <h3>Journal</h3>
                        <p>Make space to reflect honestly.</p>',
                        ['journal/index'],
                        ['class' => 'pt-action-card', 'encode' => false]
                    ) ?>

                    <?= Html::a(
                        '<div class="pt-action-icon" aria-hidden="true">📖</div>
                        <h3>Motivation Center</h3>
                        <p>Find strength, scripture, and support.</p>',
                        ['/motivation/index'],
                        ['class' => 'pt-action-card', 'encode' => false]
                    ) ?>

                    <?= Html::a(
                        '<div class="pt-action-icon" aria-hidden="true">🎯</div>
                        <h3>Goals &amp; Rewards</h3>
                        <p>Set your focus and track milestones.</p>',
                        ['/goal/index'],
                        ['class' => 'pt-action-card', 'encode' => false]
                    ) ?>
                </section>
            </main>
        <?php endif; ?>
    </div>
</div>