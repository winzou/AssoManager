
$(document).ready(function() {
    $(document).ajaxError(function(event, jqXHR) {
        var message;
        
        try {
            var response = JSON.parse(jqXHR.responseText);
            message = response.message ? response.message : 'Sf2: ' + response[0].message;
        }
        catch(err) {
            message = jqXHR.responseText;
        }
        
        if(!message)
        {
            if(403 === jqXHR.status) {
                message = 'Acces denied, please login again.';
            }
            else if(404 == jqXHR.status) {
                message = 'Page not found.';
            }
            else if(500 == jqXHR.status) {
                message = 'Server-side error.';
            }
            else {
                message = 'Unknown error!';
            }
        }
        
        alert(message);
    });
});

$(".wbb_ajx_delete").click(function(){
	//$("#result").html(ajax_load);
	$(this).fastConfirm({
		position:     "right",
		questionText: "Are you sure?",
		unique:       true,
		onProceed:    function(trigger) {
			$.ajax({
				type:     'POST',
				url:      $(trigger).attr('href') + '.json',
				dataType: 'json',
				success:  function(json) {
					if(!json.code) {
						alert( json[0].message ? json[0].message : 'Something went terribly wrong, server side.');
					}
					else {
				    	$(trigger).closest('tr').fadeOut('slow');
					}
				    //$("#result").html(result);
				 }
			});
			$(trigger).fastConfirm('close');
		}
	});
		
	return false;
});
