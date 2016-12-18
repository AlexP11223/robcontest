require('./common');

const contest = require('./contest');

$('.obstacles-form').on('submit', function(e) {
    e.preventDefault();

    const form = $(this);

    const errorLabel = form.find('label.request-error');
    const loadingIndicator = form.find('.loading-indicator');

    var data = form.serializeArray();

    errorLabel.hide();

    loadingIndicator.show();

    $.ajax({
        type: 'put',
        url: form.attr('action'),
        data: data,
        success: function (data) {
            contest.loadObstaclesResult();
        },
        error: function () {
            loadingIndicator.hide();
            errorLabel.text('Failed to send request. Try reloading page.');
            errorLabel.show();
        },
        complete: function () {
            loadingIndicator.hide();
        }
    });
});

$('#sumoFormPanel').on('submit', '.sumo-form', function(e) {
    e.preventDefault();

    const form = $(this);

    const errorLabel = form.find('label.request-error');
    const loadingIndicator = form.find('.loading-indicator');

    var data = form.serializeArray();

    errorLabel.hide();

    loadingIndicator.show();

    $.ajax({
        type: 'put',
        url: form.attr('action'),
        data: data,
        success: function (data) {
            contest.loadSumoResult();

            $.get(`/contests/${contestId}/sumo/edit`, function (newForm) {
                $('#sumoFormPanel').html(newForm);
            })
        },
        error: function () {
            loadingIndicator.hide();
            errorLabel.text('Failed to send request. Try reloading page.');
            errorLabel.show();
        },
        complete: function () {
            loadingIndicator.hide();
        }
    });
});
