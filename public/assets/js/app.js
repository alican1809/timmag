const heure = document.querySelector(".display-time");

function showTime() {
  let time = new Date();
  heure.innerText = time.toLocaleTimeString("en-US", { hour12: false });
  setTimeout(showTime, 1000);
}

showTime();

var imgTim = document.querySelectorAll(".imgTim");
console.log(imgTim)

var nbrImgTim = imgTim.length;
console.log(nbrImgTim)

var aherfTim= document.querySelectorAll(".aherfTim");
console.log(aherfTim)

var animTimFly = document.querySelector(".animTimFly"); 
console.log(animTimFly)

var max= 200;
var min= 125;
var maxTop= 0;
var minTop= 50;
var nbrProduct=aherfTim.length;
if (nbrProduct>15){
  nbrProduct=10
}
  for (let i = 0; i <nbrProduct; i++) { 
  var nbrRandomHeight = Math.floor(Math.random() * (max - min) + min) + "px";
  var nbrRandomTop = Math.floor(Math.random() * (maxTop - minTop) + minTop) + "%";

  var animImgTim = document.createElement("img");
  animImgTim.style.height = nbrRandomHeight ;
  animImgTim.style.top = nbrRandomTop ;

  var srcImgTim = imgTim[i].getAttribute("src");
   
  animImgTim.setAttribute("src", srcImgTim);
  animImgTim.setAttribute("class", "animImgTim");
  animImgTim.style.animationDuration = Math.random() * 10 + 8 + 's'; 
  console.log(animImgTim)

  var animAhrefTim = document.createElement("a");
  var aTim = aherfTim[i].getAttribute("href");
  
  animAhrefTim.setAttribute("href", aTim);
  animAhrefTim.setAttribute("class", "animAhrefTim");
  console.log(animAhrefTim)
  
  animAhrefTim.appendChild(animImgTim);
  animTimFly.appendChild(animAhrefTim);
  }
  

if (aherfTim.length) {
  
}

  


// 
// tim.setAttribute('src','');


// 
// tim.style.width = ;
// 




