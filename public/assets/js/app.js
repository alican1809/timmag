const heure = document.querySelector(".display-time");

function showTime() {
  let time = new Date();
  heure.innerText = time.toLocaleTimeString("en-US", { hour12: false });
  setTimeout(showTime, 1000);
}

showTime();


