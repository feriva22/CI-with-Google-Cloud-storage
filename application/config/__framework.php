<?php defined('BASEPATH') OR exit('No direct script access allowed');


$config['site_info'] = 'Sistem Backend';
$config['site_year'] = '2020';
$config['creator_website'] = 'http://globalsolusiinformatika.com';

/*
config for auth library
*/
$config['auth_root_username']       = 'root';
$config['auth_root_password']       = 'root';
$config['auth_dashboard_page']      = 'dashboard';
$config['auth_staff_db']            = 'staff';
$config['auth_staffgroup_db']       = 'staffgroup';
$config['auth_staffgroupacc_db']    = 'staffgroupaccess';
$config['auth_staffgroupacc_prefix']= 'sga_';
$config['auth_staff_prefix']        = 'stf_';
$config['auth_user_pk']             = 'id';
$config['auth_moduleaccess_db']     = 'moduleaccess';
$config['auth_moduleaccess_prefix'] = 'mda_';
$config['auth_module_db']           = 'module';
$config['auth_module_prefix']       = 'mdl_';

//permission status
define('UNGRANTED',0);
define('GRANTED',1);

//user status
define('ADMIN',1);

//general  status account
define('IS_ROOT',0);

define('ACTIVE',1);
define('NOT_ACTIVE',2);
define('SUSPEND',2);


define('DELETED',0);
define('PUBLISH',1);
define('DRAFT',2);


//define login method
define('USERNAME_PASSWORD',0);


//setingan bulan
$config['bulan'] = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');



//SETTINGAN GOOGLE CLOUD STORAGE
define('BUCKET_URL','gs://bucket_coba'); //use GS protocol
define('BUCKET_NAME','bucket_coba'); //if not use stream wrapper
define('GCS_KEY',APPPATH.'resources/admin/long-adviser-271306-cabe2c3f0508.json');


define('GCS_PETRO_KEY',APPPATH.'resources/devhrdocs-8ac4240448c0.json');
define('BUCKET_PETRO_NAME','devhrdocs');


?>