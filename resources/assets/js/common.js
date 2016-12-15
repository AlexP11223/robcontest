require('./bootstrap');

const bootbox = require('bootbox');

module.exports = {
    showErrorDialog: function (text) {
        bootbox.dialog({
            message: text,
            buttons: {
                ok: {
                    label: 'OK'
                }
            }
        });
    }
};
