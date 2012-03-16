    <?php  
    /** 
     * 客户端代码 
     */         
    error_reporting(0);  
    set_time_limit(0);  
    echo " TCP/IP Connection /n";  
    $service_port = 10001;  
    $address = '127.0.0.1';  
	
	var host = "ws://localhost:12345/websocket/server.php";
	
		try{
		
			socket = new WebSocket(host);
			log('WebSocket - status '+socket.readyState);
			socket.onopen    = function(msg){ log("Welcome - status "+this.readyState); };
			socket.onmessage = function(msg){ log("Received: "+msg.data); };
			socket.onclose   = function(msg){ log("Disconnected - status "+this.readyState); };
		  
		}
		catch(ex){ 
			log(ex);
		}
	
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);  
		
    if ($socket === false)  
    {  
        die;  
    }  
    else  
    {  
        echo "OK";  
    }  
    echo "试图连接 ";  
    if (socket_connect($socket, $address, $service_port) == false)  
    {  
        $error = socket_strerror(socket_last_error());  
        echo "socket_connect() failed./n","Reason: {$error} /n";  
        die;  
    }  
    else  
    {  
        echo "连接OK/n";  
    }  
    $in   = "Hello World/r/n";  
    if (socket_write($socket, $in, strlen($in)) === false)  
    {  
        echo "socket_write() failed: reason: " . socket_strerror(socket_last_error()) ."/n";  
        die;  
    }  
    else  
    {  
        echo "发送到服务器信息成功！/n","发送的内容为: $in  /n";  
    }  
    $out  = "";  
    while ($out = socket_read($socket, 8192))  
    {  
        echo "接受的内容为: ".$out;  
    }  
    echo "关闭SOCKET…/n";  
    socket_close($socket);  
    echo "关闭OK/n";  
    ?>  