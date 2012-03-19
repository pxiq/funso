<?php
require_once '../include/Config.php';
class handleRoom {

    private $tCmd;
	
	public function  __construct(){       
        $this->tCmd = SqlCommand::getInstance(0);
    }
		
	public function handleRun(){				
		
		$accept = $_REQUEST;
		$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
		
		if($action == 'addRoom'){			
			$this->addRoom($accept);
		}
		
		if($action == 'updateRoom'){
			$this->updateRoom($accept);
		}
		
		if($action == 'deleRoom'){
			$this->deleRoom($accept);
		}
		
		if($action == 'checkName'){
			$this->checkName($accept);	
		}	
		
		if($action == 'showRoom'){			
			$this->showRoom();			
		}
		
		if($action == 'updatePos'){
			$this->updateRomPos($accept);
		}
		
	}
	
	private function addRoom($acc){
	
		$addTime = date('Y-m-d H:i:s');		
		$addSQL  = " INSERT INTO mon_room values(NULL,'{$acc["roomName"]}','{$acc["roomDesc"]}','{$acc['roomTop']}','{$acc['roomLeft']}','','{$addTime}')";        
		$result  =  $this->tCmd->ExecuteNonQuery($addSQL);
		
		$roomId  = mysql_insert_id();		
		$backSQL = " SELECT roomId,roomName,roomDesc,roomTop,roomLeft from mon_room WHERE roomId = '{$roomId}'";
		$showResult = $this->tCmd->ExecuteArrayQuery($backSQL);		
		$showResult = $this->delNumIndex($showResult);
		if($result){
			echo json_encode($showResult);
		}else{
			echo 'no';
		}		
	}
	
	private function updateRoom($acc){
	
		$upsql = " UPDATE mon_room SET roomName='{$acc["roomName"]}',roomDesc='{$acc["roomDesc"]}' WHERE roomId='{$acc["roomId"]}'";
		$this->tCmd->ExecuteNonQuery($upsql);	
		$cnt 	= $this->tCmd->db_affected_rows(null);
		if($cnt == 1){
			echo 'ok';
		}else{
			echo 'no';
		}		
	}
	
	private function deleRoom($acc){
		
		//此处需要判断机房内是否有机器存在，此段代码并未处理		
		$roomId = $acc['roomId'];
		$delSQL = " DELETE FROM mon_room WHERE roomId = '{$roomId}'";
		$Result = $this->tCmd->ExecuteNonQuery($delSQL);
		$cnt 	= $this->tCmd->db_affected_rows(null);		
		if($cnt){
			echo 'ok';
		}else{
			echo 'no';
		}
	}		
	
	private function checkName($acc){
	
		$checkName = $acc['roomName'];
		$checkSQL  = "SELECT * FROM mon_room where roomName = '{$checkName}'";
		$checkResult = $this->tCmd->ExecuteArrayQuery($checkSQL);
		if(count($checkResult)!=0){
			echo 'have';
		}else{
			echo 'nohave';
		}
	}
	
	private function showRoom(){	
	
		$showSQL = "SELECT roomId,roomName,roomDesc,roomTop,roomLeft from mon_room ";
		
		$showResult = $this->tCmd->ExecuteArrayQuery($showSQL);	
		
		$showResult = $this->delNumIndex($showResult);
		
		echo json_encode($showResult);
	}
	
	private function delNumIndex($showResult){
		foreach($showResult as $kay=>$val){
			foreach($val as $ka=>$va){
				if(is_numeric($ka)){
					unset($showResult[$kay][$ka]);
				}	
			}
		}
		return $showResult;
	}
	
	private function updateRomPos($acc){
	
		$roomId = substr($acc["roomId"],4);
		$posSQL = "UPDATE mon_room set roomTop = '{$acc["roomTop"]}',roomLeft = '{$acc["roomLeft"]}' where roomId='{$roomId}'";
		$posResult = $this->tCmd->ExecuteNonQuery($posSQL);
		$cnt 	= $this->tCmd->db_affected_rows(null);
	}

}
$addR = new handleRoom();
$addR->handleRun();