'use strict';
// Class definition

var KTFeebackListDatatable = function () {

  // variables
  var datatable;
  var base_url = window.location.origin;
  // init
  var init = function () {
    // init the datatables. Learn more: https://keenthemes.com/metronic/?page=docs&section=datatable
    datatable = $('#kt_apps_reports_list_datatable').KTDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
          read: {
            url: base_url + '/admin/user-reports/get-data',
            method: 'GET'
          },
        },
        pageSize: 10, // display 20 records per page
        serverPaging: true,
        serverFiltering: true,
        serverSorting: true,
      },

      // layout definition
      layout: {
        scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
        footer: false, // display/hide footer
      },

      // column sorting
      sortable: true,

      pagination: true,

      search: {
        input: $('#generalSearch'),
        delay: 400,
      },

      // columns definition
      columns: [{
        field: 'id',
        title: '#',
        sortable: true,
        width: 20,
        // selector: {
        //   class: 'kt-checkbox--solid'
        // },
        textAlign: 'center',
      }, {
        field: 'reason',
        title: 'Reason',

      }, {
        field: 'user.report_by_user',
        title: 'Reported By',
        template: function (data) {
          console.log(data);
          var avatars = data.report_by_user.avatar;
          var output = '';
          if(avatars!=null){
            output = '<div class="kt-user-card-v2">\
                        <div class="kt-user-card-v2__pic">\
                          <img src="'+ avatars.path + '" alt="photo">\
                        </div>\
                        <div class="kt-user-card-v2__details">\
                          <a href="'+ base_url + '/admin/user/' + data.report_by_user.slug + '" class="kt-user-card-v2__name">' + data.report_by_user.username + '</a>\
                          <span class="kt-user-card-v2__desc">' + data.report_by_user.first_name + ' ' + data.report_by_user.last_name + '</span>\
                        </div>\
                      </div>';
          }
          return output;
        }
      }, {
        field: 'user.report_to_user',
        title: 'Reported Against',
        // callback function support for column rendering
        template: function (data) {
          var avatars = data.report_to_user.avatar;
          var output = '';
         
            output = '<div class="kt-user-card-v2">\
                        <div class="kt-user-card-v2__pic">\
                          <img src="'+ avatars.path + '" alt="photo">\
                        </div>\
                        <div class="kt-user-card-v2__details">\
                          <a href="'+ base_url + '/admin/user/' + data.report_to_user.slug + '" class="kt-user-card-v2__name">' + data.report_to_user.username + '</a>\
                          <span class="kt-user-card-v2__desc">' + data.report_to_user.first_name + ' ' + data.report_to_user.last_name + '</span>\
                        </div>\
                      </div>';
          return output;
        } 
      }, {
        field: 'Actions',
        width: 80,
        title: 'Actions',
        sortable: false,
        autoHide: false,
        overflow: 'visible',
        template: function (data) {
          console.log(data.id);
          return '\
              <div class="dropdown">\
                <a href="'+ base_url + '/admin/user-report/ban-user/' + data.report_to_user.slug + + data.id+ '" class="kt-nav__link">\
                <i class="kt-nav__link-icon flaticon2-expand"></i>\
                <span class="kt-nav__link-text">Ban User</span>\
                </a>\
              </div>\
              <div class="dropdown">\
              <a href="'+ base_url + '/admin/user-report/delete-report/' + data.id + '" class="kt-nav__link">\
              <i class="kt-nav__link-icon flaticon2-expand"></i>\
              <span class="kt-nav__link-text">Delete</span>\
              </a>\
            </div>\
            ';
        },
      }]
    });
  };

  // search
  var search = function () {
    $('#kt_form_status').on('change', function () {
      datatable.search($(this).val().toLowerCase(), 'Status');
    });
  };

  return {
    // public functions
    init: function () {
      init();
      search();
    },
  };
}();

// On document ready
KTUtil.ready(function () {
  KTFeebackListDatatable.init();
});