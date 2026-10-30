<?php



use yii\helpers\Html;



/** @var yii\web\View $this */

/** @var common\models\User $user */



$this->title = 'My Profile';



$usernameInitial = strtoupper(substr($user->username, 0, 1));

?>



<div class="profile-page">



    <!-- PAGE HEADER -->

    <div class="profile-heading">

        <div>

            <span class="profile-eyebrow">ACCOUNT</span>

            <h1>My Profile</h1>

            <p>Manage your account information and personal settings.</p>

        </div>

    </div>





    <!-- PROFILE HERO -->

    <div class="profile-hero">



        <div class="profile-avatar">

            <?= Html::encode($usernameInitial) ?>

        </div>



        <div class="profile-identity">

            <h2><?= Html::encode($user->username) ?></h2>

            <p><?= Html::encode($user->email) ?></p>



            <span class="account-badge">

                <span class="status-dot"></span>

                Active account

            </span>

        </div>



    </div>





    <!-- ACCOUNT INFORMATION -->

    <section class="profile-section">



        <div class="section-title">

            <div>

                <span class="section-eyebrow">PERSONAL</span>

                <h2>Account Information</h2>

                <p>Your basic account details.</p>

            </div>

        </div>





        <!-- USERNAME -->

        <div class="profile-field">



            <div class="field-icon" aria-hidden="true">

                <svg viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>

            </div>



            <div class="field-content">

                <span class="field-label">Username</span>

                <strong><?= Html::encode($user->username) ?></strong>

            </div>



            <button

                type="button"

                class="edit-button"

                onclick="openProfileModal('usernameModal')"

            >

                ✏️

            </button>



        </div>





        <!-- EMAIL -->

        <div class="profile-field">



            <div class="field-icon" aria-hidden="true">

                <svg viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="3"/><path d="m4 7 8 6 8-6"/></svg>

            </div>



            <div class="field-content">

                <span class="field-label">Email Address</span>

                <strong><?= Html::encode($user->email) ?></strong>

            </div>



            <button

                type="button"

                class="edit-button"

                onclick="openProfileModal('emailModal')"

            >

                ✏️

            </button>



        </div>





        <!-- ACCOUNT STATUS -->

        <div class="profile-field">



            <div class="field-icon" aria-hidden="true">

                <svg viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3 20 6v5c0 5-3.4 8.4-8 10-4.6-1.6-8-5-8-10V6l8-3Z"/><path d="m8.5 12 2.2 2.2 4.8-5"/></svg>

            </div>



            <div class="field-content">

                <span class="field-label">Account Status</span>



                <strong class="active-text">

                    <span class="status-dot"></span>

                    Active

                </strong>

            </div>



        </div>





        <!-- MEMBER SINCE -->

        <div class="profile-field">



            <div class="field-icon" aria-hidden="true">

                <svg viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="3"/><path d="M16 3v4M8 3v4M3 10h18"/></svg>

            </div>



            <div class="field-content">

                <span class="field-label">Member Since</span>



                <strong>

                    <?= Yii::$app->formatter->asDate($user->created_at) ?>

                </strong>

            </div>



        </div>



    </section>





    <!-- SECURITY -->

    <section class="profile-section">



        <div class="section-title">

            <div>

                <span class="section-eyebrow">SECURITY</span>

                <h2>Account Security</h2>

                <p>Keep your account protected.</p>

            </div>

        </div>



       <div

    class="profile-field clickable-field"

    onclick="openProfileModal('passwordModal')"

    role="button"

    tabindex="0"

    onkeydown="if(event.key === 'Enter' || event.key === ' ') { event.preventDefault(); openProfileModal('passwordModal'); }"

>



    <div class="field-icon" aria-hidden="true">

        <svg viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="11" rx="3"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/><circle cx="12" cy="15.5" r="1"/></svg>

    </div>



    <div class="field-content">

        <span class="field-label">Password</span>

        <strong>Change your password</strong>

    </div>



    <div class="field-arrow">

        →

    </div>



