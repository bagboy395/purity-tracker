<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var frontend\models\SignupForm $model */

$this->title = 'Create Your Account';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    :root {
        --signup-ink: #10251d;
        --signup-muted: #617167;
        --signup-forest: #174c38;
        --signup-green: #277a57;
        --signup-cream: #f7fbf8;
        --signup-border: rgba(23, 76, 56, .14);
    }

    .signup-page,
    .signup-page * {
        box-sizing: border-box;
    }

    .signup-page {
        width: 100vw;
        min-height: 100vh;
        margin-left: calc(50% - 50vw);
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(420px, .9fr);
        color: var(--signup-ink);
        background: var(--signup-cream);
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .signup-showcase {
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

    .signup-showcase::before,
    .signup-showcase::after {
        position: absolute;
        border: 1px solid rgba(255, 255, 255, .13);
        border-radius: 50%;
        content: "";
    }

    .signup-showcase::before {
        top: -220px;
        right: -115px;
        width: 460px;
        height: 460px;
    }

    .signup-showcase::after {
        bottom: -220px;
        left: -120px;
        width: 390px;
        height: 390px;
    }

    .signup-brand,
    .signup-showcase-content,
    .signup-showcase-note {
        position: relative;
        z-index: 1;
    }

    .signup-brand {
        display: inline-flex;
        align-items: center;
        gap: 11px;
        color: #fff;
        font-size: 1.08rem;
        font-weight: 830;
        letter-spacing: -.03em;
        text-decoration: none;
    }

    .signup-brand:hover {
        color: #fff;
    }

    .signup-logo {
        display: grid;
        place-items: center;
        width: 43px;
        height: 43px;
        background: rgba(255, 255, 255, .14);
        border: 1px solid rgba(255, 255, 255, .16);
        border-radius: 14px 14px 14px 4px;
        transform: rotate(-7deg);
    }

    .signup-logo svg {
        width: 25px;
        height: 25px;
        transform: rotate(7deg);
    }

    .signup-brand small {
        display: block;
        margin-top: 1px;
        color: rgba(255, 255, 255, .65);
        font-size: .62rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .signup-showcase-content {
        max-width: 510px;
        margin: auto 0;
        padding: 80px 0;
    }

    .signup-showcase-badge {
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

    .signup-showcase-badge span {
        width: 8px;
        height: 8px;
        background: #a8eb70;
        border-radius: 50%;
        box-shadow: 0 0 0 5px rgba(168, 235, 112, .13);
    }

    .signup-showcase h1 {
        margin: 22px 0 18px;
        font-size: clamp(2.8rem, 5vw, 4.8rem);
        font-weight: 850;
        letter-spacing: -.075em;
        line-height: .95;
    }

    .signup-showcase h1 span {
        color: #b4ed83;
    }

    .signup-showcase p {
        max-width: 445px;
        margin: 0;
        color: rgba(255, 255, 255, .75);
        font-size: 1rem;
        line-height: 1.75;
    }

    .signup-showcase-note {
        color: rgba(255, 255, 255, .65);
        font-size: .8rem;
        line-height: 1.55;
    }

    .signup-form-panel {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: clamp(25px, 5vw, 74px);
        background:
            radial-gradient(circle at 88% 5%, rgba(155, 225, 93, .14), transparent 19rem),
            var(--signup-cream);
    }

    .signup-form-wrap {
        width: 100%;
        max-width: 440px;
    }

    .signup-mobile-brand {
        display: none;
    }

    .signup-form-heading {
        margin-bottom: 28px;
    }

    .signup-form-heading p {
        margin: 0 0 9px;
        color: var(--signup-green);
        font-size: .76rem;
        font-weight: 810;
        letter-spacing: .09em;
        text-transform: uppercase;
    }

    .signup-form-heading h2 {
        margin: 0;
        font-size: clamp(2rem, 4vw, 2.7rem);
        font-weight: 850;
        letter-spacing: -.06em;
        line-height: 1;
    }

    .signup-form-heading span {
        display: block;
        margin-top: 13px;
        color: var(--signup-muted);
        font-size: .94rem;
        font-weight: 400;
        letter-spacing: 0;
        line-height: 1.6;
    }

    .signup-card {
        padding: 30px;
        background: rgba(255, 255, 255, .88);
        border: 1px solid var(--signup-border);
        border-radius: 22px;
        box-shadow: 0 18px 48px rgba(18, 58, 42, .10);
    }

    .signup-card .mb-3 {
        margin-bottom: 20px !important;
    }

    .signup-card .form-label,
    .signup-card label {
        margin-bottom: 8px;
        color: var(--signup-ink);
        font-size: .86rem;
        font-weight: 760;
    }

    .signup-card .form-control {
        min-height: 49px;
        padding: 12px 14px;
        color: var(--signup-ink);
        background: #fbfefc;
        border: 1px solid rgba(23, 76, 56, .18);
        border-radius: 12px;
        box-shadow: none;
        font-size: .94rem;
        transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .signup-card .form-control:focus {
        background: #fff;
        border-color: #45966d;
        box-shadow: 0 0 0 4px rgba(69, 150, 109, .13);
    }

    .signup-card .invalid-feedback,
    .signup-card .help-block {
        margin-top: 6px;
        color: #a13d3d;
        font-size: .79rem;
        font-weight: 650;
    }

    .signup-submit {
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

    .signup-submit:hover {
        box-shadow: 0 15px 29px rgba(23, 76, 56, .30);
        transform: translateY(-2px);
    }

    .signup-submit:focus-visible,
    .signup-card .form-control:focus-visible {
        outline: 3px solid rgba(56, 150, 98, .32);
        outline-offset: 3px;
    }

    .signup-privacy {
        margin: 17px 0 0;
        color: var(--signup-muted);
        font-size: .76rem;
        line-height: 1.55;
        text-align: center;
    }

    .signup-login {
        margin: 22px 0 0;
        color: var(--signup-muted);
        font-size: .86rem;
        text-align: center;
    }

    .signup-login a {
        color: var(--signup-green);
        font-weight: 800;
        text-decoration: none;
    }

    .signup-login a:hover {
        color: var(--signup-forest);
        text-decoration: underline;
    }

    @media (max-width: 860px) {
        .signup-page {
            display: block;
            min-height: 100vh;
        }

        .signup-showcase {
            display: none;
        }

        .signup-form-panel {
            min-height: 100vh;
        }

        .signup-mobile-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 40px;
            color: var(--signup-forest);
            font-weight: 830;
            letter-spacing: -.03em;
            text-decoration: none;
        }

        .signup-mobile-brand .signup-logo {
            color: #fff;
            background: linear-gradient(135deg, #2b825b, #174c38);
        }

        .signup-mobile-brand small {
            display: block;
            color: var(--signup-muted);
            font-size: .62rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
        }
    }

    @media (max-width: 480px) {
        .signup-form-panel {
            padding: 28px 16px;
        }

        .signup-mobile-brand {
            margin-bottom: 32px;
        }

        .signup-card {
            padding: 23px 19px;
            border-radius: 19px;
        }
    }
</style>

<main class="signup-page">
    <section class="signup-showcase" aria-label="Purity Tracker introduction">
        <?= Html::a(
            '<span class="signup-logo" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.5 3.5C13 3.4 6.7 6 5.3 12.5c-1 4.8 2.7 7.8 6.2 6.1 5-2.4 7.5-8.9 9-15.1Z"/>
                    <path d="M4 20c3.6-4.5 7.1-7.2 12.8-10.4"/>
                </svg>
            </span>
            <span>Purity Tracker<small>One day at a time</small></span>',
            ['site/index'],
            ['class' => 'signup-brand', 'encode' => false]
        ) ?>

        <div class="signup-showcase-content">
            <div class="signup-showcase-badge">
                <span></span>
                Begin your journey today
            </div>

            <h1>A stronger life<br>starts with <span>today.</span></h1>

            <p>
                Create your private space for daily progress, meaningful reflection,
                goals, encouragement, and consistent growth.
            </p>
        </div>

        <p class="signup-showcase-note">
            One thoughtful choice at a time is enough to create lasting change.
        </p>
    </section>

    <section class="signup-form-panel">
        <div class="signup-form-wrap">

            <?= Html::a(
                '<span class="signup-logo" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.5 3.5C13 3.4 6.7 6 5.3 12.5c-1 4.8 2.7 7.8 6.2 6.1 5-2.4 7.5-8.9 9-15.1Z"/>
                        <path d="M4 20c3.6-4.5 7.1-7.2 12.8-10.4"/>
                    </svg>
                </span>
                <span>Purity Tracker<small>One day at a time</small></span>',
                ['site/index'],
                ['class' => 'signup-mobile-brand', 'encode' => false]
            ) ?>

            <header class="signup-form-heading">
                <p>Start your journey</p>
                <h2>Create your account.<span>It only takes a moment to begin tracking your progress.</span></h2>
            </header>

            <div class="signup-card">
                <?php $form = ActiveForm::begin([
                    'id' => 'form-signup',
                ]); ?>

                <?= $form->field($model, 'username')
                    ->textInput([
                        'autofocus' => true,
                        'placeholder' => 'Choose a username',
                        'autocomplete' => 'username',
                    ]) ?>

                <?= $form->field($model, 'email')
                    ->textInput([
                        'type' => 'email',
                        'placeholder' => 'you@example.com',
                        'autocomplete' => 'email',
                    ]) ?>

                <?= $form->field($model, 'password')
                    ->passwordInput([
                        'placeholder' => 'Create a secure password',
                        'autocomplete' => 'new-password',
                    ]) ?>

                <?= Html::submitButton('Create my account →', [
                    'class' => 'signup-submit',
                    'name' => 'signup-button',
                ]) ?>

                <p class="signup-privacy">
                    Your journal, goals, and progress are designed to remain personal to you.
                </p>

                <?php ActiveForm::end(); ?>

                <p class="signup-login">
                    Already have an account?
                    <?= Html::a('Log in', ['site/login']) ?>
                </p>
            </div>
        </div>
    </section>
</main>