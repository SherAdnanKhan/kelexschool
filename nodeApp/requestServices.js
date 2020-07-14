const axios = require('axios');
var base_url = process.env.BACKEND_APP_URL;

module.exports = {
  sendMessage: function (data, token) {
    return axios.post(base_url + 'chats/message', data, {
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
  }
};