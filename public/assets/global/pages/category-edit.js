var handleAdd = function() {
    var base_url = window.location.origin;
    var form = $('#edit-category');
    debugger;
    var errorAlert = $('.alert-danger', form);
    var successAlert = $('.alert-success', form);
    $.validator.addMethod("olnynumeric", function(value, element) {
        //return this.optional(element) || /^[1-9]\d*(\.\d+)?$/i.test(value);
        return this.optional(element) || /^\d+(\.\d{1,2})?$/.test(value);
    }, "Only numbers allowed");
    form.validate({
        // Specify validation rules
        onkeyup: false,
        rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side
            name: {
                required: true,
                maxlength: 255
            },
            logo: {
                extension: "jpg|jpeg|png|gif"
            }/*,
            sort_no: {
                maxlength: 8
            }*/
        },
        messages: {
            title: {
                required: trans.required,
                maxlength: trans.maxlength + " 255",
            },
            logo: {
                required: trans.required
            }
        },


        invalidHandler: function (event, validator) { //display error alert on form submit
            successAlert.hide();
            errorAlert.show();
        },
        errorPlacement: function (error, element) { // render error placement for each input type
            // var icon = $(element).parent('.input-icon').children('i');
            var mainParent = $(element).closest('.form-group');
            var icon = mainParent.find('.input-icon').children('i');
            icon.removeClass('fa-check').addClass("fa-warning");
            icon.attr("data-original-title", error.text()).tooltip({placement:"auto top"});//({'container': 'body'});
        },
        highlight: function (element) { // hightlight error inputs
            $(element).closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group
        },
        unhighlight: function (element) {
            var icon = $(element).parent('.input-icon').children('i');
            if ($(element).hasClass('ifIsEmpty') && $(element).val() == '') {
                $(element).closest('.form-group').removeClass("has-success").removeClass('has-error');
                icon.removeClass("fa-warning").removeClass("fa-check");
            }
        },
        success: function (label, element) {
            var mainParent = $(element).closest('.form-group');
            var icon = mainParent.find('.input-icon').children('i');
            // var icon = $(element).parent('.input-icon').children('i');
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
            icon.removeClass("fa-warning").addClass("fa-check");
        },
        submitHandler: function(form) {
            debugger;
            var $obj = $(form);
            var formData = new FormData(form);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:form.method,
                url: form.action,
                processData:false,
                contentType:false,
                data: formData,
                beforeSend: function () {
                    $obj.find('button[type="submit"] i').attr('class', 'fa fa-circle-o-notch fa-spin fa-sm fa-fw');
                    $obj.find('button[type="submit"]').attr('disabled', true);
                },
                success: function(response){
                    if(response.status == 'del'){
                        swal({
                            title: trans.error,
                            text: response.message,
                            timer: 5000,
                            onOpen: function() {
                                swal.showLoading()
                            }
                        })
                        setTimeout(function() {
                            window.location.href = "/category";
                        }, 2000);
                        return false;
                    }
                    if(response.status != "success"){
                        swal({
                            title: trans.error,
                            text: trans.error_loading_in_ajax,
                            timer: 5000,
                            onOpen: function() {
                                swal.showLoading()
                            }
                        })
                        return false;
                    }
                    else if(response.status=='error')
                    {
                        swal({
                            title: trans.error,
                            text: trans.error_loading_in_ajax,
                            timer: 5000,
                            onOpen: function() {
                                swal.showLoading()
                            }
                        })

                        $('button[type="submit"]').attr('disabled', false);
                        $('button[type=reset]').trigger( "click" );
                    }
                    else{
                        $('button[type="submit"]').attr('disabled', false);
                        $('button[type=reset]').trigger( "click" );
                         swal({
                            position: 'top-right',
                            type: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(function() {
                            window.location.href = "/category";
                        }, 2000);
                    }
                },
                error: function (data, status, e) {
                    //toastr.error(e, "error storing company data");
                    $obj.find('button[type="submit"] i').attr('class', '');
                    $obj.find('button[type="submit"]').attr('disabled', false);
                    return false;
                },
                complete: function() {
                    $obj.find('button[type="submit"] i').attr('class', '');
                    $obj.find('button[type="submit"]').attr('disabled', false);
                },
            });
        }
    });	//form.validate
};

$(document).ready(function () {
    handleAdd();
});
