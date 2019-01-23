<?php 
date_default_timezone_set('PRC');
define("DEBUG",true);


define("DB_HOST",'192.168.1.17');
define("DB_USER",'root');
define("DB_PWD",'Doc88816.');
define("DB_NAME",'shopcms');
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
if(DEBUG){
    header('Content-Type: text/html; charset=utf-8');
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}

session_set_cookie_params(86400);//cookie 1天有效
session_start();
// session_save_path('e:/session/');//测试用
$root_name=str_replace("\\","/",dirname(__FILE__));
define("ROOT",$root_name);
//smarty配置
define("LEFT_DELIMITER",'<{');//left_delimiter
define("RIGHT_DELIMITER",'}>');
define("CACHING",0);//开发阶段关闭cache
define("CACHE_DIR",ROOT."/cache");
define("CACHE_TIME",60*60*24*7);
define("SITE_STATIC","/assets");


require ROOT."/classes/base.core.php";
require ROOT."/classes/dbengine.core.php";


//修正 REQUEST_URI
function getRequestUri() {
	if (isset($_SERVER['HTTP_X_REWRITE_URL'])) {
		// check this first so IIS will catch
		$requestUri = $_SERVER['HTTP_X_REWRITE_URL'];
	} elseif (isset($_SERVER['REDIRECT_URL'])) {
		// Check if using mod_rewrite
		$requestUri = $_SERVER['REDIRECT_URL'];
	} elseif (isset($_SERVER['REQUEST_URI'])) {
		$requestUri = $_SERVER['REQUEST_URI'];
	} elseif (isset($_SERVER['ORIG_PATH_INFO'])) {
		// IIS 5.0, PHP as CGI
		$requestUri = $_SERVER['ORIG_PATH_INFO'];
		if (!empty($_SERVER['QUERY_STRING'])) {
			$requestUri .= '?' . $_SERVER['QUERY_STRING'];
		}
	}
	return $requestUri;
}

$_SERVER['REQUEST_URI'] = getRequestUri();
