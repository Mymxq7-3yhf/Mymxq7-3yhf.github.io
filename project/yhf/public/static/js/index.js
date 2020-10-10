//发送长链接
let socket = io("ws://localhost:7777");

var uname = null;

let button = document.getElementsByTagName("button")[0];

button.onclick = function (event) {
  alert("777");
};

socket.on("login", function (username) {
  socket.emit("username", showWindowHref().username);
  alert(username + "ddd");
});

function showWindowHref() {
  var sHref = window.location.href;
  var args = sHref.split("?");
  if (args[0] == sHref) {
    return "";
  }
  var arr = args[1].split("&");
  var obj = {};
  for (var i = 0; i < arr.length; i++) {
    var arg = arr[i].split("=");
    obj[arg[0]] = arg[1];
  }
  return obj;
}
let href = showWindowHref();
