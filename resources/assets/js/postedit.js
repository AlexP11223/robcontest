require('./common');

var editor = require("pagedown-editor");

function getPagedownEditor() {
    return editor.getPagedownEditor();
}

window.getPagedownEditor = getPagedownEditor;

$('#postForm').validate({
    rules: {
        title: {
            required: true,
            minlength: 3
        },
        content: {
            required: true,
            minlength: 10
        }
    }
});
