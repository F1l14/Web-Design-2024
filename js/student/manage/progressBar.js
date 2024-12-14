
function progressBar(states, currentState){
    container = document.getElementById("progressBar");
    labelsDiv = document.createElement("div");
    labelsDiv.className = "labelsDiv";
    container.appendChild(labelsDiv);
    ul = document.createElement("ul");
    ul.className = "progressBar";

    barContainer = document.createElement("div");
    barContainer.className = "barContainer";
    container.appendChild(barContainer)

    greenBar = document.createElement("div");
    greenBar.className = "greenBar";
    barContainer.appendChild(greenBar);

    states.forEach(element => {
        li = document.createElement("li");
        icon = document.createElement("img");
        icon.src = "/Web-Design-2024/icons/history.svg";
        icon.className = "barIcon";
        li.appendChild(icon);
        ul.appendChild(li)
        
        label = document.createElement("span");
        label.className = "label";
        label.innerHTML = element;
        labelsDiv.appendChild(label);


       
    });

    currentStateLabel = document.createElement("span");
    currentStateLabel.className = "singleLabel";
    currentStateLabel.innerHTML = states[currentState-1];
    labelsDiv.appendChild(currentStateLabel);
    container.appendChild(ul)
    updateGreenBar(currentState);
}



function updateGreenBar(currentCircle){
    const circles = document.querySelectorAll("ul.progressBar li");
    const totalCircles = circles.length;
    const icons = document.querySelectorAll("ul.progressBar img");
    // const greenBar = document.getElementsByClassName("greenBar");
   
    if(currentCircle >  0 && currentCircle <= circles.length){
        widthPercentage = ((currentCircle) / (totalCircles))*100;
        greenBar.style.width = `${widthPercentage}%`;
        console.log(widthPercentage)
    }

    for(i=0; i<currentCircle; i++){
        circles[i].className = "activeIcon"
        icons[i].src = "/Web-Design-2024/icons/check_light.svg";
        console.log(circles[i]);
    }
}