<?php
    require_once "../quizApp/database.php";
    $_SESSION['point'] = 0;
    $id = $_GET['quizID'];
    $userID = $_SESSION['userID'];
    $sql = "SELECT COUNT(question.id) AS quest_num, SUM(question.point) AS total_point FROM quiz JOIN question ON quiz.id = question.quizId WHERE quiz.id = \"$id\"";
    $res = $conn->query($sql)->fetch_all(MYSQLI_ASSOC)[0];
    $_SESSION['total_point'] = $res['total_point'];
    $_SESSION['quest_num'] = $res['quest_num'];
    $_SESSION['offset'] = 0;
    $sql = "INSERT INTO play_attempt(playerId, quizId) VALUES('$userID', '$id')";
    $conn->query($sql);
    $sql = "SELECT playDateTime FROM play_attempt ORDER BY playDateTime DESC LIMIT 1";
    $_SESSION['playDateTime'] = $conn->query($sql)->fetch_assoc()['playDateTime'];
    header("Location: ./index.php?page=play_quiz&quizID=$id");
?>