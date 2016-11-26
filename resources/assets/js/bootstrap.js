
window._ = require('lodash');

window.$ = window.jQuery = require('jquery');
require('jquery-validation')

require('bootstrap-sass');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
