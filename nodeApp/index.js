require('./config')();
const express = require('express');
const app = express();
server = require('http').createServer(app);
require('./socket')(server);

let port = 8080;

server.listen(port, () => {
  console.log('Server is running on: ', port);
});