import WaveSurfer from "wavesurfer/dist/wavesurfer.min.js";

const ctx = document.createElement('canvas').getContext('2d');
const linGrad = ctx.createLinearGradient(0, 64, 0, 200);
linGrad.addColorStop(0.5, 'rgba(255, 255, 255, 1.000)');
linGrad.addColorStop(0.5, 'rgba(183, 183, 183, 1.000)');

const wavesurfer = WaveSurfer.create({
  container: '#waveform',
  // waveColor: 'violet',
  waveColor: linGrad,
  progressColor: 'hsla(200, 100%, 30%, 0.5)',
  cursorColor: '#fff',
  barWidth: 3
});

wavesurfer.on('loading', (percents) => {
  document.getElementById('progress').value = percents;
});

wavesurfer.on("error", (e) => {
  console.error("WAVESURFER: ", e);
});

wavesurfer.load($("#waveform").data("source"));

wavesurfer.on('ready', () => {
  $("#progress-container").fadeOut(300, () => {
    $("#mute-btn").removeClass("disabled");
    $("#stop-btn").removeClass("disabled");
    $("#pay-btn").removeClass("disabled");
  });
});

wavesurfer.on('finish', () => {
  $("#pay-btn i").removeClass("fa-pause").addClass("fa-play");
});

$("#pay-btn").on("click", () => {
  const $i = $("#pay-btn").find("i");
  if (wavesurfer.isPlaying()) {
    wavesurfer.pause();
    $i.removeClass("fa-pause").addClass("fa-play");
  } else {
    wavesurfer.play();
    $i.removeClass("fa-play").addClass("fa-pause");
  }
});

$("#mute-btn").on("click", () => {
  const $i = $("#mute-btn").find("i");
  wavesurfer.toggleMute();
  if (wavesurfer.getMute()) {
    $i.removeClass("fa-volume-up").addClass("fa-volume-mute");
  } else {
    $i.removeClass("fa-volume-mute").addClass("fa-volume-up");
  }
});

$("#stop-btn").on("click", () => {
  wavesurfer.stop();
});
