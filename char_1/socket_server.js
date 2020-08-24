//引入模块
const net = require("net");
const { Socket } = require("dgram");
const server = net.createServer();

let socketObj = {
  name: "",
  socketArr: [],
};

server.on("connection", function (socket) {
  //将socket信息写入
  socketObj.socketArr.push(socket);
  //   sockeObj.push(socket);
  socket.Index = socketObj.socketArr.length - 1;
  console.log(socket.Index);

  //读入data
  socket.on("data", function (data) {
    data = data.toString("utf-8");
    socketObj.socketArr.forEach(function (client) {
      if (client !== socket) {
        //由于同一台计算机上客户端端口号不同，所以可以通过端口号来区分是谁说的话
        client.write(data);
        //console.log(data);
      }
    });
  });
  socket.on("error", function () {
    // console.log("有客户端异常退出了");
  });
});

server.listen(8080);
//listining
server.on("listening", function () {
  console.log("port:8080");
});
