<?php
    require_once "../quizApp/database.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../quizApp/assets/css/pages/player_view_quiz.css">
    <title>Quiz overview</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
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
    $sql = "SELECT * FROM comment JOIN account ON account.id = comment.playerId WHERE comment.quizId = \"$quizID\" ORDER BY commentDateTime DESC";
    $comment = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    $sql = "SELECT COUNT(commentDateTime) AS comment_num FROM comment WHERE comment.quizId=\"$quizID\"";
    $comment_num = $conn->query($sql)->fetch_assoc();
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
            <div class="quiz-info-genre"><?php
                echo $category[0]['category'];
                for($i=1;$i<count($category);$i++) echo ", ".$category[$i]['category'];
            ?></div>
            <div class="player-num"><?=($analytic['play_attempt']) ? $analytic['play_attempt'] : 0?> attempts</div>
            <div class="quiz-creator">Creator: <?=$overview['username']?></div>
            <div class="quiz-info-des">
                <p>About the quiz</p>
                <p><?=$overview['description']?></p>
            </div>
            <div class="update">Last update: <?=date_format(date_create($overview['lastModified']), 'd/m/Y H:i:s')?></div>
            <a href="./index.php?page=play-init-processing&quizID=<?= $quizID ?>"><button class="play-quiz" type="button" style="width:100%">Play quiz</button></a>
        </div>
        <div class="max-score-area">
            <div class="max-score"><?=($analytic['play_attempt']) ? $analytic['max_score'] : 0?> points</div>
            <div class="stage-img"></div>
        </div>
    </div>

    <?php
        $sql = "SELECT * FROM rating WHERE quizId=\"$quizID\" AND playerId=\"".$_SESSION['userID']."\"";
        $rated = 0;
        $temp = $conn->query($sql);
        $res;
        if(mysqli_num_rows($temp)){
            $rated = 1;
            $res = $temp->fetch_all(MYSQLI_ASSOC)[0];
        } 
    ?>

    <div class="quiz-info-block-next">
        <div class="star-rating-area">
            <div class="star">
                <input type="radio" id="five" name="rate" value="5" <?=($rated)?"disabled":"onclick=\"submitRating(5,". $_SESSION['userID'].", $quizID)\""?>>
                <label for="five"  <?=($rated && $res['rating']==5)?"style=\"color: gold\"":""?>></label>
                <input type="radio" id="four" name="rate" value="4" <?=($rated)?"disabled":"onclick=\"submitRating(4,". $_SESSION['userID'].", $quizID)\""?>>
                <label for="four"  <?=($rated && $res['rating']>=4)?"style=\"color: gold\"":""?>></label>
                <input type="radio" id="three" name="rate" value="3" <?=($rated)?"disabled":"onclick=\"submitRating(3,". $_SESSION['userID'].", $quizID)\""?>>
                <label for="three" <?=($rated && $res['rating']>=3)?"style=\"color: gold\"":""?>></label>
                <input type="radio" id="two" name="rate" value="2" <?=($rated)?"disabled":"onclick=\"submitRating(2,". $_SESSION['userID'].", $quizID)\""?>>
                <label for="two" <?=($rated && $res['rating']>=2)?"style=\"color: gold\"":""?>></label>
                <input type="radio" id="one" name="rate" value="1" <?=($rated)?"disabled":"onclick=\"submitRating(1,". $_SESSION['userID'].", $quizID)\""?>>
                <label for="one"  <?=($rated && $res['rating']>=1)?"style=\"color: gold\"":""?>></label>
            </div>
            <div class="rate-text"><?=($rated)?"You have rated this quiz!":"Please rate this quiz!"?></div>
        </div>
        <div class="quiz-comment-block">
            <form class="quiz-comment-block-1" action="../quizApp/processing/comment-processing.php?quizID=<?=$quizID?>&userID=<?=$_SESSION['userID']?>" method="post">
                <div class="comment-box-header">Comments (<?=$comment_num['comment_num']?>)</div>
                <textarea type="text" name="comment" class="comment-input-box" placeholder="Type your comment here..." style="resize:none;"></textarea>
                <button class="comment-submit" type="submit">Submit</button>
            </form>
            <div class="comment__container opened" id="first-comment">
                <?php foreach($comment as $com){ ?>
                <div class="comment__card">
                    <span><i class="fa-solid fa-circle-user"></i></span>
                    <span class="comment__title"><?=$com['username']?></span>
                    <p><?=$com['content']?></p>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <script src="../quizApp/assets/js/pages/player_view_quiz.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</body>

</html>