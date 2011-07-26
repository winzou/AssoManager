
$(document).ready(function() {
    $(document).ajaxError(function(event, jqXHR) {
        var message;
        
        try {
            var response = JSON.parse(jqXHR.responseText);
            message = response.message ? response.message : 'Sf2 said: ' + response[0].message;
        }
        catch(err) {
        	/** @todo why doesn't it find my title? */
        	title = $(jqXHR.responseText).find('title').text();
        	
        	if(title) {
        		message = title;
        	}
        	else {
        		message = jqXHR.responseText;
        	}
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

function asso_ajx_callback(trigger, url, callback) {
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
				callback(trigger);
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
			asso_ajx_callback(trigger, url, callback);
			$(trigger).fastConfirm('close');
		}
	});
}


function asso_ajx_form_enable($this, url, postCallback, preCallback) {
	var options = {
		beforeSubmit: preCallback,  // pre-submit callback 
		success:      postCallback,  // post-submit callback
		dataType:     'json',
		url:          url ? url : $this.attr('action')
	};

	//attach handler to form's submit event 
	$this.submit(function() { 
	    // submit the form 
	    $(this).ajaxSubmit(options); 
	    // return false to prevent normal browser submit and page navigation 
	    return false; 
	});
}

function asso_ajx_form_submit($this, url, postCallback, preCallback) {
	var options = {
			beforeSubmit: preCallback,  // pre-submit callback 
			success:      postCallback,  // post-submit callback
			dataType:     'json',
			url:          url ? url : $this.attr('action')
		};
	
	$this.ajaxSubmit(options); 
}




