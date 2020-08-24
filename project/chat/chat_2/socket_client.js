//引入模块
const net = require("net");

//监听端口
const socket = net.connect(7777);

//端口连接
socket.on("connect", function () {
  console.log(
    "请按照如下格式输入：myName@你的名字:信息;若想私聊：To@目标名字@信息"
  );
});

//输入流输入

process.stdin.on("data", function (data) {
  socket.write(data);
});

//读取数据

socket.on("data", function (data) {
  console.log(data.toString("utf-8"));
});
