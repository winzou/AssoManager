

var asso_book_datatables = {
	
	'datatable': null,
	'accounts':  new Array(),
	'truc': 'moi',
	
	'ids': {},
	
	'is_active': function() {
		return $(this.ids.table).length;
	},
	
	'init': function(init_ids) {
		
		this.ids = init_ids;
		
		if( this.is_active() ) {
			this.make_datatable();
			this.save_datatable_content();
			this.listen_switch_clicks();
		}
	},
	
	'make_datatable': function() {
		this.datatable = $(this.ids.table).dataTable( $.extend({}, asso_am_datatables.defaultOptions, {
			'bSortCellsTop': true,
			'aaSorting':     [[1,'desc']],
			'aoColumns': [
	                      { 'bSearchable': false, 'bSortable': false },
	                      { 'sType': 'uk_date' },
	                      null,
	                      null,
	                      { 'sWidth': '5em' },
	                      { 'sWidth': '5em' },
	                      null,
	                      { 'bSearchable': false, 'bSortable': false }
	                     ]
		}) );
	},
	
	'save_datatable_content': function() {
		this.accounts[$(this.ids.datatable).attr('data-id')] = this.datatable.fnGetData();
	},
	
	'listen_switch_clicks': function() {
		$(this.ids.switch_links).click(function() {
			var clicked_id = $(this).attr('data-id');
			
			// if click on the already selected account, do nothing
			if(clicked_id == $(asso_book_datatables.ids.table).attr('data-id')) {
				return false;
			}
			
			// save the data
			asso_book_datatables.save_datatable_content();
			
			// if we have already the data, display it
			if(asso_book_datatables.accounts[clicked_id]) {
				// clear the table
				asso_book_datatables.datatable.fnClearTable( false );
				
				// update the table
				asso_book_datatables.datatable.fnAddData( asso_book_datatables.accounts[clicked_id] );
			}
			// ptherwise we go and retrieve it from the server
			else {
				// load the new data and update the table with it
				$.get($(this).attr('href'), function(data) {
					// clear the table
					asso_book_datatables.datatable.fnClearTable( false );
					
					// update the table
					asso_book_datatables.datatable.fnAddData( asso_am_datatables.table2array( $(data).children() ) );
				});
			}
			
			$(asso_book_datatables.ids.table).attr('data-id', clicked_id);
			$(this).addClass('asso_button_checked');
			$(this).parent().siblings().children().removeClass('asso_button_checked');
			
			return false;
		});
	},
	
	'delete_entry': function(trigger) {
		this.datatable.fnDeleteRow( $(trigger).closest('tr')[0] );
	},
	
	'add_entry': function(entry) {
		this.datatable.fnAddData(entry);
	}
};

$(document).ready(function() {

	asso_book_datatables.init({
		'table':        '#asso_book_entries_table',
		'switch_links': 'a.asso_book_account_switch'
	});
	
});
