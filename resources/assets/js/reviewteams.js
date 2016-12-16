const common = require('./common');

const contestId = $('#teamsList').data('contest-id');

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

            loadOrderTeamList();
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

function loadOrderTeamList() {
    const teamList = $("#teamsOrderableList");

    $.get(`/contests/${contestId}/teams`, function (teams) {
        let html = '';

        $.each(teams, function (i, team) {
            if (!team.approved)
                return;

            html +=
                `<li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>${team.name}
                    <input type="hidden" name="teams[]" value="${team.id}">
                 </li>`;
        });

        teamList.html(html);

        teamList.sortable();
        teamList.disableSelection();
    });
}


$("#startContestShowBtn").click(function(){
    if ($('[data-status="waiting"]').length) {
        common.showErrorDialog('You have some not reviewed teams. Approve or deny them.');
        return;
    }

    $("#startContestForm").toggle();
});

loadOrderTeamList();