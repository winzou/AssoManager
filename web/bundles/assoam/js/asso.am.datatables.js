
var asso_am_datatable_defaultOptions = {
	'sPaginationType': 'full_numbers',
	'bSortClasses':    false,
	'bAutoWidth':      false,
	'aaSorting':       []
};

// all .datatables get enhanced by the script
$(document).ready(function() {
	$('.datatables').dataTable( asso_am_datatable_defaultOptions );
} );

// for each .asso_ajx_checkbox with name $name, all input.$name are checked accordingly to the master one
$(document).ready(function() {
	$('.asso_ajx_checkbox').click(function() {
		if( $(this).attr('checked') ) {
			$('input.' + $(this).attr('name')).attr('checked', 'checked');
		}
		else {
			$('input.' + $(this).attr('name')).removeAttr('checked');
		}
	});
});