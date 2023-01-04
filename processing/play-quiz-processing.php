<?php
    require_once "../quizApp/database.php";
    $quizID = $_GET['quizID'];
    $isAnswer = $_GET['isAnswer'];
    $point = $_GET['point'];
    if($isAnswer) $_SESSION['point']+=$point;
    $_SESSION['offset']+=4;
    header("Location: ./index.php?page=play_quiz&quizID=$quizID");
?>