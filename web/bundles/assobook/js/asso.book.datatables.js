
var asso_book_entries_table;

$(document).ready(function() {
	asso_book_entries_table = $('#asso_book_entries_table').dataTable( $.extend({}, asso_am_datatable_defaultOptions, {
		'bSortCellsTop': true,
		'aoColumns': [
                      { 'bSearchable': false, 'bSortable': false },
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      { 'bSearchable': false, 'bSortable': false }
                     ]
	}) );
} );


function asso_book_datatables_delete(trigger) {alert($(trigger).closest('tr').get());
	/** @todo why is this deleting the wrong entry? */
	asso_book_entries_table.fnDeleteRow( $(trigger).closest('tr').get() );
}

function asso_book_datatables_add(entry) {
	/** @todo why is this entry added at the end of the table? */
	asso_book_entries_table.fnAddData(entry);
}