const common = require('./common');

$(".team-item-header").on('click', function() {
    var items = $(".team-item");

    var activeItem = $(this).parent();

    if (!activeItem.hasClass('active-item')) {
        $(".team-item-content").hide();

        items.removeClass("active-item");

        activeItem.addClass("active-item");

        activeItem.find('.team-item-content').show();
    }
    else {
        activeItem.find('.team-item-content').hide();

        activeItem.removeClass("active-item");
    }
});

function setTeamStatus(item, approve) {
    const loadingIndicator = $(".loading-indicator");

    const id = item.data('id');

    loadingIndicator.show();

    item.find('.btn').prop("disabled", true);

    $.ajax({
        type: 'patch',
        url: '/teams/' + id + '/' + (approve ? 'approve' : 'deny'),
        success: function (newStatus) {
            item.find('.team-item-content').hide();
            item.removeClass("active-item");

            loadingIndicator.hide();

            item.find('.btn').prop("disabled", false);

            var statusElement = item.find(".team-status");

            statusElement.attr('data-status', newStatus);
            statusElement.html(newStatus);
        },
        error: function (resp) {
            common.showErrorDialog(`Error: ${resp.statusText}. Try reloading page.`);
        },
        complete: function () {
            loadingIndicator.hide();
        }
    });
}

$("[data-action='approveTeam']").on('click', function() {
    setTeamStatus($(this).closest(".team-item"), true);
});

$("[data-action='denyTeam']").on('click', function() {
    setTeamStatus($(this).closest(".team-item"), false);
});
