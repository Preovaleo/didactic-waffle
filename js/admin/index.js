var $tableTbody,
        $pagination,
        $btnAdd,
        $placeholderAdd,
        $inputUrl,
        $inputToken;

function updateTable(page) {

    $pagination.twbsPagination('destroy');

    url = URI('/api/routes')
            .addSearch('page', page);

    $.getJSON(url).done(function (json) {
        if (json.success) {
            $tableTbody.empty();

            $.each(json.data.mins, function (key, min) {
                id = $('<td>').html(min.id);
                tokenurl = URI.expand('/u/{token}', {token: min.token});
                token = $('<td>').html($('<a>', {href: tokenurl}).html(min.token));
                url = $('<td>').html(min.url);
                action = $('<td>');
                $tableTbody.append($('<tr>').append(id, token, url, action));
            });

            $pagination.twbsPagination({
                totalPages: json.data.totalPages + 1,
                visiblePages: page + 1,
                initiateStartPageClick: false,
                onPageClick: function (event, page) {
                    updateTable(page - 1)
                }
            });
        } else {
            bootbox.alert(json.data);
        }
    });
}


$(function () {
    initVar();
    updateTable(0);
    initClick();
});

function initVar() {
    $tableTbody = $('#tableTbody');
    $pagination = $('#pagination');
    $btnAdd = $('#btnAdd');
    $placeholderAdd = $('#placeholderAdd');
    $inputUrl = $('#inputUrl');
    $inputToken = $('#inputToken');
}

function initClick() {
    $btnAdd.click(add);
}

function add() {
    $.post('/api/route', {
        token: $inputToken.val(),
        url: $inputUrl.val()
    }).done(function (json) {
        if (json.success) {
            updateTable(0);
        } else {
            bootbox.alert(json.data);
        }

    })

}