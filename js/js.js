$(document).ready(function () {
    initSearchForm();
    $('.container').css('min-height', $(window).height() - 100);
});

function initSearchForm() {
    $('#search_form').bind('submit', function () {
        return false;
    });
    $('#btn_submit_search').click(function () {
        performSearchRequest();
    });
}

function performSearchRequest() {
    $.ajax({
        url: "/",
        type: 'post',
        data: $('#search_form').serialize(),
        beforeSend: function () {
            $('#btn_submit_search').attr('disabled', true);
        },
        success: function (data) {
            if (data === 'error') {
                alert('Server error.');
            } else {
                $('#btn_submit_search').attr('disabled', false);
                $('#results_here').html(data);
            }
        },
        error: function () {
            alert('Server error.');
            $('#btn_submit_search').attr('disabled', false);
        }
    });
}