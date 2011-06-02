
$(".wbb_ajx_delete_entry").click(function(){
	//$("#result").html(ajax_load);
	$(this).fastConfirm({
		position: "right",
		questionText: "Sure?",
		onProceed: function(trigger) {
			$.getJSON(
				$(trigger).attr('href') + '.json',
				null,
				function(json) {
					alert(trigger);
				    $(trigger).parent().remove();
				    //$("#result").html(result);
				}
			);
			$(trigger).fastConfirm('close');
		},
		onCancel: function(trigger) {
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