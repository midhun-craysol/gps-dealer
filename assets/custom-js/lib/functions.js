function handleDelete(delData,delUrl){
	var titleStr = "Alert : CCM";
	var MessageText = "Are you sure you want to delete?";
	var altStr = 'Info';
	var imgStr = 'assets/images/alert-icons/DeleteAlert.png';
	var MessageData ="<div class='row'><div class='col-sm-2'><img src='"+imgStr+"' alt='"+altStr+"' width='50' height='50'><span style='padding:10px'></div><div class='col-sm-10'><div style='padding-top:10px;'><b>"+tabx+" : "+MessageText+"</b></div></span>"+"</div></div>";
	//var MessageData ="<div style='padding: 10px;'><div><img src='"+imgStr+"' alt='"+altStr+"' width='50' height='50'><span style='padding:10px'><b>"+tabx+" : "+MessageText+"</b></span>"+"</div></div>";
	bootbox.confirm({
		title: titleStr,
    	message: MessageData,
		buttons: {
			confirm: {
				label: 'Yes', 
			},
			cancel: {
				label: 'No',
			}
		},
		callback: function (result) {
			if(result==true) {
				$.ajax({
					type: 'POST',
					url: BASEURL+delUrl,
					data: delData,
					dataType: "json",
					success: function(resultData) { 
						if(resultData.Status == 1){	
							var Message = "Successfully Deleted";
							alertBox(resultData.Status,Message,tabx);
							$('#'+tableID).DataTable().ajax.reload( null, false ); 
						}
						else if (resultData.Status == -1){	 
							var Message ="In use , can't be deleted";
							alertBox(resultData.Status,Message,tabx);
						}
						else if (resultData.Status == 0){
							var Message = "Deletion Failed";
							alertBox(resultData.Status,Message,tabx);
						}
						else{
							
							var Message = "Something went wrong";
							alertBox(resultData.Status,Message,tabx);

						}
					},
					error : function(error) { 
						console.log(error);
					}
				});
			}
		}
	});
	
}
function alertBox(Status,Message,Page=""){
	var titleStr = "Alert : CCM";
	var imgStr = "";
	var statusMes="";
	var altStr="";
	if(Status==-1) {
		imgStr = 'assets/images/alert-icons/infoAlert.png';
		altStr = 'Info'; //operation can't delete
	}
	if(Status==0) {
		imgStr = 'assets/images/alert-icons/FailAlert.png';
		altStr = 'FailAlert'; //operation perform fail
	}
	if(Status==1) {
		imgStr = 'assets/images/alert-icons/SucessAlert.png';
		altStr = 'Success'; //operation perform sucess
	}
	if(Status==2) {
		imgStr = 'assets/images/alert-icons/WarningAlert.png';
		altStr = 'Duplicate Entry';  // Operation 
	}
	if(Status==3) {
		imgStr = 'assets/images/alert-icons/FailAlert.png';
		altStr = 'FailAlert';
		Message += " - Invalid user type";
	}
	if(Status==4) {
		imgStr = 'assets/images/alert-icons/WarningAlert.png';
		altStr = 'Warning'; //Server not found
		Message = "Server Not Found Error:404";
	}
	var box = bootbox.alert({	
		title: titleStr,
		backdrop : true,
		message: "<div class='row'><div class='col-sm-2'><img src='"+imgStr+"' alt='"+altStr+"' width='50' height='50'><span style='padding:10px'></div><div class='col-sm-10'><div style='padding-top:10px;'><b>"+Page+" : "+Message+"</b></div></span>"+"</div></div>"
		
	});
}

function handleCreateEdit(url,formData,msgResponse,parent=false){
	if(parent == true){
		tabAlert = parentTab;
	}
	else{
		tabAlert = tabx;
	}
	// $(".modalLoader").show();
	$.ajax({
		type: 'POST',
		url: url,
		data: formData,
		dataType: "json",
		success: function(resultData) { 
			if(resultData.Status == "1"){
				alertBox(resultData.Status,resultData.Message,tabAlert);
				if(typeof(noTable) !== 'undefined') {					
					formResetModalReload(parent,false);	
				}
				else{					
					formResetModalReload(parent);	
				}
			}  
			else if(resultData.Status == "2" || resultData.Status == "3" || resultData.Status == 2 || resultData.Status == 3){
				alertBox(resultData.Status,resultData.Message,tabAlert);
				if(typeof(noTable) !== 'undefined') {					
					formResetModalReload(parent,false);	
				}
				else{					
					formResetModalReload(parent);	 
				}
			} 
			else if(resultData.Status == "0" || resultData.Status == 0){					
				message = msgResponse+" Failed\n";
				message += (typeof(resultData.Message) !== 'undefined')?"\n"+resultData.Message:'';
				message += (typeof(resultData.Required) !== 'undefined')?"\n"+resultData.Required :'';
				alertBox(resultData.Status,message,tabAlert);
			}
			else{			
				$msgRes = msgResponse+" Failed\n";	
				alertBox(resultData.Status,$msgRes,resultData.Page);
					
			}
		},
		error : function(error) { 
			console.log(error);
		},
		complete : function(){
			$(".modalLoader").hide();
		}
	});
}
function formResetModalReload(parent=false,tableReload=true){
	if(parent){
		$("#"+parentForm)[0].reset();
		$("#"+parentFormModalBox).modal("hide");
	}
	else{
		$("#"+addEditForm)[0].reset();
		$("#"+formModalBox).modal("hide");
		if(tableReload === true){
			$("#"+tableID).DataTable().ajax.reload( null, false );
		}
		if(typeof(pageReload) != 'undefined' && pageReload == true){
			location.reload();
		}
	}
}
function addHFieldToForm(formName,fldName,fldValue){	
	$('<input>').attr({
		type: 'hidden',
		id: fldName,
		name: fldName,
		value: fldValue,
	}).appendTo('#'+formName);
}


