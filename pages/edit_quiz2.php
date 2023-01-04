<?php
    require_once '../quizApp/database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../quizApp/assets/css/pages/owner_create_quiz.css">
    <title>Quiz create</title>
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
    $sql = "SELECT question.id, question.content, question.point, question.timeLimit, question.media, option.content AS option, option.isAnswer
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
    <form class="create-quiz-box" action="../quizApp/processing/update-quiz-processing-2.php?quizID=<?=$quizID?>" method="post" onsubmit="return confirm('Do you want to save all the changes?');">
        <div class="create-heading">Create Quiz</div>
        <div class="input-form-quiz-gen">
            <label for="quiz-name-create">Quiz's name</label>
            <input type="text" name="quiz-name-create" value = "<?=$overview['name']?>" placeholder="Enter Quiz's name..." autocomplete="off" required>
        </div>
        <div class="input-form-quiz-gen">
            <label for="quiz-category-create">Quiz's category</label>
            <input type="text" name="quiz-category-create" value = "<?php
                echo $category[0]['category'];
                for($i=1;$i<count($category);$i++) echo ", ".$category[$i]['category'];
            ?>" placeholder="Enter Quiz's categories..." autocomplete="off" required>
        </div>
        <div class="input-form-quiz-gen">
            <label for="quiz-des-create">Quiz's description</label>
            <textarea type="text" name="quiz-des-create" placeholder="Enter description about the quiz..." style="resize:none;" autocomplete="off" required><?=$overview['description']?></textarea>
            <div></div>
        </div>

        <div class="question-create-state">
            <span id="totalScore">Total Score: <?=$question_info['total_score']?></span>
        </div>
        <?php 
            echo "<div id=\"addQuestion\">";
            for($i=0;$i<count($question);$i+=4){?>
                <div class="question-form-create-box" id="<?=0.25*$i+1?>">
                    <div class="question-create-state">
                        <span id="question<?=0.25*$i+1?>">Question <?=0.25*$i+1?></span>
                    </div>
                    <div class="question-form">
                        <div class="question-form-input-area">
                            <input type="hidden" name="questionID<?=0.25*$i+1?>" value="<?=$question[$i]['id']?>" required>
                            <div class="input-form-quiz-gen">
                                <label for="question-cont">Question's content</label>
                                <input type="text" name="question-cont<?=0.25*$i+1?>" value="<?=$question[$i]['content']?>" id="question-cont<?=0.25*$i+1?>" placeholder="Enter Question..." autocomplete="off" required>
                            </div>
                            <div class="input-form-quiz-gen">
                                <label for="question-img">Question's Image</label>
                                <input type="text" name="question-img<?=0.25*$i+1?>" value="<?=$question[$i]['media']?>" id="question-img<?=0.25*$i+1?>" placeholder="Enter URL...">
                            </div>
                            <div class="input-form-quiz-gen">
                                <label for="question-point">Question's point</label>
                                <input type="number" min="0" name="question-point<?=0.25*$i+1?>" value="<?=$question[$i]['point']?>" id="question-point<?=0.25*$i+1?>" class="question-point" onkeyup="updateTotalScore()" placeholder="Choose Question's point..." autocomplete="off" required>
                            </div>
                            <div class="input-form-quiz-gen">
                                <label for="question-time">Question's time (seconds)</label>
                                <input type="number" min="0" name="question-time<?=0.25*$i+1?>" value="<?=$question[$i]['timeLimit']?>" id="question-time<?=0.25*$i+1?>" placeholder="Choose Question's time..." autocomplete="off" required>
                            </div>
                        </div>

                        <div class="question-form-choose-area">
                            <label for="">Create Options</label>
                            <div class="option-form">
                                <span>A.</span>
                                <input type="text" name="optionA<?=0.25*$i+1?>" value="<?=$question[$i]['option']?>" id="optionA<?=0.25*$i+1?>" autocomplete="off" required>
                            </div>
                            <div class="option-form">
                                <span>B.</span>
                                <input type="text" name="optionB<?=0.25*$i+1?>" value="<?=$question[$i+1]['option']?>" id="optionB<?=0.25*$i+1?>" autocomplete="off" required>
                            </div>
                            <div class="option-form">
                                <span>C.</span>
                                <input type="text" name="optionC<?=0.25*$i+1?>" value="<?=$question[$i+2]['option']?>" id="optionC<?=0.25*$i+1?>" autocomplete="off" required>
                            </div>
                            <div class="option-form">
                                <span>D.</span>
                                <input type="text" name="optionD<?=0.25*$i+1?>" value="<?=$question[$i+3]['option']?>" id="optionD<?=0.25*$i+1?>" autocomplete="off" required>
                            </div>
                            
                            <div class="correct-answer">
                                <label for="CA">Correct Answer:</label>
                                <select name="CA<?=0.25*$i+1?>" id="CA<?=0.25*$i+1?>" required>
                                    <option value="A" <?=($question[$i]['isAnswer'])?"selected":""?>>A</option>
                                    <option value="B" <?=($question[$i+1]['isAnswer'])?"selected":""?>>B</option>
                                    <option value="C" <?=($question[$i+2]['isAnswer'])?"selected":""?>>C</option>
                                    <option value="D" <?=($question[$i+3]['isAnswer'])?"selected":""?>>D</option>
                                </select>
                            </div>
                        </div>
                        <div class="delete-question-btn">
                            <button name="delete-question" onclick="deleteQuestion1(<?=0.25*$i+1?>, <?=$question[$i]['id']?>, <?=$quizID?>)" type="button" id="delete<?=0.25*$i+1?>">Delete</button>
                        </div>
                    </div>
                </div>
        <?php } echo "</div>"; ?>
        <div class="quiz-create-button">
            <button name="add-question-button" onclick="addQuestion()" type="button">Add question</button>
            <button name="cancel-quiz-button" onclick="window.location.replace('http:\\\\localhost\\quizApp\\index.php?page=quizManager')" type="button">Cancel</button>
            <button name="confirm-quiz-button" type="submit">Confirm</button>
        </div>
    </form>
</body>
<script src="../quizApp/assets/js/pages/owner_create_quiz.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</html>