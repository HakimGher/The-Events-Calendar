function deleteEvent() {
    return
}
var ul = document.getElementById('event-list');
var del = document.querySelector('.del')
console.log(del)


function hide(e){
    console.log(e.target)
    if (e.target == del)
        e.target.style.visibility = 'hidden';
}

var box = document.querySelector(".popup")
var span = document.querySelectorAll(".close")[0]

span.onclick = () => {
    box.style.display = "none";

}


function showEvents() {
var eventsList = document.querySelector('.popup')
eventsList.style.display = "flex"


}