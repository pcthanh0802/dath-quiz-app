<?php
    require_once "../quizApp/database.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../quizApp/assets/css/pages/play_quiz.css">
    <title>Play quiz</title>
</head>
<body>
    <script>
        function changeQuestion(isAnswer, point, quizID){
            window.location.href = `./index.php?page=play-quiz-processing&isAnswer=${isAnswer}&point=${point}&quizID=${quizID}`;
        }
    </script>

    <?php
        $quizID = $_GET['quizID'];
        $offset = $_SESSION['offset'];
        $sql = "SELECT quiz.name, question.content, question.point, question.timeLimit, question.media, option.content AS option, option.isAnswer
                FROM quiz JOIN question ON quiz.id = question.quizId JOIN option ON question.id = option.questionId
                WHERE quiz.id = \"$quizID\"
                LIMIT 4 OFFSET $offset";
        $res = $conn->query($sql);
        if(mysqli_num_rows($res)){
            $question = $res->fetch_all(MYSQLI_ASSOC);
    ?>
        <div class="container-play-quiz">
            <div class="question-box">
                <div class="question"><?=$question[0]['content']?></div>
            </div>
        
            <div class="question-body-box">
                <div class="question-body-countdown"></div>
                <div class="question-body-img" title="Question Image"></div>
            </div>
        
            <div class="options-box">
                <button type="button" id="optionA" onclick="changeQuestion(<?=$question[0]['isAnswer']?>, <?=$question[0]['point']?>, <?=$quizID?>)">
                    <span class="opt-icon">A.</span><span class="opt-desc"><?=$question[0]['option']?></span>
                </button>
                <button type="button" id="optionB" onclick="changeQuestion(<?=$question[1]['isAnswer']?>, <?=$question[1]['point']?>, <?=$quizID?>)">
                    <span class="opt-icon">B.</span><span class="opt-desc"><?=$question[1]['option']?></span>
                </button>
                <button type="button" id="optionC" onclick="changeQuestion(<?=$question[2]['isAnswer']?>, <?=$question[2]['point']?>, <?=$quizID?>)">
                    <span class="opt-icon">C.</span><span class="opt-desc"><?=$question[2]['option']?></span>
                </button>
                <button type="button" id="optionD" onclick="changeQuestion(<?=$question[3]['isAnswer']?>, <?=$question[3]['point']?>, <?=$quizID?>)">
                    <span class="opt-icon">D.</span><span class="opt-desc"><?=$question[3]['option']?></span>
                </button>
            </div>
        
            <div class="question-footer">
                <div class="question-footer-number"><?=0.25*$_SESSION['offset']+1?>/<?=$_SESSION['quest_num']?></div>
                <div class="question-footer-quiz-name"><?=$question[0]['name']?></div>
            </div>
            <input type="hidden" value="<?=$question[0]['timeLimit']?>" id="timer">
            <input type="hidden" value="<?=$quizID?>" id="quizID">
        </div>
    <?php } 
    else header("Location: ./index.php?page=result&quizID=$quizID");
    ?>
</body>
<script src="../quizApp/assets/js/pages/play_quiz.js" type="module" defer></script>
</html>