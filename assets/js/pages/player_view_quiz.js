function submitRating(rating, userID, quizID){
  $.ajax({
    type: "GET",
    url: `../quizApp/processing/rating-processing.php`,
    data: {rating:rating, userID:userID, quizID:quizID},
    success: (data)=>{
      console.log(data);
      $('.rate-text').text('You have rated this quiz!');
      $('#five').removeAttr('onclick').prop('disabled',true);
      $('#four').removeAttr('onclick').prop('disabled',true);
      $('#three').removeAttr('onclick').prop('disabled',true);
      $('#two').removeAttr('onclick').prop('disabled',true);
      $('#one').removeAttr('onclick').prop('disabled',true);
      alert('Thanks you for your rating ❤');
    }
  });
}

// average rating for quiz view

const starsTotal = 5;
// Get ratings
function getRatings() {
  let rate = document.querySelector(".number-rating").innerHTML;
  // Get percentage
  let starPercentage = (rate / starsTotal) * 100;

  // Round to nearest 10
  let starPercentageRounded = `${Math.round(starPercentage / 5) * 5}%`;

  // Set width of stars-inner to percentage
  document.querySelector(".stars-inner").style.width = starPercentageRounded;

  // Add number rating
  document.querySelector(".number-rating").innerHTML = rate;
}

getRatings();










