    <?php  
    /** 
     * �ͻ��˴��� 
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
    echo "��ͼ���� ";  
    if (socket_connect($socket, $address, $service_port) == false)  
    {  
        $error = socket_strerror(socket_last_error());  
        echo "socket_connect() failed./n","Reason: {$error} /n";  
        die;  
    }  
    else  
    {  
        echo "����OK/n";  
    }  
    $in   = "Hello World/r/n";  
    if (socket_write($socket, $in, strlen($in)) === false)  
    {  
        echo "socket_write() failed: reason: " . socket_strerror(socket_last_error()) ."/n";  
        die;  
    }  
    else  
    {  
        echo "���͵���������Ϣ�ɹ���/n","���͵�����Ϊ: $in  /n";  
    }  
    $out  = "";  
    while ($out = socket_read($socket, 8192))  
    {  
        echo "���ܵ�����Ϊ: ".$out;  
    }  
    echo "�ر�SOCKET��/n";  
    socket_close($socket);  
    echo "�ر�OK/n";  
    ?>  