<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Journal $model */

$this->title = 'New Journal Entry';
$this->params['breadcrumbs'][] = ['label' => 'Journal', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    :root {
        --jc-ink: #10251d;
        --jc-muted: #617167;
        --jc-forest: #174c38;
        --jc-green: #277a57;
        --jc-mint: #dff8e9;
        --jc-cream: #f7fbf8;
        --jc-border: rgba(23, 76, 56, .13);
    }

    .journal-create-page,
    .journal-create-page * {
        box-sizing: border-box;
    }

    .journal-create-page {
        width: 100vw;
        min-height: 100vh;
        margin-left: calc(50% - 50vw);
        padding: 30px clamp(18px, 6vw, 110px) 75px;
        color: var(--jc-ink);
        background:
            radial-gradient(circle at 5% 4%, rgba(155, 225, 93, .19), transparent 23rem),
            radial-gradient(circle at 96% 19%, rgba(48, 172, 111, .13), transparent 25rem),
            var(--jc-cream);
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .journal-create-wrap {
        width: 100%;
        max-width: 960px;
        margin: 0 auto;
    }

    .journal-create-page a {
        text-decoration: none;
    }

    .journal-create-back {
        display: inline-flex;
        align-items: center;
        min-height: 43px;
        padding: 10px 15px;
        color: var(--jc-forest);
        background: rgba(255, 255, 255, .74);
        border: 1px solid var(--jc-border);
        border-radius: 12px;
        font-size: .88rem;
        font-weight: 750;
        transition: transform .2s ease, background .2s ease, box-shadow .2s ease;
    }

    .journal-create-back:hover {
        color: var(--jc-forest);
        background: #fff;
        box-shadow: 0 10px 24px rgba(16, 37, 29, .08);
        transform: translateY(-2px);
    }

    .journal-create-back:focus-visible,
    .journal-create-card .btn:focus-visible,
    .journal-create-card input:focus-visible,
    .journal-create-card textarea:focus-visible,
    .journal-create-card select:focus-visible {
        outline: 3px solid rgba(56, 150, 98, .32);
        outline-offset: 3px;
    }

    .journal-create-hero {
        margin: 47px 0 30px;
        text-align: center;
    }

    .journal-create-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
        color: var(--jc-forest);
        font-size: .74rem;
        font-weight: 820;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .journal-create-eyebrow span {
        width: 8px;
        height: 8px;
        background: #4aab73;
        border-radius: 50%;
        box-shadow: 0 0 0 5px rgba(74, 171, 115, .14);
    }

    .journal-create-hero h1 {
        margin: 0;
        font-size: clamp(2.4rem, 5vw, 4rem);
        font-weight: 850;
        letter-spacing: -.065em;
        line-height: 1;
    }

    .journal-create-hero h1 span {
        color: var(--jc-green);
    }

    .journal-create-hero p {
        max-width: 630px;
        margin: 17px auto 0;
        color: var(--jc-muted);
        font-size: 1rem;
        line-height: 1.75;
    }

    .journal-create-card {
        position: relative;
        overflow: hidden;
        padding: clamp(24px, 5vw, 46px);
        background: rgba(255, 255, 255, .9);
        border: 1px solid var(--jc-border);
        border-radius: 26px;
        box-shadow: 0 20px 55px rgba(18, 58, 42, .10);
    }

    .journal-create-card::before {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        content: "";
        background: linear-gradient(90deg, #9be15d, #277a57, #174c38);
    }

    /* Styles the fields rendered by _form.php */
    .journal-create-card .form-group,
    .journal-create-card .mb-3 {
        margin-bottom: 24px;
    }

    .journal-create-card label,
    .journal-create-card .control-label {
        display: block;
        margin-bottom: 8px;
        color: var(--jc-ink);
        font-size: .87rem;
        font-weight: 780;
    }

    .journal-create-card .form-control,
    .journal-create-card .form-select,
    .journal-create-card select,
    .journal-create-card input[type="text"],
    .journal-create-card input[type="date"],
    .journal-create-card input[type="number"],
    .journal-create-card textarea {
        width: 100%;
        min-height: 48px;
        padding: 12px 14px;
        color: var(--jc-ink);
        background: #fbfefc;
        border: 1px solid rgba(23, 76, 56, .17);
        border-radius: 12px;
        box-shadow: none;
        font-size: .95rem;
        line-height: 1.45;
        transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .journal-create-card textarea {
        min-height: 135px;
        resize: vertical;
    }

    .journal-create-card .form-control:focus,
    .journal-create-card .form-select:focus,
    .journal-create-card select:focus,
    .journal-create-card input:focus,
    .journal-create-card textarea:focus {
        background: #fff;
        border-color: #45966d;
        box-shadow: 0 0 0 4px rgba(69, 150, 109, .13);
    }

    .journal-create-card .help-block,
    .journal-create-card .invalid-feedback {
        margin-top: 7px;
        color: #a13d3d;
        font-size: .8rem;
        font-weight: 650;
    }

    .journal-create-card .has-error .form-control,
    .journal-create-card .has-error select,
    .journal-create-card .has-error textarea {
        border-color: #c75757;
    }

    .journal-create-card .btn-primary,
    .journal-create-card button[type="submit"],
    .journal-create-card input[type="submit"] {
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

    .journal-create-card .btn-primary:hover,
    .journal-create-card button[type="submit"]:hover,
    .journal-create-card input[type="submit"]:hover {
        color: #fff;
        box-shadow: 0 15px 29px rgba(23, 76, 56, .3);
        transform: translateY(-2px);
    }

    @media (max-width: 600px) {
        .journal-create-page {
            padding: 18px 16px 48px;
        }

        .journal-create-hero {
            margin-top: 35px;
        }

        .journal-create-hero h1 {
            font-size: 2.55rem;
        }

        .journal-create-hero p {
            font-size: .93rem;
        }

        .journal-create-card {
            padding: 24px 19px;
            border-radius: 20px;
        }
    }
</style>

<main class="journal-create-page">
    <div class="journal-create-wrap">

        <?= Html::a('← Back to Journal', ['index'], [
            'class' => 'journal-create-back',
        ]) ?>

        <header class="journal-create-hero">
            <div class="journal-create-eyebrow">
                <span></span>
                A moment to reflect
            </div>

            <h1>Write it down.<br><span>Learn from it.</span></h1>

            <p>
                Record what happened, what you felt, and how you responded.
                Honest reflection helps you recognise patterns and choose your next step with clarity.
            </p>
        </header>

        <section class="journal-create-card" aria-label="New journal entry form">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </section>

    </div>
</main>