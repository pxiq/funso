<?php
require_once 'FrameWork.php';
session_start();
class Config {
	/**
	 * 数据库编码
	 *
	 * @var string
	 */
	public static $DataBaseCharset = 'utf8';
	
	/**
	 * 数据库配置信息
	 *
	 * @var array
	 */
	public static $DataBases = array (
	    //0
	    array (
	    	'DatabaseType' => 'MySql', 
	    	'DatabaseHost' => '127.0.0.1', 
	    	'DatabasePort' => '3306', 
	    	'DatabaseUsername' => 'root', 
	    	'DatabasePassword' => '123', 
	    	'DatabaseName' => 'mon_info', 
	    	'Charset' => 'utf8' )
	    //2
	    );	
	    
	    
	/**
	 * 临时目录
	 *
	 * @var string
	 */
	public static $TempPath = '/tmp';
	
	
	public static $ReverseUrl = 'http://172.16.35.51/x';
	
	/**
	 * 应用class目录
	 *
	 * @var string
	 */
	public static $ClassPath = '/www/monitor/pub/include';
	
	/**
	 * 框架目录
	 *
	 * @var string
	 */
	
	public static $LibPath = 'D:/nginx';
	
	public static $TemplatePath = 'E:\www\monitor\pub\templates';
	
	const SMS_DEBUG_LOG_PATH = '/monitor/tmp';
	const SMS_ERROR_LOG_PATH = '/monitor/tmp';
	const SMS_DATA_LOG_PATH = '/monitor/tmp';	
	//标识是否调试
	const DEBUG_MODE = true;		
	const WARNING_URL = 'http://localhost/test.php';	
	/**
	 * 获取系统目录
	 *
	 * @param string $pName
	 * @return string
	 */	
	public static function getSystemPath($pName) {
		if ($pName == 'temp') {
			return self::$TempPath;
		} else if ($pName == 'webroot') {
			return realpath ( self::$ClassPath . '/..' );
		} else if ($pName == 'class') {
			return self::$ClassPath;
		} else if ($pName == 'template') {
			return realpath ( self::$ClassPath . '/..' ) . '/templates';
		} else if ($pName == 'upload') {
			return realpath ( self::$ClassPath . '/..' ) . '/uploads';
		} else if ($pName == 'release') {
			return realpath ( self::$ClassPath . '/..' ) . '/release';
		} else if ($pName == 'gzfile') {
			return realpath ( self::$ClassPath . '/..' ) . '/gzfile';
		} else if ($pName == 'mmsdata') {
			return realpath ( self::$ClassPath . '/..' ) . '/mmsdata';
		} else {
			return self::$LibPath;
		}
		
		
	}
	
	/**
	 * 获取运行模式
	 *
	 * @return string
	 */
	public static function getMode() {
		if (isset ( $_COOKIE ['app_debug'] ) && 1 == $_COOKIE ['app_debug']) {
			return "debug";
		} else {
			return "online";
		}
	}
	
	/**
	 * 是否缓存
	 *
	 * @return bool
	 */
	public static function isCached() {
		return false;
	}
}
?>
