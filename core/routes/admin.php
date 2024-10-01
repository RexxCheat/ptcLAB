<?php

use Illuminate\Support\Facades\Route;


Route::namespace('Auth')->controller('LoginController')->group(function () {
    Route::get('/', 'showLoginForm')->name('login');
    Route::post('/', 'login')->name('login');
    Route::get('logout', 'logout')->name('logout');

    // Admin Password Reset
    Route::controller('ForgotPasswordController')->group(function(){
        Route::get('password/reset', 'showLinkRequestForm')->name('password.reset');
        Route::post('password/reset', 'sendResetCodeEmail');
        Route::get('password/code-verify', 'codeVerify')->name('password.code.verify');
        Route::post('password/verify-code', 'verifyCode')->name('password.verify.code');
    });

    Route::controller('ResetPasswordController')->group(function(){
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset.form');
        Route::post('password/reset/change', 'reset')->name('password.change');
    });
});

Route::middleware('admin')->group(function () {
    Route::controller('AdminController')->group(function(){
        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::get('profile', 'profile')->name('profile');
        Route::post('profile', 'profileUpdate')->name('profile.update');
        Route::get('password', 'password')->name('password');
        Route::post('password', 'passwordUpdate')->name('password.update');

        //Notification
        Route::get('notifications','notifications')->name('notifications');
        Route::get('notification/read/{id}','notificationRead')->name('notification.read');
        Route::get('notifications/read-all','readAll')->name('notifications.readAll');

        //Report Bugs
        Route::get('request-report','requestReport')->name('request.report');
        Route::post('request-report','reportSubmit');

        Route::get('download-attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');

    });

    // Users Manager
    Route::controller('ManageUsersController')->name('users.')->prefix('users')->group(function(){
        Route::get('/', 'allUsers')->name('all');
        Route::get('active', 'activeUsers')->name('active');
        Route::get('banned', 'bannedUsers')->name('banned');
        Route::get('email-verified', 'emailVerifiedUsers')->name('email.verified');
        Route::get('email-unverified', 'emailUnverifiedUsers')->name('email.unverified');
        Route::get('mobile-unverified', 'mobileUnverifiedUsers')->name('mobile.unverified');
        Route::get('kyc-unverified', 'kycUnverifiedUsers')->name('kyc.unverified');
        Route::get('kyc-pending', 'kycPendingUsers')->name('kyc.pending');
        Route::get('mobile-verified', 'mobileVerifiedUsers')->name('mobile.verified');
        Route::get('mobile-verified', 'mobileVerifiedUsers')->name('mobile.verified');
        Route::get('with-balance', 'usersWithBalance')->name('with.balance');

        Route::get('detail/{id}', 'detail')->name('detail');
        Route::get('kyc-data/{id}', 'kycDetails')->name('kyc.details');
        Route::post('kyc-approve/{id}', 'kycApprove')->name('kyc.approve');
        Route::post('kyc-reject/{id}', 'kycReject')->name('kyc.reject');
        Route::post('update/{id}', 'update')->name('update');
        Route::post('add-sub-balance/{id}', 'addSubBalance')->name('add.sub.balance');
        Route::get('send-notification/{id}', 'showNotificationSingleForm')->name('notification.single');
        Route::post('send-notification/{id}', 'sendNotificationSingle')->name('notification.single');
        Route::get('login/{id}', 'login')->name('login');
        Route::post('status/{id}', 'status')->name('status');

        Route::get('send-notification', 'showNotificationAllForm')->name('notification.all');
        Route::post('send-notification', 'sendNotificationAll')->name('notification.all.send');
        Route::get('notification-log/{id}', 'notificationLog')->name('notification.log');
    });

    // Deposit Gateway
    Route::name('gateway.')->prefix('gateway')->group(function(){

        // Automatic Gateway
        Route::controller('AutomaticGatewayController')->group(function(){
            Route::get('automatic', 'index')->name('automatic.index');
            Route::get('automatic/edit/{alias}', 'edit')->name('automatic.edit');
            Route::post('automatic/update/{code}', 'update')->name('automatic.update');
            Route::post('automatic/remove/{id}', 'remove')->name('automatic.remove');
            Route::post('automatic/activate/{code}', 'activate')->name('automatic.activate');
            Route::post('automatic/deactivate/{code}', 'deactivate')->name('automatic.deactivate');
        });


        // Manual Methods
        Route::controller('ManualGatewayController')->group(function(){
            Route::get('manual', 'index')->name('manual.index');
            Route::get('manual/new', 'create')->name('manual.create');
            Route::post('manual/new', 'store')->name('manual.store');
            Route::get('manual/edit/{alias}', 'edit')->name('manual.edit');
            Route::post('manual/update/{id}', 'update')->name('manual.update');
            Route::post('manual/activate/{code}', 'activate')->name('manual.activate');
            Route::post('manual/deactivate/{code}', 'deactivate')->name('manual.deactivate');
        });
    });


    // DEPOSIT SYSTEM
    Route::name('deposit.')->controller('DepositController')->prefix('deposit')->group(function(){
        Route::get('/', 'deposit')->name('list');
        Route::get('pending', 'pending')->name('pending');
        Route::get('rejected', 'rejected')->name('rejected');
        Route::get('approved', 'approved')->name('approved');
        Route::get('successful', 'successful')->name('successful');
        Route::get('initiated', 'initiated')->name('initiated');
        Route::get('details/{id}', 'details')->name('details');

        Route::post('reject', 'reject')->name('reject');
        Route::post('approve/{id}', 'approve')->name('approve');

    });


    // WITHDRAW SYSTEM
    Route::name('withdraw.')->prefix('withdraw')->group(function(){

        Route::controller('WithdrawalController')->group(function(){
            Route::get('pending', 'pending')->name('pending');
            Route::get('approved', 'approved')->name('approved');
            Route::get('rejected', 'rejected')->name('rejected');
            Route::get('log', 'log')->name('log');
            Route::get('details/{id}', 'details')->name('details');
            Route::post('approve', 'approve')->name('approve');
            Route::post('reject', 'reject')->name('reject');
        });


        // Withdraw Method
        Route::controller('WithdrawMethodController')->group(function(){
            Route::get('method/', 'methods')->name('method.index');
            Route::get('method/create', 'create')->name('method.create');
            Route::post('method/create', 'store')->name('method.store');
            Route::get('method/edit/{id}', 'edit')->name('method.edit');
            Route::post('method/edit/{id}', 'update')->name('method.update');
            Route::post('method/activate/{id}', 'activate')->name('method.activate');
            Route::post('method/deactivate/{id}', 'deactivate')->name('method.deactivate');
        });
    });

    //refer
    Route::controller('ReferralController')->name('referrals.')->prefix('referrals')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::post('/', 'update')->name('update');
        Route::get('status/{id}', 'status')->name('status');
    });

    //Plan
    Route::get('/plan', 'PlanController@index')->name('plan.index');
    Route::post('/plan', 'PlanController@savePlan')->name('plan.save');


    //PTC ADS
    Route::controller('ManagePtcController')->name('ptc.')->prefix('ptc')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('active', 'active')->name('active');
        Route::get('inactive', 'inactive')->name('inactive');
        Route::get('pending', 'pending')->name('pending');
        Route::get('rejected', 'rejected')->name('rejected');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
    });

    // Report
    Route::controller('ReportController')->name('report.')->prefix('report')->group(function(){
        Route::get('transaction', 'transaction')->name('transaction');
        Route::get('login/history', 'loginHistory')->name('login.history');
        Route::get('login/ipHistory/{ip}', 'loginIpHistory')->name('login.ipHistory');
        Route::get('notification/history', 'notificationHistory')->name('notification.history');
        Route::get('email/detail/{id}', 'emailDetails')->name('email.details');
        Route::get('ptcview', 'ptcview')->name('ptcview');
        Route::get('referral-commissions', 'commissions')->name('commissions');
    });


    // Admin Support
    Route::controller('SupportTicketController')->group(function(){
        Route::get('tickets', 'tickets')->name('ticket');
        Route::get('tickets/pending', 'pendingTicket')->name('ticket.pending');
        Route::get('tickets/closed', 'closedTicket')->name('ticket.closed');
        Route::get('tickets/answered', 'answeredTicket')->name('ticket.answered');
        Route::get('tickets/view/{id}', 'ticketReply')->name('ticket.view');
        Route::post('ticket/reply/{id}', 'replyTicket')->name('ticket.reply');
        Route::post('ticket/close/{id}', 'closeTicket')->name('ticket.close');
        Route::get('ticket/download/{ticket}', 'ticketDownload')->name('ticket.download');
        Route::post('ticket/delete/{id}', 'ticketDelete')->name('ticket.delete');
    });


    // Language Manager
    Route::controller('LanguageController')->group(function(){
        Route::get('/language', 'langManage')->name('language.manage');
        Route::post('/language', 'langStore')->name('language.manage.store');
        Route::post('/language/delete/{id}', 'langDelete')->name('language.manage.delete');
        Route::post('/language/update/{id}', 'langUpdate')->name('language.manage.update');
        Route::get('/language/edit/{id}', 'langEdit')->name('language.key');
        Route::post('/language/import', 'langImport')->name('language.import.lang');
        Route::post('language/store/key/{id}', 'storeLanguageJson')->name('language.store.key');
        Route::post('language/delete/key/{id}', 'deleteLanguageJson')->name('language.delete.key');
        Route::post('language/update/key/{id}', 'updateLanguageJson')->name('language.update.key');
    });

    Route::controller('GeneralSettingController')->group(function(){
        // General Setting
        Route::get('general-setting', 'index')->name('setting.index');
        Route::post('general-setting', 'update')->name('setting.update');

        // Logo-Icon
        Route::get('setting/logo-icon', 'logoIcon')->name('setting.logo.icon');
        Route::post('setting/logo-icon', 'logoIconUpdate')->name('setting.logo.icon');

        //Custom CSS
        Route::get('custom-css','customCss')->name('setting.custom.css');
        Route::post('custom-css','customCssSubmit');

        //Cookie
        Route::get('cookie','cookie')->name('setting.cookie');
        Route::post('cookie','cookieSubmit');

        //maintenance_mode
        Route::get('maintenance-mode','maintenanceMode')->name('maintenance.mode');
        Route::post('maintenance-mode','maintenanceModeSubmit');

        //maintenance_mode
        Route::get('ads-setting','adsSetting')->name('setting.ads');
        Route::post('ads-setting','adsSettingSubmit');

    });


    //KYC setting
    Route::controller('KycController')->group(function(){
        Route::get('kyc-setting','setting')->name('kyc.setting');
        Route::post('kyc-setting','settingUpdate');
    });

    //Notification Setting
    Route::name('setting.notification.')->controller('NotificationController')->prefix('notification')->group(function(){
        //Template Setting
        Route::get('global','global')->name('global');
        Route::post('global/update','globalUpdate')->name('global.update');
        Route::get('templates','templates')->name('templates');
        Route::get('template/edit/{id}','templateEdit')->name('template.edit');
        Route::post('template/update/{id}','templateUpdate')->name('template.update');

        //Email Setting
        Route::get('email/setting','emailSetting')->name('email');
        Route::post('email/setting','emailSettingUpdate');
        Route::post('email/test','emailTest')->name('email.test');

        //SMS Setting
        Route::get('sms/setting','smsSetting')->name('sms');
        Route::post('sms/setting','smsSettingUpdate');
        Route::post('sms/test','smsTest')->name('sms.test');
    });

    // Plugin
    Route::controller('ExtensionController')->group(function(){
        Route::get('extensions', 'index')->name('extensions.index');
        Route::post('extensions/update/{id}', 'update')->name('extensions.update');
        Route::post('extensions/status/{id}', 'status')->name('extensions.status');
    });


    //System Information
    Route::controller('SystemController')->name('system.')->prefix('system')->group(function(){
        Route::get('info','systemInfo')->name('info');
        Route::get('server-info','systemServerInfo')->name('server.info');
        Route::get('optimize', 'optimize')->name('optimize');
        Route::get('optimize-clear', 'optimizeClear')->name('optimize.clear');
    });


    // SEO
    Route::get('seo', 'FrontendController@seoEdit')->name('seo');


    // Frontend
    Route::name('frontend.')->prefix('frontend')->group(function () {

        Route::controller('FrontendController')->group(function(){
            Route::get('templates', 'templates')->name('templates');
            Route::post('templates', 'templatesActive')->name('templates.active');
            Route::get('frontend-sections/{key}', 'frontendSections')->name('sections');
            Route::post('frontend-content/{key}', 'frontendContent')->name('sections.content');
            Route::get('frontend-element/{key}/{id?}', 'frontendElement')->name('sections.element');
            Route::post('remove/{id}', 'remove')->name('remove');
        });

        // Page Builder
        Route::controller('PageBuilderController')->group(function(){
            Route::get('manage-pages', 'managePages')->name('manage.pages');
            Route::post('manage-pages', 'managePagesSave')->name('manage.pages.save');
            Route::post('manage-pages/update', 'managePagesUpdate')->name('manage.pages.update');
            Route::post('manage-pages/delete/{id}', 'managePagesDelete')->name('manage.pages.delete');
            Route::get('manage-section/{id}', 'manageSection')->name('manage.section');
            Route::post('manage-section/{id}', 'manageSectionUpdate')->name('manage.section.update');
        });

    });
});