</div>



    </section>



    <!-- NOTIFICATION PREFERENCES -->

    <section class="profile-section" id="notification-preferences">



        <div class="section-title">

            <div>

                <span class="section-eyebrow">PREFERENCES</span>

                <h2>Notification Preferences</h2>

                <p>Choose which updates you'd like to receive.</p>

            </div>

        </div>



        <?php $form = \yii\widgets\ActiveForm::begin([

            'action' => ['index'],

            'method' => 'post',

            'options' => [

                'id' => 'notification-preferences-form',

            ],

        ]); ?>



        <?= Html::hiddenInput('formType', 'notifications') ?>



        <?php

        $notificationOptions = [

            'notifications_enabled' => [

                'title' => 'All Notifications',

                'description' => 'Enable or disable all notifications.',

            ],

            'achievement_notifications' => [

                'title' => 'Achievements',

                'description' => 'Get notified when you unlock achievements.',

            ],

            'goal_notifications' => [

                'title' => 'Goals',

                'description' => 'Receive updates about your personal goals.',

            ],

            'streak_notifications' => [

                'title' => 'Streak Updates',

                'description' => 'Stay informed about your abstinence streak.',

            ],

            'motivation_notifications' => [

                'title' => 'Motivation',

                'description' => 'Receive motivational updates and encouragement.',

            ],

            'scripture_notifications' => [

                'title' => 'Scripture',

                'description' => 'Receive updates related to Scripture.',

            ],

            'checkin_reminders' => [

                'title' => 'Daily Check-in Reminders',

                'description' => 'Get reminders to complete your daily check-in.',

            ],

        ];

        ?>



        <?php foreach ($notificationOptions as $field => $option): ?>

            <div class="profile-field notification-field">



                <div class="field-icon" aria-hidden="true">

                    <svg viewBox="0 0 24 24"

                         width="19" height="19"

                         fill="none"

                         stroke="currentColor"

                         stroke-width="1.8"

                         stroke-linecap="round"

                         stroke-linejoin="round">

                        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>

                        <path d="M10 21h4"/>

                    </svg>

                </div>



                <div class="field-content">

                    <strong><?= Html::encode($option['title']) ?></strong>

                    <span class="notification-description">

                        <?= Html::encode($option['description']) ?>

                    </span>

                </div>



                <label class="notification-switch">

                    <?= Html::checkbox(

                        'NotificationPreference[' . $field . ']',

                        (bool) $preferences->$field,

                        [

                            'value' => 1,

                            'uncheck' => null,

                            'class' => 'notification-checkbox',

                            'aria-label' => $option['title'],

                        ]

                    ) ?>

                    <span class="notification-slider"></span>

                </label>



            </div>

        <?php endforeach; ?>



        <?= Html::submitButton('Save Preferences', [

            'class' => 'modal-save notification-save',

        ]) ?>



        <?php \yii\widgets\ActiveForm::end(); ?>



    </section>



</div>





<!-- ========================================= -->

<!-- USERNAME MODAL -->







<div

    id="usernameModal"

    class="profile-modal"

    onclick="closeProfileModalOutside(event, 'usernameModal')"

>



    <div class="modal-card">



        <button

            type="button"

            class="modal-close"

            onclick="closeProfileModal('usernameModal')"

        >

            ×

        </button>



        <div class="modal-icon" aria-hidden="true">

            <svg viewBox="0 0 24 24" width="21" height="21" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>

        </div>



        <h2>Edit Username</h2>



        <p class="modal-description">

            Choose the username you want to use on your Purity Tracker account.

        </p>







        <?php $form = \yii\widgets\ActiveForm::begin([

    'action' => ['index'],

    'method' => 'post',

    'options' => [

        'id' => 'username-form',

    ],

]); ?>



<?= $form->field($model, 'username')

    ->textInput([

        'class' => 'modal-input',

        'value' => $user->username,

        'autocomplete' => 'username',

    ])

    ->label('Username', [

        'class' => 'modal-label',

    ])

?>



<?= Html::submitButton('Save Changes', [

    'class' => 'modal-save',

]) ?>



<?php \yii\widgets\ActiveForm::end(); ?>





    </div>



</div>





<!-- ========================================= -->

<!-- EMAIL MODAL -->

<!-- ========================================= -->



<div

    id="emailModal"

    class="profile-modal"

    onclick="closeProfileModalOutside(event, 'emailModal')"

