<?php
    require_once "../quizApp/database.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../quizApp/assets/css/pages/owner_view_quiz.css">
    <title>Quiz overview</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
</head>

<?php
    $quizID = $_GET['quizID'];
    $sql = "SELECT * FROM quiz JOIN account ON quiz.creatorId = account.id WHERE quiz.id = \"$quizID\"";
    $overview = $conn->query($sql)->fetch_assoc();
    $sql = "SELECT * FROM quiz JOIN quiz_category ON quiz_category.quizId = quiz.id WHERE quiz.id = \"$quizID\"";
    $category = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    $sql = "SELECT COUNT(play_attempt.id) AS play_attempt, MAX(score) AS max_score  
            FROM quiz LEFT JOIN play_attempt ON quizId = quiz.id JOIN account ON account.id = quiz.creatorId 
            WHERE quiz.id = \"$quizID\"
            GROUP BY quizId";
    $analytic = $conn->query($sql)->fetch_assoc();
    $sql = "SELECT question.content, question.point, question.timeLimit, question.media, option.content AS option, option.isAnswer
            FROM quiz JOIN question ON quiz.id = question.quizId JOIN option ON question.id = option.questionId
            WHERE quiz.id = \"$quizID\"";
    $question = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    $sql = "SELECT SUM(question.point) AS total_score, COUNT(question.id) AS question_num
            FROM quiz JOIN question ON quiz.id = question.quizId
            WHERE quiz.id = \"$quizID\"
            GROUP BY quiz.id";
    $question_info = $conn->query($sql)->fetch_assoc();
    $sql = "SELECT AVG(rating) AS rating FROM rating WHERE rating.quizId = \"$quizID\"";
    $rating = $conn->query($sql)->fetch_assoc();
?>

<body>

    <div class="quiz-info-block">
        <div class="quiz-info-block-1">
        <div class="quiz-name"><?=$overview['name']?></div>
        <div class="current-rating">
            <div class="star-cont">
                <div class="stars-outer">
                    <div class="stars-inner"></div>
                </div>
                <span class="number-rating"><?=number_format($rating['rating'],1)?></span>
            </div>
        </div>
        <div class="quiz-info-genre">
            <?php
                echo $category[0]['category'];
                for($i=1;$i<count($category);$i++) echo ", ".$category[$i]['category'];
            ?>
        </div>
        <div class="player-num"><?=($analytic['play_attempt']) ? $analytic['play_attempt'] : 0?> attempts</div>
        <div class="quiz-creator">Creator: <?=$overview['username']?></div>
        <div class="quiz-info-des">
            <p>About the quiz</p>
            <p><?=$overview['description']?></p>
        </div>
        <div class="update">Last update: <?=date_format(date_create($overview['lastModified']), 'd/m/Y H:i:s')?></div>
        </div>
        <div class="max-score-area">
            <div class="max-score"><?=($analytic['play_attempt']) ? $analytic['max_score'] : 0?> points</div>
            <div class="stage-img"></div>
        </div>
    </div>
    
    <div class="container-result">
        <div class="question-total"><span class="text">Question:</span><span class="num-question"><?=$question_info['question_num']?></span></div>
        <div class="score-text"><span class="text">Total Score:</span><span class="score"><?=$question_info['total_score']?></span></div>
        <div class="result-report-owner">
            <?php
                for($i=0;$i<count($question);$i+=4){
            ?>
                    <div class="result-question">
                        <div class="header">
                            <div class="question"><?=$question[$i]['content']?> (<?=$question[$i]['point']?> points)</div>
                            <div class="image" title="Question Image"></div>
                        </div>
                        <div class="option optionA <?=($question[$i]['isAnswer'])?"correct-ans":""?>">
                            <span>A.</span>
                            <span><?=$question[$i]['option']?></span>
                        </div>
                        <div class="option optionB  <?=($question[$i+1]['isAnswer'])?"correct-ans":""?>">
                            <span>B.</span>
                            <span><?=$question[$i+1]['option']?></span>
                        </div>
                        <div class="option optionC  <?=($question[$i+2]['isAnswer'])?"correct-ans":""?>">
                            <span>C.</span>
                            <span><?=$question[$i+2]['option']?></span>
                        </div>
                        <div class="option optionD <?=($question[$i+3]['isAnswer'])?"correct-ans":""?>">
                            <span>D.</span>
                            <span><?=$question[$i+3]['option']?></span>
                        </div>
                    </div>
            <?php } ?>
        </div>
    </div>
    <script src="../quizApp/assets/js/pages/owner_view_quiz.js" type="module"></script>
</body>

</html>