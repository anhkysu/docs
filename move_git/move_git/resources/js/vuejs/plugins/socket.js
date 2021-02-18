export default {
    // Socket register for user login
    online(data){
        socketClient.emit('IIMS_PUB_SUB_ONLINE', data);
    },
    sendNotificationForIOData(data){
        socketClient.emit('IIMS_PUB_SUB_IODATA_NOTIFICATION', data);
    },
    receiveNotificationForIOData(callback){
        socketClient.on('PERSONAL_MESSAGE', callback);
    }
};