>



    <div class="modal-card">



        <button

            type="button"

            class="modal-close"

            onclick="closeProfileModal('emailModal')"

        >

            ×

        </button>



        <div class="modal-icon" aria-hidden="true">

            <svg viewBox="0 0 24 24" width="21" height="21" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="3"/><path d="m4 7 8 6 8-6"/></svg>

        </div>



        <h2>Change Email</h2>



        <p class="modal-description">

            Update the email address associated with your account.

        </p>



        <?php $form = \yii\widgets\ActiveForm::begin([

    'action' => ['index'],

    'method' => 'post',

    'options' => [

        'id' => 'email-form',

    ],

]); ?>



<?= $form->field($model, 'email')

    ->input('email', [

        'class' => 'modal-input',

        'value' => $user->email,

        'autocomplete' => 'email',

    ])

    ->label('Email Address', [

        'class' => 'modal-label',

    ])

?>



<?= Html::submitButton('Save Changes', [

    'class' => 'modal-save',

]) ?>



<?php \yii\widgets\ActiveForm::end(); ?>



    </div>



</div>



<!-- ========================================= -->

<!-- PASSWORD MODAL -->

<!-- ========================================= -->



<div

    id="passwordModal"

    class="profile-modal"

    onclick="closeProfileModalOutside(event, 'passwordModal')"

>



    <div class="modal-card">



        <button

            type="button"

            class="modal-close"

            onclick="closeProfileModal('passwordModal')"

        >

            ×

        </button>



        <div class="modal-icon" aria-hidden="true">

            <svg viewBox="0 0 24 24" width="21" height="21" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="11" rx="3"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>

        </div>



        <h2>Change Password</h2>



        <p class="modal-description">

            Choose a new password to keep your Purity Tracker account secure.

        </p>



        <?php $form = \yii\widgets\ActiveForm::begin([

            'action' => ['index'],

            'method' => 'post',

            'options' => [

                'id' => 'password-form',

            ],

        ]); ?>



        <?= Html::hiddenInput('formType', 'password') ?>



        <?= $form->field($passwordModel, 'currentPassword')

            ->passwordInput([

                'class' => 'modal-input',

                'autocomplete' => 'current-password',

                'placeholder' => 'Enter your current password',

            ])

            ->label('Current Password', [

                'class' => 'modal-label',

            ])

        ?>



        <?= $form->field($passwordModel, 'newPassword')

            ->passwordInput([

                'class' => 'modal-input',

                'autocomplete' => 'new-password',

                'placeholder' => 'Enter your new password',

            ])

            ->label('New Password', [

                'class' => 'modal-label',

            ])

        ?>



        <?= $form->field($passwordModel, 'confirmPassword')

            ->passwordInput([

                'class' => 'modal-input',

                'autocomplete' => 'new-password',

                'placeholder' => 'Confirm your new password',

            ])

            ->label('Confirm New Password', [

                'class' => 'modal-label',

            ])

        ?>



        <?= Html::submitButton('Change Password', [

            'class' => 'modal-save',

        ]) ?>



        <?php \yii\widgets\ActiveForm::end(); ?>



    </div>



</div>





<style>

/* =========================================================

   PURITY TRACKER — PREMIUM PROFILE / SETTINGS

   ========================================================= */





/* Notification preferences — aligned with the existing profile sections */
#notification-preferences {
    margin-top: 0;
}

#notification-preferences .section-title {
    margin-bottom: 10px;
}

#notification-preferences .notification-intro {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin: 0 0 12px;
    padding: 14px 16px;
    background: #f2f8f4;
    border: 1px solid rgba(23, 76, 56, .08);
    border-radius: 15px;
}

#notification-preferences .notification-intro-icon {
    display: grid;
    place-items: center;
    flex: 0 0 38px;
    width: 38px;
    height: 38px;
    color: var(--profile-green);
    background: #e2f4e8;
    border-radius: 12px;
}

#notification-preferences .notification-intro strong {
    display: block;
    margin: 1px 0 3px;
    color: var(--profile-ink);
    font-size: .86rem;
    font-weight: 800;
}

#notification-preferences .notification-intro p {
    margin: 0;
    color: var(--profile-soft);
    font-size: .79rem;
    line-height: 1.5;
}

#notification-preferences .notification-field {
    gap: 14px;
    min-height: 72px;
    padding: 12px 4px;
}

#notification-preferences .notification-field:first-of-type {
    border-top: 0;
}

#notification-preferences .notification-field .field-icon {
    width: 40px;
    height: 40px;
    border-radius: 13px;
}

#notification-preferences .notification-field .field-content {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

