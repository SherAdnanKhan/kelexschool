'use strict';

// Class Definition
var FeelEdit = function () {
  var showMsg = function (form, type, msg) {
    var alert = $('<div class="alert alert-' + type + ' alert-dismissible" role="alert">\
      <div class="alert-text">'+ msg + '</div>\
      <div class="alert-close">\
                <i class="flaticon2-cross kt-icon-sm" data-dismiss="alert"></i>\
            </div>\
    </div>');

    form.find('.alert').remove();
    alert.prependTo(form);
    //alert.animateClass('fadeIn animated');
    KTUtil.animateClass(alert[0], 'fadeIn animated');
    alert.find('span').html(msg);
  };

  var handleFeelEditFormSubmit = function () {
    $('#feel_edit_submit').click(function (e) {
      e.preventDefault();
      var btn = $(this);
      var form = $(this).closest('form');

      form.validate({
        rules: {
          color_code: {
            required: true
          }
        }
      });

      if (!form.valid()) {
        return;
      }

      btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);
      //console.log(form[0].action);
      form.ajaxSubmit({
        url: form[0].action,
        success: function (response, status) {
          if (status === 'success') {
            showMsg(form, 'success', 'Feel updated Sucessfully');
            btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
          } else {
            showMsg(form, 'danger', 'Unable to update! Please try again.');
          }
          setTimeout(function () {
            window.location.href = '/admin/feels';
          }, 500);
        },
        error: function () {
          showMsg(form, 'danger', 'Unable to update! Please try again.');
          btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
        }
      });
    });
  };
  // Public Functions
  return {
    // public functions
    init: function () {
      handleFeelEditFormSubmit();
    }
  };
}();

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#feel-icon-img').attr('src', e.target.result);
    };
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}


jQuery(document).ready(function () {
  FeelEdit.init();
  $('#feel_icon').change(function () {
    readURL(this);
  });
});