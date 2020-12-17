module.exports = function (server) {

  let online_users = [];
  const videoRooms = {};
  const draws = {};

  const io = require('socket.io')(server);
  io.origins('*:*');
  const requestServices = require('./requestServices');

  const removeDuplicates = (users) => {
    const uniqueUsers = [];

    for (let user of users) {
      if (!uniqueUsers.some(uniqueUser => uniqueUser.slug === user.slug)) {
        uniqueUsers.push(user);
      };
    };
    return uniqueUsers;
  }

  io.sockets.on('connection', function (socket) {
    socket.on('joinUser', async (user, token, callback) => {
      socket.join(user.slug);
      socket.user = user.slug;
      socket.token = token;

      const userObject = {
        slug: user.slug,
        socketId: socket.id,
        token
      };

      if (!online_users.some(user => user.slug === userObject.slug)) {
        socket.broadcast.emit('onlineUser', userObject.slug);
      }

      online_users.push(userObject);

      try {
        await requestServices.setOnlineStatus(1, token);
      } catch (ex) {
        console.log(ex.message);
      }

      const users = removeDuplicates(online_users);

      callback && callback(users.map(user => user.slug));
    });

    socket.on('join', (data, callback) => {
      socket.join(data.room);
      callback && callback();
    });

    socket.on('joinVideo', (data, error) => {
      socket.join(data.room);
      if (!videoRooms[data.room]) {
        videoRooms[data.room] = [{ user: data.user, socketId: socket.id }];
      } else {
        if (videoRooms[data.room].some(item => item.user.id === data.user.id)) {
          error && error('You are already in the room');
        } else {
          videoRooms[data.room].push({ user: data.user, socketId: socket.id });
          socket.emit('userList', videoRooms[data.room].filter(obj => obj.socketId !== socket.id))
        }
      }
    });

    socket.on('rejoin-call', (data) => {
      const payload = {
        user: data.user,
        socketId: socket.id
      };

      socket.join(data.room);

      if (!videoRooms[data.room]) {
        videoRooms[data.room] = [payload];
      } else {
        videoRooms[data.room].push(payload);
      }
      socket.to(data.room).emit('call-rejoined', payload);
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
    });

    socket.on('call-user', data => {
      socket.to(data.userToCall).emit('call-made', data);
    });

    socket.on('make-answer', data => {
      socket.to(data.to).emit('answer-made', data);
    });

    socket.on('leave-call', data => {
      if (videoRooms[data.room]) {
        videoRooms[data.room] = videoRooms[data.room]
          .filter(user => user.user.id !== data.user.id);

        socket
          .to(data.room)
          .emit('user-leave', { user: data.user, socketId: socket.id });


        if (videoRooms[data.room].length === 0) {
          delete videoRooms[data.room];
          io.to(data.room).emit('onMeetingEnded');
        }
      }
    });

    socket.on('onMeetingStatus', (room, callback) => {
      if (videoRooms[room]) {
        return callback(true);
      }
      return callback(false);
    })

    socket.on('on-toggle-microphone', data => {
      socket.to(data.room).emit('toggle-microphone', data);
    })

    socket.on('onType', (data) => {
      socket.to(data.conversation_id).emit('typing', data);
    });

    socket.on('stopTyping', data => {
      socket.to(data.conversation_id).emit('typingStopped', data);
    })

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

        if (data.recievers.length === 1) {
          try {
            const { data: { is_muted } } = await requestServices.checkMuteStatus(data.recievers[0].id, socket.token);
            if (!is_muted) {
              io.to(data.recievers[0].slug).emit('notify', response);
            }
          } catch (ex) {
            console.log(ex.message);
          }
        } else {
          for (let reciever of data.recievers) {
            io.to(reciever.slug).emit('notify', response);
          }
        }
      } catch (ex) {
        console.log(ex.message)
        callback && callback('Could not send message try again.');
      }
    });

    socket.on('onDeleteMessage', payload => {
      socket.to(payload.room).emit('deleteMessage', payload.id);
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

    socket.on('logout', async (data) => {
      online_users = online_users.filter(user => user.token !== data.token);

      if (!online_users.some(user => user.slug === data.user.slug)) {
        try {
          await requestServices.setOnlineStatus(0, data.token);
        } catch (ex) {
          console.log(ex.message);
        }
        io.emit('offlineUser', data.user.slug);
      }
      socket.to(data.user.slug).emit('logout-called', { token: data.token });
    });

    socket.on('draw', payload => {
      socket.to(payload.room).emit('drawing', payload)
    });

    socket.on('open draw', payload => {
      socket.to(payload.room).emit('drawOpened', payload)
    });

    socket.on('disconnect', async () => {
      console.log(`${socket.id} is disconnected`);

      for (let room in videoRooms) {
        videoRooms[room] = videoRooms[room].filter(data => data.socketId !== socket.id);
        socket.leave(room);

        if (videoRooms[room].length === 0) {
          delete videoRooms[room];
          io.to(room).emit('onMeetingEnded');
        }
      }

      const userFound = online_users.find(user => user.socketId === socket.id);
      online_users = online_users.filter(user => user.socketId !== socket.id);

      if (userFound) {
        if (!online_users.some(user => user.slug === userFound.slug)) {
          try {
            await requestServices.setOnlineStatus(0, userFound.token);
          } catch (ex) {
            console.log(ex.message);
          }
          io.emit('offlineUser', userFound.slug);
        }
      }
    });

    socket.on('faveExhibitNotifications', async (data, notification_type) => {
      if (data.recievers && data.recievers.length > 0) {
        for (let reciever of data.recievers) {
          socket.to(reciever).emit('reciveUserNotifications', data, notification_type);
        }
      }
    });

    socket.on('onUserNotifications', async (data, notification_type, callback) => {
      //await requestServices.checkMuteStatus(socket.token, data.reciever.id);
      try {
        const { data: { is_muted } } = await requestServices.checkMuteStatus(data.reciever.id, socket.token);
        if (!is_muted) {
          io.to(data.reciever.slug).emit('reciveUserNotifications', data, notification_type);
        }
      } catch (ex) {
        console.log(ex.message);
      }
      callback && callback();
    });
  });
};