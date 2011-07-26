
var asso_book_entries_table;

$(document).ready(function() {
    
	asso_book_entries_table = $('#asso_book_entries_table').dataTable( $.extend({}, asso_am_datatable_defaultOptions, {
		'bSortCellsTop': true,
		'aaSorting':     [[1,'desc']],
		'aoColumns': [
                      { 'bSearchable': false, 'bSortable': false },
                      { 'sType': 'uk_date' },
                      null,
                      null,
                      null,
                      null,
                      null,
                      { 'bSearchable': false, 'bSortable': false }
                     ]
	}) );
	
} );


function asso_book_datatables_delete(trigger) {
	asso_book_entries_table.fnDeleteRow( $(trigger).closest('tr')[0] );
}

function asso_book_datatables_add(entry) {
	asso_book_entries_table.fnAddData(entry);
}