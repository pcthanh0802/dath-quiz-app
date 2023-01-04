export default class Timer{
    constructor(root){
        root.innerHTML = Timer.getHTML();

        this.el = {
            countDownEl: document.querySelector("#countDownTimer"),
            countButton: document.querySelector("input#inputNumber+button"),
            inputTime: document.querySelector("input#inputNumber")
        }

        this.timecount = null;

        this.countDown(this.timecount);

    }

    countDown(time){
        if(time == null){
            return;
        }
        let tmp = setInterval(()=>{
            this.el.countDownEl.innerHTML = `${time}`;
            time--;
            if(time === 0){
                let id = document.getElementById('quizID').value;
                clearInterval(tmp);
                changeQuestion(0,0,id);
            }
        }, 1000);
    }

    static getHTML(){
        return `
        <div class="countDownTimerBound"><p id="countDownTimer"></p></div>
        `;
    }
}

function changeQuestion(isAnswer, point, quizID){
    window.location.href = `./index.php?page=play-quiz-processing&isAnswer=${isAnswer}&point=${point}&quizID=${quizID}`;
}