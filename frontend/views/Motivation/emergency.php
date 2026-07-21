<?php

use yii\helpers\Html;

$this->title = 'Emergency Help';
?>

<div class="container" style="max-width:900px; margin-top:40px; margin-bottom:50px;">

    <!-- Back Button -->
    <div class="mb-4">
        <?= Html::a(
            '← Back to Motivation Center',
            ['motivation/index'],
            ['class' => 'btn btn-outline-secondary']
        ) ?>
    </div>

    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1>🚨 Emergency Help</h1>

        <p class="text-muted">
            Take a pause. You are stronger than this moment.
        </p>
    </div>

    <!-- Reminder -->
    <div class="card app-card">

        <h3>💬 Remember</h3>

        <p>
            Urges come and go. They are temporary.
            You don't have to act on every thought.
            Give yourself time, breathe, and let this moment pass.
        </p>

    </div>

    <!-- Scripture -->
    <div class="card app-card">

        <h3>📖 Scripture</h3>

        <blockquote class="mb-2">
            "No temptation has overtaken you except what is common to mankind.
            And God is faithful; He will not let you be tempted beyond what you can bear."
        </blockquote>

        <small class="text-muted">
            — 1 Corinthians 10:13
        </small>

    </div>

    <!-- Timer -->
    <div class="card app-card text-center">

        <h3>⏱ 10 Minute Reset</h3>

        <p class="text-muted">
            Before making any decision, give yourself ten minutes.
        </p>

        <h1 id="countdown" style="font-size:60px;">
            10:00
        </h1>

        <button
            id="startTimer"
            class="btn btn-primary btn-lg">
            Start Timer
        </button>

        <div
            id="finishedMessage"
            class="alert alert-success mt-4"
            style="display:none;">

            🎉 Great job!

            You stayed present for ten minutes.
            Every minute you choose self-control makes you stronger.

        </div>

    </div>

    <!-- Prayer -->
    <div class="card app-card">

        <h3>🙏 Prayer</h3>

        <p>
            Father,

            Give me strength for this moment.

            Help me make one good decision at a time.

            Remind me that this feeling will pass.

            Amen.
        </p>

    </div>

</div>


<script>

const countdown = document.getElementById('countdown');
const startButton = document.getElementById('startTimer');
const finishedMessage = document.getElementById('finishedMessage');

startButton.addEventListener('click', function () {

    let timeLeft = 600; //600seconds=10minutes in JS

    //so users can't start multiple timers
    startButton.disabled = true;
    startButton.textContent="Timer Running...";

    //intervals for changing timer values
    const timer= setInterval(function() {
        timeLeft--;
     const minutes = Math.floor(timeLeft / 60); 
    const seconds = timeLeft % 60;


    countdown.textContent =
        `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

         //make interval at zero
    if(timeLeft<=0){
        clearInterval(timer);
        countdown.textContent="00:00";
        finishedMessage.style.display="block";
        startButton.textContent="Completed";
        startButton.classList.remove("btn-primary");
        startButton.classList.add("btn-success");
    }
        
    }, 1000);


});

</script>