<?php
    session_start();
    require_once "../database.php";
    $quizID = $_GET['quizID'];
    $quizName = $_POST['quiz-name-create'];
    $quizDescription = $_POST['quiz-des-create'];
    $quizCategory = $_POST['quiz-category-create'];
    $sql = "UPDATE quiz 
            SET quiz.name = \"$quizName\", quiz.description = \"$quizDescription\"
            WHERE quiz.id = \"$quizID\"";
    $conn->query($sql);
    $sql = "UPDATE quiz_category
            SET quiz_category.category = \"$quizCategory\"
            WHERE quiz_category.quizId = \"$quizID\"";
    $conn->query($sql);
    for($i=1;;$i++){
        if(array_key_exists("questionID$i", $_POST)){
            $questionID = $_POST["questionID$i"];
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
            if($questionID){
                $sql = "UPDATE question
                    SET content = \"$content\", media = \"$media\", point = \"$point\", timeLimit = \"$time\"
                    WHERE question.id = \"$questionID\"";
                $conn->query($sql);
                $sql = "SELECT id FROM option WHERE option.questionId = \"$questionID\"";
                $optionID = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
                if($CA == "A"){
                    $sql = "UPDATE option SET content = \"$optionA\", isAnswer = 1 WHERE option.id = \"".$optionID[0]['id']."\"";
                    $conn->query($sql);
                }
                else{
                    $sql = "UPDATE option SET content = \"$optionA\", isAnswer = 0 WHERE option.id = \"".$optionID[0]['id']."\"";
                    $conn->query($sql);
                }
                if($CA == "B"){
                    $sql = "UPDATE option SET content = \"$optionB\", isAnswer = 1 WHERE option.id = \"".$optionID[1]['id']."\"";
                    $conn->query($sql);
                }
                else{
                    $sql = "UPDATE option SET content = \"$optionB\", isAnswer = 0 WHERE option.id = \"".$optionID[1]['id']."\"";
                    $conn->query($sql);
                }
                if($CA == "C"){
                    $sql = "UPDATE option SET content = \"$optionC\", isAnswer = 1 WHERE option.id = \"".$optionID[2]['id']."\"";
                    $conn->query($sql);
                }
                else{
                    $sql = "UPDATE option SET content = \"$optionC\", isAnswer = 0 WHERE option.id = \"".$optionID[2]['id']."\"";
                    $conn->query($sql);
                }
                if($CA == "D"){
                    $sql = "UPDATE option SET content = \"$optionD\", isAnswer = 1 WHERE option.id = \"".$optionID[3]['id']."\"";
                    $conn->query($sql);
                }
                else{
                    $sql = "UPDATE option SET content = \"$optionD\", isAnswer = 0 WHERE option.id = \"".$optionID[3]['id']."\"";
                    $conn->query($sql);
                }
            }
            else{
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
        }
        else break;
    }
    header("Location: ../index.php?page=edit_quiz&quizID=$quizID");
?>