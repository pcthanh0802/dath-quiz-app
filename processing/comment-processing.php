<?php
    require_once "../database.php";
    $userID = $_GET['userID'];
    $quizID = $_GET['quizID'];
    $comment = $_POST['comment'];
    $sql = "INSERT INTO comment(content, playerId, quizId) VALUES('$comment', '$userID', '$quizID')";
    $conn->query($sql);
    header("Location: ../index.php?page=player_view_quiz&quizID=$quizID");
?>