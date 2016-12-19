require('./common');

$("#member1_dob").datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: 'yy-mm-dd'
});
$("#member2_dob").datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: 'yy-mm-dd'
});


$('body').on('blur', 'input.phone-input', function(){
    var $input = $(this);
    $input.val($input.val().replace(/[^\d]+/g,''));
});

$("#applyForm").validate({
    rules: {
        team: {
            required: true,
            minlength: 3,
            maxlength: 25
        },
        email: {
            required: true,
            email: true
        },
        phone: {
            required: true,
            minlength: 6,
            maxlength: 15
        },
        teacher_first_name: {
            required: true
        },
        teacher_last_name: {
            required: true
        },
        member1_first_name: {
            required: true
        },
        member1_last_name: {
            required: true
        },
        member1_dob: {
            required: true
        },
        member2_first_name: {
            required: true
        },
        member2_last_name: {
            required: true
        },
        member2_dob: {
            required: true
        },
        sumo: {
            require_from_group: [1, '.competition-choice']
        },
        obstacles: {
            require_from_group: [1, '.competition-choice']
        }
    },
    groups: {
        competitions: "sumo obstacles"
    },
    errorPlacement: function(error, element) {
        if (element.attr("name") == "sumo" || element.attr("name") == "obstacles" ) {
            error.insertAfter(".competition-choice-group");
        } else {
            error.insertAfter(element);
        }
    },
    messages: {
        team: {
            required: "Enter team name",
            minlength: "Too short team name",
            maxlength: "Too long team name"
        },
        phone: {
            required: "Enter phone number",
            pattern: "Enter correct phone number (such as in format 370xxxxxxxx)",
            minlength: "Enter correct phone number (such as in format 370xxxxxxxx)",
            maxlength: "Enter correct phone number (such as in format 370xxxxxxxx)"
        },
        sumo: {
            require_from_group: "Choose competitions"
        },
        obstacles: {
            require_from_group: "Choose competitions"
        }
    }
});

