require('./common');

const bootbox = require('bootbox');

function showErrorDialog(text) {
    bootbox.dialog({
        message: text,
        buttons: {
            ok: {
                label: 'OK'
            }
        }
    });
}

$('a[data-action="deletePost"]').click(function(event) {
    event.preventDefault();

    const post = $(this).closest('.post');

    const postTitle = post.data('post-title');
    const postUrl = post.data('post-url');

    const loadingIndicator = post.find('.postaction-loading-indicator');

    bootbox.dialog({
        title: 'Delete post',
        message: `Are you sure you want to delete post <b>${postTitle}</b>? You will not be able to recover it.`,
        buttons: {
            cancel: {
                label: 'Cancel'
            },
            main: {
                label: 'Delete',
                className: 'btn-danger',
                callback: function() {
                    loadingIndicator.show();

                    $.ajax({
                        type: 'delete',
                        url: postUrl,
                        success: function (data) {
                            post.remove();

                            if (window.location.href.indexOf('/posts/') > -1) {
                                window.location.href = '/';
                            }
                        },
                        error: function (resp) {
                            showErrorDialog(`Error: ${resp.statusText}. Try reloading page.`);
                        },
                        complete: function () {
                            loadingIndicator.hide();
                        }
                    });
                }
            }
        }
    });
});