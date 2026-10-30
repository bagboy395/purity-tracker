

<?php



use yii\helpers\Html;



/** @var common\models\Notification[] $notifications */



$this->title = 'Notifications';



$unreadCount = 0;



foreach ($notifications as $notification) {

    if (!$notification->is_read) {

        $unreadCount++;

    }

}



?>



<style>

    .pt-notifications-page,

    .pt-notifications-page * {

        box-sizing: border-box;

    }



    .pt-notifications-page {

        --nt-ink: #10251d;

        --nt-muted: #61736b;

        --nt-forest: #174c38;

        --nt-green: #237453;

        --nt-mint: #dff8e9;

        --nt-lime: #9be15d;

        --nt-cream: #f7fbf8;

        --nt-border: rgba(23, 76, 56, .10);

        /* Break out of Yii's centered content container so the background spans the viewport. */
        position: relative;
        left: 50%;
        width: 100vw;
        max-width: none;
        min-height: 100vh;
        margin-left: -50vw;
        padding: 42px clamp(20px, 6vw, 100px) 80px;
        color: var(--nt-ink);
        background:
            radial-gradient(circle at 5% 3%, rgba(155, 225, 93, .18), transparent 23rem),
            radial-gradient(circle at 96% 12%, rgba(52, 180, 122, .12), transparent 25rem),
            var(--nt-cream);

        font-family: Inter, ui-sans-serif, system-ui, -apple-system,

            BlinkMacSystemFont, "Segoe UI", sans-serif;

    }



    .pt-notifications-inner {

        width: 100%;

        max-width: 1000px;

        margin: 0 auto;

    }



    .pt-notifications-topline {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 16px;

        margin-bottom: 30px;

    }



    .pt-notifications-back {

        display: inline-flex;

        align-items: center;

        gap: 9px;

        color: var(--nt-muted);

        font-size: .88rem;

        font-weight: 750;

        text-decoration: none;

        transition: color .2s ease, transform .2s ease;

    }



    .pt-notifications-back:hover {

        color: var(--nt-forest);

        transform: translateX(-3px);

        text-decoration: none;

    }



    .pt-notifications-back svg {

        width: 18px;

        height: 18px;

    }



    .pt-notifications-eyebrow {

        display: inline-flex;

        align-items: center;

        gap: 8px;

        margin-bottom: 12px;

        color: var(--nt-green);

        font-size: .72rem;

        font-weight: 850;

        letter-spacing: .13em;

        text-transform: uppercase;

    }



    .pt-notifications-eyebrow::before {

        content: "";

        width: 7px;

        height: 7px;

        background: var(--nt-lime);

        border-radius: 50%;

        box-shadow: 0 0 0 4px rgba(155, 225, 93, .17);

    }



    .pt-notifications-heading {

        display: flex;

        align-items: flex-end;

        justify-content: space-between;

        gap: 24px;

        margin-bottom: 30px;

    }



    .pt-notifications-heading h1 {

        margin: 0;

        color: var(--nt-ink);

        font-size: clamp(2.2rem, 5vw, 3.4rem);

        font-weight: 850;

        letter-spacing: -.065em;

        line-height: 1.04;

    }



    .pt-notifications-heading p {

        max-width: 460px;

        margin: 12px 0 0;

        color: var(--nt-muted);

        font-size: .98rem;

        line-height: 1.7;

    }



    .pt-notifications-summary {

        display: flex;

        align-items: center;

        gap: 12px;

        flex: 0 0 auto;

        padding: 13px 17px;

        background: rgba(255, 255, 255, .76);

        border: 1px solid var(--nt-border);

        border-radius: 17px;

        box-shadow: 0 8px 24px rgba(16, 37, 29, .04);

    }



    .pt-notifications-summary-icon {

        display: grid;

        place-items: center;

        width: 42px;

        height: 42px;

        color: var(--nt-forest);

        background: var(--nt-mint);

        border-radius: 13px;

    }



    .pt-notifications-summary-icon svg {

        width: 21px;

        height: 21px;

    }



    .pt-notifications-summary strong {

        display: block;

        color: var(--nt-ink);

        font-size: 1.15rem;

        font-weight: 850;

        line-height: 1.2;

    }



    .pt-notifications-summary span {

        display: block;

        margin-top: 3px;

        color: var(--nt-muted);

        font-size: .73rem;

        font-weight: 700;

    }



    .pt-notifications-panel {

        overflow: hidden;

        background: rgba(255, 255, 255, .86);

        border: 1px solid rgba(23, 76, 56, .09);

        border-radius: 25px;

        box-shadow: 0 20px 55px rgba(19, 66, 46, .075);

        backdrop-filter: blur(12px);

    }



    .pt-notifications-panel-header {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 16px;

        padding: 23px 27px;

        border-bottom: 1px solid var(--nt-border);

    }



    .pt-notifications-panel-header h2 {

        margin: 0;

        color: var(--nt-ink);

        font-size: 1rem;

        font-weight: 850;

        letter-spacing: -.02em;

    }



    .pt-notifications-panel-header p {

        margin: 5px 0 0;

        color: var(--nt-muted);

        font-size: .82rem;

    }



    .pt-notifications-live-count {

        display: inline-flex;

        align-items: center;

        gap: 7px;

        padding: 7px 11px;

        color: var(--nt-green);

        background: #edf9f1;

        border: 1px solid rgba(35, 116, 83, .10);

        border-radius: 999px;

        font-size: .73rem;

        font-weight: 800;

        white-space: nowrap;

    }



    .pt-notifications-live-count::before {

        content: "";

        width: 6px;

        height: 6px;

        background: var(--nt-green);

        border-radius: 50%;

    }



    .pt-notification-item {

        position: relative;

        display: flex;

        align-items: flex-start;

        gap: 17px;

        padding: 23px 27px;

        border-bottom: 1px solid rgba(23, 76, 56, .075);

        transition: background .2s ease;

    }



    .pt-notification-item:last-child {

        border-bottom: 0;

    }



    .pt-notification-item:hover {

        background: rgba(247, 251, 248, .8);

    }



    .pt-notification-item.is-unread {

        background: linear-gradient(90deg, rgba(223, 248, 233, .48), rgba(255, 255, 255, .35));

    }



    .pt-notification-icon {

        display: grid;

        place-items: center;

        width: 46px;

        height: 46px;

        flex: 0 0 46px;

        color: var(--nt-forest);

        background: var(--nt-mint);

        border: 1px solid rgba(35, 116, 83, .08);

        border-radius: 15px;

    }



    .pt-notification-icon svg {

        width: 21px;

        height: 21px;

    }



    .pt-notification-content {

        min-width: 0;

        flex: 1;

    }



    .pt-notification-title-row {

        display: flex;

        align-items: center;

        flex-wrap: wrap;

        gap: 9px;

        margin: 1px 0 7px;

    }



    .pt-notification-title {

        margin: 0;

        color: var(--nt-ink);

        font-size: .98rem;

        font-weight: 820;

        letter-spacing: -.02em;

        overflow-wrap: anywhere;

    }



    .pt-notification-new {

        display: inline-flex;

        align-items: center;

        padding: 4px 8px;

        color: var(--nt-green);

        background: #e5f8eb;

        border-radius: 999px;

        font-size: .64rem;

        font-weight: 850;

        letter-spacing: .04em;

        text-transform: uppercase;

    }



    .pt-notification-message {

        margin: 0;

        color: #52665c;

        font-size: .9rem;

        line-height: 1.75;

        overflow-wrap: anywhere;

    }



    .pt-notification-date {

        display: inline-flex;

        align-items: center;

        gap: 6px;

        margin-top: 12px;

        color: #84938b;

        font-size: .73rem;

        font-weight: 650;

    }



    .pt-notification-date svg {

        width: 14px;

        height: 14px;

    }



    .pt-notification-status {

        width: 8px;

        height: 8px;

        flex: 0 0 8px;

        margin-top: 7px;

        background: var(--nt-green);

        border-radius: 50%;

        box-shadow: 0 0 0 4px rgba(35, 116, 83, .09);

    }



    .pt-notifications-empty {

        padding: 65px 25px 72px;

        text-align: center;

    }



    .pt-notifications-empty-icon {

        display: grid;

        place-items: center;

        width: 76px;

        height: 76px;

        margin: 0 auto 22px;

        color: var(--nt-forest);

        background: linear-gradient(145deg, #e8faee, #d5f2df);

        border: 1px solid rgba(35, 116, 83, .08);

        border-radius: 25px;

        box-shadow: 0 12px 30px rgba(23, 76, 56, .08);

    }



    .pt-notifications-empty-icon svg {

        width: 33px;

        height: 33px;

    }



    .pt-notifications-empty h3 {

        margin: 0 0 9px;

        color: var(--nt-ink);

        font-size: 1.35rem;

        font-weight: 850;

        letter-spacing: -.04em;

    }



    .pt-notifications-empty p {

        max-width: 360px;

        margin: 0 auto;

        color: var(--nt-muted);

        font-size: .9rem;

        line-height: 1.75;

    }



    .pt-notifications-empty a {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        gap: 9px;

        margin-top: 25px;

        padding: 13px 19px;

        color: #fff;

        background: linear-gradient(135deg, #287e59, #174c38);

        border-radius: 13px;

        box-shadow: 0 9px 22px rgba(23, 76, 56, .17);

        font-size: .85rem;

        font-weight: 800;

        text-decoration: none;

        transition: transform .2s ease, box-shadow .2s ease;

    }



    .pt-notifications-empty a:hover {

        color: #fff;

        box-shadow: 0 13px 28px rgba(23, 76, 56, .23);

        transform: translateY(-2px);

    }



    .pt-notifications-footer {

        display: flex;

        align-items: center;

        justify-content: center;

        gap: 8px;

        margin-top: 22px;

        color: #84938b;

        font-size: .76rem;

        text-align: center;

    }



    .pt-notifications-footer svg {

        width: 15px;

        height: 15px;

        color: var(--nt-green);

    }



    @media (max-width: 700px) {

        .pt-notifications-page {

            padding: 28px 16px 55px;

        }



        .pt-notifications-topline {

            margin-bottom: 27px;

        }



        .pt-notifications-heading {

            align-items: flex-start;

            flex-direction: column;

            gap: 20px;

            margin-bottom: 24px;

        }



        .pt-notifications-heading h1 {

            font-size: clamp(2.15rem, 9vw, 3rem);

        }



        .pt-notifications-summary {

            width: 100%;

        }



        .pt-notifications-panel {

            border-radius: 20px;

        }



        .pt-notifications-panel-header {

            padding: 19px;

        }



        .pt-notification-item {

            gap: 12px;

            padding: 20px 17px;

        }



        .pt-notification-icon {

            width: 40px;

            height: 40px;

            flex-basis: 40px;

            border-radius: 13px;

        }



        .pt-notification-title {

            font-size: .91rem;

        }



        .pt-notification-message {

            font-size: .85rem;

        }



        .pt-notification-status {

            display: none;

        }



        .pt-notifications-empty {

            padding: 48px 20px 53px;

        }

    }



    @media (prefers-reduced-motion: reduce) {

        .pt-notifications-page *,

        .pt-notifications-page *::before,

        .pt-notifications-page *::after {

            transition: none !important;

        }

    }

</style>



<div class="pt-notifications-page">

    <div class="pt-notifications-inner">



        <div class="pt-notifications-topline">

            <div class="pt-notifications-eyebrow">

                Your personal space

            </div>



            <?= Html::a(

                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/><path d="M9 12h12"/></svg> Back to dashboard',

                ['/site/index'],

                ['class' => 'pt-notifications-back', 'encode' => false]

            ) ?>

        </div>



        <div class="pt-notifications-heading">

            



           

        </div>



        <section class="pt-notifications-panel" aria-label="Your notifications">



            <div class="pt-notifications-panel-header">

                <div>

                    <h2>Recent activity</h2>

                    <p>Your latest updates, all in one place.</p>

                </div>



                <span class="pt-notifications-live-count">

                    <?= $unreadCount ?> unread

                </span>

            </div>



            <?php if (empty($notifications)): ?>



                <div class="pt-notifications-empty">

                    <div class="pt-notifications-empty-icon">

                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">

                            <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>

                            <path d="M10 21h4"/>

                        </svg>

                    </div>



                    <h3>It's quiet for now.</h3>



                    <p>

                        No notifications yet. Keep showing up for yourself.

                        Your milestones and updates will find their way here.

                    </p>



                    <?= Html::a(

                        'Return to your dashboard <span aria-hidden="true">→</span>',

                        ['/site/index'],

                        ['encode' => false]

                    ) ?>

                </div>



            <?php else: ?>



                <?php foreach ($notifications as $notification): ?>



                    <article class="pt-notification-item <?= !$notification->is_read ? 'is-unread' : '' ?>">



                        <div class="pt-notification-icon" aria-hidden="true">

                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">

                                <?php if (in_array($notification->type, ['achievement', 'streak'], true)): ?>

                                    <path d="m12 3 2.7 5.5 6.1.9-4.4 4.3 1 6.1-5.4-2.9-5.4 2.9 1-6.1-4.4-4.3 6.1-.9L12 3Z"/>

                                <?php elseif ($notification->type === 'goal'): ?>

                                    <circle cx="12" cy="12" r="9"/>

                                    <circle cx="12" cy="12" r="5"/>

                                    <circle cx="12" cy="12" r="1"/>

                                <?php elseif ($notification->type === 'scripture'): ?>

                                    <path d="M12 7v14"/>

                                    <path d="M5 3h14v18H5z"/>

                                    <path d="M9 7h6M9 11h6"/>

                                <?php elseif ($notification->type === 'motivation'): ?>

                                    <path d="M12 3v3M12 18v3M3 12h3M18 12h3"/>

                                    <path d="m5.6 5.6 2.1 2.1m8.6 8.6 2.1 2.1m0-12.8-2.1 2.1m-8.6 8.6-2.1 2.1"/>

                                    <circle cx="12" cy="12" r="4"/>

                                <?php else: ?>

                                    <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>

                                    <path d="M10 21h4"/>

                                <?php endif; ?>

                            </svg>

                        </div>



                        <div class="pt-notification-content">

                            <div class="pt-notification-title-row">

                                <h3 class="pt-notification-title">

                                    <?= Html::encode($notification->title) ?>

                                </h3>



                                <?php if (!$notification->is_read): ?>

                                    <span class="pt-notification-new">New</span>

                                <?php endif; ?>

                            </div>



                            <p class="pt-notification-message">

                                <?= nl2br(Html::encode($notification->message)) ?>

                            </p>



                            <time class="pt-notification-date">

                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">

                                    <circle cx="12" cy="12" r="9"/>

                                    <path d="M12 7v5l3 2"/>

                                </svg>



                                <?= Yii::$app->formatter->asDatetime(

                                    $notification->created_at,

                                    'php:M j, Y · g:i A'

                                ) ?>

                            </time>

                        </div>



                        <?php if (!$notification->is_read): ?>

                            <span class="pt-notification-status" aria-label="Unread"></span>

                        <?php endif; ?>



                    </article>



                <?php endforeach; ?>



            <?php endif; ?>



        </section>



        <div class="pt-notifications-footer">

            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">

                <path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11Z"/>

                <path d="m9 12 2 2 4-4"/>

            </svg>

            Every small step forward matters.

        </div>



    </div>

</div>
