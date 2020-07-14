const axios = require('axios');
var base_url = 'https://staging-api.meuzm.com/api/v1/';
axios.defaults.base_url = base_url;

module.exports = {
  sendMessage: function (data, token) {
    return axios.post(base_url + 'chats/message', data, {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json'
      }
    });
    // .then(res => {
    //   const response = res.data.data;
    //   console.log(response);
    //   return response;
    // })
    // .catch(err => {
    //   throw new Error(err.response.data);
    // });
  },
  bar: function () {
    // whatever
  }
};