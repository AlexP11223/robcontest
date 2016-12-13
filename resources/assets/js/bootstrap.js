
window._ = require('lodash');

window.$ = window.jQuery = require('jquery');
require('jquery-ui');
require('jquery-validation');
require('jquery-validation/dist/additional-methods.js');

require('bootstrap-sass');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
