
var ServerMgr = function(se){	

	$('#container').css('display','none');
	$('#add-server').show();
	
	serverData = {};	server = [];	
	serverWin  = typeof se == 'object'? se :$('#' + se);
	
	this.sNewAdd = function(){		
		var server = new Server(serverWin);		
		server.AddWin(serverWin);			
	};	
};


var Server = function(sWin){		
		
	var winIcon ;
	
	this.AddWin = function(){
	
		var timeId = new Date();
		
		var serverTime = timeId.getTime();
		
		//winIcon = $('div /').addClass().attr('id',serverTime+'server');
		
		//var $('<input class="easyui-validatebox" type="text" name="serverKey" id="serverKey" dataType="str" />
		
		//var <input class="easyui-validatebox" type="text" name="serverName" id="serverName" dataType="str" />
		
		//var <input class="easyui-validatebox" type="text" name="IP1" id="IP1" dataType="str" required="true"/>
		
		//var  <input class="easyui-validatebox" type="text" name="IP2" id="IP2" dataType="str" />
	
	}
}