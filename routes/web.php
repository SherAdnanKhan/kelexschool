<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AcademicsController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\KelexBanksController;
use App\Http\Controllers\PaperMarksController;
use App\Http\Controllers\NonTeachingController;
use App\Http\Controllers\SchoolWebsiteController;
use App\Http\Controllers\StudentLoginController;
use App\Http\Controllers\TeacherLoginController;
use App\Http\Controllers\StudentAttendanceController;
use App\Http\Controllers\TeacherAttendanceController;
use App\Http\Controllers\TempController;
use App\Http\Controllers\WithdrawController;
use App\Models\Kelex_banks;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', [TempController::class, 'updatestudents']);
Route::get('/test1', [TempController::class, 'updateteachers']);

Route::match(['get', 'post'], '/submit_admiss_form', [StudentController::class, 'submit_admiss_form'])->name('submit_admiss_form');


Route::get('/', [SchoolWebsiteController::class, 'index']);


Route::get('/login', function () {
    if(session()->has('is_admin'))
    {
        return redirect('/admin');
    }
    else if(session()->has('is_student'))
    {
        return redirect('/student/dashboard');
    }
    else if(session()->has('is_teacher'))
    {
        return redirect('/teacher/dashboard');
    }
    else{
    return view('auth.kelexlogin');
    }
})->name('login');

Route::match(['get', 'post'], '/searchingtimetable', [TimetableController::class, 'searchingtimetable'])->name('searchingtimetable');

Route::match(['get', 'post'], '/showtimetable', [TimetableController::class, 'showtimetable'])->name('showtimetable');
Route::get('/get-employee-details/{employeeid}', [EmployeeController::class, 'getemployeedetails'])->name('get-employee-details');

Route::prefix('admin')->group(function () {

    Route::match(['get', 'post'], '/login', [AdminLoginController::class, 'login_Admin'])->name('adminLogin');

    Route::match(['get', 'post'], '/logout', [AdminloginController::class, 'logout_Admin'])->name('logout');

    Route::post('/passwordreset', [AdminLoginController::class, 'resetpassword_Admin'])->name('password.request');
});

Route::prefix('student')->group(function () {

    Route::match(['get', 'post'], '/login_student', [StudentLoginController::class, 'login_student'])->name('loginstudent');

    Route::match(['get', 'post'], '/logout_student', [StudentLoginController::class, 'logout_student'])->name('logoutstudent');

    Route::post('/password_reset_student', [StudentLoginController::class, 'resetpassword_student'])->name('passwordstudent');

    Route::group(['middleware' => 'Student'], function () {
        Route::match(['get', 'post'], '/dashboard', [StudentLoginController::class, 'dashboard'])->name('studentdashboard');
        Route::get('viewstudentdetails/{id}', [StudentController::class, 'showdetails'])->name('viewstudentdetails');

        //Student application routes
        Route::match(['get', 'post'], '/Application', [StudentAttendanceController::class, 'StudentApplication'])->name('StudentApplication');
        Route::match(['get', 'post'], '/AddApplication', [StudentAttendanceController::class, 'AddApplication'])->name('Student_Add_Application');
        Route::match(['get', 'post'], '/ViewApplication', [StudentAttendanceController::class, 'ViewApplication'])->name('Student_View_Application');
        // Student result routes

        Route::match(['get', 'post'], '/ExamResult', [ExamController::class, 'ExamResult'])->name('ExamResult');
        Route::match(['get', 'post'], '/showtimetable', [TimetableController::class, 'showtimetableStudent'])->name('showtimetableStudent');

    });
});


