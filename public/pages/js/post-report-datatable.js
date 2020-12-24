'use strict';
// Class definition

var KTFeebackListDatatable = function () {

  // variables
  var datatable;
  var base_url = window.location.origin;
  // init
  var init = function () {
    // init the datatables. Learn more: https://keenthemes.com/metronic/?page=docs&section=datatable
    datatable = $('#kt_apps_post_reports_list_datatable').KTDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
          read: {
            url: base_url + '/admin/post-reports/get-data',
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
        field: 'title',
        title: 'Title',

      }, {
        field: 'description',
        title: 'Description',

      }, {
        field: 'user.avatars',
        title: 'Created By',
        template: function (data) {
          console.log(data);
          var avatars = data.user.avatars;
          var output = '';
          if(avatars!=null){
            output = '<div class="kt-user-card-v2">\
                        <div class="kt-user-card-v2__pic">\
                          <img src="'+ avatars[0].path + '" alt="photo">\
                        </div>\
                        <div class="kt-user-card-v2__details">\
                          <a href="'+ base_url + '/admin/user/' + data.user.slug + '" class="kt-user-card-v2__name">' + data.user.username + '</a>\
                          <span class="kt-user-card-v2__desc">' + data.user.first_name + ' ' + data.user.last_name + '</span>\
                        </div>\
                      </div>';
          }
          return output;
        }
      }, {
        field: 'user.image',
        title: 'Picture',
        // callback function support for column rendering
        template: function (data) {
          var images = data.image;
          var output = '';
         
            output = '<div class="kt-user-card-v2">\
                        <div class="kt-user-card-v2__pic">\
                          <img src="'+ images.path + '" alt="photo">\
                        </div>\
                      </div>';
          return output;
        } 

      }, {
        field: 'Actions',
        width: 120,
        title: 'Actions',
        sortable: false,
        autoHide: false,
        overflow: 'visible',
        template: function (data) {
          console.log(data.id);
          return '\
              <div class="dropdown">\
                <a href="'+ base_url + '/admin/post-report/view-post/' + data.slug + '" class="kt-nav__link">\
                <i class="kt-nav__link-icon flaticon2-expand"></i>\
                <span class="kt-nav__link-text">View Post</span>\
                </a>\
              </div>\
              <div class="dropdown">\
                <a href="'+ base_url + '/admin/post-report/delete-post/' + data.slug + '" class="kt-nav__link">\
                <i class="kt-nav__link-icon flaticon2-expand"></i>\
                <span class="kt-nav__link-text">Delete Post</span>\
                </a>\
              </div>\
              <div class="dropdown">\
                <a href="'+ base_url + '/admin/post-report/delete-report/' + data.slug + '" class="kt-nav__link">\
                <i class="kt-nav__link-icon flaticon2-expand"></i>\
                <span class="kt-nav__link-text">Delete Report</span>\
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