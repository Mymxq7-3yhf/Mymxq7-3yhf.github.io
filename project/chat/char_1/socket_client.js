//引入模块
const net = require("net");

// const server = net.createServer();
const socket = net.connect(8080);

socket.on("connect", function () {
  console.log("连接成功");
});

socket.on("data", function (data) {
  console.log(data.toString("utf-8"));
});

process.stdin.on("data", function (data) {
  socket.write(data);
});
