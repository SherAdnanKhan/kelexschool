const axios = require('axios');
var base_url = process.env.BACKEND_APP_URL;

module.exports = {
  setOnlineStatus: function (online, token) {
    console.log("set online");
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
  },

  callStart: function (data, token) {
    return axios.post(base_url + `chats/call-start`, data, {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json'
      }
    });
  },

  callJoin: function (data, token) {
    return axios.post(base_url + `chats/call-join`, data, {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json'
      }
    });
  },

  callEnd: function (data, token) {
    return axios.post(base_url + `chats/call-end`, data, {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json'
      }
    });
  },

  callDecline: function (data, token) {
    return axios.post(base_url + `chats/call-decline`, data, {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json'
      }
    });
  },
};