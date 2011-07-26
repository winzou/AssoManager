/**
 * http://datatables.net/plug-ins/sorting
 */
jQuery.fn.dataTableExt.oSort['uk_date-asc']  = function(a,b) {
    var ukDatea = a.split('/');
    var ukDateb = b.split('/');
    
    var x = (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
    var y = (ukDateb[2] + ukDateb[1] + ukDateb[0]) * 1;
    
    return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};

jQuery.fn.dataTableExt.oSort['uk_date-desc'] = function(a,b) {
    var ukDatea = a.split('/');
    var ukDateb = b.split('/');
    
    var x = (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
    var y = (ukDateb[2] + ukDateb[1] + ukDateb[0]) * 1;
    
    return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
};