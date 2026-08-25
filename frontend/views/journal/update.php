<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Journal $model */

$this->title = 'Edit Journal Entry';
$this->params['breadcrumbs'][] = ['label' => 'Journal', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'View Entry', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    :root {
        --ju-ink: #10251d;
        --ju-muted: #617167;
        --ju-forest: #174c38;
        --ju-green: #277a57;
        --ju-mint: #dff8e9;
        --ju-cream: #f7fbf8;
        --ju-border: rgba(23, 76, 56, .13);
    }

    .journal-update-page,
    .journal-update-page * {
        box-sizing: border-box;
    }

    .journal-update-page {
        width: 100vw;
        min-height: 100vh;
        margin-left: calc(50% - 50vw);
        padding: 30px clamp(18px, 6vw, 110px) 75px;
        color: var(--ju-ink);
        background:
            radial-gradient(circle at 5% 4%, rgba(155, 225, 93, .19), transparent 23rem),
            radial-gradient(circle at 96% 19%, rgba(48, 172, 111, .13), transparent 25rem),
            var(--ju-cream);
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .journal-update-wrap {
        width: 100%;
        max-width: 960px;
        margin: 0 auto;
    }

    .journal-update-page a {
        text-decoration: none;
    }

    .journal-update-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .journal-update-back,
    .journal-update-view {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 43px;
        padding: 10px 15px;
        border-radius: 12px;
        font-size: .88rem;
        font-weight: 750;
        transition: transform .2s ease, background .2s ease, box-shadow .2s ease;
    }

    .journal-update-back {
        color: var(--ju-forest);
        background: rgba(255, 255, 255, .74);
        border: 1px solid var(--ju-border);
    }

    .journal-update-view {
        color: var(--ju-forest);
        background: rgba(223, 248, 233, .85);
        border: 1px solid rgba(39, 122, 87, .16);
    }

    .journal-update-back:hover,
    .journal-update-view:hover {
        color: var(--ju-forest);
        background: #fff;
        box-shadow: 0 10px 24px rgba(16, 37, 29, .08);
        transform: translateY(-2px);
    }

    .journal-update-back:focus-visible,
    .journal-update-view:focus-visible,
    .journal-update-card .btn:focus-visible,
    .journal-update-card input:focus-visible,
    .journal-update-card textarea:focus-visible,
    .journal-update-card select:focus-visible {
        outline: 3px solid rgba(56, 150, 98, .32);
        outline-offset: 3px;
    }

    .journal-update-hero {
        margin: 47px 0 30px;
        text-align: center;
    }

    .journal-update-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
        color: var(--ju-forest);
        font-size: .74rem;
        font-weight: 820;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .journal-update-eyebrow span {
        width: 8px;
        height: 8px;
        background: #4aab73;
        border-radius: 50%;
        box-shadow: 0 0 0 5px rgba(74, 171, 115, .14);
    }

    .journal-update-hero h1 {
        margin: 0;
        font-size: clamp(2.4rem, 5vw, 4rem);
        font-weight: 850;
        letter-spacing: -.065em;
        line-height: 1;
    }

    .journal-update-hero h1 span {
        color: var(--ju-green);
    }

    .journal-update-hero p {
        max-width: 630px;
        margin: 17px auto 0;
        color: var(--ju-muted);
        font-size: 1rem;
        line-height: 1.75;
    }

    .journal-update-card {
        position: relative;
        overflow: hidden;
        padding: clamp(24px, 5vw, 46px);
        background: rgba(255, 255, 255, .9);
        border: 1px solid var(--ju-border);
        border-radius: 26px;
        box-shadow: 0 20px 55px rgba(18, 58, 42, .10);
    }

    .journal-update-card::before {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        content: "";
        background: linear-gradient(90deg, #9be15d, #277a57, #174c38);
    }

    /* Styles fields rendered by _form.php without changing its Yii logic */
    .journal-update-card .form-group,
    .journal-update-card .mb-3 {
        margin-bottom: 24px;
    }

    .journal-update-card label,
    .journal-update-card .control-label {
        display: block;
        margin-bottom: 8px;
        color: var(--ju-ink);
        font-size: .87rem;
        font-weight: 780;
    }

    .journal-update-card .form-control,
    .journal-update-card .form-select,
    .journal-update-card select,
    .journal-update-card input[type="text"],
    .journal-update-card input[type="date"],
    .journal-update-card input[type="number"],
    .journal-update-card textarea {
        width: 100%;
        min-height: 48px;
        padding: 12px 14px;
        color: var(--ju-ink);
        background: #fbfefc;
        border: 1px solid rgba(23, 76, 56, .17);
        border-radius: 12px;
        box-shadow: none;
        font-size: .95rem;
        line-height: 1.45;
        transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .journal-update-card textarea {
        min-height: 135px;
        resize: vertical;
    }

    .journal-update-card .form-control:focus,
    .journal-update-card .form-select:focus,
    .journal-update-card select:focus,
    .journal-update-card input:focus,
    .journal-update-card textarea:focus {
        background: #fff;
        border-color: #45966d;
        box-shadow: 0 0 0 4px rgba(69, 150, 109, .13);
    }

    .journal-update-card .help-block,
    .journal-update-card .invalid-feedback {
        margin-top: 7px;
        color: #a13d3d;
        font-size: .8rem;
        font-weight: 650;
    }

    .journal-update-card .has-error .form-control,
    .journal-update-card .has-error select,
    .journal-update-card .has-error textarea {
        border-color: #c75757;
    }

    .journal-update-card .btn-primary,
    .journal-update-card button[type="submit"],
    .journal-update-card input[type="submit"] {
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

    .journal-update-card .btn-primary:hover,
    .journal-update-card button[type="submit"]:hover,
    .journal-update-card input[type="submit"]:hover {
        color: #fff;
        box-shadow: 0 15px 29px rgba(23, 76, 56, .3);
        transform: translateY(-2px);
    }

    @media (max-width: 600px) {
        .journal-update-page {
            padding: 18px 16px 48px;
        }

        .journal-update-topbar {
            align-items: stretch;
        }

        .journal-update-back,
        .journal-update-view {
            min-height: 40px;
            padding: 9px 11px;
            font-size: .8rem;
        }

        .journal-update-hero {
            margin-top: 35px;
        }

        .journal-update-hero h1 {
            font-size: 2.55rem;
        }

        .journal-update-hero p {
            font-size: .93rem;
        }

        .journal-update-card {
            padding: 24px 19px;
            border-radius: 20px;
        }
    }
</style>

<main class="journal-update-page">
    <div class="journal-update-wrap">

        <div class="journal-update-topbar">
            <?= Html::a('← Back to Journal', ['index'], [
                'class' => 'journal-update-back',
            ]) ?>

            <?= Html::a('View Entry →', ['view', 'id' => $model->id], [
                'class' => 'journal-update-view',
            ]) ?>
        </div>

        <header class="journal-update-hero">
            <div class="journal-update-eyebrow">
                <span></span>
                Refine your reflection
            </div>

            <h1>Give your story<br><span>the full picture.</span></h1>

            <p>
                Add anything you missed, clarify what happened, or update how you responded.
                Each honest detail helps you understand your patterns more clearly.
            </p>
        </header>

        <section class="journal-update-card" aria-label="Edit journal entry form">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </section>

    </div>
</main>