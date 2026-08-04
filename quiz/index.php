<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/quiz.css">
</head>

<body>

<?php include("../includes/header.php"); ?>
<?php include("../includes/navigation.php"); ?>

<main>
<div><h1>Quiz Domain</h1></div>

<!--
Introduction to the quiz section of the website
-->
<p>
    Welcome to the quiz section of this website. Here, you will be tested on the profound knowledge
    you have accumulated throughout your journey of learning everything there is to know about 
    the Wildlife. Are you brave enough to accept this challenge and earn your place among the Wildlife 
    experts? 
</p>

<br>
<hr>
<br>

<!--
Alerting users to login/register before partaking in
the quiz
-->
<p style="text-align: center;">
    <strong>If you wish to partake in our quiz, please login(or register for newcomers) before proceeding.</strong>
</p>

<br>

<article>

<!--
Displaying the topics available for users to quiz
themselves on
-->
<section>
<div id="Topic1" class="QuizTopic">
<a href="javascript:void(0)" id="africanLion">
<img src="../images/AfricanLion.jpg" alt="A picture of African Lion" class="animal">
<p>Topic 1: African Lion</p>
</a>
</div>


<div id="Topic2" class="QuizTopic">
<a href="javascript:void(0)" id="orangUtan">
<img src="../images/OrangUtan.jpg" alt="A picture of Orang Utan" class="animal">
<p>Topic 2: Orang Utan</p>
</a>
</div>

<div id="Topic3" class="QuizTopic">
<a href="javascript:void(0)" id="penguin">
<img src="../images/Penguin.jpeg" alt="A picture of Penguin" class="animal">
<p>Topic 3: Penguin</p>
</a>
</div>

<div id="Topic4" class="QuizTopic">
<a href="javascript:void(0)" id="tiger">
<img src="../images/tiger.jpg" alt="A picture of Tiger" class="animal">
<p>Topic 4: Tiger</p>
</a>
</div>

<div id="Topic5" class="QuizTopic">
<a href="javascript:void(0)" id="giantPanda">
<img src="../images/panda.jpg" alt="A picture of Giant Panda" class="animal">
<p>Topic 5: Giant Panda</p>
</a>
</div>

<div id="Topic6" class="QuizTopic">
<a href="javascript:void(0)" id="raccoon">
<img src="../images/raccoon.jpg" alt="A picture of Raccoon" class="animal">
<p>Topic 6: Raccoon</p>
</a>
</div>

<div id="Topic7" class="QuizTopic">
<a href="javascript:void(0)" id="snowLeopard">
<img src="../images/SnowLeopard.jpg" alt="A picture of Snow Leopard" class="animal">
<p>Topic 7: Snow Leopard</p>
</a>
</div>

<div id="Topic8" class="QuizTopic">
<a href="javascript:void(0)" id="polarBear">
<img src="../images/PolarBear.jpg" alt="A picture of Polar Bear" class="animal">
<p>Topic 8: Polar Bear</p>
</a>
</div>

<div id="Topic9" class="QuizTopic">
<a href="javascript:void(0)" id="lynx">
<img src="../images/lynx.jpg" alt="A picture of Lynx" class="animal">
<p>Topic 9: Lynx</p>
</a>
</div>

<div id="Topic10" class="QuizTopic">
<a href="javascript:void(0)" id="cheetah">
<img src="../images/cheetah.jpg" alt="A picture of Cheetah" class="animal">
<p>Topic 10: Cheetah</p>
</a>
</div>
</section>

</article>

</main>

<?php include("../includes/footer.php"); ?>

<script src="../js/script.js"></script>
<script src="../js/quiz.js"></script>

</body>
</html>