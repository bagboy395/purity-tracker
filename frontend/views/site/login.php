<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var common\models\LoginForm $model */

$this->title = 'Welcome Back';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    :root {
        --login-ink: #10251d;
        --login-muted: #617167;
        --login-forest: #174c38;
        --login-green: #277a57;
        --login-mint: #dff8e9;
        --login-cream: #f7fbf8;
        --login-border: rgba(23, 76, 56, .14);
    }

    .login-page,
    .login-page * {
        box-sizing: border-box;
    }

    .login-page {
        width: 100vw;
        min-height: 100vh;
        margin-left: calc(50% - 50vw);
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(420px, .9fr);
        color: var(--login-ink);
        background: var(--login-cream);
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .login-showcase {
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 100vh;
        padding: clamp(32px, 6vw, 84px);
        overflow: hidden;
        color: #fff;
        background: linear-gradient(145deg, #103d2d 0%, #1b6548 58%, #319262 100%);
    }

    .login-showcase::before,
    .login-showcase::after {
        position: absolute;
        border: 1px solid rgba(255, 255, 255, .13);
        border-radius: 50%;
        content: "";
    }

    .login-showcase::before {
        top: -220px;
        right: -115px;
        width: 460px;
        height: 460px;
    }

    .login-showcase::after {
        bottom: -220px;
        left: -120px;
        width: 390px;
        height: 390px;
    }

    .login-brand,
    .login-showcase-content,
    .login-showcase-note {
        position: relative;
        z-index: 1;
    }

    .login-brand {
        display: inline-flex;
        align-items: center;
        gap: 11px;
        color: #fff;
        font-size: 1.08rem;
        font-weight: 830;
        letter-spacing: -.03em;
        text-decoration: none;
    }

    .login-brand:hover {
        color: #fff;
    }

    .login-logo {
        display: grid;
        place-items: center;
        width: 43px;
        height: 43px;
        background: rgba(255, 255, 255, .14);
        border: 1px solid rgba(255, 255, 255, .16);
        border-radius: 14px 14px 14px 4px;
        transform: rotate(-7deg);
    }

    .login-logo svg {
        width: 25px;
        height: 25px;
        transform: rotate(7deg);
    }

    .login-brand small {
        display: block;
        margin-top: 1px;
        color: rgba(255, 255, 255, .65);
        font-size: .62rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .login-showcase-content {
        max-width: 500px;
        margin: auto 0;
        padding: 80px 0;
    }

    .login-showcase-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        background: rgba(255, 255, 255, .11);
        border: 1px solid rgba(255, 255, 255, .14);
        border-radius: 999px;
        color: rgba(255, 255, 255, .87);
        font-size: .75rem;
        font-weight: 750;
    }

    .login-showcase-badge span {
        width: 8px;
        height: 8px;
        background: #a8eb70;
        border-radius: 50%;
        box-shadow: 0 0 0 5px rgba(168, 235, 112, .13);
    }

    .login-showcase h1 {
        margin: 22px 0 18px;
        font-size: clamp(2.8rem, 5vw, 4.8rem);
        font-weight: 850;
        letter-spacing: -.075em;
        line-height: .95;
    }

    .login-showcase h1 span {
        color: #b4ed83;
    }

    .login-showcase p {
        max-width: 435px;
        margin: 0;
        color: rgba(255, 255, 255, .75);
        font-size: 1rem;
        line-height: 1.75;
    }

    .login-showcase-note {
        color: rgba(255, 255, 255, .65);
        font-size: .8rem;
        line-height: 1.55;
    }

    .login-form-panel {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: clamp(25px, 5vw, 74px);
        background:
            radial-gradient(circle at 88% 5%, rgba(155, 225, 93, .14), transparent 19rem),
            var(--login-cream);
    }

    .login-form-wrap {
        width: 100%;
        max-width: 430px;
    }

    .login-mobile-brand {
        display: none;
    }

    .login-form-heading {
        margin-bottom: 28px;
    }

    .login-form-heading p {
        margin: 0 0 9px;
        color: var(--login-green);
        font-size: .76rem;
        font-weight: 810;
        letter-spacing: .09em;
        text-transform: uppercase;
    }

    .login-form-heading h2 {
        margin: 0;
        font-size: clamp(2rem, 4vw, 2.7rem);
        font-weight: 850;
        letter-spacing: -.06em;
        line-height: 1;
    }

    .login-form-heading span {
        display: block;
        margin-top: 13px;
        color: var(--login-muted);
        font-size: .94rem;
        font-weight: 400;
        letter-spacing: 0;
        line-height: 1.6;
    }

    .login-card {
        padding: 30px;
        background: rgba(255, 255, 255, .88);
        border: 1px solid var(--login-border);
        border-radius: 22px;
        box-shadow: 0 18px 48px rgba(18, 58, 42, .10);
    }

    .login-card .mb-3 {
        margin-bottom: 20px !important;
    }

    .login-card .form-label,
    .login-card label {
        margin-bottom: 8px;
        color: var(--login-ink);
        font-size: .86rem;
        font-weight: 760;
    }

    .login-card .form-control {
        min-height: 49px;
        padding: 12px 14px;
        color: var(--login-ink);
        background: #fbfefc;
        border: 1px solid rgba(23, 76, 56, .18);
        border-radius: 12px;
        box-shadow: none;
        font-size: .94rem;
        transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .login-card .form-control:focus {
        background: #fff;
        border-color: #45966d;
        box-shadow: 0 0 0 4px rgba(69, 150, 109, .13);
    }

    .login-card .invalid-feedback,
    .login-card .help-block {
        margin-top: 6px;
        color: #a13d3d;
        font-size: .79rem;
        font-weight: 650;
    }

    .login-card .form-check {
        margin: 2px 0 19px;
    }

    .login-card .form-check-input {
        width: 1.08em;
        height: 1.08em;
        border-color: rgba(23, 76, 56, .34);
        box-shadow: none;
        cursor: pointer;
    }

    .login-card .form-check-input:checked {
        background-color: var(--login-green);
        border-color: var(--login-green);
    }

    .login-card .form-check-label {
        color: var(--login-muted);
        font-size: .84rem;
        font-weight: 650;
        cursor: pointer;
    }

    .login-help-links {
        margin: 0 0 23px;
        color: var(--login-muted);
        font-size: .82rem;
        line-height: 1.75;
    }

    .login-help-links a {
        color: var(--login-green);
        font-weight: 750;
        text-decoration: none;
    }

    .login-help-links a:hover {
        color: var(--login-forest);
        text-decoration: underline;
    }

    .login-submit {
        width: 100%;
        min-height: 51px;
        padding: 12px 20px;
        color: #fff;
        background: linear-gradient(135deg, #2b825b, #174c38);
        border: 0;
        border-radius: 13px;
        box-shadow: 0 11px 24px rgba(23, 76, 56, .22);
        cursor: pointer;
        font-size: .93rem;
        font-weight: 820;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .login-submit:hover {
        box-shadow: 0 15px 29px rgba(23, 76, 56, .30);
        transform: translateY(-2px);
    }

    .login-submit:focus-visible,
    .login-card .form-control:focus-visible {
        outline: 3px solid rgba(56, 150, 98, .32);
        outline-offset: 3px;
    }

    .login-signup {
        margin: 22px 0 0;
        color: var(--login-muted);
        font-size: .86rem;
        text-align: center;
    }

    .login-signup a {
        color: var(--login-green);
        font-weight: 800;
        text-decoration: none;
    }

    .login-signup a:hover {
        color: var(--login-forest);
        text-decoration: underline;
    }

    @media (max-width: 860px) {
        .login-page {
            display: block;
            min-height: 100vh;
        }

        .login-showcase {
            display: none;
        }

        .login-form-panel {
            min-height: 100vh;
        }

        .login-mobile-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 40px;
            color: var(--login-forest);
            font-weight: 830;
            letter-spacing: -.03em;
            text-decoration: none;
        }

        .login-mobile-brand .login-logo {
            color: #fff;
            background: linear-gradient(135deg, #2b825b, #174c38);
        }

        .login-mobile-brand small {
            display: block;
            color: var(--login-muted);
            font-size: .62rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
        }
    }

    @media (max-width: 480px) {
        .login-form-panel {
            padding: 28px 16px;
        }

        .login-mobile-brand {
            margin-bottom: 32px;
        }

        .login-card {
            padding: 23px 19px;
            border-radius: 19px;
        }
    }
</style>

<main class="login-page">
    <section class="login-showcase" aria-label="Purity Tracker introduction">
        <?= Html::a(
            '<span class="login-logo" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.5 3.5C13 3.4 6.7 6 5.3 12.5c-1 4.8 2.7 7.8 6.2 6.1 5-2.4 7.5-8.9 9-15.1Z"/>
                    <path d="M4 20c3.6-4.5 7.1-7.2 12.8-10.4"/>
                </svg>
            </span>
            <span>Purity Tracker<small>One day at a time</small></span>',
            ['site/index'],
            ['class' => 'login-brand', 'encode' => false]
        ) ?>

        <div class="login-showcase-content">
            <div class="login-showcase-badge">
                <span></span>
                Your journey continues here
            </div>

            <h1>Welcome back<br>to your <span>growth.</span></h1>

            <p>
                Every check-in, reflection, and intentional choice adds up.
                Pick up exactly where you left off.
            </p>
        </div>

        <p class="login-showcase-note">
            A private space for consistent progress, encouragement, and purpose.
        </p>
    </section>

    <section class="login-form-panel">
        <div class="login-form-wrap">

            <?= Html::a(
                '<span class="login-logo" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.5 3.5C13 3.4 6.7 6 5.3 12.5c-1 4.8 2.7 7.8 6.2 6.1 5-2.4 7.5-8.9 9-15.1Z"/>
                        <path d="M4 20c3.6-4.5 7.1-7.2 12.8-10.4"/>
                    </svg>
                </span>
                <span>Purity Tracker<small>One day at a time</small></span>',
                ['site/index'],
                ['class' => 'login-mobile-brand', 'encode' => false]
            ) ?>

            <header class="login-form-heading">
                <p>Welcome back</p>
                <h2>Sign in to continue.<span>Enter your details to return to your dashboard.</span></h2>
            </header>

            <div class="login-card">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                ]); ?>

                <?= $form->field($model, 'username')
                    ->textInput([
                        'autofocus' => true,
                        'placeholder' => 'Enter your username',
                        'autocomplete' => 'username',
                    ]) ?>

                <?= $form->field($model, 'password')
                    ->passwordInput([
                        'placeholder' => 'Enter your password',
                        'autocomplete' => 'current-password',
                    ]) ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="login-help-links">
                    Forgot your password?
                    <?= Html::a('Reset it', ['site/request-password-reset']) ?>.
                    <br>
                    Need a new verification email?
                    <?= Html::a('Resend verification email', ['site/resend-verification-email']) ?>.
                </div>

                <?= Html::submitButton('Log in →', [
                    'class' => 'login-submit',
                    'name' => 'login-button',
                ]) ?>

                <?php ActiveForm::end(); ?>

                <p class="login-signup">
                    New to Purity Tracker?
                    <?= Html::a('Create an account', ['site/signup']) ?>
                </p>
            </div>
        </div>
    </section>
</main>