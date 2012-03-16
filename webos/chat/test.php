<?php  
/** 
 * 服务器端代码 
 * 
 */  
//确保在连接客户端时不会超时  
set_time_limit(0);  
//设置IP和端口号  
$address = "localhost";  
$port = 1234; //调试的时候，可以多换端口来测试程序！  
//创建一个SOCKET  
if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false)  
{  
    echo "socket_create() 失败的原因是:" . socket_strerror(socket_last_error()) . "/n";  
    die;  
}  
//阻塞模式  
if (socket_set_block($sock) == false)  
{  
    echo "socket_set_block() 失败的原因是:" . socket_strerror(socket_last_error()) . "/n";  
    die;  
}  
//绑定到socket端口  
if (socket_bind($sock, $address, $port) == false)  
{  
    echo "socket_bind() 失败的原因是:" . socket_strerror(socket_last_error()) . "/n";  
    die;  
}  
//开始监听  
if (socket_listen($sock, 4) == false)  
{  
    echo "socket_listen() 失败的原因是:" . socket_strerror(socket_last_error()) . "/n";  
    die;  
}  
do  
{  
    if (($msgsock = socket_accept($sock)) === false)  
    {  
        echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error()) . "/n";  
        die;  
    }  
    //发到客户端  
    $msg = "welcome /n";  
    if (socket_write($msgsock, $msg, strlen($msg)) === false)  
    {  
        echo "socket_write() failed: reason: " . socket_strerror(socket_last_error()) ."/n";  
        die;  
    }  
    echo "读取客户端发来的信息/n";  
    $buf = socket_read($msgsock, 8192);  
    echo "收到的信息: $buf   /n";  
     
    socket_close($msgsock);  
} while (true);  
socket_close($sock);  
?> 