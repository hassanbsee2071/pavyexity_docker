<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  |scheduHere is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

/**
 * Auth routes
 */
Route::get('command', function () {

	/* php artisan migrate */
    \Artisan::call('migrate');
    dd("Done");
});
Route::get('card/success', function () {

    return view('admin.Response.success');
});
Route::get('card/virtual', function () {

    return view('admin.payments.card2');
});
Route::get('create_bank_account','Admin\PaymentsController@create_bank_account')->name('create_bank_account');
Route::get('viewcreditcard','Admin\PaymentsController@creditview');
Route::get('create_card','admin\PaymentsController@createCardPayment')->name('create_card');
// Route::get('v','admin\PaymentsController@createCardPayment')->name('create_card');
// Route::get('paymentlink/{id}', 'admin\PaymentsController@paymentlink')->name('paymentlink');
// Route::get('/new/company/invoice/list', 'Admin/InvoiceController@index')->name('company.invoices.list');

Route::get('paymentlink/{id}', 'Admin\PaymentsController@guestpaymentlink')->name('paymentlink'); //Guest Payment
// Route::post('guest/payments/proccess-payment','Admin\UpdatedPaymentsController@proccess-payment')->name('guest.payments.proccess-payment');
Route::post('guest/payments/proccess-payment','Admin\UpdatedPaymentsController@processGuestPaymentforPayee')->name('guest.payments.proccess-payment');
    Route::get('admin/users/export/csv', 'ExportCsvController@exportCsvUser')->name('admin.user.export');
    Route::get('admin/invoice/export/csv', 'ExportCsvController@exportCsvInvoice')->name('company.invoice.export');
    Route::get('admin/payment/export/csv', 'ExportCsvController@exportCsvPayment')->name('admin.payment.export');
    Route::get('admin/schedule/export/csv', 'ExportCsvController@exportCsvSchedule')->name('admin.schedule.export');
    Route::get('admin/schedule/export/csv', 'ExportCsvController@exportCsvSchedule')->name('admin.schedule.export');
    Route::get('payment/received/view/{id}', 'ExportCsvController@receive_payment')->name('payment.received.view');



Route::group(['namespace' => 'Auth'], function () {

    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout')->name('logout');

    // Registration Routes...
    if (config('auth.users.registration')) {
        Route::get('payment/{email}', 'RegisterController@showRegistrationForm')->name('payment');
        Route::post('register', 'RegisterController@register');
    }

    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');

    // Confirmation Routes...
    if (config('auth.users.confirm_email')) {
        Route::get('confirm/{user_by_code}', 'ConfirmController@confirm')->name('confirm');
        Route::get('confirm/resend/{user_by_email}', 'ConfirmController@sendEmail')->name('confirm.send');
    }

    // Social Authentication Routes...
    Route::get('social/redirect/{provider}', 'SocialLoginController@redirect')->name('social.redirect');
    Route::get('social/login/{provider}', 'SocialLoginController@login')->name('social.login');
});

