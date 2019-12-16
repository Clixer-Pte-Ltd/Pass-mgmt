<?php
//----------cag user---------//
define('CAG_ADMIN_ROLE', 'cag admin');
define('CAG_STAFF_ROLE', 'cag staff');
define('CAG_VIEWER_ROLE', 'cag viewer');

define('CAG_ADMIN_ROLE_ID', '1');
define('CAG_STAFF_ROLE_ID', '2');
define('CAG_VIEWER_ROLE_ID', '3');
//----------end cag user---------//

//----------company user--------//
define('COMPANY_CO_ROLE', 'company coordinator');
define('COMPANY_AS_ROLE', 'company as');
define('COMPANY_VIEWER_ROLE', 'company viewer');

define('COMPANY_CO_ROLE_ID', '4');
define('COMPANY_AS_ROLE_ID', '5');
define('COMPANY_VIEWER_ROLE_ID', '6');
//----------end company user--------//



define('DATE_FORMAT', 'd/m/Y');
define('DATE_TIME_FORMAT', 'd/m/Y h:i');

define('SESS_NEW_ACC_FROM_TENANT', 'tenant');
define('SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR', 'sub_constructor');
define('SESS_TENANT_2FA', 'tenant_2fa');
define('SESS_SUB_CONSTRUCTOR_2FA', 'sub_constructor_2fa');
define('SESS_TENANT_SUB_CONSTRUCTOR', 'tenant_sub_constructor');
define('SESS_TENANT_MY_COMPANY', 'tenant_my_company');

define('SESS_ZONES', 'zones');

define('DEFAULT_PASSWORD', '$2y$10$lf6d3CGKjJ8l9dk39wJ8cOgB.xxl5akeI32oe7CTD4BwUYe/Xm7nC');

define('COMPANY_STATUS_WORKING', 0);
define('COMPANY_STATUS_WORKING_BUT_NEED_VALIDATE', 1);
define('COMPANY_STATUS_EXPIRED', 2);

define('PASS_STATUS_VALID', 0);
define('PASS_STATUS_BLACKLISTED', 1);
define('PASS_STATUS_WAITING_CONFIRM_RETURN', 2);
define('PASS_STATUS_RETURNED', 3);

define('SMTP_HOST', 'smtp_host');
define('SMTP_PORT', 'smtp_port');
define('SMTP_USERNAME', 'smtp_username');
define('SMTP_PASSWORD', 'smtp_password');
define('SMTP_ENCRYPTION', 'smtp_encryption');
define('ALLOW_MAIL', [
    'APP_MAIL_ACCOUNTINFO' => 'app_mail_accountinfo',
    'APP_MAIL_ADHOCMAIL' => 'app_mail_adhocmail',
    'APP_MAIL_BIANNUALMAIL' => 'app_mail_biannualmail',
    'APP_MAIL_COMPANIESLISTNOTVALIDATE' => 'app_mail_companieslistnotvalidate',
    'APP_MAIL_COMPANYEXPIREDMAIL' => 'app_mail_companyexpiredmail',
    'APP_MAIL_COMPANYEXPIRESOONMAIL' => 'app_mail_companyexpiresoonmail',
    'APP_MAIL_COMPANYNEEDVALIDATEMAIL' => 'app_mail_companyneedvalidatemail',
    'APP_MAIL_COMPANYNOTIFYNEWACCOUNT' => 'app_mail_companynotifynewaccount',
    'APP_MAIL_CREATEPASSHOLDERSUCCESSMAIL' => 'app_mail_createpassholdersuccessmail',
    'APP_MAIL_PASSHOLDEREXPIREDMAIL' => 'app_mail_passholderexpiredmail',
    'APP_MAIL_PASSHOLDEREXPIRESOONMAIL' => 'app_mail_passholderexpiresoonmail',
    'APP_MAIL_PASSHOLDERLISTISPENDINGRETURNMAIL' => 'app_mail_passholderlistispendingreturnmail',
    'APP_MAIL_PASSHOLDERNEEDCONFIRMRETURNMAIL' => 'app_mail_passholderneedconfirmreturnmail',
    'APP_MAIL_PASSHOLDERRENEWMAIL' => 'app_mail_passholderrenewmail',
    'APP_MAIL_PASSHOLDERVALIDDAILYMAIL' => 'app_mail_passholdervaliddailymail',
    'APP_MAIL_WELCOMEMAIL' => 'app_mail_welcomemail'
]);

