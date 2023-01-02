 
BASEURL ="http://localhost/dealer_app/index.php/";
 var addEditForm ="loginForm";

 
$(document).ready(function(e){
	// $("#loginForm").validate({
	
	// 	rules: {   
	// 		UserName:"required",        
	// 		Password: "required",
	// 	},
		 
	
	// 	messages: {
	// 		UserName: "Select Country",
	// 		Password: " Enter Dealer level",        
	// 	},
		
	// 	errorElement: "em",
	// 	errorPlacement: function ( error, element ) {
			
	// 		error.addClass( "help-block" );
	
	// 		if ( element.prop( "type" ) === "checkbox" ) {
	// 			error.insertAfter( element.parent( "label" ) );
	// 		} else {
	// 			error.insertAfter( element );
	// 		}
	// 	},
	// 	highlight: function ( element, errorClass, validClass ) {
	// 		$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
	// 	},
	// 	unhighlight: function (element, errorClass, validClass) {
	// 		$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
	// 	},
	// });



    $("#loginForm").submit(function(e){		
		e.preventDefault();	
		var uname = document.getElementById("UserName").value;
		var pwdusr = document.getElementById("LoginPswd").value;
		if(uname=="")
		{
			document.getElementById("err1").innerHTML = "Please enter user name";
		}
		else{
			var msg1="OK";
			document.getElementById("err1").innerHTML = " ";
	    }
		if(pwdusr=="")
		{
			document.getElementById("err2").innerHTML = "Please enter password";
			

		}
		else
		{
			var msg2="OK";
			document.getElementById("err2").innerHTML = " ";
		}
         if(msg1=="OK" && msg2=="OK")
		 {
		    document.getElementById("err3").innerHTML = " ";
		
		var formData = $("#loginForm").serialize();
		$.ajax({
			type: 'POST',
			url: BASEURL+"verifyLogin",
			data: formData,
			dataType: "json",
			success: function(resultData) { 
				if(resultData.Status == "1"){
					
					window.location = BASEURL+"";	
				} else {
					//alert(resultData.Message); 
					document.getElementById("err3").innerHTML = "Invalid UserName/Password";

				}
			},
			error : function(error) { 
				
			}
		});			
	}	
	});
});
