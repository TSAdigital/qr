$(document).ready(function () {
    var link = $("#short-link").text();
    $("#qr-code").qrcode(link);

    $('#qr-form').on('submit', function(event) {
        event.preventDefault();

        if ($('#qr-form').data('yiiActiveForm').validated) {
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: $(this).serialize(),
                success: function(data) {
                    var response = JSON.parse(data);
                    if (response.link) {
                        $('#qr-code-index').empty();
                        $('#qr-code-index').qrcode(response.link);
                        $('#link-index').html('Короткая ссылка: ' + response.link);
                    }
                },
                error: function() {
                    alert('Произошла ошибка при генерации ссылки.');
                }
            });
        } else {
            $('#qr-code-index').empty();
        }
    });

    var hash = window.location.hash;
    if (hash) {
        $('button[data-bs-target="' + hash + '"]').tab('show');
    } else {
        $('#myTab .nav-link:first').tab('show');
    }

    updatePaginationLinks(window.location.hash);
});

$('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
    var hash = $(e.target).data('bs-target');

    if (history.pushState) {
        history.pushState(null, null, hash);
    } else {
        location.hash = hash;
    }
    updatePaginationLinks(hash);
});

function updatePaginationLinks(currentHash) {
    $('.pagination a.page-link').each(function() {
        var href = $(this).attr('href').split('#')[0];
        $(this).attr('href', href + currentHash);
    });
}