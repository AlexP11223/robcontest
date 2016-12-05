require('./common');


$("#changePasswordForm").validate({
    rules: {
        password: {
            required: true
        },
        newPassword: {
            required: true,
            minlength: 8
        },
        newPassword_confirmation: {
            required: true,
            equalTo: "#newPassword"
        }
    },
    messages: {
        password: {
            required: "Enter password"
        },
        newPassword: {
            required: "Enter new password",
            minlength: "Password is too short"
        },
        newPassword_confirmation: {
            required: "Enter new password",
            equalTo: "Passwords do not match"
        }
    }
});
