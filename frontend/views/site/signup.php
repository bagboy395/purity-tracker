
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
        background: #3b7bd1;
     }
</style>
<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    

    <div class="row">
        
        <div class="col-lg-5" style="float:none; margin:0 auto;">
            <div style="
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:100vh;
            ">
            <div style="
              width:100%;
              max-width:420px;
              padding:30px;
              bord-radius:12px;
              box-shadow:0 10px 30px rgba(0,0,0,0.1);
              background:#fff;">

              <h1 style="text-align:center; margin-bottom:10px;"><?= Html::encode($this->title) ?></h1>

    <p style="text-align:center; margin-bottom:20px;">Please fill out the following fields to signup</p>

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

               <div class="auth-input">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
               </div>
                
               <div class="auth-input">
                <?= $form->field($model, 'email') ?>
                </div>

                <div class="auth-input">
                <?= $form->field($model, 'password')->passwordInput()?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Signup', [
                        'class' => 'auth-button', 
                        'name' => 'signup-button',
                    ]) ?>
                </div>

            <?php ActiveForm::end(); ?>
</div>
</div>
        </div>
    </div>
</div>
