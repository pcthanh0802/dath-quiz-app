<?php
    require_once "../quizApp/database.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../quizApp/assets/css/pages/result.css">
    <title>Final result</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>

</head>

<?php
    $quizID = $_GET['quizID'];
    $playDateTime = $_SESSION['playDateTime'];
    $point = $_SESSION['point'];
    $sql = "SELECT question.content, question.media, option.content AS option, option.isAnswer
            FROM quiz JOIN question ON quiz.id = question.quizId JOIN option ON question.id = option.questionId
            WHERE quiz.id = \"$quizID\"";
    $question = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    $sql = "UPDATE play_attempt SET score = \"$point\" WHERE playDateTime=\"$playDateTime\"";
    $conn->query($sql);
?>

<script>
    function goBack(){
        window.location.replace('http://localhost/quizApp/index.php?page=player');
    }
</script>

<body>
    <div class="goback-btn"><button type ="button" onclick="goBack()">Go Back</button></div>
    <div class="container-result">
        <div class="score-text"><span class="text">Your Score: </span><span class="score"><?=$_SESSION['point']?>/<?=$_SESSION['total_point']?></span></div>
        <!-- <div class="star-rating-area">
            <div class="star">
                <input type="radio" id="five" name="rate" value="5">
                <label for="five"></label>
                <input type="radio" id="four" name="rate" value="4">
                <label for="four"></label>
                <input type="radio" id="three" name="rate" value="3">
                <label for="three"></label>
                <input type="radio" id="two" name="rate" value="2">
                <label for="two"></label>
                <input type="radio" id="one" name="rate" value="1">
                <label for="one"></label>
            </div>
            <div class="rate-text">Please rate this quiz!</div>
        </div> -->
        <div class="result-report">
            <?php
                for($i=0;$i<=$_SESSION['quest_num']*4-4;$i+=4){
            ?>
            <div class="result-question">
                <div class="header">
                    <div class="question"><?=$question[$i]['content']?></div>
                    <div class="image" title="Question Image"></div>
                </div>
                <div class="option optionA <?=($question[$i]['isAnswer'])?"correct-ans":""?>">
                    <span>A.</span>
                    <span><?=$question[$i]['option']?></span>
                </div>
                <div class="option optionB <?=($question[$i+1]['isAnswer'])?"correct-ans":""?>">
                    <span>B.</span>
                    <span><?=$question[$i+1]['option']?></span>
                </div>
                <div class="option optionC <?=($question[$i+2]['isAnswer'])?"correct-ans":""?>">
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
    <script src="../quizApp/assets/js/pages/result.js" defer></script>
</body>
<?php
    unset($_SESSION['quest_num']);
    unset($_SESSION['offset']);
    unset($_SESSION['point']);
    unset($_SESSION['playDateTime']);
    unset($_SESSION['total_point']);
?>
</html>