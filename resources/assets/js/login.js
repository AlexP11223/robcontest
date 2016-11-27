require('./common');


$('#loginForm').validate({
    rules: {
        name: {
            required: true
        },
        password: {
            required: true
        }
    },
    messages: {
        name: {
            required: "Enter username"
        },
        password: {
            required: "Enter password"
        }
    }
});
