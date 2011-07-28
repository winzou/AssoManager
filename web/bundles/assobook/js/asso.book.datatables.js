

var Asso_book_datatables = function(init_ids) {
	
	var that = this;
	
	this.datatable = null;
	this.accounts  = [];
	this.ids       = init_ids;
	
	
	this.is_active = function() {
		return $(that.ids.table).length;
	};
	
	this.init = function() {
		if( that.is_active() ) {
			that.make_datatable();
			that.save_datatable_content();
			that.listen_switch_clicks();
		}
	};
	
	this.make_datatable = function() {
		that.datatable = $(that.ids.table).dataTable( $.extend({}, asso_am_datatables.defaultOptions, {
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
	};
	
	this.save_datatable_content = function() {
		that.accounts[$(that.ids.table).attr('data-id')] = that.datatable.fnGetData();
	};
	
	this.listen_switch_clicks = function() {
		$(that.ids.switch_links).click(function() {
			var clicked_id = $(this).attr('data-id');
			
			// if click on the already selected account, do nothing
			if(clicked_id == $(that.ids.table).attr('data-id')) {
				return false;
			}
			
			// save the data
			that.save_datatable_content();
			
			// if we have already the data, display it
			if(that.accounts[clicked_id]) {
				// clear the table
				that.datatable.fnClearTable( false );
				
				// update the table
				that.datatable.fnAddData( that.accounts[clicked_id] );
			}
			// otherwise we go and retrieve it from the server
			else {
				// load the new data and update the table with it
				$.get($(this).attr('href'), function(data) {
					// clear the table
					that.datatable.fnClearTable( false );
					
					// update the table
					that.datatable.fnAddData( asso_am_datatables.table2array( $(data).children() ) );
				});
			}
			
			// don't forget to change the value of the form
			abook_ajx.set_account(clicked_id);
			
			$(that.ids.table).attr('data-id', clicked_id);
			$(this).addClass('asso_button_checked');
			$(this).parent().siblings().children().removeClass('asso_button_checked');
			
			return false;
		});
	};
	
	this.delete_entry = function(trigger) {
		that.datatable.fnDeleteRow( $(trigger).closest('tr')[0] );
	};
	
	this.add_entry = function(entry) {
		that.datatable.fnAddData(entry);
	};
};

var abook_dt = new Asso_book_datatables({
	'table':        '#asso_book_entries_table',
	'switch_links': 'a.asso_book_account_switch'
});

$(document).ready(function() {
	
	abook_dt.init();
	
});