define('ALLOW_MAIL_NAME', [
    'APP_MAIL_ACCOUNTINFO' => 'Account Info',
    'APP_MAIL_ADHOCMAIL' => 'Adhoc Mail',
    'APP_MAIL_BIANNUALMAIL' => 'Bi Annual Mail',
    'APP_MAIL_COMPANIESLISTNOTVALIDATE' => 'Companies List Not Validate',
    'APP_MAIL_COMPANYEXPIREDMAIL' => 'Company Expired Mail',
    'APP_MAIL_COMPANYEXPIRESOONMAIL' => 'Company Expire Soon Mail',
    'APP_MAIL_COMPANYNEEDVALIDATEMAIL' => 'Company Need Validate Mail',
    'APP_MAIL_COMPANYNOTIFYNEWACCOUNT' => 'Company Notify New Account',
    'APP_MAIL_CREATEPASSHOLDERSUCCESSMAIL' => 'Create Pass Holder Success Mail',
    'APP_MAIL_PASSHOLDEREXPIREDMAIL' => 'Pass Holder Expired Mail',
    'APP_MAIL_PASSHOLDEREXPIRESOONMAIL' => 'Pass Holder Expire Soon Mail',
    'APP_MAIL_PASSHOLDERLISTISPENDINGRETURNMAIL' => 'Pass Holder List Is Pending Return Mail',
    'APP_MAIL_PASSHOLDERNEEDCONFIRMRETURNMAIL' => 'Pass Holder Need Confirm Return Mail',
    'APP_MAIL_PASSHOLDERRENEWMAIL' => 'Pass Holder Renew Mail',
    'APP_MAIL_PASSHOLDERVALIDDAILYMAIL' => 'Pass Holder Valid Daily Mail',
    'APP_MAIL_WELCOMEMAIL' => 'Welcome Mail'
]);


//after update action here, must update action in function.php in getLogActions()
//action must folow form revision_action_actionname
define('REVISION_UPDATED', 'revision_action_updated');
define('REVISION_DELETED', 'revision_action_deleted');
define('REVISION_CREATED', 'revision_action_created');

define('REVISION_RETENTATION_RATE', 'revision_retentation_rate');
define('ADHOC_EMAIL_RETENTATION_RATE', 'adhoc_email_retentation_rate');

//Frequency Email
define('FREQUENCY_EXPIRING_PASS_EMAIL', 'Frequency expiring pass email nofitication'); //pass_holder:checking
define('FREQUENCY_BLACKLISTED_PASS_EMAIL', 'Frequency blacklisted pass email nofitication'); //when blackisted pass
define('FREQUENCY_RENEWED_PASS_EMAIL', 'Frequency renewed pass email nofitication'); //when renewed pass
define('FREQUENCY_TERMINATED_PASS_EMAIL', 'Frequency terminated pass email nofitication'); //when  PASS_STATUS_WAITING_CONFIRM_RETURN pass


//notificaitons type
define('NOTIFICATION_SYSTEM', 0);

//notification name
define('CHANGE_PASSWORD_NOTIFICATION', 'change password');

//adhoc-email status
define('ACTIVE_ADHOC_EMAIL', 0);
define('ARCHIVE_ADHOC_EMAIL', 1);

//activity log status
define('ACTIVE_ACTIVITY_LOG', 0);
define('ARCHIVE_ACTIVITY_LOG', 1);
