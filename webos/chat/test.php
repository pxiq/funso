<?php  
/** 
 * �������˴��� 
 * 
 */  
//ȷ�������ӿͻ���ʱ���ᳬʱ  
set_time_limit(0);  
//����IP�Ͷ˿ں�  
$address = "localhost";  
$port = 1234; //���Ե�ʱ�򣬿��Զ໻�˿������Գ���  
//����һ��SOCKET  
if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false)  
{  
    echo "socket_create() ʧ�ܵ�ԭ����:" . socket_strerror(socket_last_error()) . "/n";  
    die;  
}  
//����ģʽ  
if (socket_set_block($sock) == false)  
{  
    echo "socket_set_block() ʧ�ܵ�ԭ����:" . socket_strerror(socket_last_error()) . "/n";  
    die;  
}  
//�󶨵�socket�˿�  
if (socket_bind($sock, $address, $port) == false)  
{  
    echo "socket_bind() ʧ�ܵ�ԭ����:" . socket_strerror(socket_last_error()) . "/n";  
    die;  
}  
//��ʼ����  
if (socket_listen($sock, 4) == false)  
{  
    echo "socket_listen() ʧ�ܵ�ԭ����:" . socket_strerror(socket_last_error()) . "/n";  
    die;  
}  
do  
{  
    if (($msgsock = socket_accept($sock)) === false)  
    {  
        echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error()) . "/n";  
        die;  
    }  
    //�����ͻ���  
    $msg = "welcome /n";  
    if (socket_write($msgsock, $msg, strlen($msg)) === false)  
    {  
        echo "socket_write() failed: reason: " . socket_strerror(socket_last_error()) ."/n";  
        die;  
    }  
    echo "��ȡ�ͻ��˷�������Ϣ/n";  
    $buf = socket_read($msgsock, 8192);  
    echo "�յ�����Ϣ: $buf   /n";  
     
    socket_close($msgsock);  
} while (true);  
socket_close($sock);  
?> 