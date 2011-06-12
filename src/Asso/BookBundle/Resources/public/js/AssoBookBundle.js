

$(document).ready(function() {
    $(document).ajaxError(function(event, jqXHR) {
        try {
            var response = JSON.parse(jqXHR.responseText);
            var message = response.message;
        }
        catch(errr) {
            var message = jqXHR.responseText;
        }
        
        if(!message)
        {
            if(403 === jqXHR.status) {
                message = 'Acces denied, please login again';
            }
            else if(404 == jqXHR.status) {
                message = 'Page not found';
            }
            else if(500 = jqXHR.status) {
                message = 'Server-side error';
            }
            else {
                message = 'Unknown error!';
            }
        }
        
        alert(message);
    });
});




$(".wbb_ajx_delete_entry").click(function(){
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
						alert( json.message ? json.message : 'Something went terribly wrong, server side.');
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



/*

$('button.fos_comment_comment_reply_show_form').live('click', function() {
    var $button = $(this);
    var $container = $button.parent().addClass('replying');
    var $reply = $('div.fos_comment_reply_prototype').clone()
        .removeClass('fos_comment_reply_prototype')
        .find('.fos_comment_reply_name_placeholder').text($button.attr('data-name')).end()
        .find('input[name=reply_to]').val($button.attr('data-id')).end()
        .find('.fos_comment_reply_cancel').click(function() {
            $reply.remove();
            $container.removeClass('replying');
        }).end()
        .appendTo($container)
        .find('textarea').focus().end();
});
*/