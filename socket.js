const express = require('express');
const app = express();
const http = require('http').Server(app);
const io = require('socket.io')(http);

io.sockets.on('connection', function (socket) {
  socket.on('room', function (room) {
    socket.join(room);
    console.log("room joined");
  });
  socket.on('message', function (message) {
    io.sockets.in(message.room).emit('message', message.message);
    console.log("message", message)
  });
});

const server = http.listen(8080, function () {
  console.log('listening on *:8080');
});