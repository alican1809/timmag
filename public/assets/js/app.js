



/*------------ animation home time parade ----------------------------*/


var imgTim = document.querySelectorAll(".imgTim");
var nbrImgTim = imgTim.length;

var aherfTim = document.querySelectorAll(".aherfTim");
var animTimFly = document.querySelector(".animTimFly");

var max = 200;
var min = 125;
var maxTop = 0;
var minTop = 50;

var nbrProduct = aherfTim.length;

if (nbrProduct > 15) {
  nbrProduct = 10
}

for (let i = 0; i < nbrProduct; i++) {

  var nbrRandomHeight = Math.floor(Math.random() * (max - min) + min) + "px";
  var nbrRandomTop = Math.floor(Math.random() * (maxTop - minTop) + minTop) + "%";

  var animImgTim = document.createElement("img");
  animImgTim.style.height = nbrRandomHeight;
  animImgTim.style.top = nbrRandomTop;

  var srcImgTim = imgTim[i].getAttribute("src");

  animImgTim.setAttribute("src", srcImgTim);
  animImgTim.setAttribute("class", "animImgTim");
  animImgTim.style.animationDuration = Math.random() * 10 + 8 + 's';

  var animAhrefTim = document.createElement("a");
  var aTim = aherfTim[i].getAttribute("href");

  animAhrefTim.setAttribute("href", aTim);
  animAhrefTim.setAttribute("class", "animAhrefTim");

  animAhrefTim.appendChild(animImgTim);
  animTimFly.appendChild(animAhrefTim);

}


/*------------------------------------------------------------------------------*/
