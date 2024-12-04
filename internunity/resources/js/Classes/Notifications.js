import WebSocket from "./WebSocket";

export default class Notifications extends WebSocket {
    subscribeToPrivate(channel, callback) {
        window.Echo.private(channel).notification((notification) => {
            callback(notification)
        });
    }
    unsubscribe() {

    }
}
