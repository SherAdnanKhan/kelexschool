'use strict';
// Class definition

var KTUserListDatatable = function () {

  // variables
  var datatable;
  var base_url = window.location.origin;
  // init
  var init = function () {
    // init the datatables. Learn more: https://keenthemes.com/metronic/?page=docs&section=datatable
    datatable = $('#kt_apps_user_list_datatable').KTDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
          read: {
            url: base_url + '/admin/users/get-data',
          },
        },
        pageSize: 10, // display 20 records per page
        //serverPaging: true,
        //serverFiltering: true,
        //serverSorting: true,
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
        sortable: false,
        width: 20,
        // selector: {
        //   class: 'kt-checkbox--solid'
        // },
        textAlign: 'center',
      }, {
        field: 'UserName',
        title: 'User',
        width: 200,
        // callback function support for column rendering
        template: function (data) {
          var avatars = data.avatars;
          var output = '';
          if (avatars.length > 0) {
            output = '<div class="kt-user-card-v2">\
								<div class="kt-user-card-v2__pic">\
									<img src="assets/media/users/' + avatars[0] + '" alt="photo">\
								</div>\
								<div class="kt-user-card-v2__details">\
									<a href="#" class="kt-user-card-v2__name">' + data.username + '</a>\
									<span class="kt-user-card-v2__desc">' + data.first_name + ' ' + data.last_name + '</span>\
								</div>\
							</div>';
          } else {
            var stateNo = KTUtil.getRandomInt(0, 6);
            var states = [
              'success',
              'brand',
              'danger',
              'success',
              'warning',
              'primary',
              'info'
            ];
            var state = states[stateNo];

            output = '<div class="kt-user-card-v2">\
								<div class="kt-user-card-v2__pic">\
									<div class="kt-badge kt-badge--xl kt-badge--' + state + '">' + data.username.substring(0, 1) + '</div>\
								</div>\
								<div class="kt-user-card-v2__details">\
									<a href="#" class="kt-user-card-v2__name">' + data.username + '</a>\
									<span class="kt-user-card-v2__desc">' + data.first_name + ' ' + data.last_name + '</span>\
								</div>\
							</div>';
          }

          return output;
        }
      }, {
        field: 'posts_count',
        title: 'Country',
        width: 20,
      }, {
        field: 'Actions',
        width: 80,
        title: 'Actions',
        sortable: false,
        autoHide: false,
        overflow: 'visible',
        template: function () {
          return '\
							<div class="dropdown">\
								<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">\
									<i class="flaticon-more-1"></i>\
								</a>\
								<div class="dropdown-menu dropdown-menu-right">\
									<ul class="kt-nav">\
										<li class="kt-nav__item">\
											<a href="#" class="kt-nav__link">\
												<i class="kt-nav__link-icon flaticon2-expand"></i>\
												<span class="kt-nav__link-text">View</span>\
											</a>\
										</li>\
									</ul>\
								</div>\
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
  KTUserListDatatable.init();
});