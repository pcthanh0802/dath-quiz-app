




let starRate = 0;
// Star rating
const getRating = document.querySelectorAll("input").forEach(el => {
    el.nextElementSibling.addEventListener("click", ()=>{
        console.log(el.value);
        // gán chỉ số tại đây
        starRate = el.value;
    })
});

getRating;

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










