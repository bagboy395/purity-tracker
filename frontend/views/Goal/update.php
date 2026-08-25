<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Goal $model */

$this->title = 'Update Goal: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Goals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<style>
    :root {
        --gu-ink: #10251d;
        --gu-muted: #617167;
        --gu-forest: #174c38;
        --gu-green: #277a57;
        --gu-cream: #f7fbf8;
        --gu-border: rgba(23, 76, 56, .13);
    }

    .goal-update-page,
    .goal-update-page * {
        box-sizing: border-box;
    }

    .goal-update-page {
        width: 100vw;
        min-height: 100vh;
        margin-left: calc(50% - 50vw);
        padding: 30px clamp(18px, 6vw, 110px) 75px;
        color: var(--gu-ink);
        background:
            radial-gradient(circle at 5% 4%, rgba(155, 225, 93, .20), transparent 23rem),
            radial-gradient(circle at 96% 18%, rgba(48, 172, 111, .13), transparent 25rem),
            var(--gu-cream);
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .goal-update-wrap {
        width: 100%;
        max-width: 960px;
        margin: 0 auto;
    }

    .goal-update-page a {
        text-decoration: none;
    }

    .goal-update-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .goal-update-back,
    .goal-update-view {
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

    .goal-update-back {
        color: var(--gu-forest);
        background: rgba(255, 255, 255, .75);
        border: 1px solid var(--gu-border);
    }

    .goal-update-view {
        color: var(--gu-forest);
        background: rgba(223, 248, 233, .85);
        border: 1px solid rgba(39, 122, 87, .16);
    }

    .goal-update-back:hover,
    .goal-update-view:hover {
        color: var(--gu-forest);
        background: #fff;
        box-shadow: 0 10px 24px rgba(16, 37, 29, .08);
        transform: translateY(-2px);
    }

    .goal-update-back:focus-visible,
    .goal-update-view:focus-visible,
    .goal-update-card input:focus-visible,
    .goal-update-card textarea:focus-visible,
    .goal-update-card select:focus-visible,
    .goal-update-card button:focus-visible {
        outline: 3px solid rgba(56, 150, 98, .32);
        outline-offset: 3px;
    }

    .goal-update-hero {
        margin: 47px 0 30px;
        text-align: center;
    }

    .goal-update-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
        color: var(--gu-forest);
        font-size: .74rem;
        font-weight: 820;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .goal-update-eyebrow span {
        width: 8px;
        height: 8px;
        background: #4aab73;
        border-radius: 50%;
        box-shadow: 0 0 0 5px rgba(74, 171, 115, .14);
    }

    .goal-update-hero h1 {
        margin: 0;
        font-size: clamp(2.4rem, 5vw, 4rem);
        font-weight: 850;
        letter-spacing: -.065em;
        line-height: 1;
    }

    .goal-update-hero h1 span {
        color: var(--gu-green);
    }

    .goal-update-hero p {
        max-width: 630px;
        margin: 17px auto 0;
        color: var(--gu-muted);
        font-size: 1rem;
        line-height: 1.75;
    }

    .goal-update-name {
        display: inline-block;
        max-width: 100%;
        margin-top: 11px;
        padding: 8px 13px;
        overflow: hidden;
        color: var(--gu-forest);
        background: rgba(223, 248, 233, .82);
        border-radius: 999px;
        font-size: .83rem;
        font-weight: 760;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .goal-update-card {
        position: relative;
        overflow: hidden;
        padding: clamp(24px, 5vw, 46px);
        background: rgba(255, 255, 255, .9);
        border: 1px solid var(--gu-border);
        border-radius: 26px;
        box-shadow: 0 20px 55px rgba(18, 58, 42, .10);
    }

    .goal-update-card::before {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        content: "";
        background: linear-gradient(90deg, #9be15d, #277a57, #174c38);
    }

    /* Applies polished field styling to the existing _form.php */
    .goal-update-card .form-group,
    .goal-update-card .mb-3 {
        margin-bottom: 24px;
    }

    .goal-update-card label,
    .goal-update-card .control-label {
        display: block;
        margin-bottom: 8px;
        color: var(--gu-ink);
        font-size: .87rem;
        font-weight: 780;
    }

    .goal-update-card .form-control,
    .goal-update-card .form-select,
    .goal-update-card input[type="text"],
    .goal-update-card input[type="number"],
    .goal-update-card textarea,
    .goal-update-card select {
        width: 100%;
        min-height: 48px;
        padding: 12px 14px;
        color: var(--gu-ink);
        background: #fbfefc;
        border: 1px solid rgba(23, 76, 56, .17);
        border-radius: 12px;
        box-shadow: none;
        font-size: .95rem;
        line-height: 1.45;
        transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .goal-update-card textarea {
        min-height: 130px;
        resize: vertical;
    }

    .goal-update-card .form-control:focus,
    .goal-update-card .form-select:focus,
    .goal-update-card input:focus,
    .goal-update-card textarea:focus,
    .goal-update-card select:focus {
        background: #fff;
        border-color: #45966d;
        box-shadow: 0 0 0 4px rgba(69, 150, 109, .13);
    }

    .goal-update-card .help-block,
    .goal-update-card .invalid-feedback {
        margin-top: 7px;
        color: #a13d3d;
        font-size: .8rem;
        font-weight: 650;
    }

    .goal-update-card .has-error .form-control,
    .goal-update-card .has-error input,
    .goal-update-card .has-error textarea {
        border-color: #c75757;
    }

    .goal-update-card .btn-primary,
    .goal-update-card .btn-success,
    .goal-update-card button[type="submit"],
    .goal-update-card input[type="submit"] {
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

    .goal-update-card .btn-primary:hover,
    .goal-update-card .btn-success:hover,
    .goal-update-card button[type="submit"]:hover,
    .goal-update-card input[type="submit"]:hover {
        color: #fff;
        box-shadow: 0 15px 29px rgba(23, 76, 56, .30);
        transform: translateY(-2px);
    }

    @media (max-width: 600px) {
        .goal-update-page {
            padding: 18px 16px 48px;
        }

        .goal-update-topbar {
            align-items: stretch;
        }

        .goal-update-back,
        .goal-update-view {
            min-height: 40px;
            padding: 9px 11px;
            font-size: .8rem;
        }

        .goal-update-hero {
            margin-top: 35px;
        }

        .goal-update-hero h1 {
            font-size: 2.55rem;
        }

        .goal-update-hero p {
            font-size: .93rem;
        }

        .goal-update-card {
            padding: 24px 19px;
            border-radius: 20px;
        }
    }
</style>

<main class="goal-update-page">
    <div class="goal-update-wrap">

        <div class="goal-update-topbar">
            <?= Html::a('← Back to Goals', ['index'], [
                'class' => 'goal-update-back',
            ]) ?>

            <?= Html::a('View Goal →', ['view', 'id' => $model->id], [
                'class' => 'goal-update-view',
            ]) ?>
        </div>

        <header class="goal-update-hero">
            <div class="goal-update-eyebrow">
                <span></span>
                Refine your milestone
            </div>

            <h1>Keep your goal<br><span>aligned with you.</span></h1>

            <p>
                Update the details if your focus has changed. A clear, meaningful goal
                makes it easier to stay committed one day at a time.
            </p>

            <div class="goal-update-name"><?= Html::encode($model->title) ?></div>
        </header>

        <section class="goal-update-card" aria-label="Update goal form">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </section>

    </div>
</main>