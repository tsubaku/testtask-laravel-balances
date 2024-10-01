$(document).ready(function () {
    // Handler for clicks on pagination links
    $(document).on('click', '.pagination a', function (event) {
        event.preventDefault();
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');

        var page = $(this).attr('href').split('page=')[1];
        var searchQuery = $('#searchInput').val();

        getData(page, searchQuery);
    });

    // Handler for submitting the search form when the button is clicked
    $('#searchForm').on('submit', function (event) {
        event.preventDefault();
        var searchQuery = $('#searchInput').val();
        var page = 1;

        getData(page, searchQuery);
    });

    // Handler for submitting the search form when pressing the Enter
    $('#searchInput').on('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            var searchQuery = $('#searchInput').val();
            var page = 1;

            getData(page, searchQuery);
        }
    });

    // Request data from server
    function getData(page, searchQuery) {
        let msgTag = $('#searchForm').find(".alert-msg")
        msgTag.find("ul").html('');
        msgTag.addClass('d-none');

        var url = '?page=' + page;

        if (searchQuery) {
            url += '&search=' + encodeURIComponent(searchQuery);
        }

        blockUI();

        $.ajax({
            url: url,
            type: "get",
            datatype: "html",
        })
            .done(function (data) {
                $("#item-lists").empty().html(data); // Updating the table contents
                window.history.pushState(null, null, url); // Refreshing the address bar
            })
            .fail(function (jqXHR) {
                msgTag.removeClass('d-none');
                msgTag.addClass('alert-danger');
                $.each(jqXHR.responseJSON.errors, function (key, value) {
                    $('#searchForm').find(".alert-msg").find("ul").append('<li>' + value + '</li>');
                    console.log(value);
                });

            })
            .always(function () {
                unblockUI();
            });
    }

    // Blocking UI elements
    function blockUI() {
        $('#searchInput').prop('disabled', true);
        $('.pagination a').addClass('disabled');
        $('#item-lists').css('opacity', '0.5');
        $('#searchForm').css('opacity', '0.5');
        $('#loader').show();
    }

    // Unblocking UI elements
    function unblockUI() {
        $('#loader').hide();
        $('#searchInput').prop('disabled', false);
        $('.pagination a').removeClass('disabled');
        $('#item-lists').css('opacity', '1');
        $('#searchForm').css('opacity', '1');
    }
});
