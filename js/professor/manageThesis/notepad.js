const note = document.getElementById("1")
const counter = document.getElementById("current");


note.addEventListener("input",function(){
    counter.innerHTML = note.value.length;
});
