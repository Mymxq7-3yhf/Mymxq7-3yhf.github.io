//引入模块
const net = require("net");

//启动webserver服务

const server = net.createServer();

//定义对象

let socketObj = {
  name: [],
  socketArr: [],
};

server.on("connection", function (socket) {
  //读取socket信息
  socketObj.socketArr.push(socket);

  socket.on("data", function (data) {
    data = data.toString("utf-8");

    //截取数据
    let Type = data.split("@")[0];

    let name = data.split("@")[1];

    let information = data.split("@")[2];

    //判断
    if (Type === "myName") {
      let name = data.split("@")[1].replace(/[\r\n]/g, "");
      for (let j = 0; j <= socketObj.name.length; j++) {
        if (socketObj.name[j] != name) {
          socketObj.name.push(name);
          socket.name = name;
          socket.write("注册成功");
          console.log(socketObj.name);
          return;
        } else {
          socket.write("有相同用户名或格式错误，请重新输入");
          return;
        }
      }
    } else if (Type === "To") {
      //   let information = data.split("@")[2].replace(/[\r\n]/g, "");

      socketObj.socketArr.forEach(function (client) {
        if (name == client.name) {
          client.write(socket.name + "的私聊 " + information);
        }
      });
      //   socketObj.socketArr.forEach(function (client) {
      //     for (let i = 0; i < socketObj.name.length; i++) {
      //       if (client !== socket || socketObj.name[i] == name) {
      //         client.write(socket.name + "的私聊 " + information);
      //       }
      //     }
      //   });

      //   for (let i = 0; i < socketObj.name.length; i++) {
      //     console.log(socketObj.name[i]);
      //     console.log(information);
      //     if (socketObj.name[i] == name) {
      //       socketObj.socketArr.forEach(function (client) {
      //         if (client !== socket) {
      //           client.write(socket.name + "的私聊 :" + information);
      //         }
      //       });
      //     }
      //   }
    } else {
      socketObj.socketArr.forEach(function (client) {
        if (client !== socket) {
          client.write(socket.name + ": " + data);
        }
      });
    }
  });
});

//监听
server.listen(7777);
