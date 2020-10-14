"use strict";

//sources for a lot of this code comes from:
// https://developer.mozilla.org/en-US/docs/Web/API/Web_Audio_API
// https://developer.mozilla.org/en-US/docs/Web/API/Web_Audio_API/Using_Web_Audio_API
//start there if you want to learn more!

// < BASIC WEB AUDIO API SYNTAX >
// creating a web audio api context
// `(window.AudioContext || window.webkitAudioContext` makes it accessible in different browsers)
// < EXAMPLE > `audioObject = new Audio(url)`
// url is an optional DOMString pointing to the url of an audiofile associated w/ (audioObject)
// This will return a new HTMLAudioElement where the preload property is set to auto and the src is set to url.
// This url can be set to null, if you want to initiate the audio element without loading its src.
// Once this url is given the browser asynchronously loads in the media itself before returning the audioObject.
let audioCtx = new (window.AudioContext || window.webkitAudioContext)();

// create Oscillator node
let oscillator = audioCtx.createOscillator();

//variable for checking to see if the oscillator is playing
//(used to make sure stop/start function properly)
let oscillatorPlaying = false;

function start() {
  //check to see if the oscillator is already playing
  if (oscillatorPlaying)
  {
    stop();
  }

  //make a new oscillator
  oscillator = audioCtx.createOscillator();

  //set oscillator properties
  frequency();
  waveType();
  detune();

  //connect it so it outputs sound
  oscillator.connect(audioCtx.destination);

  //start the oscillator
  oscillator.start();
  oscillatorPlaying = true;
}

//frequency in hertz, determines frequency of the oscillator
function frequency() {
  let inputFreq = document.getElementById("freq").value;
  oscillator.frequency.setValueAtTime(inputFreq, audioCtx.currentTime); // value in hertz
}

//sets the wave type, takes string input
//can be sine, square, sawtooth, or triangle
function waveType() {
  let inputType = document.getElementById("wave").value;
  oscillator.type = inputType;
}

//detuning in cents, good for effects that involve layering
//oscillators
function detune() {
  let inputDetu = document.getElementById("detune").value;
  oscillator.detune.setValueAtTime(inputDetu, audioCtx.currentTime); // value in cents
}

function stop() {
  oscillator.stop();
  oscillatorPlaying = false;
}

let audioElement;
let track;

//need to wait for page to load to get audio from HTML
window.onload = function() {
  // get the audio element
  audioElement = document.getElementById('bell');
  //checks to see if the audio has loaded
  audioElement.addEventListener('canplay', (event) => {
  console.log('sound loaded');

  //check for autoplay restriction
  if (audioCtx.state === 'suspended') {
        audioCtx.resume();
    }

  //makes a node using an <audio> element in the html
  track = audioCtx.createMediaElementSource(audioElement);

  //GAIN for volume control, takes live updates from
  //an input and sets the node's gain property to that

  let fileGain = audioCtx.createGain();

  let volumeControl = document.querySelector('#fileVolume');

  //set gain value to volume control value
  volumeControl.addEventListener('input', function() {
      fileGain.gain.value = this.value;
  }, false);

  //connect input node to gain node, connect gain node to audio destination
  track.connect(fileGain).connect(audioCtx.destination);
});
// pass it into the audio context
}

function startFile() {
  if (track !== undefined)
  {
    audioElement.play();
  }
}

function stopFile() {
  if (track !== undefined)
  {
    audioElement.pause();
  }
}