#notification-preferences .notification-field .field-content strong {
    white-space: normal;
    font-size: .88rem;
}

#notification-preferences .notification-description {
    color: var(--profile-soft);
    font-size: .78rem;
    line-height: 1.45;
}

#notification-preferences .notification-switch {
    position: relative;
    display: inline-flex;
    flex: 0 0 auto;
    width: 44px;
    height: 25px;
    margin-left: 8px;
    cursor: pointer;
}

#notification-preferences .notification-checkbox {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
}

#notification-preferences .notification-slider {
    position: absolute;
    inset: 0;
    background: #d5ded8;
    border: 1px solid rgba(16, 37, 29, .05);
    border-radius: 999px;
    transition: background .2s ease;
}

#notification-preferences .notification-slider::before {
    position: absolute;
    top: 2px;
    left: 2px;
    width: 19px;
    height: 19px;
    content: "";
    background: #fff;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0, 0, 0, .13);
    transition: transform .2s ease;
}

#notification-preferences .notification-checkbox:checked + .notification-slider {
    background: var(--profile-green);
}

#notification-preferences .notification-checkbox:checked + .notification-slider::before {
    transform: translateX(19px);
}

#notification-preferences .notification-checkbox:focus-visible + .notification-slider {
    outline: 3px solid rgba(40, 126, 89, .25);
    outline-offset: 3px;
}

#notification-preferences .notification-save {
    width: auto;
    min-width: 190px;
    max-width: 100%;
    margin: 18px 0 22px;
    padding: 12px 20px;
}

@media (max-width: 480px) {
    #notification-preferences .notification-field {
        gap: 10px;
        padding: 12px 0;
    }

    #notification-preferences .notification-field .field-icon {
        width: 36px;
        height: 36px;
    }

    #notification-preferences .notification-description {
        font-size: .74rem;
    }

    #notification-preferences .notification-switch {
        width: 42px;
        height: 24px;
        margin-left: 2px;
    }

    #notification-preferences .notification-slider::before {
        width: 18px;
        height: 18px;
    }

    #notification-preferences .notification-checkbox:checked + .notification-slider::before {
        transform: translateX(18px);
    }

    #notification-preferences .notification-save {
        width: 100%;
    }
}


.profile-page,

.profile-page * {

    box-sizing: border-box;

}



.profile-page {

    --profile-ink: #10251d;

    --profile-soft: #61736b;

    --profile-forest: #174c38;

    --profile-green: #287e59;

    --profile-mint: #dff8e9;

    --profile-lime: #9be15d;

    --profile-cream: #f7fbf8;

    --profile-white: #ffffff;

    --profile-border: rgba(23, 76, 56, .10);



    width: 100vw;

    min-height: 100vh;

    margin-left: calc(50% - 50vw);

    padding: 34px clamp(20px, 6vw, 110px) 75px;

    color: var(--profile-ink);

    background:

        radial-gradient(circle at 7% 2%, rgba(155, 225, 93, .18), transparent 23rem),

        radial-gradient(circle at 94% 10%, rgba(52, 180, 122, .13), transparent 26rem),

        var(--profile-cream);

    font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;

}



.profile-page button,

.profile-page input {

    font: inherit;

}



/* Header */

.profile-heading {

    display: flex;

    align-items: flex-end;

    justify-content: space-between;

    max-width: 1080px;

    margin: 0 auto 24px;

}



.profile-heading > div {

    position: relative;

}



.profile-eyebrow,

.section-eyebrow {

    display: inline-flex;

    align-items: center;

    gap: 7px;

    margin-bottom: 8px;

    color: var(--profile-green);

    font-size: 10px;

    font-weight: 850;

    letter-spacing: .14em;

    text-transform: uppercase;

}



.profile-eyebrow::before,

.section-eyebrow::before {

    content: "";

    width: 6px;

    height: 6px;

    border-radius: 50%;

    background: var(--profile-lime);

    box-shadow: 0 0 0 4px rgba(155, 225, 93, .16);

}



.profile-heading h1 {

    margin: 0;

    color: var(--profile-ink);

    font-size: clamp(2rem, 4vw, 2.8rem);

    font-weight: 850;

    letter-spacing: -.06em;

    line-height: 1;

}



.profile-heading p {

    margin: 9px 0 0;

    color: var(--profile-soft);

    font-size: .94rem;

}



