<?php
    session_start();
    require_once "../database.php";
    $creatorId = $_SESSION['userID'];
    $quizName = $_POST['quiz-name-create'];
    $quizDescription = $_POST['quiz-des-create'];
    $quizCategory = $_POST['quiz-category-create'];
    $sql = "INSERT INTO quiz(name, description, creatorId) VALUES('$quizName', '$quizDescription', '$creatorId')";
    $conn->query($sql);
    $sql = "SELECT MAX(id) AS id FROM quiz";
    $quizID = $conn->query($sql)->fetch_assoc()['id'];
    $sql = "INSERT INTO quiz_category VALUES('$quizID', '$quizCategory')";
    $conn->query($sql);
    for( $i=1;;$i++){
        if(array_key_exists("question-cont$i", $_POST)){
            $content = $_POST["question-cont$i"];
            $media = NULL;
            if(array_key_exists("question-img$i", $_POST)) $media = $_POST["question-img$i"];
            $point = $_POST["question-point$i"];
            $time = $_POST["question-time$i"];
            $optionA = $_POST["optionA$i"];
            $optionB = $_POST["optionB$i"];
            $optionC = $_POST["optionC$i"];
            $optionD = $_POST["optionD$i"];
            $CA = $_POST["CA$i"];
            $sql = "INSERT INTO question(content, point, timeLimit, media, quizId) VALUES('$content', '$point', '$time', '$media', '$quizID')";
            $conn->query($sql);
            $sql = "SELECT MAX(id) AS id FROM question";
            $questionID = $conn->query($sql)->fetch_assoc()['id'];
            if($CA == "A"){
                $sql = "INSERT INTO option(content, isAnswer, questionId) VALUES('$optionA', 1, '$questionID')";
                $conn->query($sql);
            }
            else{
                $sql = "INSERT INTO option(content, isAnswer, questionId) VALUES('$optionA', 0, '$questionID')";
                $conn->query($sql); 
            }
            if($CA == "B"){
                $sql = "INSERT INTO option(content, isAnswer, questionId) VALUES('$optionB', 1, '$questionID')";
                $conn->query($sql);
            }
            else{
                $sql = "INSERT INTO option(content, isAnswer, questionId) VALUES('$optionB', 0, '$questionID')";
                $conn->query($sql); 
            }
            if($CA == "C"){
                $sql = "INSERT INTO option(content, isAnswer, questionId) VALUES('$optionC', 1, '$questionID')";
                $conn->query($sql);
            }
            else{
                $sql = "INSERT INTO option(content, isAnswer, questionId) VALUES('$optionC', 0, '$questionID')";
                $conn->query($sql); 
            }
            if($CA == "D"){
                $sql = "INSERT INTO option(content, isAnswer, questionId) VALUES('$optionD', 1, '$questionID')";
                $conn->query($sql);
            }
            else{
                $sql = "INSERT INTO option(content, isAnswer, questionId) VALUES('$optionD', 0, '$questionID')";
                $conn->query($sql); 
            }
        }
        else break;
    }
    header("Location: ../index.php?page=owner_create_quiz");
?>