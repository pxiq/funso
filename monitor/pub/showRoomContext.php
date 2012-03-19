<?php
require_once '../include/Config.php';
class showRoomContext {

	private $tCmd;
	
	public function  __construct(){       
        $this->tCmd = SqlCommand::getInstance(0);
    }

	public function showRCRun(){
		
		exit('[]');
	
	}


}
$showRC = new showRoomContext();
$showRC->showRCRun();
