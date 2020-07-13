//require('./config')();
const dotenv = require('dotenv');
dotenv.config({ path: __dirname + '/../.env' });

const express = require('express');
const app = express();
server = require('http').createServer(app);
require('./socket')(server);

console.log(process.env.NODE_APP_PORT);
server.listen(process.env.NODE_APP_PORT, () => {
  console.log('Server is running on: ', process.env.NODE_APP_PORT);
});