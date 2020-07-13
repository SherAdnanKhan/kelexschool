require('./config')();
const express = require('express');
const app = express();
server = require('http').createServer(app);
require('./socket')(server);

server.listen(process.env.NODE_APP_PORT, () => {
  console.log('Server is running on: ', process.env.NODE_APP_PORT);
});