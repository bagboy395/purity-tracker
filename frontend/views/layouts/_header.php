<?php

use common\models\Notification;
use yii\helpers\Html;

$isGuest = Yii::$app->user->isGuest;

$firstName = '';

$unreadNotificationCount = 0;

if (!$isGuest) {
    $userName = Yii::$app->user->identity->username ?? 'Friend';

    $firstName = trim(explode(' ', $userName)[0]);

    $unreadNotificationCount = Notification::find()
        ->where([
            'user_id' => Yii::$app->user->id,
            'is_read' => 0,
        ])
        ->count();
}

$this->registerCss(<<<CSS

/* =========================================
   PURITY TRACKER — SHARED SITE HEADER
========================================= */

.pt-site-header,
.pt-site-header * {
    box-sizing: border-box;
}

.pt-site-header {
    position: sticky;
    top: 0;
    z-index: 1050;
    width: 100%;
    background: rgba(255, 255, 255, 0.94);
    border-bottom: 1px solid rgba(23, 76, 56, 0.10);
    box-shadow: 0 5px 24px rgba(16, 37, 29, 0.035);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    font-family: Inter, ui-sans-serif, system-ui, -apple-system,
        BlinkMacSystemFont, "Segoe UI", sans-serif;
}

.pt-site-header a {
    text-decoration: none;
}

.pt-header-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    width: 100%;
    max-width: 1600px;
    min-height: 88px;
    margin: 0 auto;
    padding: 14px clamp(20px, 6vw, 110px);
}

.pt-navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    width: 100%;
}

.pt-brand {
    display: inline-flex;
    align-items: center;
    flex: 0 0 auto;
    gap: 11px;
    color: #10251d;
    font-size: 1.08rem;
    font-weight: 800;
    letter-spacing: -.03em;
}

.pt-brand:hover {
    color: #174c38;
}

.pt-logo {
    display: grid;
    place-items: center;
    width: 42px;
    height: 42px;
    flex: 0 0 42px;
    color: #fff;
    background: linear-gradient(140deg, #2e925f, #174c38);
    border-radius: 14px 14px 14px 4px;
    box-shadow: 0 8px 20px rgba(26, 111, 72, .20);
    transform: rotate(-7deg);
}

.pt-logo svg {
    width: 25px;
    height: 25px;
    transform: rotate(7deg);
}

.pt-brand-copy small {
    display: block;
    margin-top: 3px;
    color: #50645a;
    font-size: .64rem;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.pt-nav-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
}

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
    transition: transform .2s ease, box-shadow .2s ease,
        background .2s ease, border-color .2s ease;
}

.pt-nav-button:hover {
    transform: translateY(-2px);
}