/* Main hero */

.profile-hero {

    position: relative;

    display: flex;

    align-items: center;

    gap: 24px;

    max-width: 1080px;

    min-height: 190px;

    margin: 0 auto 22px;

    padding: 32px;

    overflow: hidden;

    color: #fff;

    background:

        radial-gradient(circle at 88% 15%, rgba(155, 225, 93, .22), transparent 13rem),

        linear-gradient(135deg, #123d2d 0%, #174c38 48%, #287e59 100%);

    border: 1px solid rgba(255,255,255,.08);

    border-radius: 27px;

    box-shadow: 0 24px 55px rgba(19, 76, 54, .20);

}



.profile-hero::before,

.profile-hero::after {

    position: absolute;

    content: "";

    border: 1px solid rgba(255,255,255,.12);

    border-radius: 50%;

    pointer-events: none;

}



.profile-hero::before {

    width: 310px;

    height: 310px;

    right: -125px;

    top: -190px;

}



.profile-hero::after {

    width: 190px;

    height: 190px;

    right: 100px;

    bottom: -145px;

}



.profile-avatar {

    position: relative;

    z-index: 1;

    display: grid;

    place-items: center;

    width: 94px;

    height: 94px;

    flex: 0 0 auto;

    color: var(--profile-forest);

    background: linear-gradient(145deg, #ffffff 0%, #e6f8ec 100%);

    border: 5px solid rgba(255,255,255,.18);

    border-radius: 28px 28px 28px 9px;

    box-shadow:

        0 18px 35px rgba(0,0,0,.18),

        inset 0 1px 1px rgba(255,255,255,.9);

    font-size: 36px;

    font-weight: 850;

    letter-spacing: -.05em;

    transform: rotate(-3deg);

}



.profile-avatar::after {

    position: absolute;

    right: -5px;

    bottom: -5px;

    width: 17px;

    height: 17px;

    content: "";

    background: var(--profile-lime);

    border: 4px solid #1b5b40;

    border-radius: 50%;

    box-shadow: 0 4px 10px rgba(0,0,0,.18);

}



.profile-identity {

    position: relative;

    z-index: 1;

    min-width: 0;

}



.profile-identity h2 {

    margin: 0 0 6px;

    color: #fff;

    font-size: clamp(1.45rem, 3vw, 2rem);

    font-weight: 850;

    letter-spacing: -.045em;

}



.profile-identity p {

    margin: 0 0 14px;

    overflow: hidden;

    color: rgba(255,255,255,.70);

    font-size: .92rem;

    text-overflow: ellipsis;

    white-space: nowrap;

}



.account-badge {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 7px 12px;

    color: #dff8e9;

    background: rgba(255,255,255,.10);

    border: 1px solid rgba(255,255,255,.13);

    border-radius: 999px;

    font-size: .72rem;

    font-weight: 800;

    backdrop-filter: blur(8px);

}



.status-dot {

    width: 7px;

    height: 7px;

    display: inline-block;

    flex: 0 0 auto;

    border-radius: 50%;

    background: var(--profile-lime);

    box-shadow: 0 0 0 4px rgba(155,225,93,.13);

}



.active-text {

    display: flex;

    align-items: center;

    gap: 8px;

    color: var(--profile-green);

}



/* Settings sections */

.profile-section {

    max-width: 1080px;

    margin: 0 auto 20px;

    padding: 27px 30px 8px;

    background: rgba(255,255,255,.80);

    border: 1px solid var(--profile-border);

    border-radius: 24px;

    box-shadow: 0 14px 40px rgba(16,37,29,.055);

    backdrop-filter: blur(14px);

}



.section-title {

    margin-bottom: 7px;

}



.section-eyebrow {

    color: #789087;

}



.section-title h2 {

    margin: 0;

    color: var(--profile-ink);

    font-size: 1.2rem;

    font-weight: 830;

    letter-spacing: -.035em;

}



.section-title p {

    margin: 5px 0 18px;

    color: var(--profile-soft);

    font-size: .84rem;

}



/* Rows */

.profile-field {

    position: relative;

    display: flex;

    align-items: center;

    gap: 14px;

    min-height: 78px;

    padding: 13px 4px;

    border-top: 1px solid rgba(23,76,56,.08);

}



.field-icon {

    display: grid;

    place-items: center;

    width: 43px;

    height: 43px;

    flex: 0 0 auto;

    color: var(--profile-green);

    background: #edf8f1;

    border: 1px solid rgba(35,116,83,.08);

    border-radius: 14px;

    font-size: 17px;

}



.profile-field:nth-of-type(2) .field-icon {

    background: #f0f7ff;

    color: #3d7198;

}



.profile-field:nth-of-type(3) .field-icon {

    background: #fff7e6;

    color: #ad791b;

}



.profile-field:nth-of-type(4) .field-icon {

    background: #f1edff;

    color: #7655b7;

}



.field-content {

    flex: 1;

    min-width: 0;

}



.field-label {

    display: block;

    margin-bottom: 4px;

    color: #82918b;

    font-size: .70rem;

    font-weight: 800;

    letter-spacing: .04em;

    text-transform: uppercase;

}



.field-content strong {

    display: block;

    overflow: hidden;

    color: var(--profile-ink);

    font-size: .92rem;

    font-weight: 780;

    text-overflow: ellipsis;

    white-space: nowrap;

}



.edit-button {

    display: grid;

    place-items: center;

    width: 38px;

    height: 38px;

    flex: 0 0 auto;

    color: var(--profile-forest);

    background: #f4f8f5;

    border: 1px solid transparent;

    border-radius: 12px;

    cursor: pointer;

    font-size: 0;

    transition: transform .2s ease, background .2s ease, border-color .2s ease, box-shadow .2s ease;

}



.edit-button::after {

    content: "↗";

    font-size: 16px;

    font-weight: 800;

}



.edit-button:hover {

    color: #fff;

    background: var(--profile-green);

    border-color: var(--profile-green);

    box-shadow: 0 8px 18px rgba(35,116,83,.20);

    transform: translateY(-2px);

}



.clickable-field {

    cursor: pointer;

    transition: background .2s ease, padding .2s ease;

}



.clickable-field:hover {

    padding-left: 10px;

    padding-right: 10px;

    background: rgba(223,248,233,.32);

}



.field-arrow {

    color: #9aacA4;

    font-size: 21px;

    transition: transform .2s ease, color .2s ease;

}



.clickable-field:hover .field-arrow {

    color: var(--profile-green);

    transform: translateX(4px);

}



/* Modals */

.profile-modal {

    position: fixed;

    inset: 0;

    display: none;

    align-items: center;

    justify-content: center;

    padding: 20px;

    background: rgba(8, 30, 21, .58);

    backdrop-filter: blur(10px);

    z-index: 9999;

}



.profile-modal.active {

    display: flex;

}



.modal-card {

    position: relative;

    width: 100%;

    max-width: 450px;

    padding: 32px;

    overflow: hidden;

    background: rgba(255,255,255,.97);

    border: 1px solid rgba(255,255,255,.8);

    border-radius: 25px;

    box-shadow: 0 30px 90px rgba(5,35,23,.28);

    animation: modalIn .22s ease;

}



.modal-card::before {

    position: absolute;

    top: 0;

    right: 0;

    left: 0;

    height: 4px;

    content: "";

    background: linear-gradient(90deg, var(--profile-lime), var(--profile-green));

}



@keyframes modalIn {

    from {

        opacity: 0;

        transform: translateY(12px) scale(.975);

    }

    to {

        opacity: 1;

        transform: translateY(0) scale(1);

    }

}



.modal-close {

    position: absolute;

    top: 17px;

    right: 17px;

    display: grid;

    place-items: center;

    width: 34px;

    height: 34px;

    color: #65746d;

    background: #f2f7f3;

    border: 1px solid rgba(23,76,56,.07);

    border-radius: 50%;

    cursor: pointer;

    font-size: 21px;

    line-height: 1;

    transition: .2s ease;

}



.modal-close:hover {

    color: var(--profile-forest);

    background: var(--profile-mint);

    transform: rotate(90deg);

}



.modal-icon {

    display: grid;

    place-items: center;

    width: 50px;

    height: 50px;

    margin-bottom: 17px;

    color: var(--profile-green);

    background: var(--profile-mint);

    border: 1px solid rgba(35,116,83,.10);

    border-radius: 15px;

    font-size: 20px;

}



.modal-card h2 {

    margin: 0 0 7px;

    color: var(--profile-ink);

    font-size: 1.45rem;

    font-weight: 850;

    letter-spacing: -.04em;

}



.modal-description {

    margin: 0 0 23px;

    color: var(--profile-soft);

    font-size: .84rem;

    line-height: 1.6;

}



.profile-modal .form-group {

    margin-bottom: 15px;

}



.profile-modal .help-block {

    margin: 5px 0 10px;

    color: #dc2626;

    font-size: 12px;

}



.profile-modal .has-error .modal-input {

    border-color: #dc2626;

}



.modal-label {

    display: block;

    margin-bottom: 7px;

    color: var(--profile-ink);

    font-size: .76rem;

    font-weight: 800;

}



.modal-input {

    width: 100%;

    padding: 13px 14px;

    color: var(--profile-ink);

    background: #f9fcfa;

    border: 1px solid #dbe6df;

    border-radius: 12px;

    outline: none;

    font-size: .9rem;

    transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;

}



.modal-input:focus {

    background: #fff;

    border-color: var(--profile-green);

    box-shadow: 0 0 0 4px rgba(35,116,83,.10);

}



.modal-save {

    width: 100%;

    margin-top: 8px;

    padding: 13px 16px;

    color: #fff;

    background: linear-gradient(135deg, #287e59, #174c38);

    border: 0;

    border-radius: 12px;

    box-shadow: 0 10px 22px rgba(23,76,56,.18);

    cursor: pointer;

    font-size: .88rem;

    font-weight: 820;

    transition: transform .2s ease, box-shadow .2s ease;

}



.modal-save:hover {

    box-shadow: 0 14px 28px rgba(23,76,56,.25);

    transform: translateY(-1px);

}



/* Mobile */

@media (max-width: 700px) {

    .profile-page {

        padding: 27px 16px 55px;

    }



    .profile-heading {

        margin-bottom: 20px;

    }



    .profile-heading h1 {

        font-size: 2rem;

    }



    .profile-hero {

        min-height: 0;

        padding: 25px;

        border-radius: 22px;

    }



    .profile-avatar {

        width: 76px;

        height: 76px;

        border-radius: 23px 23px 23px 8px;

        font-size: 30px;

    }



    .profile-identity h2 {

        font-size: 1.35rem;

    }



    .profile-section {

        padding: 23px 21px 7px;

        border-radius: 20px;

    }

}



@media (max-width: 480px) {

    .profile-hero {

        align-items: flex-start;

        gap: 17px;

        padding: 21px;

    }



    .profile-avatar {

        width: 64px;

        height: 64px;

        border-width: 4px;

        border-radius: 19px 19px 19px 7px;

        font-size: 25px;

    }



    .profile-avatar::after {

        width: 14px;

        height: 14px;

        border-width: 3px;

    }



    .profile-identity h2 {

        font-size: 1.15rem;

    }



    .profile-identity p {

        max-width: 210px;

        margin-bottom: 10px;

        font-size: .78rem;

    }



    .profile-field {

        gap: 11px;

        min-height: 70px;

    }



    .field-icon {

        width: 39px;

        height: 39px;

        border-radius: 12px;

        font-size: 15px;

    }



    .field-content strong {

        font-size: .84rem;

    }



    .edit-button {

        width: 35px;

        height: 35px;

    }



    .modal-card {

        padding: 28px 21px 23px;

        border-radius: 21px;

    }

}



@media (prefers-reduced-motion: reduce) {

    .profile-page *,

    .profile-page *::before,

    .profile-page *::after {

        transition-duration: .01ms !important;

        animation-duration: .01ms !important;

    }

}

</style>





<script>



function openProfileModal(modalId) {

    const modal = document.getElementById(modalId);



    if (modal) {

        modal.classList.add('active');

        document.body.style.overflow = 'hidden';

    }

}



function closeProfileModal(modalId) {

    const modal = document.getElementById(modalId);



    if (modal) {

        modal.classList.remove('active');

        document.body.style.overflow = '';

    }

}



function closeProfileModalOutside(event, modalId) {

    if (event.target.id === modalId) {

        closeProfileModal(modalId);

    }

}



document.addEventListener('keydown', function (event) {



    if (event.key === 'Escape') {



        document.querySelectorAll('.profile-modal.active')

            .forEach(function (modal) {



                modal.classList.remove('active');



            });



        document.body.style.overflow = '';

    }



});



</script>
