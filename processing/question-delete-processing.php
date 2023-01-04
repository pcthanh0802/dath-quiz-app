<?php
    require_once "../database.php";
    $questionID = $_GET['questionID'];
    $quizID = $_GET['quizID'];
    $sql = "DELETE FROM question WHERE id = \"$questionID\"";
    $conn->query($sql);
    header("Location: ../index.php?page=edit_quiz&quizID=$quizID")
?>