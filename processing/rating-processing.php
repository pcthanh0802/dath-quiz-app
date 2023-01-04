<?php
    session_start();
    require_once "../database.php";
    $rating = $_GET['rating'];
    $userID = $_GET['userID'];
    $quizID = $_GET['quizID'];
    $sql = "INSERT INTO rating(playerId, quizId, rating) VALUES('$userID', '$quizID', '$rating')";
    $conn->query($sql);
?>