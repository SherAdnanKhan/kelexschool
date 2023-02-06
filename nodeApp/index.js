//require('./config')();
const dotenv = require('dotenv');
dotenv.config({ path: __dirname + '/../.env' });

const express = require('express');
const cors = require('cors');
const app = express();
app.use(cors);
const server = require('http').createServer(app);
require('./socket')(server);

server.listen(process.env.NODE_APP_PORT, () => {
  console.log('Server is running on: ', process.env.NODE_APP_PORT);
});