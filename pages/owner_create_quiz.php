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

<body>
    <form class="create-quiz-box" action="../quizApp/processing/insert-quiz-processing.php" method="post" onsubmit="return confirm('Do you want to save all the changes?')">
        <div class="create-heading">Create Quiz</div>
        <div class="input-form-quiz-gen">
            <label for="quiz-name-create">Quiz's name</label>
            <input type="text" name="quiz-name-create" placeholder="Enter Quiz's name..." autocomplete="off" required>
        </div>
        <div class="input-form-quiz-gen">
            <label for="quiz-category-create">Quiz's category</label>
            <input type="text" name="quiz-category-create" placeholder="Enter Quiz's categories..." autocomplete="off" required>
        </div>
        <div class="input-form-quiz-gen">
            <label for="quiz-des-create">Quiz's description</label>
            <textarea type="text" name="quiz-des-create" placeholder="Enter description about the quiz..." style="resize:none;" autocomplete="off" required></textarea>
            <div></div>
        </div>

        <div class="question-create-state">
            <span id="totalScore">Total Score: 0</span>
        </div>
        <div class="question-form-create-box" id="1">
            <div class="question-create-state">
                <span id="question1">Question 1</span>
            </div>
            <div class="question-form">
                <div class="question-form-input-area">
                    <div class="input-form-quiz-gen">
                        <label for="question-cont">Question's content</label>
                        <input type="text" name="question-cont1" id="question-cont1" placeholder="Enter Question..." autocomplete="off" required>
                    </div>
                    <div class="input-form-quiz-gen">
                        <label for="question-img">Question's Image</label>
                        <input type="text" name="question-img1" id="question-img1" placeholder="Enter URL...">
                    </div>
                    <div class="input-form-quiz-gen">
                        <label for="question-point">Question's point</label>
                        <input type="number" min="0" name="question-point1" id="question-point1" class="question-point" onkeyup="updateTotalScore()" placeholder="Choose Question's point..." autocomplete="off" required>
                    </div>
                    <div class="input-form-quiz-gen">
                        <label for="question-time">Question's time (seconds)</label>
                        <input type="number" min="0" name="question-time1" id="question-time1" placeholder="Choose Question's time..." autocomplete="off" required>
                    </div>
                </div>

                <div class="question-form-choose-area">
                    <label for="">Create Options</label>
                    <div class="option-form">
                        <span>A.</span>
                        <input type="text" name="optionA1" id="optionA1" autocomplete="off" required>
                    </div>
                    <div class="option-form">
                        <span>B.</span>
                        <input type="text" name="optionB1" id="optionB1" autocomplete="off" required>
                    </div>
                    <div class="option-form">
                        <span>C.</span>
                        <input type="text" name="optionC1" id="optionC1" autocomplete="off" required>
                    </div>
                    <div class="option-form">
                        <span>D.</span>
                        <input type="text" name="optionD1" id="optionD1" autocomplete="off" required>
                    </div>
                    
                    <div class="correct-answer">
                        <label for="CA">Correct Answer:</label>
                        <select name="CA1" id="CA1" required>
                            <option value="A" selected>A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                </div>
                <div class="delete-question-btn">
                    <button name="delete-question" onclick="deleteQuestion(1)" type="button" id="delete1">Delete</button>
                </div>
            </div>
        </div>

        <div id="addQuestion"></div>

        <div class="quiz-create-button">
            <button name="add-question-button" onclick="addQuestion()" type="button">Add question</button>
            <button name="cancel-quiz-button" onclick="goBack()" type="button">Cancel</button>
            <button name="confirm-quiz-button" onclick="createQuiz()" type="submit">Confirm</button>
        </div>
    </form>
</body>
<script src="../quizApp/assets/js/pages/owner_create_quiz.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</html>