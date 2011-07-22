
$(".asso_book_ajx_delete").click(function(){
	asso_ajx_callback($(this), $(this).attr('href') + '.json', asso_book_ajx_delete);
	return false;
});

function asso_book_ajx_delete($this) {
	$this.closest('tr').fadeOut('slow');
}