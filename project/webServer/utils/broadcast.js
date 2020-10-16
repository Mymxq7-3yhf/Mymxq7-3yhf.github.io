module.exports = function (eventName, data, socket, socketObj) {
  for (let username in socketObj) {
    if (username === socket.user.username) {
      continue;
    }
    socketObj[username].emit(eventName, data);
  }
};
