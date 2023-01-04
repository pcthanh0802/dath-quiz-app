
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











