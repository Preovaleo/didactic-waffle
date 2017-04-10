var tableTbody,
    pagination;

function updateTable(page) {

    pagination.twbsPagination('destroy');

    url = URI('/api/routes')
        .addSearch('page', page);

    $.getJSON(url).done(function (json) {
        $.each(json.data.mins, function (key, min) {
            id = $('<td>').html(min.id);
            tokenurl = URI.expand('/u/{token}', {token: min.token});
            token = $('<td>').html($('<a>', {href: tokenurl}).html(min.token));
            url = $('<td>').html(min.url);
            action = $('<td>');
            tableTbody.append($('<tr>').append(id, token, url, action));
        });

        pagination.twbsPagination({
            totalPages: json.data.totalPages + 1,
            visiblePages: page + 1,
            initiateStartPageClick: false,
            onPageClick: function (event, page) {
                updateTable(page - 1)
            }
        });
    });
}


$(function () {
    tableTbody = $('#tableTbody');
    pagination = $('#pagination');
    updateTable(0);
});