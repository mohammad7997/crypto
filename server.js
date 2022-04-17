var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var users = [];

var Redis = require('ioredis');
var redis = new Redis();

redis.subscribe('private-channel', (err, count) => {
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
    console.log(data);
    let messages = data.data.message;

    let recive_id = data.data.recive_id;
    console.log(channel);
    console.log(users);
    io.to(users[recive_id]).emit(channel,messages);
    // io.emit(channel,messages);
});



http.listen(3000, () => {
    console.log('listening on *:3000');
});

io.on("connection", (socket) => {
    socket.on("user_connected", (user_id)=>{
        users[user_id] = socket.id;
        io.emit('status_user',users)
    });

    socket.on("disconnect", () => {
        var i = users.indexOf(socket.id);
        users.splice(i,1,0);
        console.log(users);
        io.emit('status_user',users);
    });
});

