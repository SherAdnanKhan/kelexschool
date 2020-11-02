const axios = require('axios');
var base_url = process.env.BACKEND_APP_URL;

module.exports = {
  setOnlineStatus: function (online, token) {
    return axios.get(base_url + `user/online-status/${online}`, {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json'
      }
    });
  },

  sendMessage: function (data, token) {
    return axios.post(base_url + `chats/message`, data, {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json'
      }
    });
  },

  readMessage: function (message_id, user, token) {
    return axios.post(base_url + `chats/message/read/${message_id}`, user, {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json'
      }
    });
  },

  readAll: function (data, token) {
    return axios.post(base_url + `chats/message/read-all`, { conversation_id: data.room }, {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json'
      }
    });
  },

  checkMuteStatus: function (reciver_id, token) {
    return axios.post(base_url + `users/check-status-mute`, { check_mute_user_id: reciver_id }, {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json'
      }
    });
  }
};