Route::prefix('teacher')->group(function () {

    Route::match(['get', 'post'], '/dashboard', [TeacherLoginController::class, 'dashboard'])->name('dashboard');
    Route::match(['get', 'post'], '/login_teacher', [TeacherLoginController::class, 'login_employee'])->name('loginteacher');

    Route::match(['get', 'post'], '/logout_teacher', [TeacherLoginController::class, 'logout_employee'])->name('logoutteacher');

    Route::post('/passwordreset_teacher', [TeacherLoginController::class, 'resetpassword_employee'])->name('passwordteacher');
Route::group(['middleware' => 'Teacher'], function () {
Route::match(['get', 'post'],'/Application',[TeacherAttendanceController::class,'TeacherApplication'])->name('TeacherApplication');
Route::match(['get', 'post'],'/AddApplication',[TeacherAttendanceController::class,'AddApplication'])->name('Teacher_Add_Application');
Route::match(['get', 'post'],'/ViewApplication',[TeacherAttendanceController::class,'ViewApplication'])->name('Teacher_View_Application');
// Teahcer Mark Paper Routes
Route::match(['get', 'post'],'/Paper',[PaperMarksController::class,'Paper'])->name('Paper');
Route::match(['get', 'post'],'/getsubjects',[PaperMarksController::class,'getsubjects'])->name('getsubjects');
Route::match(['get', 'post'],'/getpaperid',[PaperMarksController::class,'getpaperid'])->name('getpaperid');
Route::match(['get', 'post'],'/Search_Student',[PaperMarksController::class,'Search_Student'])->name('Search_Student');
Route::match(['get', 'post'],'/Add_marks',[PaperMarksController::class,'Add_marks'])->name('Add_marks');
Route::match(['get', 'post'],'/View_marks',[PaperMarksController::class,'View_marks'])->name('View_marks');
Route::get('/getsections/{id}',  [StudentController::class, 'fetch']);

//upload paper by teacher Route Start here

Route::match(['get', 'post'],'/UploadPaperTeacher',[ExamController::class,'UploadPaperTeacher'])->name('UploadPaperTeacher');
Route::match(['get', 'post'],'/need_to_upload',[ExamController::class,'need_to_upload'])->name('need_to_upload');
Route::match(['get', 'post'],'/upload_paper',[ExamController::class,'upload_paper'])->name('upload_paper');

// Teacher Paper Attendance routes start here
Route::match(['get', 'post'],'/Paperattendance',[PaperMarksController::class,'Paperattendance'])->name('Paperattendance');
Route::match(['get', 'post'],'/Search_attendance',[PaperMarksController::class,'Search_attendance'])->name('Search_attendance');
Route::match(['get', 'post'],'/Add_attendance',[PaperMarksController::class,'Add_attendance'])->name('Add_attendance');
Route::match(['get', 'post'], '/Application', [TeacherAttendanceController::class, 'TeacherApplication'])->name('TeacherApplication');
Route::match(['get', 'post'], '/AddApplication', [TeacherAttendanceController::class, 'AddApplication'])->name('Teacher_Add_Application');
Route::match(['get', 'post'], '/ViewApplication', [TeacherAttendanceController::class, 'ViewApplication'])->name('Teacher_View_Application');
Route::match(['get', 'post'], '/showtimetable', [TimetableController::class, 'showtimetableTeacher'])->name('showtimetableteacher');
    });

});


Route::group(['middleware' => 'SuperAdmin'], function () {
    Route::get('/superadmin', [App\Http\Controllers\AdminController::class, 'index'])->name('superadmin');
    // Campus Routes
    Route::match(['get', 'post'], '/campus', [CampusController::class, 'index'])->name("campus");

    Route::match(['get', 'post'], '/addcampus', [App\Http\Controllers\CampusController::class, 'store'])->name('addcampus');

    Route::get('/showcampus', [App\Http\Controllers\CampusController::class, 'showcampus'])->name('showcampus');

    Route::get('/editcampus', [App\Http\Controllers\CampusController::class, 'getcampusdata'])->name('editcampus');

    Route::post('/updatecampus', [App\Http\Controllers\CampusController::class, 'updatecampusdata'])->name('updatecampus');

    Route::get('/deletecampus', [App\Http\Controllers\CampusController::class, 'deletecampusdata'])->name('deletecampus');
});


