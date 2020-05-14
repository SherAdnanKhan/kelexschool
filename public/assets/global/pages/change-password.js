var UserValidation = function () {
    var handleChangePassword = function () {
        var form = $('.user-change-password');
        var error2 = $('.alert-danger', form);
        var success2 = $('.alert-success', form);

        form.validate({
            // errorElement: 'span', //default input error message container
            // errorClass: 'help-block help-block-error', // default input error message class
            // focusInvalid: false, // do not focus the last invalid input
            // ignore: "",  // validate all fields including form hidden input
            rules: {
                password: {
                    minlength: 6,
                    maxlength: 64,
                    required: true
                },
                confirmed_password: {
                    minlength: 6,
                    required: true,
                    equalTo: "#password"
                },
            },
            messages: {
                title: {
                    required: trans.required,
                    maxlength: trans.maxlength + " 64",
                    minlength: trans.maxlength + " 6",
                },
                confirmed_password: {
                    required: trans.required,
                    minlength: trans.maxlength + " 6",
                    equalTo: trans.equalTo
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                success2.hide();
                error2.show();
            },

            errorPlacement: function (error, element) { // render error placement for each input type
                var mainParent = $(element).closest('.form-group');
                var icon = mainParent.find('.input-icon').children('i');
                // var icon = $(element).parent('.input-icon').children('i');
                icon.removeClass('fa-check').addClass("fa-warning");
                icon.attr("data-original-title", error.text()).tooltip({placement: "auto top"});//({'container': 'body'});
            },

            highlight: function (element) { // hightlight error inputs
                $(element).closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                var icon = $(element).parent('.input-icon').children('i');
                var iconFa = $(element).parent().siblings('i');
                if ($(element).hasClass('ifIsEmpty') && $(element).val() == '') {
                    $(element).closest('.form-group').removeClass("has-success").removeClass('has-error');
                    icon.removeClass("fa-warning").removeClass("fa-check");
                    iconFa.removeClass("fa-check").removeClass("fa-warning");
                }
            },

            success: function (label, element) {
                var mainParent = $(element).closest('.form-group');
                var icon = mainParent.find('.input-icon').children('i');
                // var icon = $(element).parent('.input-icon').children('i');
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                icon.removeClass("fa-warning").addClass("fa-check");
            },

            submitHandler: function (form) {
                var $obj = $('#' + form.id);
                var formData = new FormData(form);
                isSaving = true;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: form.action,
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $obj.find('#save-loader').removeClass('hide');
                        $obj.find('#save').attr('disabled', true);
                        $obj.find('button.close').attr('disabled', true);
                        $obj.find('button.close-modal').attr('disabled', true);
                    },
                    success: function (response, status) {
                        if (response.status == 'error') {
                            $obj.find('.alert').show();
                            $obj.find('.alert').find('p').remove();
                        } else {
                            $('button[name=close]').trigger( "click" );
                            setTimeout(function() {
                                swal({
                                    position: 'top-right',
                                    type: 'success',
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }, 500);

                        }
                        $obj.find('.btn').find('i').remove();
                        $obj.find('.btn').attr('disabled', false);
                        return;
                    },
                    error: function (data, status, e) {
                        toastr.error(e, trans.error);
                        $obj.find('#save-loader').addClass('hide');
                        $obj.find('#save-btn').attr('disabled', false);
                        $obj.find('button.close').attr('disabled', false);
                        $obj.find('button.close-modal').attr('disabled', false);
                        return;
                    },
                    complete: function () {
                        $obj.find('#save-loader').addClass('hide');
                        $obj.find('#save-btn').attr('disabled', false);
                        $obj.find('button.close').attr('disabled', false);
                        $obj.find('button.close-modal').attr('disabled', false);
                    },
                    statusCode: {
                        404: function () {
                            toastr.error(trans.request_not_found, trans.error);
                        },
                        500: function () {
                            toastr.error(trans.internal_server_error, trans.error);
                        }
                    }
                });
                return false;
            }
        });
    };
    return {
        init: function () {
            handleChangePassword();
        }
    };
}();
$(document).ready(function () {
    UserValidation.init();
});
