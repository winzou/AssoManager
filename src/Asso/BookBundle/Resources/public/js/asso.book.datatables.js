$(document).ready(function() {
	$('.asso_book_datatables').dataTable( $.extend({}, asso_am_datatable_defaultOptions, {
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