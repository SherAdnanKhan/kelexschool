module.exports = function (server) {

  const io = require('socket.io')(server);
  io.origins('*:*');
  const requestServices = require('./requestServices');

  io.sockets.on('connection', function (socket) {
    console.log('user connected');
    socket.on('join', (data, callback) => {
      socket.join(data.room);
      console.log(data.room);
      callback && callback();
    });
    socket.on('joinUser', (user, callback) => {
      socket.join(user.slug);
      console.log('user join user' + user.slug);
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
    socket.on('sendMessage', async (data, token, callback) => {
      const reciver = data.reciver;
      try {
        const { data: { data: response } } = await requestServices.sendMessage(data, token);
        io.to(response.message.conversation_id).emit('recieveMessage', response);
        io.to(reciver).emit('notify', data);
      } catch (ex) {
        console.log(ex);
      }
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
};