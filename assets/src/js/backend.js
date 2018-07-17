$(function () {
    $('.link-status').click(function (e) {
        e.preventDefault();
        setStatus(e);
    });
});

// Ajax link
function setStatus(e) {
    let link = e.currentTarget,
        url = link.href,
        body = $('#' + link.id);
    $.ajax({
        url: url,
        dataType: 'json',
        type: 'post',
    }).done(function (response) {
        body.html(response.result);
    }).fail(function (response) {
        console.log(response.result);
    });
}
