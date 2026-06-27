

<?php

use yii\helpers\Html;
?>
<div class="text-end mb-3" style="margin-top:10px">
        <?=Html::beginForm(['/site/index'],'post')?>
        <?=Html::submitButton(
            'Home',
            ['class'=>'btn btn-outline-info']
        )?>
        <?= Html::endForm()?>
    </div>
<div class="container mt-5">
    
<h1> Purity Tracker Dashboard</h1>
<p> Your commitment journey starts here.</p>


 
<?php if($hasCheckedInToday):?>
    <div class="alert alert-sucess">
        You've already checked in today 👍
</div>
<?php else:?>
    <div class="alert alert-warning"> 
        You haven't checked in today yet ⚠
</div>
<?php endif; ?>

<div class="alert alert-info"> 
    Total Check-ins: <?=$totalCheckins?>
</div>


<?= Html::beginForm('index.php?r=checkin/create','post')?>

<?= Html::submitButton('I Conquered Today',
['class'=>'btn btn-primary']
)
?>

<?= Html::endForm()?> <br><br>

<h2>Current Streak:<?= $streak?> days 🔥</h2>

</div>

<div class="col-md-6 mb-3">
            <div class="card" style="padding:20px; border-radius:12px;">
                <h4 style="margin:0;">🏆 Best Streak</h4>
                <p style="font-size:22px; margin:0;">
                    <?= isset($longestStreak) ? $longestStreak : 0 ?>
                </p>
            </div>
        </div>

        
<h2>Your Check-ins 📆</h2>
<ul>
    <?php foreach ($checkins as $checkin):?>
        <li>
            <?= $checkin->checkin_date ?>
        </li>
        <?php endforeach;?>
</ul>

