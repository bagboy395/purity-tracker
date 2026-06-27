
<style>
     .auth-input input{
        border-radius: 10px;
        padding:12px;
        border: 1px solid #ddd;
     }
     .auth-input input:focus {
        border-color: #4a90e2;
        box-shadow: 0 0 0 2px rgba(74,144,226,0.15);
        outline:none;
     }
     .auth-button {
        width:100%;
        padding: 12px;
        border-radius: 10px;
        border: none;
        background: #4a90e2;
        color:#fff;
        font-weight: 500;
        transition: 0.2s ease;
     }
     .auth-button:hover {
        background: #216fd5;
     }
</style>

<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <div class="row">
        <div class="col-lg-5" style="float:none; margin:0 auto;">
            <div style="
            background:#fff;
            padding:30px;
            border-radius:12px;
            box-shadow:0 10px 30px rgba(0,0,0,0.1);">

            <h3 style="text-align:center; margin-bottom:10px;">Welcome Back</h3>
             <p style="text-align:center; margin-bottom:20px">Please fill out the following fields to login</p>

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <div class="auth-input">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
            </div>

            <div class="auth-input">
                <?= $form->field($model, 'password')->passwordInput() ?>
            </div>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="my-1 mx-0" style="color:#999;">
                    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                    <br>
                    Need new verification email? <?= Html::a('Resend', ['site/resend-verification-email']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Login', [
                    'class' => 'auth-button', 
                    'name' => 'login-button',
                    ]) ?>
                </div>

            <?php ActiveForm::end(); ?>
          </div>
        </div>
    </div>
</div>
