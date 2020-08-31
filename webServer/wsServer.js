const socketIo = require("socket.io");

const HttpServer = require("./httpServer");

const io = socketIo(HttpServer);

var users = [];

io.on("connection", function (socket) {
  var isNewPerson = true;

  var username = null;

  socket.on("login", function (data) {
    for (var i = 0; i < users.length; i++) {
      if (users[i].username === data.username) {
        isNewPerson = false;

        break;
      } else {
        isNewPerson = true;
      }
    }
    if (isNewPerson) {
      username = data.username;

      users.push({
        username: data.username,
      });

      socket.emit("loginSuccess", data);

      io.sockets.emit("add", data);
    } else {
      socket.emit("loginFail", "");
    }
  });

  socket.on("disconnect", function () {
    io.sockets.emit("leave", username);

    users.map(function (val, index) {
      if (val.username === username) {
        users.splice(index, 1);
      }
    });
  });
  socket.on("sendMessage", function (data) {
    io.sockets.emit("receiveMessage", data);
  });
});

HttpServer.listen(8089, () => {
  console.log("已经监听8089端口");
});
