const dotenv = require('dotenv');
dotenv.config();
const express = require('express');
const app = express();
let server, io;

server = require('http').createServer(app);
io = require('socket.io')(server);
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
    socket.leave(user.slug);
  });
  socket.on('userColorChange', (user) => {
    io.to(user.slug).emit('notifyColrChange', user);
  });
  socket.on('disconnect', () => {
    console.log('disconnected');
  });
  socket.on('onUserNotifications', (data, notification_type, callback) => {
    io.to(data.reciever.slug).emit('reciveUserNotifications', data, notification_type);
    callback && callback();
  });

});
server.listen(`${process.env.NODE_APP_PORT}`, () => {
  console.log('Server (', `${process.env.NODE_APP_ENV}`, ') is running on: ', `${process.env.NODE_APP_PORT}`);
});