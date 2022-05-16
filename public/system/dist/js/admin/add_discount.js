
function validation() {
    var from = $('#valid_from');
    var to = $('#valid_till');
    if (Date.parse(from.val()) > Date.parse(to.val())) {
        from.addClass('is-invalid');
        to.addClass('is-invalid');
        toastr.error('Valid till date should greter than valid from date !');
        return false;
    }
    return true;
}
