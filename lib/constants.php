<?php
//----------cag user---------//
define('CAG_ADMIN_ROLE', 'cag admin');
define('CAG_STAFF', 'cag staff');
define('CAG_VIEWER', 'cag viewer');

define('CAG_ADMIN_ROLE_ID', '1');
define('CAG_STAFF_ID', '2');
define('CAG_VIEWER_ID', '3');
//----------end cag user---------//

//----------company user--------//
define('TENANT_CO_ROLE', 'tenant coordinator');
define('TENANT_AS_ROLE', 'tenant as');
define('TENANT_VIEWER_ROLE', 'tenant viewer');

define('SUB_CONSTRUCTOR_CO_ROLE', 'sub constructor coordinator');
define('SUB_CONSTRUCTOR_AS_ROLE', 'sub constructor as');
define('SUB_CONSTRUCTOR_VIEWER_ROLE', 'sub constructor viewer');


define('TENANT_CO_ROLE_ID', '4');
define('TENANT_AS_ROLE_ID', '5');
define('TENANT_VIEWER_ROLE_ID', '6');

define('SUB_CONSTRUCTOR_CO_ROLE_ID', '7');
define('SUB_CONSTRUCTOR_AS_ROLE_ID', '8');
define('SUB_CONSTRUCTOR_VIEWER_ROLE_ID', '9');

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

define('DEFAULT_PASSWORD', '123456');

define('COMPANY_STATUS_WORKING', 0);
define('COMPANY_STATUS_WORKING_BUT_NEED_VALIDATE', 1);
define('COMPANY_STATUS_EXPIRED', 2);

define('PASS_STATUS_VALID', 0);
define('PASS_STATUS_BLACKLISTED', 1);
define('PASS_STATUS_TERMINATED', 2);
define('PASS_STATUS_RETURNED', 3);

define('SMTP_HOST', 'smtp_host');
define('SMTP_PORT', 'smtp_port');
define('SMTP_USERNAME', 'smtp_username');
define('SMTP_PASSWORD', 'smtp_password');
define('SMTP_ENCRYPTION', 'smtp_encryption');

//after update action here, must update action in function.php in getLogActions()
//action must folow form revision_action_actionname
define('REVISION_UPDATED', 'revision_action_updated');
define('REVISION_DELETED', 'revision_action_deleted');
define('REVISION_CREATED', 'revision_action_created');

define('REVISION_RETENTATION_RATE', 'revision_retentation_rate');