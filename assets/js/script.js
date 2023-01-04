function calculatePoint(answer, quizID) {
  $.ajax({
    type: "GET",
    url: "../processing/point-processing.php",
    data: { answer: $(`#${answer}`).text() },
    success: (data) => {
      console.log(data);
    },
  });
  showQuiz(quizID);
}

function showQuiz(quizID) {
  $.ajax({
    type: "GET",
    url: "../processing/showquiz-processing.php",
    data: { id: quizID },
    success: (data) => {
      console.log(data);
    },
  });
}

function showComment(quizID) {
  $.ajax({
    type: "GET",
    url: "../processing/showcomment-processing.php",
    data: { id: quizID },
    success: (data) => {
      console.log(data);
    },
  });
}

function showRating(quizID) {
  $.ajax({
    type: "GET",
    url: "../processing/showrating-processing.php",
    data: { id: quizID },
    success: (data) => {
      console.log(data);
    },
  });
}



