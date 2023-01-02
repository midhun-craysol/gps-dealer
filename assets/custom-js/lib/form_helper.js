$(document).ready(function(){	
	if(typeof addEditForm !== 'undefined' && addEditForm!=""){
		$("#"+addEditForm).submit(function(e){	
			e.preventDefault();	
			if($( "#"+addEditForm ).valid()){				
				var msgResponse = " Creation";
				var url = BASEURL+addUrl;
				
				//Changing base Url if the case is edited.
				if(($('#'+IdField).length)&&($('#'+addEditForm+' input[name="'+IdField+'"]').val() !='')){			
					url = BASEURL+updateUrl;						
					msgResponse = " Updation";					
				}
				var formData = $("#"+addEditForm).serialize();
				handleCreateEdit(url,formData,msgResponse);
			}
		});
	}
});

$.validator.addMethod("blankSpace", function(value, element) {
	if(value.substring(0,1)!=" " && value.substr(-1)!=" "){
		return value.trim() != "" && value != ""; 
	}
}, "No white space please");

$.validator.addMethod("emailVal", function(value, element) {
	var mailformat = (/^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i);			
	if(value.match(mailformat)){			
		return value;
	}
}, "Please enter a valid email address.");

function caretPosition(input) {
	var start = input[0].selectionStart,
		end = input[0].selectionEnd,
		diff = end - start;
	if (start >= 0 && start == end) {
		return start;
	} else if (start >= 0) {
  return start;
	}
}

function toTitleCase(str) {
    str = str.split(' ');
    for (var i = 0; i < str.length; i++) {
      str[i] = str[i].charAt(0).toUpperCase() + str[i].slice(1);
    }
    return str.join(' ');
  }
$.fn.selectRange = function(start, end) {
    if(end === undefined) {
        end = start;
    }
    return this.each(function() {
        if('selectionStart' in this) {
            this.selectionStart = start;
            this.selectionEnd = end;
        } else if(this.setSelectionRange) {
            this.setSelectionRange(start, end);
        } else if(this.createTextRange) {
            var range = this.createTextRange();
            range.collapse(true);
            range.moveEnd('character', end);
            range.moveStart('character', start);
            range.select();
        }
    });
};
