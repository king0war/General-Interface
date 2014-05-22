<?php
/**
 * General Interface	通用web接口
 * @author: Ibrahim
 * @qq: 80511360
 */

define('GI_KEY', '*(<.%$#');		//加密key
define('GI_PATH', dirname(__FILE__));	//根目录
define('GI_CHAR', 'UTF-8');		//程序字符集
define('GI_TIMEOUT', 200); //过期时间， 单位：秒
define('GI_PARAMS_ARRAY', 0); //参数是否用array封装
$whiteList = array('get','post','put','delete','test');		//可调用方法白名单

include_once(GI_PATH . '/gi_exec.class.php');	//引入执行类
include_once(GI_PATH . '/gi_notice.class.php');	//引入执行类
include_once(GI_PATH . '/common.func.php');	//引入公共函数库