Route::group(['middleware' => 'Admin'], function () {

    Route::get('admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
    Route::get('/comingsoon', function () {

        return view('Coming_Soon');
    });
    // Academics Route Start


    //section route
    Route::match(['get', 'post'], '/section', [AcademicsController::class, 'index_section'])->name("section");
    Route::match(['get', 'post'], '/addsection', [AcademicsController::class, 'add_section'])->name("addsection");
    Route::match(['get', 'post'], '/editsection', [AcademicsController::class, 'edit_section'])->name("editsection");
    Route::match(['get', 'post'], '/updatesection', [AcademicsController::class, 'update_section'])->name("updatesection");
    Route::match(['get', 'post'], '/deletesection', [AcademicsController::class, 'delete_section'])->name("deletesection");
    //end section routes

    //Class Routes
    Route::match(['get', 'post'], '/class', [AcademicsController::class, 'index_class'])->name("class");
    Route::match(['get', 'post'], '/addclass', [AcademicsController::class, 'add_class'])->name("addclass");
    Route::match(['get', 'post'], '/editclass', [AcademicsController::class, 'edit_class'])->name("editclass");
    Route::match(['get', 'post'], '/updateclass', [AcademicsController::class, 'update_class'])->name("updateclass");
    Route::match(['get', 'post'], '/deleteclass', [AcademicsController::class, 'delete_class'])->name("deleteclass");
    //end class routes

    //Subject Routes
    Route::match(['get', 'post'], 'subject', [AcademicsController::class, 'index_subject'])->name("subject");
    Route::match(['get', 'post'], '/addsubject', [AcademicsController::class, 'add_subject'])->name("addsubject");
    Route::match(['get', 'post'], '/editsubject', [AcademicsController::class, 'edit_subject'])->name("editsubject");
    Route::match(['get', 'post'], '/updatesubject', [AcademicsController::class, 'update_subject'])->name("updatesubject");
    Route::match(['get', 'post'], '/deletesubject', [AcademicsController::class, 'delete_subject'])->name("deletesubject");
    //end Subject routes

    //session-batch Routes
    Route::match(['get', 'post'], '/session-batch', [AcademicsController::class, 'index_sessionbatch'])->name("session-batch");
    Route::match(['get', 'post'], '/addsession-batch', [AcademicsController::class, 'add_sessionbatch'])->name("addsession-batch");
    Route::match(['get', 'post'], '/editsession-batch', [AcademicsController::class, 'edit_sessionbatch'])->name("editsession-batch");
    Route::match(['get', 'post'], '/updatesession-batch', [AcademicsController::class, 'update_sessionbatch'])->name("updatesession-batch");
    Route::match(['get', 'post'], '/deletesession-batch', [AcademicsController::class, 'delete_sessionbatch'])->name("deletesession-batch");
    //end session-batch routes

    //Subject Group NAME Routes
    Route::match(['get', 'post'], '/sgroup', [AcademicsController::class, 'index_sgroup'])->name("sgroup");
    Route::match(['get', 'post'], '/addsgroup', [AcademicsController::class, 'add_sgroup'])->name("addsgroup");
    Route::match(['get', 'post'], '/editsgroup', [AcademicsController::class, 'edit_sgroup'])->name("editsgroup");
    Route::match(['get', 'post'], '/updatesgroup', [AcademicsController::class, 'update_sgroup'])->name("updatesgroup");
    //end Subject Group Routes

    //Subject Group Routes
    Route::match(['get', 'post'], 'subjectgroup', [AcademicsController::class, 'index_subjectgroup'])->name("subjectgroup");
    Route::match(['get', 'post'], '/addsubjectgroup', [AcademicsController::class, 'add_subjectgroup'])->name("addsubjectgroup");
    Route::match(['get', 'post'], '/editsubjectgroup', [AcademicsController::class, 'edit_subjectgroup'])->name("editsubjectgroup");
    Route::match(['get', 'post'], '/updatesubjectgroup', [AcademicsController::class, 'update_subjectgroup'])->name("updatesubjectgroup");
    //end Subject route



    // Academatics Routes End


    // Student Routes Start

    Route::match(['get', 'post'], '/student', [StudentController::class, 'index_student'])->name("student");
    Route::match(['post'], '/addstudent', [StudentController::class, 'add_student'])->name('addstudent');
    Route::get('/showstudent', [StudentController::class, 'showstudent'])->name('showstudent');
    Route::get('/editstudent/{id}', [StudentController::class, 'getstudentdata'])->name('editstudent');
    Route::match(['get', 'post'], '/updatestudent', [StudentController::class, 'update_student'])->name("updatestudent");

    Route::get('/showstudent', [StudentController::class, 'show'])->name('showstudent');
    Route::get('/getsections/{id}',  [StudentController::class, 'fetch']);
    Route::get('/getsection/{id}',  [GeneralController::class, 'getSections']);
    Route::get('/getclasses/',  [GeneralController::class, 'getClasses']);
    Route::get('getmatchingdata/{id}',  [StudentController::class, 'fetchstudentdata']);

    Route::get('/searchstudent', [StudentController::class, 'searchstudent'])->name('searchstudent');

    Route::get('/getidcard/{id}', [StudentController::class, 'get_student_data_for_id_card'])->name('getidcard');

    Route::match(['get', 'post'], '/showcredentialsstudent', [StudentController::class, 'showcredentials'])->name('showcredentialsstudent');
    Route::match(['get', 'post'], '/showcredentialsteacher', [EmployeeController::class, 'showcredentials'])->name('showcredentialsteacher');

    // Student Add Through Csv Start here

    Route::get('/import', [StudentController::class, 'getImport'])->name('import');
    Route::get('/download', [StudentController::class, 'getDownload']);
    Route::post('/import_process', [StudentController::class, 'processImport'])->name('import_process');



    /// Student Attendance start
    Route::get('/student-attendance', [StudentAttendanceController::class, 'student_attendance'])->name('student-attendance');
    Route::post('/get-abscent-list', [StudentAttendanceController::class, 'getNonPresentStudents'])->name('get-abscent-list');
    Route::post('/get-std-for-attendance', [StudentAttendanceController::class, 'get_stds_for_attendance'])->name('get-std-for-attendance');
    Route::post('/save-students-attendance', [StudentAttendanceController::class, 'save_students_attendance'])->name('save-students-attendance');
    Route::match(['post', 'get'], '/non-present-students', [StudentAttendanceController::class, 'non_present_students'])->name('non-present-students');
    Route::match(['get', 'post'], '/ViewApplicationAdmin', [StudentAttendanceController::class, 'ViewApplicationbyadmin'])->name('Admin_View_Application');
    Route::match(['get', 'post'], '/actionApplicationAdmin', [StudentAttendanceController::class, 'actionApplicationbyadmin'])->name('Admin_action_Application');
    /// Student Attendance end..


    /// Teacher Attendance start

    /// Teacher Attendance start
    Route::match(['get', 'post'], '/teacher-attendance', [teacherAttendanceController::class, 'teacher_attendance'])->name('teacher-attendance');
    Route::match(['get', 'post'], '/get-tchrall-for-attendance', [teacherAttendanceController::class, 'get_tchrall_for_attendance'])->name('get-tchrall-for-attendance');
    Route::match(['get', 'post'], '/save-teachers-attendance', [teacherAttendanceController::class, 'save_teachers_attendance'])->name('save-teachers-attendance');

    /// Teacher Attendance start
    Route::match(['get', 'post'], '/teacher-attendance', [teacherAttendanceController::class, 'teacher_attendance'])->name('teacher-attendance');
    Route::match(['get', 'post'], '/get-tchrall-for-attendance', [teacherAttendanceController::class, 'get_tchrall_for_attendance'])->name('get-tchrall-for-attendance');
    Route::match(['get', 'post'], '/save-teachers-attendance', [teacherAttendanceController::class, 'save_teachers_attendance'])->name('save-teachers-attendance');
    Route::match(['get', 'post'], '/TeacherViewApplicationAdmin', [TeacherAttendanceController::class, 'ViewApplicationbyadmin'])->name('Teacher-View-Application-by-admin');
    Route::match(['get', 'post'], '/TeacteractionApplicationAdmin', [TeacherAttendanceController::class, 'actionApplicationbyadmin'])->name('Teacher-Action-Application-by-admin');
    /// Teacher Attendance end..

    // Fee Catergory Routes Start

    Route::match(['get', 'post'], '/feecategory', [FeeController::class, 'index_feecategory'])->name("feecategory");
    Route::match(['get', 'post'], '/get-sections-by-session/{session_id}', [FeeController::class, 'fee_define_new'])->name("get-sections-by-session");
    Route::match(['get', 'post'], '/addfeecategory', [FeeController::class, 'add_feecategory'])->name("addfeecategory");
    Route::match(['get', 'post'], '/editfeecategory', [FeeController::class, 'edit_feecategory'])->name("editfeecategory");
    Route::match(['get', 'post'], '/updatefeecategory', [FeeController::class, 'update_feecategory'])->name("updatefeecategory");
    Route::match(['get', 'post'], '/get-fee-categories/{class_id}/{section_id}', [FeeController::class, 'get_fee_categories'])->name("get-fee-categories");

    //Fee type Routes Start
    Route::match(['get', 'post'], '/get-student-fee/{session_id}/{class_id}/{section_id}', [FeeController::class, 'get_student_fee'])->name("get-student-fee");
    Route::match(['get', 'post'], '/fee-type', [FeeController::class, 'fee_type'])->name("fee-type");
    Route::match(['get', 'post'], '/add-fee-type', [FeeController::class, 'add_fee_type'])->name("add-fee-type");
    Route::match(['get', 'post'], '/edit-fee-type', [FeeController::class, 'edit_fee_type'])->name("edit-fee-type");
    Route::match(['get', 'post'], '/update-fee-type', [FeeController::class, 'update_subjectgroup'])->name("update-fee-type");
    // Route::match(['get', 'post'], '/fee-structure', [FeeController::class, 'fee_structure'])->name("fee-structure");
    Route::match(['get', 'post'], '/fee-structure', [FeeController::class, 'fee_define_new'])->name("fee-structure");
    Route::match(['get', 'post'], '/add-fee-structure', [FeeController::class, 'add_fee_structure'])->name("add-fee-structure");
    Route::match(['get', 'post'], '/apply-fee-structure', [FeeController::class, 'apply_fee_structure'])->name("apply-fee-structure");
    Route::match(['get', 'post'], '/apply-fee', [FeeController::class, 'apply_fee'])->name("Apply-Fee");
    Route::match(['get', 'post'], '/get-section-fee-category/{session_id}/{class_id}/{section_id}', [FeeController::class, 'get_section_fee_category'])->name("get-section-fee-category");
    Route::match(['get', 'post'], '/get-section-fee/{session_id}/{class_id}/{section_id}/{type}', [FeeController::class, 'get_section_fee'])->name("get-section-fee");
    Route::match(['get', 'post'], '/print-fee-voucher', [FeeController::class, 'fee_voucher'])->name("fee-voucher");
    Route::match(['get', 'post'], '/apply-fee-on-sections', [FeeController::class, 'apply_fee_on_sections'])->name("apply-fee-on-sections");
    Route::get('/get-fee-type/{session_id}/{class_id}/{section_id}/{fee_cat_id}', [FeeController::class, 'get_fee_type'])->name("get-fee-type");
    Route::get('/fee-collection-view',[FeeController::class, 'student_fee_collection_view'])->name('fee-collection-view');
    Route::match(['get','post'],'/get-fee-collection-data/{session_id}/{class_id}/{section_id}', [FeeController::class, 'get_fee_collection_data'])->name('get-fee-collection-data');
    Route::match(['get', 'post'], '/fee-collection', [FeeController::class, 'fee_collection'])->name("fee-collection");
    Route::match(['get', 'post'], '/family-accounts', [FeeController::class, 'family_accounts'])->name("family-accounts");
    Route::match(['get', 'post'], '/get-family-accounts/{session_id}', [FeeController::class, 'get_family_accounts'])->name("get-family-accounts");
    Route::match(['get', 'post'], '/fee-register', [FeeController::class, 'fee_register'])->name("fee-register");
    // Route::get('/get-fee-collection-data',function(){

// });

  //Online Registation fee routes start here
  Route::match(['get', 'post'], '/index_fee_reg', [FeeController::class, 'index_fee_reg'])->name("index_fee_reg");
  Route::match(['get', 'post'], '/search_reg_fee', [FeeController::class, 'search_reg_fee'])->name("search_reg_fee");
  Route::match(['get', 'post'], '/apply_reg_fee', [FeeController::class, 'apply_reg_fee'])->name("apply_reg_fee");


//Employee Routes Start
Route::match(['get', 'post'], '/employee', [EmployeeController::class, 'index_employee'])->name("employee");
Route::match(['post'],'/addemployee', [EmployeeController::class, 'add_employee'])->name('addemployee');
Route::get('/showemployee', [EmployeeController::class, 'showemployee'])->name('showemployee');
Route::get('/editemployee/{id}', [EmployeeController::class, 'getemployeedata'])->name('editemployee');
Route::match(['get', 'post'], '/updateemployee', [EmployeeController::class, 'update_employee'])->name("updateemployee");

//Add Non Teaching Staff
Route::match(['get', 'post'], '/staff', [NonTeachingController::class, 'index_staff'])->name("staff");
Route::match(['get', 'post'], '/addstaff', [NonTeachingController::class, 'store_staff'])->name("add-staff");
Route::match(['get', 'post'], '/showstaff', [NonTeachingController::class, 'show_all_staff'])->name("show-staff");
Route::match(['get', 'post'], '/editstaff/{id}', [NonTeachingController::class, 'edit_staff'])->name("edit-staff");
Route::match(['get', 'post'], '/updatestaff', [NonTeachingController::class, 'update_staff'])->name("update-staff");

// Add Exam Routes Start Here
Route::match(['get', 'post'], '/exam', [ExamController::class, 'index_exam'])->name("exam");
Route::match(['get', 'post'], '/addexam', [ExamController::class, 'add_exam'])->name("addexam");
Route::match(['get', 'post'], '/editexam', [ExamController::class, 'edit_exam'])->name("editexam");
Route::match(['get', 'post'], '/updateexam', [ExamController::class, 'update_exam'])->name("updateexam");
Route::match(['get', 'post'], '/deleteexam', [ExamController::class, 'delete_exam'])->name("deleteexam");

// Add Exam paper routes start here

Route::match(['get', 'post'], '/exampaper', [ExamController::class, 'index_exampaper'])->name("exampaper");
Route::match(['get', 'post'], '/view_exam_paper', [ExamController::class, 'view_exam_paper'])->name("view_exam_paper");
Route::match(['get', 'post'], '/add_exam_paper', [ExamController::class, 'add_exam_paper'])->name("add_exam_paper");
Route::match(['get', 'post'], '/edit_exam_paper', [ExamController::class, 'edit_exam_paper'])->name("edit_exam_paper");
Route::match(['get', 'post'], '/update_exam_paper', [ExamController::class, 'update_exam_paper'])->name("update_exam_paper");

//Exam Roll No Routes  Start Here
Route::match(['get', 'post'], '/examrollno', [ExamController::class, 'index_examrollno'])->name("examrollno");
Route::match(['get', 'post'], '/printrollno', [PaperMarksController::class, 'print_roll_no'])->name("printrollno");

// Assign Paper to teacher start here
Route::match(['get', 'post'], '/papermark', [ExamController::class, 'index_paperassign'])->name("papermark");
Route::match(['get', 'post'], '/assign_paper_teacher', [ExamController::class, 'assign_paper_teacher'])->name("assign_paper_teacher");
Route::match(['get', 'post'],'/getpapersubject',[ExamController::class,'getpapersubject'])->name('getpapersubject');
Route::get('/downloadupload/{UPLOADFILE}', [ExamController::class, 'getDownload']);

// Assign Teacher to Paper Exam Start here
Route::match(['get', 'post'], '/assign_exam_paper', [ExamController::class, 'assign_exam_paper'])->name("assign_exam_paper");
Route::match(['get', 'post'], '/get_assign_exam_paper', [ExamController::class, 'get_assign_exam_paper'])->name("get_assign_exam_paper");

//Add Grade Routes Start here

Route::match(['get', 'post'], '/grade', [ExamController::class, 'index_grade'])->name("grade");
Route::match(['get', 'post'], '/addgrade', [ExamController::class, 'add_grade'])->name("addgrade");
Route::match(['get', 'post'], '/editgrade', [ExamController::class, 'edit_grade'])->name("editgrade");
Route::match(['get', 'post'], '/updategrade', [ExamController::class, 'update_grade'])->name("updategrade");
Route::match(['get', 'post'], '/deletegrade', [ExamController::class, 'delete_grade'])->name("deletegrade");

//Publish Result Routes Start here
Route::match(['get', 'post'], '/result', [ExamController::class, 'index_result'])->name("result");
Route::match(['get', 'post'],'/getsubject',[PaperMarksController::class,'getsubjects'])->name('getsubject');

Route::match(['get', 'post'],'/getsubjectadmin',[PaperMarksController::class,'getsubjectadmin'])->name('getsubjectadmin');
Route::match(['get', 'post'],'/Search_result',[PaperMarksController::class,'Search_result'])->name('Search_result');
Route::match(['get', 'post'],'/PublishResult',[PaperMarksController::class,'PublishResult'])->name('PublishResult');

// Print result start here
Route::match(['get', 'post'],'/PrintResult',[PaperMarksController::class,'PrintResult'])->name('PrintResult');

Route::match(['get', 'post'],'/ResultPrint',[PaperMarksController::class,'ResultPrint'])->name('ResultPrint');

// Print DateSheet Route Start here
Route::match(['get', 'post'],'/IndexDateSheet',[PaperMarksController::class,'IndexDateSheet'])->name('IndexDateSheet');

// Withdraw Student ROutes Start here

Route::get('/withdrawstudent', [WithdrawController::class, 'show'])->name('withdrawstudent');
Route::match(['get', 'post'],'/deletestudent', [WithdrawController::class, 'delete_student'])->name('deletestudent');

Route::get('/show_withdraw_students', [WithdrawController::class, 'show_withdraw_students'])->name('show_withdraw_students');
Route::post('getmatchingstudent',  [WithdrawController::class, 'fetch_withdraw_student_data']);
Route::match(['get', 'post'],'/rollbackstudent', [WithdrawController::class, 'roll_back_student'])->name('rollbackstudent');

// Certificate Management Routes Start here
Route::match(['get', 'post'],'/index_slc', [CertificateController::class, 'index_slc'])->name('index_slc');
Route::match(['get', 'post'],'/print_slc/{STUDENT_ID}', [CertificateController::class, 'print_slc'])->name('print_slc');

// Timetable routes start here


Route::match(['get', 'post'], '/timetable', [TimetableController::class, 'index'])->name('timetable');

Route::match(['get', 'post'], '/Searchtimetable', [TimetableController::class, 'Searchtimetable'])->name('Searchtimetable');
Route::match(['get', 'post'], '/Savetimetable', [TimetableController::class, 'Savetimetable'])->name('Savetimetable');
Route::match(['get', 'post'], '/deletetimetable', [TimetableController::class, 'deletetimetable'])->name('deletetimetable');

///Banak Managament rouets.
Route::match(['get','post'],'/bank-managment',[KelexBanksController::class,'index'])->name('bank-managment');
Route::match(['get', 'post'], '/add-bank', [KelexBanksController::class, 'add_bank'])->name('add-bank');
Route::match(['get', 'post'], '/edit-bank/{id}', [KelexBanksController::class, 'edit_bank'])->name('edit-bank');
Route::match(['get', 'post'], '/update-bank', [KelexBanksController::class, 'update_bank'])->name('update-bank');
    /// End Bank Managment routes..

// General Setting routes
Route::match(['get', 'post'], '/fee-terms', [GeneralSettingController::class, 'fee_terms'])->name('fee-terms');
Route::match(['get', 'post'], '/index_campus_settings', [GeneralSettingController::class, 'index_campus_settings'])->name('index_campus_settings');
Route::match(['get', 'post'], '/update_campus_settings', [GeneralSettingController::class, 'update_campus_settings'])->name('update_campus_settings');
// End General Setting routes
});
