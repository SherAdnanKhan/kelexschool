const express = require('express');
const app = express();
const https = require('http').Server(app);
const io = require('socket.io')(https);

let port = 8080;
io.origins('*:*');
io.sockets.on('connection', function (socket) {
  console.log('user connected');

  socket.on('join', (data, callback) => {
    socket.join(data.room);
    console.log(data.room);
    callback && callback();
  });

  socket.on('joinUser', (user, callback) => {
    socket.join(user.slug);
    console.log(user.slug);
    console.log('user join user');
    callback && callback();
  });

  socket.on('onRead', (data, callback) => {
    io.to(data.room).emit('read', data);
    callback && callback();
  });

  socket.on('onReadAll', (data, callback) => {
    io.to(data.room).emit('readAll', data);
    callback && callback();
  });

  socket.on('sendMessage', (data, callback) => {
    io.to(data.room).emit('recieveMessage', data);
    io.to(data.reciver).emit('notify', data);
    callback && callback();
  });

  socket.on('leave', (data) => {
    socket.leave(data.room);
  });

  socket.on('userLeft', (user) => {
    socket.joinUser(user.slug);
  });

  socket.on('userColorChange', (user) => {
    io.to(user.slug).emit('notifyColrChange', user);
  });

  socket.on('disconnect', () => {
    console.log('disconnected');
  });
});


const server = https.listen(8080, function () {
  console.log('listening on *:8080');
});
