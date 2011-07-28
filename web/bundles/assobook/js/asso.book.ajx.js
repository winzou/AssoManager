
var Asso_book_ajx = function(init_ids) {
	
	var that = this;
	
	this.ids = init_ids;
		
	this.is_active = function() {
		return true;
	};
	
	this.init = function() {
		if( that.is_active() ) {
			that.listen_delete_links();
			that.listen_new_button();
		}
	};
	
	this.listen_delete_links = function() {
		// delete links for each entry
		$(that.ids.delete_link).click(function() {
	        asso_am_ajx.confirm($(this), $(this).attr('href') + '.json', null, abook_dt.delete_entry);
	        return false;
	    });
	};
	
	this.listen_new_button = function() {
		// submit button to add an entry
	    $(that.ids.new_button).click(function() {
	        $form = $(that.ids.new_form);
	        asso_am_ajx.form_submit($form, $form.attr('action') + '.json', that.new_post, that.new_pre);
	        return false;
	    });
	};
	
	this.new_post = function(data, statusText, xhr, $form) {
		if(data.code == true) {
			// display the message
			alert(data.notice);
			
			// reset the form
			$form.resetForm();
			
			abook_dt.add_entry( asso_am_datatables.tr2array(data.tr) );
		}
		else {
			alert(data.error);
		}
	};
	
	this.new_pre = function(formData, jqForm, options) {
		// just add the 'new' value so that PHP will know we want to add an entry
		formData.push({'name': 'new', 'value':'true' });
	};
	
	this.set_account = function(id) {
		$(that.ids.new_account_id).children().each(function() {
			if($(this).val() == id) {
				$(this).attr('selected', 'selected');
			}
			else {
				$(this).removeAttr('selected');
			}
		});
	};
};

var abook_ajx = new Asso_book_ajx({
	'delete_link':    '.asso_book_ajx_delete',
	'new_button':     'input#asso_book_new',
	'new_form':	      'form#asso_book_ajx_new',
	'new_account_id': '#asso_book_entry_new_account'
});

$(document).ready(function() {

    abook_ajx.init();
    
});
