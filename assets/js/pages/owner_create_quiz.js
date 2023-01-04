function addQuestion(){
    let questionForm = document.getElementsByClassName('question-form-create-box');
    let order = parseInt(questionForm[questionForm.length - 1].id) + 1;
    $("#addQuestion").append(`<div class="question-form-create-box" id="${order}">
            <div class="question-create-state">
                <span id="question${order}">Question ${order}</span>
            </div>
            <div class="question-form">
                <div class="question-form-input-area">
                    <input type="hidden" name="questionID${order}" value="0" required>
                    <div class="input-form-quiz-gen">
                        <label for="question-cont">Question's content</label>
                        <input type="text" name="question-cont${order}" id="question-cont${order}" placeholder="Enter Question..." required>
                    </div>
                    <div class="input-form-quiz-gen">
                        <label for="question-img">Question's Image</label>
                        <input type="text" name="question-img${order}" id="question-img${order}" placeholder="Enter URL...">
                    </div>
                    <div class="input-form-quiz-gen">
                        <label for="question-point">Question's point</label>
                        <input type="number" min="0" name="question-point${order}" id="question-point${order}" class="question-point" onkeyup="updateTotalScore()" placeholder="Choose Question's point..." required>
                    </div>
                    <div class="input-form-quiz-gen">
                        <label for="question-time">Question's time (seconds)</label>
                        <input type="number" min="0" name="question-time${order}" id="question-time${order}" placeholder="Choose Question's time..." required>
                    </div>
                </div>

                <div class="question-form-choose-area">
                    <label for="">Create Options</label>
                    <div class="option-form">
                        <span>A.</span>
                        <input type="text" name="optionA${order}" id="optionA${order}" required>
                    </div>
                    <div class="option-form">
                        <span>B.</span>
                        <input type="text" name="optionB${order}" id="optionB${order}" required>
                    </div>
                    <div class="option-form">
                        <span>C.</span>
                        <input type="text" name="optionC${order}" id="optionC${order}" required>
                    </div>
                    <div class="option-form">
                        <span>D.</span>
                        <input type="text" name="optionD${order}" id="optionD${order}" required>
                    </div>
                    
                    <div class="correct-answer">
                        <label for="CA">Correct Answer:</label>
                        <select name="CA${order}" id="CA${order}" required>
                            <option value="A" selected>A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                </div>
                <div class="delete-question-btn">
                    <button name="delete-question" onclick="deleteQuestion(${order})" type="button" id="delete${order}">Delete</button>
                </div>
            </div>
        </div>`);
}

function deleteQuestion(order){
    let questionForm = document.getElementsByClassName('question-form-create-box');
    if(questionForm.length === 1) alert("Your quiz must have at least 1 question");
    else{
        if(confirm('This action can not be recovered. Do you want to delete this question? ')){
            let question = document.getElementById(`${order}`);
            question.remove();
            for(let i=0;i<questionForm.length;i++){
                let num = parseInt(questionForm[i].id);
                if(num > order){
                    $(`#${num} #question-cont${num}`).attr('name',`question-cont${num-1}`);
                    $(`#${num} #question-cont${num}`).attr('id',`question-cont${num-1}`);
                    $(`#${num} #question-img${num}`).attr('name',`question-img${num-1}`);
                    $(`#${num} #question-img${num}`).attr('id',`question-img${num-1}`);
                    $(`#${num} #question-point${num}`).attr('name',`question-point${num-1}`);
                    $(`#${num} #question-point${num}`).attr('id',`question-point${num-1}`);
                    $(`#${num} #question-time${num}`).attr('name',`question-time${num-1}`);
                    $(`#${num} #question-time${num}`).attr('id',`question-time${num-1}`);
                    $(`#${num} #optionA${num}`).attr('name',`optionA${num-1}`);
                    $(`#${num} #optionA${num}`).attr('id',`optionA${num-1}`);
                    $(`#${num} #optionB${num}`).attr('name',`optionB${num-1}`);
                    $(`#${num} #optionB${num}`).attr('id',`optionB${num-1}`);
                    $(`#${num} #optionC${num}`).attr('name',`optionC${num-1}`);
                    $(`#${num} #optionC${num}`).attr('id',`optionC${num-1}`);
                    $(`#${num} #optionD${num}`).attr('name',`optionD${num-1}`);
                    $(`#${num} #optionD${num}`).attr('id',`optionD${num-1}`);
                    $(`#${num} #CA${num}`).attr('name',`CA${num-1}`);
                    $(`#${num} #CA${num}`).attr('id',`CA${num-1}`);
                    $(`#question${num}`).text(`Question ${num-1}`);
                    $(`#question${num}`).attr('id', `question${num-1}`);
                    $(`#delete${num}`).attr('onclick', `deleteQuestion(${num-1})`);
                    $(`#delete${num}`).attr('id', `delete${num-1}`);
                    questionForm[i].id = `${num-1}`;
                    updateTotalScore();
                }
            }
        }
    }
}

