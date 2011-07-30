
var asso_am_datatables = {
	
	'defaultOptions': {
		'sPaginationType': 'full_numbers',
		'bSortClasses':    false,
		'bAutoWidth':      true,
		'bJQueryUI':       true,
		'aaSorting':       []
	},
	
	'ids': {},
	
	'is_active': function() {
		return true;
	},
	
	'init': function(init_ids) {
		
		this.ids = init_ids;
		
		if( this.is_active() ) {
			// all .datatables get enhanced by the script
			this.make_datatable();
			
			// for each .asso_ajx_checkbox with name $name, all input.$name are checked accordingly to the master one
			this.listen_checkboxes();
		}
	},
	
	'make_datatable': function() {
		$(this.ids.datatables).dataTable( this.defaultOptions );
	},
	
	'listen_checkboxes': function() {
		$(this.ids.checkboxes).click(function() {
	        if( $(this).attr('checked') ) {
	            $('input.' + $(this).attr('name')).attr('checked', 'checked');
	        }
	        else {
	            $('input.' + $(this).attr('name')).removeAttr('checked');
	        }
	    });
	},
	
	'tr2array': function(tr) {
		//append the newly created entry
		var entry = new Array();
		$(tr).children().each(function() {
			entry.push($(this).html());
		});
		
		return entry;
	},
	
	'table2array': function(table) {
		//append the newly created entries
		var entries = new Array();
		$(table).children().each(function() {
			entries.push(asso_am_datatables.tr2array($(this)));
		});
		
		return entries;
	}
};


$(document).ready(function() {
    
	asso_am_datatables.init({
		'datatables': '.datatables',
		'checkboxes': '.asso_ajx_checkbox'
	});
	
});

