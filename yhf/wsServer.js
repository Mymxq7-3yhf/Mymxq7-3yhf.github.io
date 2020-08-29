const http = require("./httpServer");
const socketIo = require("socket.io")(http);
const Cotroller = require("./cotroller/textCotroller");

// socketIo.on("connection", function (socket) {
//   socket.emit("login");
//   socket.on("username", function (username) {
//     socketIo.emit("message", Cotroller.username);
//   });
// });

socketIo.on("connection", function (socket) {
  /*监听登录*/
  socket.on("login", function (data) {
    console.log(data);
  });
});
http.listen(7777);