.pt-button-primary {
    color: #fff;
    background: linear-gradient(135deg, #287e59, #174c38);
    box-shadow: 0 8px 18px rgba(23, 76, 56, .16);
}

.pt-button-primary:hover {
    color: #fff;
    box-shadow: 0 12px 24px rgba(23, 76, 56, .24);
}

.pt-button-light {
    color: #174c38;
    background: rgba(255, 255, 255, .85);
    border-color: rgba(23, 76, 56, .13);
}

.pt-button-light:hover {
    color: #174c38;
    background: #f4faf6;
}

.pt-logout-form {
    margin: 0;
}

.pt-logout {
    color: #9d3434;
    background: transparent;
    border-color: rgba(157, 52, 52, .18);
    cursor: pointer;
}

.pt-logout:hover {
    color: #842525;
    background: #fff5f5;
}

/* Notification bell */

.pt-notification-link {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 46px;
    height: 46px;
    flex: 0 0 46px;
    color: #174c38;
    background: rgba(255, 255, 255, .85);
    border: 1px solid rgba(23, 76, 56, .13);
    border-radius: 50%;
    box-shadow: 0 5px 16px rgba(16, 37, 29, .04);
    transition: transform .2s ease, background .2s ease;
}

.pt-notification-link:hover {
    color: #174c38;
    background: #edf8f0;
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

/* Profile control */

.pt-profile-link {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    min-height: 48px;
    padding: 5px 12px 5px 6px;
    color: #174c38;
    background: rgba(255, 255, 255, .85);
    border: 1px solid rgba(23, 76, 56, .11);
    border-radius: 999px;
    box-shadow: 0 5px 16px rgba(16, 37, 29, .04);
    transition: transform .2s ease, box-shadow .2s ease,
        background .2s ease;
}

.pt-profile-link:hover {
    color: #174c38;
    background: #fff;
    box-shadow: 0 10px 24px rgba(16, 37, 29, .09);
    transform: translateY(-2px);
}

.pt-profile-avatar {
    position: relative;
    display: grid;
    place-items: center;
    width: 38px;
    height: 38px;
    flex: 0 0 38px;
    color: #fff;
    background: linear-gradient(145deg, #3ba66f, #174c38);
    border: 2px solid #fff;
    border-radius: 50%;
}

.pt-profile-avatar svg {
    width: 21px;
    height: 21px;
}

.pt-profile-online {
    position: absolute;
    right: -1px;
    bottom: 1px;
    width: 10px;
    height: 10px;
    background: #9be15d;
    border: 2px solid #fff;
    border-radius: 50%;
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
    color: #10251d;
    font-size: .82rem;
    font-weight: 800;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.pt-profile-copy span {
    margin-top: 4px;
    color: #50645a;
    font-size: .64rem;
    font-weight: 700;
    letter-spacing: .045em;
    text-transform: uppercase;
}

.pt-profile-chevron {
    width: 14px;
    height: 14px;
    color: #789087;
}

/* Keyboard accessibility */

.pt-site-header a:focus-visible,
.pt-site-header button:focus-visible {
    outline: 3px solid rgba(64, 164, 104, .4);
    outline-offset: 3px;
}

/* Responsive header */

@media (max-width: 700px) {
    .pt-header-inner {
        min-height: 72px;
        padding: 12px 16px;
    }

    .pt-navbar {
        gap: 10px;
    }

    .pt-brand {
        gap: 8px;
        font-size: .96rem;
    }

    .pt-logo {
        width: 38px;
        height: 38px;
        flex-basis: 38px;
    }

    .pt-brand-copy small {
        display: none;
    }

    .pt-nav-actions {
        gap: 7px;
    }

    .pt-nav-button {
        min-height: 40px;
        padding: 9px 11px;
        font-size: .8rem;
    }

    .pt-notification-link {
        width: 40px;
        height: 40px;
        flex-basis: 40px;
    }

    .pt-profile-link {
        min-height: 40px;
        padding: 4px;
    }

    .pt-profile-avatar {
        width: 32px;
        height: 32px;
        flex-basis: 32px;
    }

    .pt-profile-copy,
    .pt-profile-chevron {
        display: none;
    }
}

@media (max-width: 390px) {
    .pt-header-inner {
        padding-right: 10px;
        padding-left: 10px;
    }

    .pt-nav-actions {
        gap: 5px;
    }

    .pt-nav-button {
        padding: 8px;
        font-size: .76rem;
    }

    .pt-brand {
        font-size: .88rem;
    }
}

@media (prefers-reduced-motion: reduce) {
    .pt-site-header *,
    .pt-site-header *::before,
    .pt-site-header *::after {
        transition: none !important;
    }
}

CSS);
?>

<header class="pt-site-header">
    <div class="pt-header-inner">
        <nav class="pt-navbar" aria-label="Primary navigation">

            <?= Html::a(
                '<span class="pt-logo" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2.2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.5 3.5C13 3.4 6.7 6 5.3 12.5c-1 4.8 2.7 7.8 6.2 6.1 5-2.4 7.5-8.9 9-15.1Z"/>
                        <path d="M4 20c3.6-4.5 7.1-7.2 12.8-10.4"/>
                    </svg>
                </span>
                <span class="pt-brand-copy">
                    Purity Tracker
                    <small>One day at a time</small>
                </span>',
                ['/site/index'],
                [
                    'class' => 'pt-brand',
                    'encode' => false,
                    'aria-label' => 'Purity Tracker home',
                ]
            ) ?>

            <div class="pt-nav-actions">

                <?php if ($isGuest): ?>

                    <?= Html::a(
                        'About',
                        ['/site/about'],
                        ['class' => 'pt-nav-button pt-button-light']
                    ) ?>

                    <?= Html::a(
                        'Log in',
                        ['/site/login'],
                        ['class' => 'pt-nav-button pt-button-light']
                    ) ?>

                    <?= Html::a(
                        'Get started',
                        ['/site/signup'],
                        ['class' => 'pt-nav-button pt-button-primary']
                    ) ?>

                <?php else: ?>

                    <?= Html::a(
                        '<svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
                            <path d="M10 21h4"/>
                        </svg>' .
                        ($unreadNotificationCount > 0
                            ? '<span class="pt-notification-count">'
                                . (int) $unreadNotificationCount .
                              '</span>'
                            : ''),
                        ['/notification/index'],
                        [
                            'class' => 'pt-notification-link',
                            'encode' => false,
                            'aria-label' => 'Notifications',
                            'title' => 'Notifications',
                        ]
                    ) ?>

                    <?= Html::a(
                        '<span class="pt-profile-avatar" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21a8 8 0 0 0-16 0"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <span class="pt-profile-online"></span>
                        </span>
                        <span class="pt-profile-copy">
                            <strong>' . Html::encode($firstName ?: 'Account') . '</strong>
                            <span>Profile settings</span>
                        </span>
                        <svg class="pt-profile-chevron" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>',
                        ['/profile/index'],
                        [
                            'class' => 'pt-profile-link',
                            'encode' => false,
                            'aria-label' => 'Open profile settings',
                            'title' => 'Profile settings',
                        ]
                    ) ?>

                    <?= Html::beginForm(
                        ['/site/logout'],
                        'post',
                        ['class' => 'pt-logout-form']
                    ) ?>

                        <?= Html::submitButton(
                            'Log out',
                            ['class' => 'pt-nav-button pt-logout']
                        ) ?>

                    <?= Html::endForm() ?>

                <?php endif; ?>

            </div>
        </nav>
    </div>
</header>