"use strict";

//messageText is a variable defined in the php page

let animationRunning = true;
let textElement;
window.addEventListener('load', function () {
  runAnimation();
  setTimeout( function () { setInterval(updateAnimation, 100) }, 3500);
})

function runAnimation()
{
  textElement = $("#textBox");
  $("#returnLink").hide();

  textElement.text(messageText);
}

function updateAnimation()
{
  if (messageText.length > 2)
  {
    messageText = messageText.slice(0, messageText.length-1);
  }
  else
  {
    messageText = "";
    animationRunning = false;
    $("#returnLink").show();
  }

  textElement.text(messageText);

}
