
$(document).ready(function() {

    // delete links for each entry
    $(".asso_book_ajx_delete").click(function() {
        asso_ajx_confirm($(this), $(this).attr('href') + '.json', asso_book_datatables_delete);
        return false;
    });
    
    // submit button to add an entry
    $("input#asso_book_new").click(function() {
        $form = $('form#asso_book_ajx_new');
        asso_ajx_form_submit($form, $form.attr('action') + '.json', asso_book_ajx_new, asso_book_ajx_new_pre);
        return false;
    });
});

// ------------------------------------

function asso_book_ajx_new(data, statusText, xhr, $form) {
	if(data.code == true) {
		// display the message
		alert(data.notice);
		
		// reset the form
		$form.resetForm();
		
		//append the newly created entry
		var entry = new Array();
		$(data.tr).children().each(function() {
			entry.push($(this).html());
		});
		
		asso_book_datatables_add(entry);
	}
	else {
		alert(data.error);
	}
}

function asso_book_ajx_new_pre(formData, jqForm, options) {
	// just add the 'new' value so that PHP will know we want to add an entry
	formData.push({'name': 'new', 'value':'true' });
}