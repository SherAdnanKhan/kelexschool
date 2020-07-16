module.exports = function (server) {

  const io = require('socket.io')(server);
  io.origins('*:*');
  const requestServices = require('./requestServices');

  io.sockets.on('connection', function (socket) {
    console.log('user connected');
    socket.on('join', (data, callback) => {
      socket.join(data.room);
      callback && callback();
    });

    socket.on('joinUser', (user, callback) => {
      socket.join(user.slug);
      console.log('user join user ' + user.slug);
      callback && callback();
    });

    socket.on('onType', (data) => {
      console.log(data);
      io.to(data.conversation_id).emit('typing', data);
    });

    socket.on('onRead', async (message_id, user, data, token, callback) => {
      try {
        await requestServices.readMessage(message_id, user, token);
        io.to(data.message.conversation_id).emit('read', data);
      } catch (ex) {
        console.log(ex.message);
      }

      callback && callback();
    });

    socket.on('onReadAll', async (data, token, callback) => {
      try {
        await requestServices.readAll(data, token);
        io.to(data.room).emit('readAll', data);
      } catch (ex) {
        console.log(ex);
      }

      callback && callback();
    });

    socket.on('sendMessage', async (data, token, callback) => {
      try {
        const { data: { data: response } } = await requestServices.sendMessage(data, token);
        io.to(response.message.conversation_id).emit('recieveMessage', response);
        io.to(data.reciver).emit('notify', response);
      } catch (ex) {
        callback && callback('Could not send message try again.');
      }
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