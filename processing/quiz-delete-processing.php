<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require_once "./database.php";
    $id = $_GET['quizID'];
    $sql="DELETE FROM quiz WHERE id = \"$id\"";
    $conn->query($sql);
    header("location: ./index.php?page=myQuiz");
}
?>