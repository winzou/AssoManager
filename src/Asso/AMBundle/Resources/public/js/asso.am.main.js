
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