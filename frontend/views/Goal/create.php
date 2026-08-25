<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Goal $model */

$this->title = 'Create Goal';
$this->params['breadcrumbs'][] = ['label' => 'Goals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    :root {
        --gc-ink: #10251d;
        --gc-muted: #617167;
        --gc-forest: #174c38;
        --gc-green: #277a57;
        --gc-mint: #dff8e9;
        --gc-cream: #f7fbf8;
        --gc-border: rgba(23, 76, 56, .13);
    }

    .goal-create-page,
    .goal-create-page * {
        box-sizing: border-box;
    }

    .goal-create-page {
        width: 100vw;
        min-height: 100vh;
        margin-left: calc(50% - 50vw);
        padding: 30px clamp(18px, 6vw, 110px) 75px;
        color: var(--gc-ink);
        background:
            radial-gradient(circle at 5% 4%, rgba(155, 225, 93, .20), transparent 23rem),
            radial-gradient(circle at 96% 18%, rgba(48, 172, 111, .13), transparent 25rem),
            var(--gc-cream);
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .goal-create-wrap {
        width: 100%;
        max-width: 960px;
        margin: 0 auto;
    }

    .goal-create-page a {
        text-decoration: none;
    }

    .goal-create-back {
        display: inline-flex;
        align-items: center;
        min-height: 43px;
        padding: 10px 15px;
        color: var(--gc-forest);
        background: rgba(255, 255, 255, .75);
        border: 1px solid var(--gc-border);
        border-radius: 12px;
        font-size: .88rem;
        font-weight: 750;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .goal-create-back:hover {
        color: var(--gc-forest);
        background: #fff;
        box-shadow: 0 10px 24px rgba(16, 37, 29, .08);
        transform: translateY(-2px);
    }

    .goal-create-back:focus-visible,
    .goal-create-card input:focus-visible,
    .goal-create-card textarea:focus-visible,
    .goal-create-card select:focus-visible,
    .goal-create-card button:focus-visible {
        outline: 3px solid rgba(56, 150, 98, .32);
        outline-offset: 3px;
    }

    .goal-create-hero {
        margin: 47px 0 30px;
        text-align: center;
    }

    .goal-create-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
        color: var(--gc-forest);
        font-size: .74rem;
        font-weight: 820;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .goal-create-eyebrow span {
        width: 8px;
        height: 8px;
        background: #4aab73;
        border-radius: 50%;
        box-shadow: 0 0 0 5px rgba(74, 171, 115, .14);
    }

    .goal-create-hero h1 {
        margin: 0;
        font-size: clamp(2.45rem, 5vw, 4rem);
        font-weight: 850;
        letter-spacing: -.065em;
        line-height: 1;
    }

    .goal-create-hero h1 span {
        color: var(--gc-green);
    }

    .goal-create-hero p {
        max-width: 630px;
        margin: 17px auto 0;
        color: var(--gc-muted);
        font-size: 1rem;
        line-height: 1.75;
    }

    .goal-create-card {
        position: relative;
        overflow: hidden;
        padding: clamp(24px, 5vw, 46px);
        background: rgba(255, 255, 255, .9);
        border: 1px solid var(--gc-border);
        border-radius: 26px;
        box-shadow: 0 20px 55px rgba(18, 58, 42, .10);
    }

    .goal-create-card::before {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        content: "";
        background: linear-gradient(90deg, #9be15d, #277a57, #174c38);
    }

    /* Applies polished field styling to your existing _form.php */
    .goal-create-card .form-group,
    .goal-create-card .mb-3 {
        margin-bottom: 24px;
    }

    .goal-create-card label,
    .goal-create-card .control-label {
        display: block;
        margin-bottom: 8px;
        color: var(--gc-ink);
        font-size: .87rem;
        font-weight: 780;
    }

    .goal-create-card .form-control,
    .goal-create-card .form-select,
    .goal-create-card input[type="text"],
    .goal-create-card input[type="number"],
    .goal-create-card textarea,
    .goal-create-card select {
        width: 100%;
        min-height: 48px;
        padding: 12px 14px;
        color: var(--gc-ink);
        background: #fbfefc;
        border: 1px solid rgba(23, 76, 56, .17);
        border-radius: 12px;
        box-shadow: none;
        font-size: .95rem;
        line-height: 1.45;
        transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .goal-create-card textarea {
        min-height: 130px;
        resize: vertical;
    }

    .goal-create-card .form-control:focus,
    .goal-create-card .form-select:focus,
    .goal-create-card input:focus,
    .goal-create-card textarea:focus,
    .goal-create-card select:focus {
        background: #fff;
        border-color: #45966d;
        box-shadow: 0 0 0 4px rgba(69, 150, 109, .13);
    }

    .goal-create-card .help-block,
    .goal-create-card .invalid-feedback {
        margin-top: 7px;
        color: #a13d3d;
        font-size: .8rem;
        font-weight: 650;
    }

    .goal-create-card .has-error .form-control,
    .goal-create-card .has-error input,
    .goal-create-card .has-error textarea {
        border-color: #c75757;
    }

    .goal-create-card .btn-primary,
    .goal-create-card .btn-success,
    .goal-create-card button[type="submit"],
    .goal-create-card input[type="submit"] {
        min-height: 50px;
        padding: 12px 21px;
        color: #fff;
        background: linear-gradient(135deg, #2b825b, #174c38);
        border: 0;
        border-radius: 13px;
        box-shadow: 0 11px 24px rgba(23, 76, 56, .22);
        font-size: .92rem;
        font-weight: 800;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .goal-create-card .btn-primary:hover,
    .goal-create-card .btn-success:hover,
    .goal-create-card button[type="submit"]:hover,
    .goal-create-card input[type="submit"]:hover {
        color: #fff;
        box-shadow: 0 15px 29px rgba(23, 76, 56, .30);
        transform: translateY(-2px);
    }

    @media (max-width: 600px) {
        .goal-create-page {
            padding: 18px 16px 48px;
        }

        .goal-create-hero {
            margin-top: 35px;
        }

        .goal-create-hero h1 {
            font-size: 2.55rem;
        }

        .goal-create-hero p {
            font-size: .93rem;
        }

        .goal-create-card {
            padding: 24px 19px;
            border-radius: 20px;
        }
    }
</style>

<main class="goal-create-page">
    <div class="goal-create-wrap">

        <?= Html::a('← Back to Goals', ['index'], [
            'class' => 'goal-create-back',
        ]) ?>

        <header class="goal-create-hero">
            <div class="goal-create-eyebrow">
                <span></span>
                Set your next milestone
            </div>

            <h1>Turn intention into<br><span>something measurable.</span></h1>

            <p>
                Choose a goal that matters to you. Every daily check-in will show you
                exactly how far you have come and what is still ahead.
            </p>
        </header>

        <section class="goal-create-card" aria-label="Create a new goal">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </section>

    </div>
</main>