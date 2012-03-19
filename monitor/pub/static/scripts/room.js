var RoomMgr = function(el){

    var _self = this;	
	
    var datas = {}, rooms = [];	
	
    ground = typeof el == 'object' ? el : $('#' + el);
	
    _self.load = function(roomsData){	
		var Roln =  roomsData.length;		
		for(var i=0;i<Roln;i++){			
			var r = new Room();
			r.showRoomIcon(roomsData[i],ground);
		}		
    };
	
    _self.newAdd = function(){
        var room = new Room();		
        room.showAdd(ground);
		return room;
    }

    _self.full = function(){
		alert('nihao');
    }	
}

var Room = function(){

	var _self = this;
	var data, tplIcon;	
	
	_self.setData = function(d){
		data = d;
	};	
	
	_self.getData = function(){
		return data;
	};	
	
	_self.showAdd = function(grd){		
		var timeId = new Date();		
		var roomIdByTime = timeId.getTime();
		
		if(tplIcon){
			tplIcon.remove();
		}	
		
		tplIcon = $('<div />').addClass('room_icon').attr( 'id' , roomIdByTime +'room' ); 		
		var title = $('<div />').attr('id', roomIdByTime +'title').addClass('title').html("Add New Room").appendTo(tplIcon);		
		var ctxBody = $('<div />').attr('id',roomIdByTime +'body').addClass('body').appendTo(tplIcon);		
		$('<form name="frm"id="'+roomIdByTime+'frm'+'">机房:<input name="roomName" size="19" id="'+ roomIdByTime +'roomName'+ '">'+'<b/>描述:<textarea name="roomDesc" id="'+roomIdByTime+'roomDesc"'+'></textarea></form>').appendTo(ctxBody);		
		var toolbar1  = $('<div />').attr('roomTool',roomIdByTime +'toolbar1').addClass('toolbar').appendTo(tplIcon);		
		var btnAdd    = $('<span class="'+roomIdByTime+'addRoom"/>').attr('addRoom',roomIdByTime +'add').html('增加').appendTo(toolbar1);	
		var btnThrow  = $('<span class="'+roomIdByTime+'delRoom"/>').attr('throwRoom',roomIdByTime+'throw').html('放弃').appendTo(toolbar1);		
		
		btnAdd.click(function(){		
			var roomTop = tplIcon.offset().top;			
			var roomLeft = tplIcon.offset().left;			
			var roomName = $('#'+roomIdByTime+'roomName').val();			
			var roomDesc = $('#'+roomIdByTime+'roomDesc').val();			
			if(roomName==''||roomDesc==''){
				alert('机房和描述为必填项');
				return;
			}			
			var Rurl = '/handleRoom.php?action=checkName&roomName='+$('#'+roomIdByTime+'roomName').val();			
			$.post(Rurl,function(checkR){
				if(checkR=='have'){
					alert('此机房名称已被使用,换个别的试试！');
					return;
				}else{
					var data = {'roomName':roomName,'roomDesc':roomDesc,'roomTop':roomTop,'roomLeft':roomLeft};
					var addsave = new Room();
					addsave.save(data,tplIcon,grd);
				}			
			});			
		});
		
		btnThrow.click(function(){	tplIcon.remove();	});		
		
		tplIcon.mouseover(function(){	toolbar1.css('visibility', 'visible'); 	});	
		
		tplIcon.draggable();
		
		grd.append(tplIcon);		
	};
		
	//由服务器数据显示当前已存在的机房
	_self.showRoomIcon = function(roomData,grd){
		
		var intAlarm ;
		
		if(tplIcon){ 	tplIcon.remove(); 	}	
		
		tplIcon = $('<div />').addClass('room_icon').attr( 'id','room'+roomData.roomId).css({position:'absolute',top:parseInt(roomData.roomTop),left:parseInt(roomData.roomLeft)});		
		
		var title = $('<div />').attr('id','title'+roomData.roomId).addClass('title').html(roomData.roomName).appendTo(tplIcon);
		
		var ctxBody = $('<div />').attr('id','body'+roomData.roomId).addClass('body').appendTo(tplIcon);
				
		$('<form name="frm" /><br/><b>机房:</b><span name="roomName" id='+'"roomName'+roomData.roomId+'">' + roomData.roomName+'</span>'+'<br/><br/><b>描述:</b><span name="roomDesc" id='+'"roomDesc'+roomData.roomId+'"'+'>'+roomData.roomDesc+'</span>').appendTo(ctxBody);	
		
		var toolbar1  = $('<div />').attr('roomId','toolbar1'+roomData.roomId).addClass('toolbar').appendTo(tplIcon);
		
		var btnEdit   = $('<span />').attr('editRoom','edit'+roomData.roomId).html('编辑').appendTo(toolbar1);	
		
		var btnDel    = $('<span />').attr('delRoom','del'+roomData.roomId).html('删除').appendTo(toolbar1);
		
		roomData.warning = 1;//此字段用于判断本机房是否有报警	
		
		if(roomData.warning){ tplIcon.addClass('warnone'); }
		
		tplIcon.mouseover(function(){ toolbar1.css('visibility', 'visible'); });
		
		btnEdit.click(function(){			
			editroom(roomData);			
		});
		
		tplIcon.dblclick(function(){			
			tplIcon.removeClass("warnone")
			var bigRoomId = 'big' + $(this).attr('id');		
			grd.css('display','none');
			
			var Roomdata = {'bigRoomId':bigRoomId,'bigRoomName':roomData.roomName,'top':grd.offset().top,'left':grd.offset().left};			
			loadInBigRoom(Roomdata);					
		});
		
		tplIcon.mouseout(function(){ toolbar1.css('visibility','hidden'); });
		
		btnDel.click(function(){			
			var roomId = $(this).attr('delRoom').substr(3);		
			$('.sureDiv').html('<b style="color:red;"><be/><br/>你确信删除此机房?</b>').dialog({
				title:'删除机房',
				height:160,
				modal: true,
				buttons: 
					{"确定": function() {
							var url = '/handleRoom.php?action=deleRoom&roomId='+roomId;
							$.post(url,function(r){
								
								if(r=='ok'){
									tplIcon.remove();
									$('.sureDiv').dialog( "close" );
								}else{
									$('.sureDiv').html('<b style="color:red;"><be/><br/>此机房有机器在被监控,不可删除!</b>');
									return;
								}				
							});							
						},
					'取消': function() {$( this ).dialog( "close" );}
				}
			});	
		});
		
		if(data){	tplIcon.empty(); }		
		
		tplIcon.draggable({		
			start:function(){//alert('start'+$(this).offset().top+$(this).attr('id'));
			},			
			stop:function(){							
				var da ={'roomTop':$(this).offset().top,'roomLeft':$(this).offset().left,'roomId':$(this).attr('id')};				
				var url = '/handleRoom.php?action=updatePos';				
				$.post(url,da,function(r){					
				});
			},			
			drag: function(){}			
		});	
		
		grd.append(tplIcon);			
	};
	
	var editroom = function(roomData){
	
		var roomeId   = roomData.roomId ;
		var roomDesc = roomData.roomDesc ;
	    var roomName = roomData.roomName ;  	   
	    var r = '<br/>机房:<input type="text" id='+"roomedit"+ roomeId +' value='+roomName+' />'+'<br/>描述:<br/><textarea style="margin-left:32px;"id="descedit">' + roomDesc + "</textarea><br/><br/>";
    	$('#edit').html(r).dialog({
      		title:'编辑机房',        	
      		modal:true,
      		width:286,
      		height:268,        	
      		buttons:{
      			修改:function(){				
      				    var roomname2 = $('#roomedit'+roomeId).val();						
      				    var roomdesc2 = $('#descedit').val();						
      				    if( roomname2 == roomName && roomdesc2 == roomDesc ){
      				    	$(this).dialog('close');
      				    }else{
	      					var url="/handleRoom.php?action=updateRoom";
	      					var data={'roomId':roomeId,'roomDesc':roomdesc2,'roomName':roomname2};
	      					$.post(url,data,function(r){
								if(r=='ok'){
									$('#edit').dialog('close');
									var rn=$('#roomName'+roomeId).text(roomname2);
									$('#title'+roomeId).text(roomname2);
									$('#roomDesc'+roomeId).text(roomdesc2);									
								}else{
									$('#edit').append('&nbsp;&nbsp;<b style="color:red;">修改失败,请核实!</b>');
									return ;
								}
	      					});	
      				    }
      			},
      			取消:function(){
      				$(this).dialog('close');
      			}
      		}
      	}); 
	};
	
	var loadInBigRoom = function(data){	
	
		var bigRoomData;
		
		var url = '/showRoomContext.php?action=showBig&roomId='+data.bigRoomId.substr(7);
		
		$.post(url,function(bigData){
			if(bigData.length!=0){
				bigRoomData = bigData;				
			}else{
				//alert('没有数据');
			}		
		},'json');	
		
		var bigRooms = $('.bigRoom').attr('bigRoomId',data.bigRoomId).css({'top':data.top,'left':data.left,"border":"1px solid #BBB","background-color":'#F7F7F7','height':1200,'display':"block"});
		var bigRoom = 'bigRoom';
		var btnBigTitle = $('<div style="background-color:#E7E7E7;height:16px;font-size:120%;"><span>&nbsp;hello world</span><img class="ui-icon ui-icon-circle-close" onclick= "closeBigRoom(this);" style="float:right;" title="关闭" />&nbsp;</div>').appendTo(bigRooms);
		
		closeBigRoom = function(ob){		
			var cls  = $(ob.parentNode.parentNode).attr('bigRoomId');			
			$(ob.parentNode.parentNode).html('').css('display','none');
			$('#container').show();
		};				
	};	
	
	_self.edit = function(){}
	
	_self.save = function(data,tplIcon,grd){				
		var url = '/handleRoom.php?action=addRoom';				
		$.post(url,data,function(r){						
			if(r=='no'){
				alert('增加失败,请核实数据!');
				return; 									
			}else{
				tplIcon.remove();
				var roomMgr = new RoomMgr('container');								
				roomAdd  = new roomMgr.load(r);
			}
		},"json");	
	}
	
	_self.remove = function(){	}	
}