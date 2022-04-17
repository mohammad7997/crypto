var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);


// config redis io for crypto-data-channel
var Redis = require('ioredis');
var redis = new Redis();
redis.subscribe('crypto-data-channel', (err, count) => {
    if (err) {
    console.error("Failed to subscribe: %s", err.message);
    } else {
        console.log(
        `Subscribed successfully! This client is currently subscribed to ${count} channels.`
        );
    }
});


// send data to front
redis.on("message", (channel, message) => {
    const data = JSON.parse(message).data;
    let messages = data.crypto_data;
    io.emit(channel,messages);
});



http.listen(3000, () => {
    console.log('listening on *:3000');
});

