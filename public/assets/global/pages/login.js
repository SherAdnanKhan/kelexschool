var Login = function() {

    var handleLogin = function() {

        $('.login-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                remember: {
                    required: false
                }
            },

            messages: {
                email: {
                    required: trans.required,
                    email: trans.email
                },
                password: {
                    required: trans.required,
                    minlength: trans.minlength + " 6",
                }
            },

            errorPlacement: function(error, element) {
                var icon = $(element).parent('.input-icon').children('i');
                icon.removeClass('fa-check').addClass("fa-warning");
                icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
            },

            invalidHandler: function(event, validator) { //display error alert on form submit
                //  $('.alert-danger', $('.login-form')).show();
            },

            unhighlight: function(element) { // hightlight error inputs
                // var icon = $(element).parent('.input-icon').children('i');
                // icon.removeClass('fa-check').addClass("fa-warning");
                // icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
            },
            highlight: function(element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label, element) {
                var icon = $(element).parent('.input-icon').children('i');
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                icon.removeClass("fa-warning").addClass("fa-check");
            },

            submitHandler: function(form) {
                // form.submit(); // form validation success, call ajax form submit
                var $obj = $('#' + form.id);
                var formData = new FormData(form);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url 	      : form.action,
                    type        : 'POST',
                    dataType	  : 'json',
                    data        : formData,
                    cache       : false,
                    contentType : false,
                    processData : false,
                    beforeSend: function () {
                        $obj.find('.login-submit').append('<i id="save-loader" class="fa fa-circle-o-notch fa-spin fa-md fa-fw"></i>');
                        $obj.find('.btn').attr('disabled', true);
                    },
                    success	: function (response, status){
                        console.log(response);
                        if ( response.data == 'success' ) {
                            toastr.success(response.message, trans.success);
                            window.location.href = "/articles";
                        }
                        else {
                            $obj.find('.alert>span').html(response.message);
                            $obj.find('.alert').show();
                        }
                        return;

                    },
                    error: function (data, status, e) {
                        $obj.find('.alert>span').html(trans.invalid_credentials);
                        $obj.find('.alert').show();
                        return;
                    },
                    complete: function() {
                        $obj.find('.login-submit').find('i').remove();
                        $obj.find('.btn').attr('disabled', false);
                    },
                    statusCode: {
                        404: function() {
                            toastr.error(trans.request_not_found, trans.error);
                        },
                        500: function() {
                            toastr.error(trans.internal_server_error, trans.error);
                        }
                    }
                });
            }
        });

        $('.login-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.login-form').validate().form()) {
                    $('.login-form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });
    }

    var handleForgetPassword = function() {
        $('.forget-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },

            messages: {
                email: {
                    required: trans.required,
                    email: trans.email
                }
            },

            errorPlacement: function(error, element) {
                var icon = $(element).parent('.input-icon').children('i');
                icon.removeClass('fa-check').addClass("fa-warning");
                icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
            },

            invalidHandler: function(event, validator) { //display error alert on form submit
                //  $('.alert-danger', $('.login-form')).show();
            },

            unhighlight: function(element) { // hightlight error inputs
                // var icon = $(element).parent('.input-icon').children('i');
                // icon.removeClass('fa-check').addClass("fa-warning");
                // icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
            },
            highlight: function(element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label, element) {
                var icon = $(element).parent('.input-icon').children('i');
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                icon.removeClass("fa-warning").addClass("fa-check");
            },

            submitHandler: function(form) {
                //form.submit();
                //console.log(form);
                var $obj = $('#' + form.id);
                var formData = new FormData(form);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url 	      : form.action,
                    type        : 'POST',
                    dataType	  : 'json',
                    data        : formData,
                    cache       : false,
                    contentType : false,
                    processData : false,
                    beforeSend: function () {
                        //  debugger
                        $obj.find("#forgot_password_btn").append('<i class="fa fa-circle-o-notch fa-spin fa-md fa-fw"></i>');
                        $obj.find("#forgot_password_btn").attr('disabled', true);
                    },
                    success	: function (response, status){
                        console.log(response);
                        if ( response.data == 'success' ) {
                            toastr.success(response.message, "");
                            window.location.href = "/";
                        }
                        else {
                            toastr.error(response.message, "" );
                        }
                        $obj.find("#forgot_password_btn").find('i').remove();
                        $obj.find("#forgot_password_btn").attr('disabled', false);
                        return;
                    },
                    error: function (data, status, e)
                    {
                        toastr.error(e, trans.error);
                        $obj.find("#forgot_password_btn").find('i').remove();
                        $obj.find("#forgot_password_btn").attr('disabled', false);
                        return;
                    },
                    complete: function() {
                        $("#stackLogin").find("#forgot_password_btn").find('i').remove();
                        $("#stackLogin").find("#forgot_password_btn").attr('disabled', false);
                    },
                    statusCode: {
                        404: function() {
                            toastr.error(trans.request_not_found, trans.error);
                        },
                        500: function() {
                            toastr.error(trans.internal_server_error, trans.error);
                        }
                    }
                });
            }
        });

        $('.forget-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.forget-form').validate().form()) {
                    $('.forget-form').submit();
                }
                return false;
            }
        });

        jQuery('#forget-password').click(function() {
            jQuery('.login-form').hide();
            jQuery('.forget-form').show();
        });

        jQuery('#back-btn').click(function() {
            jQuery('.login-form').show();
            jQuery('.forget-form').hide();
        });

    }

    var handleRegister = function() {

        function format(state) {
            if (!state.id) { return state.text; }
            var $state = $(
                '<span><img src="../assets/global/img/flags/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
            );

            return $state;
        }

        if (jQuery().select2 && $('#country_list').size() > 0) {
            $("#country_list").select2({
                placeholder: '<i class="fa fa-map-marker"></i>&nbsp;Select a Country',
                templateResult: format,
                templateSelection: format,
                width: 'auto',
                escapeMarkup: function(m) {
                    return m;
                }
            });


            $('#country_list').change(function() {
                $('.register-form').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
        }

        $('.register-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {

                fullname: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                address: {
                    required: true
                },
                city: {
                    required: true
                },
                country: {
                    required: true
                },

                username: {
                    required: true
                },
                password: {
                    required: true
                },
                rpassword: {
                    equalTo: "#register_password"
                },

                tnc: {
                    required: true
                }
            },

            messages: { // custom messages for radio buttons and checkboxes
                tnc: {
                    required: "Please accept TNC first."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit

            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                if (element.attr("name") == "tnc") { // insert checkbox errors after the container
                    error.insertAfter($('#register_tnc_error'));
                } else if (element.closest('.input-icon').size() === 1) {
                    error.insertAfter(element.closest('.input-icon'));
                } else {
                    error.insertAfter(element);
                }
            },

            submitHandler: function(form) {
                form[0].submit();
            }
        });

        $('.register-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.register-form').validate().form()) {
                    $('.register-form').submit();
                }
                return false;
            }
        });

        jQuery('#register-btn').click(function() {
            jQuery('.login-form').hide();
            jQuery('.register-form').show();
        });

        jQuery('#register-back-btn').click(function() {
            jQuery('.login-form').show();
            jQuery('.register-form').hide();
        });
    }

    return {
        //main function to initiate the module
        init: function() {

            handleLogin();
            handleForgetPassword();
            handleRegister();

            // init background slide images
            $.backstretch([
                    // "../assets/pages/media/bg/7.jpg",
                    "../assets/pages/media/bg/8.jpg",
                    // "../assets/pages/media/bg/9.jpg",
                    // "../assets/pages/media/bg/4.jpg"
                ], {
                    fade: 600,
                    // duration: 1000
                }
            );

        }

    };

}();

jQuery(document).ready(function() {
    Login.init();
});