/**
 * Backend routes
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin'], function () {

    // Dashboard
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::middleware(['SuperUser'])->group(function () {
        //company settings
        Route::get('company', 'CompanySettingController@index')->name('company');
        Route::get('company/add', 'CompanySettingController@add')->name('company.add');
        Route::get('company/{id}/delete', 'CompanySettingController@delete')->name('company.delete');
        Route::post('company_save', 'CompanySettingController@save_company')->name('company.company_save');

        Route::get('email_template', 'EmailManagementController@index')->name('email_template');
        Route::get('email_template/add', 'EmailManagementController@add')->name('email_template.add');
        Route::get('email_template/{id}', 'EmailManagementController@edit')->name('email_template.edit');
        Route::get('email_template/{id}/delete', 'EmailManagementController@delete')->name('email_template.delete');
        Route::post('email_template/{id}', 'EmailManagementController@update')->name('email_template.update');
        Route::post('email_template', 'EmailManagementController@save_email_template')->name('email_template.save_email_template');
        Route::get('smtp', 'SmtpSettingController@update')->name('smtp');
        Route::post('smtp', 'SmtpSettingController@update')->name('smtp.update');
    });
    Route::post('bulk_payment_import', 'PaymentsController@bulkImportCSV')->name('bulk_payment_import');
    Route::post('import_process', 'PaymentsController@processImport')->name('import_process');
    Route::get('delete_process/{name}', 'PaymentsController@delete_process')->name('delete_process');

    Route::middleware(['SuperAndAdminUser'])->group(function () {
        //company settings
        Route::get('company/{id}', 'CompanySettingController@edit')->name('company.edit');
        Route::post('company/{id}', 'CompanySettingController@update')->name('company.update');

    });
    Route::post('payments/send-payment','UpdatedPaymentsController@sendPayment')->name('payments.send-payment');
   
   
    // Route::get('admin/users/export/csv', 'ExportCsvController@exportCsvUser')->name('admin.user.export');
    Route::middleware(['AdminUser'])->group(function () {
        //Users
        Route::get('users', 'UserController@index')->name('users');

        Route::get('user_add', 'UserController@create')->name('users.add');
        Route::post('user_save', 'UserController@store')->name('users.save');
        Route::get('users/restore', 'UserController@restore')->name('users.restore');
        Route::get('users/{id}/restore', 'UserController@restoreUser')->name('users.restore-user');
        Route::get('users/{user}', 'UserController@show')->name('users.show');
        Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');
        Route::put('users/{user}', 'UserController@update')->name('users.update');
        Route::any('users/{id}/destroy', 'UserController@destroy')->name('users.destroy');
        Route::get('permissions', 'PermissionController@index')->name('permissions');
        Route::get('permissions/{user}/repeat', 'PermissionController@repeat')->name('permissions.repeat');

        // Invoice management...
        Route::get('company/invoice/list', 'InvoiceController@index')->name('company.invoices.list');
        Route::get('company/invoice/add', 'InvoiceController@add')->name('company.invoice.add');
        Route::get('company/invoice/add-access', 'InvoiceController@add2')->name('company.invoice.add.access');
      
        Route::get('company/invoice/edit/{id}', 'InvoiceController@edit')->name('company.invoice.edit');
        Route::post('company/invoice/save', 'InvoiceController@save')->name('company.invoice.save');
        Route::post('company/invoice/save-access', 'InvoiceController@save2')->name('company.invoice.save2');

        Route::any('company/invoice/update/{id}', 'InvoiceController@update')->name('company.invoice.update');
        Route::any('company/invoice/{id}/destroy', 'InvoiceController@destroy')->name('company.invoice.destroy');
        Route::get('company/invoice/pdf', 'InvoiceController@invoicepdf')->name('company.invoice.pdf');
        //Dashboard
        Route::get('dashboard/log-chart', 'DashboardController@getLogChartData')->name('dashboard.log.chart');
        Route::get('dashboard/registration-chart', 'DashboardController@getRegistrationChartData')->name('dashboard.registration.chart');


        //Payment routes
        // Route::post('payments/send-payment','PaymentsController@sendPayment')->name('payments.send-payment');
        Route::post('payments/make-payment','PaymentsController@processPaymentforPayee')->name('payments.make-payment');

        //Bulk upload payment routes
        // Route::post('bulk_payment_import', 'PaymentsController@bulkImportCSV')->name('bulk_payment_import');
        // Route::post('import_process', 'PaymentsController@processImport')->name('import_process');

        Route::post('bulk_schedule_payment_import','PaymentsController@bulkImportScheduleCSV')->name('bulk_schedule_payment_import');
        Route::post('import_schedule_payment_process', 'PaymentsController@processScheduleImport')->name('import_schedule_payment_process');
        Route::post('import_schedule_payment_process_rec', 'PaymentsController@processScheduleImportRec')->name('import_schedule_payment_process_rec');

    });
    Route::get('/payments/importcsv', 'ImportController@getImport')->name('payments.importcsv');
    Route::post('/payments/import_parse', 'ImportController@parseImport')->name('payments.import_parse');
    Route::post('/payments/import_process', 'ImportController@processImport')->name('payments.import_process');
    Route::post('/payments/import_process_rec', 'ImportController@processImport2')->name('payments.import_process2');


    Route::get('/payments/importcsv-rec', 'ImportController@getImport2')->name('payments.importcsv2');
    Route::post('/payments/import_parse2', 'ImportController@parseImport2')->name('payments.import_parse2');


    Route::get('/payments', 'PaymentsController@index')->name('payments');
    Route::get('/payments/one-time-payment', 'PaymentsController@createOnetimePayment')->name('payments.one-time-payment');
    Route::get('payments/bulk', 'PaymentsController@index')->name('payments.bulk');

    Route::get('/payments/schedule/view','PaymentsController@viewPayment')->name('payments.schedule.view');
    Route::get('/payments/schedule/new','PaymentsController@schedulePayment')->name('payments.schedule.new');
    Route::post('/payments/schedule/add','PaymentsController@addSchedulePayment')->name('payments.schedule.add');
    Route::get('/payments/schedule/{user}/edit','PaymentsController@editSchedulePayment')->name('payments.schedule.edit');
    Route::any('/payments/schedule/{user}/delete','PaymentsController@deleteSchedulePayment')->name('payments.schedule.delete');
    Route::put('/payments/schedule/{user}','PaymentsController@updateSchedulePayment')->name('payments.schedule');
    Route::get('/payments/card/view','PaymentsController@viewCard')->name('payments.card.view');
    Route::post('payments/proccess-payment','UpdatedPaymentsController@processPaymentforAcceptence')->name('payments.proccess-payment');

    // Logs
    // Route::get('/logs', 'LogController@index')->name('logs');
    Route::get('/logs', 'LogsController@index')->name('logs');
});


//Main Default route for home
Route::get('/', 'Admin\DashboardController@index')->name('dashboard');
Route::get('/payment-method','Admin\PaymentsController@paymentMethod')->name('payment-method');

/**
 * Membership
 */