function goBack(){
    window.location.replace('http://localhost/quizApp/index.php?page=myQuiz');
}

function updateTotalScore(){
    let score = document.getElementById('totalScore');
    let scoreInput = document.getElementsByClassName('question-point');
    let sum = 0;
    for(let i=0;i<scoreInput.length;i++){
        if(scoreInput[i].value) sum+=parseInt(scoreInput[i].value);
    }   
    score.innerText = `Total Score: ${sum}`;
}

function deleteQuestion1(order, questionID, quizID){
    let questionForm = document.getElementsByClassName('question-form-create-box');
    if(questionForm.length === 1) alert("Your quiz must have at least 1 question");
    else{
        if(confirm('This action can not be recovered. Do you want to delete this question? ')){
            let question = document.getElementById(`${order}`);
            question.remove();
            for(let i=0;i<questionForm.length;i++){
                let num = parseInt(questionForm[i].id);
                if(num > order){
                    $(`#${num} #question-cont${num}`).attr('name',`question-cont${num-1}`);
                    $(`#${num} #question-cont${num}`).attr('id',`question-cont${num-1}`);
                    $(`#${num} #question-img${num}`).attr('name',`question-img${num-1}`);
                    $(`#${num} #question-img${num}`).attr('id',`question-img${num-1}`);
                    $(`#${num} #question-point${num}`).attr('name',`question-point${num-1}`);
                    $(`#${num} #question-point${num}`).attr('id',`question-point${num-1}`);
                    $(`#${num} #question-time${num}`).attr('name',`question-time${num-1}`);
                    $(`#${num} #question-time${num}`).attr('id',`question-time${num-1}`);
                    $(`#${num} #optionA${num}`).attr('name',`optionA${num-1}`);
                    $(`#${num} #optionA${num}`).attr('id',`optionA${num-1}`);
                    $(`#${num} #optionB${num}`).attr('name',`optionB${num-1}`);
                    $(`#${num} #optionB${num}`).attr('id',`optionB${num-1}`);
                    $(`#${num} #optionC${num}`).attr('name',`optionC${num-1}`);
                    $(`#${num} #optionC${num}`).attr('id',`optionC${num-1}`);
                    $(`#${num} #optionD${num}`).attr('name',`optionD${num-1}`);
                    $(`#${num} #optionD${num}`).attr('id',`optionD${num-1}`);
                    $(`#${num} #CA${num}`).attr('name',`CA${num-1}`);
                    $(`#${num} #CA${num}`).attr('id',`CA${num-1}`);
                    $(`#question${num}`).text(`Question ${num-1}`);
                    $(`#question${num}`).attr('id', `question${num-1}`);
                    $(`#delete${num}`).attr('onclick', `deleteQuestion(${num-1})`);
                    $(`#delete${num}`).attr('id', `delete${num-1}`);
                    questionForm[i].id = `${num-1}`;
                    updateTotalScore();
                }
            }
            window.location.href = `../quizApp/processing/question-delete-processing.php?questionID=${questionID}&quizID=${quizID}`;
        }
    }
}
