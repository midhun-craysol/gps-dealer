tabx = "User";
IdField = "UserID";
tableID ="userTable";
ajaxUrl ="userDtTable";
pageTable ="userTable";
formModalBox  ="userFormModal";	
addEditForm = "userForm";
addUrl = "addUser";	
detailUrl = "userDetails";
updateUrl = "updateUser";
delUrl = "delUser";

function delUser(id){
    delData = {UserID:id};
  handleDelete(delData,delUrl);
}

tdList = ['UserID', 'UserName', 'LoginID','UserType','Status','Actions'];
loadDataTable(tableID ,tdList,ajaxUrl);
var somethingChanged = false;
$('input').on('keypress',function() { 
    somethingChanged = true; 
    $("#userSubmit").attr("disabled", false);
});
$('#'+addEditForm+' input[type="checkbox"]').change(function() { 
	$("#userSubmit").attr("disabled", false); 
		somethingChanged = true; 
});
$('#'+addUrl).click(function(e){
    $('#Status').removeAttr("checked");
    $("#Status").attr("value",0); 
    $('#PasswordDiv').show();  
    $('#Statusdiv').hide();  
    $("#"+addEditForm)[0].reset();  
    $('#userFormModal').modal("show");
    $('#UserID').remove();  
    $(".help-block").hide();
      if(($('#UserID').length)&&($('#'+addEditForm+' input[name="UserID"]').val() !='')){			
       $('#'+addEditForm+' input[name="UserID"]').remove();
       $('#'+addEditForm)[0].reset();
   }
   
});
$("#RestBtn").click(function() {
    $('#pwdFormUser')[0].reset();
});
$("#ViewPwd").click(function() {
 //var x = document.getElementById("Pswd");
var x= $("#PswdAdmin").attr("type");
  if (x=== "password") {
    $("#PswdAdmin").attr("type","text");
  } else {
    $("#PswdAdmin").attr("type","password");
  }

});
$("#ViewPwdUser").click(function() {
    //var x = document.getElementById("Pswd");
   var x= $("#Pswd").attr("type");
     if (x=== "password") {
       $("#Pswd").attr("type","text");
     } else {
       $("#Pswd").attr("type","password");
     }
   
   });

function resetPwd(id){
    $("#UserID").remove();
   
    if(id!=""){
    $(".help-block").hide();
    $('#pwdFormModal').modal("show");
    $('#pwdForm')[0].reset();
    $('<input>').attr({
        type: 'hidden',
        id: 'UserID',
        name: 'UserID',
        value: id,
    }).appendTo('#pwdForm');
}
}
function editUser(id){
    $('#'+addEditForm)[0].reset();
    $("#userSubmit").attr("disabled", true); 
    $(".help-block").hide();
    $("#Status").removeAttr("checked");
    $("#RootFlg").removeAttr("checked");
    $("#User").removeAttr("checked"); 
    $("#Admin").removeAttr("checked"); 
    $("#Admin").attr("disabled", false); 
    $("#User").attr("disabled", false);

    somethingChanged = false;
    $('#Statusdiv').show();
    $('#PasswordDiv').hide(); 
    var UserID = id;
    $('#'+formModalBox).modal("show");
        $.ajax({
            type: 'POST',
            url: BASEURL+detailUrl,
            data: {UserID:UserID},
            dataType: "json",
            success: function(resultData) { 
                if(resultData.data){ 
                    dat = resultData.data; 
                    $('#'+formModalBox).modal("show");
                    $("#UserName").val(dat.UserName);
                    $("#LoginID").val(dat.LoginID);
                     if(dat.UserType=="Admin"){
                        $("#Admin").val(dat.UserType);
                        $("#Admin").attr("checked","checked"); 
                        $("#Admin").attr("disabled", true); 
                        $("#User").attr("disabled", true); 


                    }
                     else{
                        $("#User").val(dat.UserType);
                        $("#User").attr("checked","checked"); 

                     }
                    $("#LoginID").val(dat.UserType);
                    $("#"+formModalBox).modal("show");
                    var val=0;
                    if(dat.Status==1){
                        $("#Status").attr("checked","checked");                        
                        val =1;                        
                    }  
                            
                    $("#Status").attr("value",val);                
                        $('<input>').attr({
                        type: 'hidden',
                        id: 'UserID',
                        name: 'UserID',
                        value: UserID,
                    }).appendTo('#'+addEditForm);

                   
                }
            },
            error : function(error) { 
                console.log(error);
            }
        });

}
$("#pwdForm").on('submit', function(e){
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: BASEURL+"pwdUpdate",
        data: new FormData(this),
        dataType:"json",
        contentType: false,
        processData:false,
        beforeSend:function(){
        },
        success: function(resultData) {
            if(resultData.Status == "1"){			
                alertBox(resultData.Status,resultData.Message,tabx);					
                $('#pwdFormModal').modal("hide");
            } 
        },
        error : function(error) { 
            console.log(error);
        }
    });
});

$("#pwdFormUser").on('submit', function(e){
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: BASEURL+"pwdUpdateUser",
        data: new FormData(this),
        dataType:"json",
        contentType: false,
        processData:false,
        beforeSend:function(){
        },
        success: function(resultData) {
            if(resultData.Status == "1"){			
                alertBox(resultData.Status,resultData.Message,tabx);
                var delayInMilliseconds = 2000; //1 second
                setTimeout(function() {
                    location.reload();
                }, delayInMilliseconds);					
            } 
            else{
                alertBox(resultData.Status,"Updation Failed",tabx);					

            }
        },
        error : function(error) { 
            console.log(error);
        }
    });
});
$("#pwdForm").validate({
    rules: {
         Pswd:{required:true,blankSpace:true},
    },
    messages: {   
        Pswd : "Enter Password",
    },
    errorElement: "em",
    errorPlacement: function ( error, element ) {             
        error.addClass( "help-block" ); 
        if ( element.prop( "type" ) === "checkbox" ) {
            error.insertAfter( element.parent( "label" ) );
        }else {
            error.insertAfter( element );
        }
    },
    highlight: function ( element, errorClass, validClass ) {
        $( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
    },
    unhighlight: function (element, errorClass, validClass) {
        $( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
    },
});
$("#"+addEditForm).validate({
    rules: {
        UserName: {required:true,blankSpace:true},
        LoginID: {required:true,blankSpace:true},
        Pswd:{required:true,blankSpace:true},
        UserType:{required:true},
    },
    messages: {
        UserName: "Enter username",
        LoginID:"Enter username",
        Pswd : "Enter Password",
        UserType : "Select User Type",

    },
    errorElement: "em",
    errorPlacement: function ( error, element ) {             
        error.addClass( "help-block" ); 
        if ( element.prop( "type" ) === "checkbox" ) {
            error.insertAfter( element.parent( "label" ) );
        }else {
            error.insertAfter( element );
        }
    },
    highlight: function ( element, errorClass, validClass ) {
        $( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
    },
    unhighlight: function (element, errorClass, validClass) {
        $( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
    },
});