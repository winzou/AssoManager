
$(document).ready(function() {
    $(document).ajaxError(function(event, jqXHR) {
        var message;
        
        try {
            var response = JSON.parse(jqXHR.responseText);
            message = response.message ? response.message : 'Sf2 said: ' + response[0].message;
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

function asso_ajx_callback($this, url, callback) {
	//$("#result").html(ajax_load);
	$.ajax({
		type:     'POST',
		url:      url,
		dataType: 'json',
		success:  function(json) {
			if(!json.code) {
				alert( json[0].message ? json[0].message : 'Something went terribly wrong, server side.');
			}
			else {
				callback($this);
			}
		    //$("#result").html(result);
		 }
	});
}

function asso_ajx_confirm($this, url, callback) {
	$this.fastConfirm({
		position:     "right",
		questionText: "Are you sure?",
		unique:       true,
		onProceed:    function(trigger) {
			asso_ajx_callback($(trigger), url, callback);
			$(trigger).fastConfirm('close');
		}
	});
}


function asso_ajx_formSubmit($this, postCallback, preCallback) {
	var options = { 
        beforeSubmit: preCallback,  // pre-submit callback 
        success:      postCallback,  // post-submit callback
        dataType:     'json',
        url:          $this.attr('action') + '.json'
	};
	//attach handler to form's submit event 
	$this.submit(function() { 
	    // submit the form 
	    $(this).ajaxSubmit(options); 
	    // return false to prevent normal browser submit and page navigation 
	    return false; 
	});
}




