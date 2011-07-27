
var asso_book_ajx = {
	
	'ids': {},
		
	'is_active': function() {
		return true;
	},
	
	'init': function(init_ids) {
		
		this.ids = init_ids;
		
		if( this.is_active() ) {
			this.listen_delete_links();
			this.listen_new_links();
		}
	},
	
	'listen_delete_links': function() {
		// delete links for each entry
		$(this.ids.delete_link).click(function() {
	        asso_am_ajx.confirm($(this), $(this).attr('href') + '.json', asso_book_datatables.delete_entry);
	        return false;
	    });
	},
	
	'listen_new_links': function() {
		// submit button to add an entry
	    $(this.ids.new_button).click(function() {
	        $form = $(asso_book_ajx.ids.new_form);
	        asso_am_ajx.form_submit($form, $form.attr('action') + '.json', asso_book_ajx.new_post, asso_book_ajx.new_pre);
	        return false;
	    });
	},
	
	'new_post': function(data, statusText, xhr, $form) {
		if(data.code == true) {
			// display the message
			alert(data.notice);
			
			// reset the form
			$form.resetForm();
			
			asso_book_datatables.add_entry( asso_am_datatables.tr2array(data.tr) );
		}
		else {
			alert(data.error);
		}
	},
	
	'new_pre': function(formData, jqForm, options) {
		// just add the 'new' value so that PHP will know we want to add an entry
		formData.push({'name': 'new', 'value':'true' });
	}
};

$(document).ready(function() {

    asso_book_ajx.init({
    	'delete_link': '.asso_book_ajx_delete',
    	'new_button':  'input#asso_book_new',
    	'new_form':	   'form#asso_book_ajx_new'
    });
    
});
