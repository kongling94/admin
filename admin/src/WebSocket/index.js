const root = process.env.API_ROOT;
const ws = new WebSocket('ws://' + root);

// 建立链接
ws.onopen = function() {
    // 使用 send() 方法发送数据
    ws.send('发送数据');
    alert('数据发送中...');
};

// 接收服务端数据时触发事件
ws.onmessage = function(evt) {
    var received_msg = evt.data;
    alert('数据已接收...');
};

// 断开 web socket 连接成功触发事件
ws.onclose = function() {
    alert('连接已关闭...');
};
// 错误
ws.onerror = function(evt) {
    //产生异常
};
