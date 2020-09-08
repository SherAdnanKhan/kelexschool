module.exports = function (server) {

  let online_users = [];
  const videoRooms = {};

  const io = require('socket.io')(server);
  io.origins('*:*');
  const requestServices = require('./requestServices');


  io.sockets.on('connection', function (socket) {
    socket.on('join', (data, callback) => {
      socket.join(data.room);
      callback && callback();
    });

    socket.on('joinVideo', (data) => {
      socket.join(data.room);
      if (!videoRooms[data.room]) {
        videoRooms[data.room] = [{ user: data.user, socketId: socket.id }];
      } else {
        videoRooms[data.room].push({ user: data.user, socketId: socket.id });
        socket.emit('userList', videoRooms[data.room].filter(obj => obj.socketId !== socket.id))
      }
    });

    socket.on('outgoing-call', data => {
      const payload = {
        caller: data.caller,
        room: data.room,
        socketId: socket.id
      };

      data.participants.forEach(participant => {
        socket.to(participant.slug).emit('incoming-call', payload)
      });
    });

    socket.on('accept-call', data => {
      socket.to(data.callerSocket).emit('call-accepted', data)
    });

    socket.on('reject-call', data => {
      socket.to(data.callerSocket).emit('call-rejected', data)
    });

    socket.on('decline-call', data => {
      const payload = {
        caller: data.caller,
        room: data.room,
        socketId: socket.id
      };

      data.participants.forEach(participant => {
        socket.to(participant.slug).emit('call-declined', payload)
      });
      // socket.to(data.callerSocket).emit('call-rejected', data)
    });

    socket.on('call-user', data => {
      socket.to(data.userToCall).emit('call-made', data);
    });

    socket.on('make-answer', data => {
      socket.to(data.to).emit('answer-made', data);
    });

    socket.on('leave-call', data => {
      if (videoRooms[data.room]) {
        videoRooms[data.room] = videoRooms[data.room].filter(user => user.socketId !== socket.id);
        socket.to(data.room).emit('user-leave', { user: data.user, socketId: socket.id });
        socket.leave(data.room)
      }
    });

    socket.on('on-toggle-microphone', data => {
      socket.to(data.room).emit('toggle-microphone', data);
    })

    socket.on('joinUser', async (user, token, callback) => {
      socket.join(user.slug);
      socket.user = user.slug;
      socket.token = token;
      online_users.push(user.slug);

      try {
        await requestServices.setOnlineStatus(1, token);
      } catch (ex) {
        console.log(ex.message);
      }
      io.emit('onlineUsers', online_users);
      callback && callback();
    });

    socket.on('onType', (data) => {
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

        for (let reciever of data.recievers) {
          io.to(reciever).emit('notify', response);
        }
      } catch (ex) {
        callback && callback('Could not send message try again.');
      }
    });

    socket.on('leave', (data) => {
      socket.leave(data.room);
    });

    socket.on('userLeft', (user) => {
      socket.leave(user.slug);
      console.log('user left');
    });

    socket.on('userColorChange', (user) => {
      io.to(user.slug).emit('notifyColrChange', user);
    });

    socket.on('logout', () => {
      for (let room in videoRooms) {
        videoRooms[room] = videoRooms[room].filter(data => data.socketId !== socket.id);
        videoRooms[room].forEach(data => {
          socket.to(data.socketId).emit('user-leave', socket.id);
        });
      }
    });

    socket.on('disconnect', async () => {
      // var connectionMessage = socket.user + ' Disconnected from Socket ';
      console.log(`${socket.id} is disconnected`);

      for (let room in videoRooms) {
        videoRooms[room] = videoRooms[room].filter(data => data.socketId !== socket.id);
        io.to(room).emit('user-leave', { socketId: socket.id });
        socket.leave(room);
      }

      if (socket.user != undefined) {
        online_users = online_users.filter(slug => slug !== socket.user);
        try {
          await requestServices.setOnlineStatus(0, socket.token);
        } catch (ex) {
          console.log(ex.message);
        }
      }
      io.emit('onlineUsers', online_users);
    });

    socket.on('onUserNotifications', (data, notification_type, callback) => {
      io.to(data.reciever.slug).emit('reciveUserNotifications', data, notification_type);
      callback && callback();
    });

  });
};