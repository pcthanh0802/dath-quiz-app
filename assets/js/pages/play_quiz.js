import Timer from "./Timer.js";
function init(){
  let time = document.getElementById('timer').value;
  new Timer(document.querySelector(".question-body-countdown")).countDown(time);
}
init();

