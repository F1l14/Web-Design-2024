function progressBar(states){
    container = document.getElementById("progressBar");
    ul = document.createElement("ul");
    ul.className = "progressBar";

    barContainer = document.createElement("div");
    barContainer.className = "barContainer";
    container.appendChild(barContainer)

    greenBar = document.createElement("div");
    greenBar.className = "greenBar";
    barContainer.appendChild(greenBar);

    states.forEach(element => {
        console.log(element);
        colDiv = document.createElement
        li = document.createElement("li");
        x = document.createElement("img");
        x.src = "/Web-Design-2024/icons/x.svg";
        li.appendChild(x);
        ul.appendChild(li)
    });

    container.appendChild(ul)
}