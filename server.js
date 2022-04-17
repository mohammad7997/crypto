var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var users = [];

var Redis = require('ioredis');
var redis = new Redis();
redis.subscribe('crypto-data-channel', (err, count) => {
  if (err) {
    // Just like other commands, subscribe() can fail for some reasons,
    // ex network issues.
    console.error("Failed to subscribe: %s", err.message);
  } else {
    // `count` represents the number of channels this client are currently subscribed to.
    console.log(
      `Subscribed successfully! This client is currently subscribed to ${count} channels.`
    );
  }
});


redis.on("message", (channel, message) => {

    const data = JSON.parse(message).data;
    let messages = data.crypto_data;

    io.emit(channel,messages);
});



http.listen(3000, () => {
    console.log('listening on *:3000');
});

