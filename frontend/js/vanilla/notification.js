import Pusher from "pusher-js";

Pusher.logToConsole = true;
const pusherAppKey = document
  .getElementById("pusher-app-key")
  .getAttribute("content");

const notification = document
  .getElementById("notification-channel")
  .getAttribute("content");

const pusher = new Pusher(pusherAppKey, {
  cluster: "eu",
});

const channel = pusher.subscribe(notification);

channel.bind("donation", function (data) {
  alert(JSON.stringify(data));
});
channel.bind("payment", function (data) {
  alert(JSON.stringify(data));
});
channel.bind("comment", function (data) {
  alert(JSON.stringify(data));
});