//Not in use as of moment
Route::group(['as' => 'protection.'], function () {
    Route::get('membership', 'MembershipController@index')->name('membership')->middleware('protection:' . config('protection.membership.product_module_number') . ',protection.membership.failed');
    Route::get('membership/access-denied', 'MembershipController@failed')->name('membership.failed');
    Route::get('membership/clear-cache/', 'MembershipController@clearValidationCache')->name('membership.clear_validation_cache');
});

/**
 * Online Payment Service routes
 */

 Route::group(['prefix' => 'online', 'as' => 'online.'], function () {
     Route::get('/payment/links', 'Admin\PaymentsController@getPaymentLinks')->name('payment.links');
     Route::get('/payment/links/export/csv', 'ExportCsvController@exportCsvLinks')->name('payment.links.export');
     Route::get('/payment/links/create', 'Admin\PaymentsController@createPaymentLink')->name('payment.links.create');
     Route::get('/payment/links/{id}', 'Admin\PaymentsController@showPaymentLink')->name('payment.links.show');
     Route::get('/payment/links/{id}/edit', 'Admin\PaymentsController@editPaymentLink')->name('payment.links.edit');
    //  Route::post('/payment/links', 'Admin\PaymentsController@savePaymentLink')->name('payment.links.save');
    Route::post('/payment/links/generate', 'Admin\PaymentsController@generatepaymentlink')->name('payment.links.generate'); //Guest Payment
    
    
    Route::post('/payment/links', 'Admin\PaymentsController@savePaymentLink')->name('payment.links.save');

     Route::put('/payment/links/{id}', 'Admin\PaymentsController@updatePaymentLink')->name('payment.links.update');
     Route::delete('/payment/links/{id}', 'Admin\PaymentsController@deletePaymentLink')->name('payment.links.destroy');
     Route::get('/paymentlink/{hash}/{id}', 'Admin\PaymentsController@showOnlinePayment')->name('payment.show');

     Route::post('/payment', 'Admin\PaymentsController@makeOnlinePayment')->name('payment');
     Route::get('/payment/received', 'Admin\PaymentsController@getReceivedPayments')->name('payment.received');
 });
