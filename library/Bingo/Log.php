<?php
/**
 * Log
 * Ŀǰֻ֧��file����������֧��db,netcomlog�ȵ�
 * @author xuliqiang <xuliqiang@baidu.com>
 * @since 2010-04-26
 * @package Bingo
 *
 */
class Bingo_Log
{
	/**
	 * none
	 * @var int
	 */
	const LOG_NONE  	= 0x00;
	/**
	 * Fatal
	 * @var int
	 */
	const LOG_FATAL 	= 0x01;
	/**
	 * Warning 
	 * @var int
	 */
	const LOG_WARNING	= 0x02;
	/**
	 * notice
	 * @var int
	 */
	const LOG_NOTICE	= 0x04;
	/**
	 * trace
	 * @var int
	 */
	const LOG_TRACE		= 0x08;
	/**
	 * debug
	 * @var int
	 */
	const LOG_DEBUG		= 0x10;
	/**
	 * all
	 * @var int
	 */
	const LOG_ALL		= 0xFF;
	/**
	 * level to text
	 * @var array
	 */
	public static $arrLogNames = array(
		self::LOG_FATAL 	=> 'FATAL',
		self::LOG_WARNING	=> 'WARNING',
		self::LOG_NOTICE	=> 'NOTICE',
		self::LOG_TRACE		=> 'TRACE',
		self::LOG_DEBUG		=> 'DEBUG',
	);
	/**
	 * module => obj log
	 * @var array
	 */
	protected static $_arrLogs = array();
	
	protected static $_strDefaultModule = '';
	
	protected static $_intLogId = 0;
	
	protected static $_arrNoticeNodes = array();
	/**
	 * ��ʼ��
	 * @param array $arrConfig
	 * {
	 * 		module => array(
	 * 			'file' => '',
	 * 			'level' => 0xFF,
 	 * 		)
	 * }
	 * @param string $strDefaultModule
	 */
	public static function init($arrConfig=array(), $strDefaultModule='')
	{
		if (! empty($arrConfig)) {
			require_once 'Bingo/Log/File.php';
			foreach ($arrConfig as $_strModule => $_arrConf) {
				if (isset($_arrConf['file'])) {
					$_intLevel = 0xFF;
					if (isset($_arrConf['level'])) $_intLevel = intval($_arrConf['level']);
					//self::addModule($_strModule, new Bingo_Log_File($_arrConf['file'], $_intLevel));
					self::$_arrLogs[$_strModule] = new Bingo_Log_File($_arrConf['file'], $_intLevel);
				}
			}
		}
		self::$_strDefaultModule = $strDefaultModule;
	}
	
	public static function pushNotice($strKey, $strValue)
	{
	    self::$_arrNoticeNodes[strval($strKey)] = strval($strValue);
	}
	
	public static function buildNotice($strOtherLog='', $strModule='', $strFile='', $intLine=0, $intTraceLevel=0)
	{
	    $strLog = '';
	    if (! empty(self::$_arrNoticeNodes)) {
	        foreach (self::$_arrNoticeNodes as $strKey=>$strValue) {
	            $strLog .= $strKey . '[' . $strValue . '] ';
	        }
	    }
	    $strLog .= $strOtherLog;
		return self::_log(self::LOG_NOTICE, $strLog, $strModule, $strFile, $intLine, $intTraceLevel);
	}
    
    public static function getNoticeNods()
    {
        return self::$_arrNoticeNodes;
    }
    public static function getNoticeNodes()
    {
        return self::$_arrNoticeNodes;
    }
	
	public static function getLogId()
	{
	    if (empty(self::$_intLogId)) {
			if (defined('REQUEST_ID')) {
				self::$_intLogId = REQUEST_ID;
			} else {
			    $requestTime = gettimeofday();
				self::$_intLogId = intval($requestTime['sec'] * 100000 + $requestTime['usec'] / 10) & 0x7FFFFFFF;
			}
		}
		return self::$_intLogId;
	}
	
	public static function addModule($strModule, $objLog) 
	{
		self::$_arrLogs[$strModule] = $objLog;
	}
	
	public static function getModule($strModule='') 
	{
	    if ($strModule === false) {
	        //˵����ȫ�ǹر�log�ģ������������Ŀ���ʹ�á�
	        return false;
	    } 
		if (empty($strModule)) $strModule = self::$_strDefaultModule;
		if (isset(self::$_arrLogs[$strModule])) {
			return self::$_arrLogs[$strModule];
		}
		return false;
	}
	
	public static function fatal($strLog, $strModule='', $strFile='', $intLine=0, $intTraceLevel=0)
	{
		return self::_log(self::LOG_FATAL, $strLog, $strModule, $strFile, $intLine, $intTraceLevel);
	}
	
	public static function warning($strLog, $strModule='', $strFile='', $intLine=0, $intTraceLevel=0)
	{
		return self::_log(self::LOG_WARNING, $strLog, $strModule, $strFile, $intLine, $intTraceLevel);
	}
	
	public static function notice($strLog, $strModule='', $strFile='', $intLine=0, $intTraceLevel=0)
	{
		return self::_log(self::LOG_NOTICE, $strLog, $strModule, $strFile, $intLine, $intTraceLevel);
	}
	
	public static function trace($strLog, $strModule='', $strFile='', $intLine=0, $intTraceLevel=0)
	{
		return self::_log(self::LOG_TRACE, $strLog, $strModule, $strFile, $intLine, $intTraceLevel);
	}
	
	public static function debug($strLog, $strModule='', $strFile='', $intLine=0, $intTraceLevel=0)
	{
		return self::_log(self::LOG_DEBUG, $strLog, $strModule, $strFile, $intLine, $intTraceLevel);
	}
	
	protected static function _log($intLogLevel, $strLog, $strModule, $strFile='', $intLine=0, $intTraceLevel=0)
	{
		$objLog = self::getModule($strModule);
		if ($objLog) {
			//����Ƿ���Ҫ��¼
			if ($objLog->check($intLogLevel)) {
				if (empty($strFile)) {				
					$arrRet = self::_getFileAndLine($intTraceLevel);
					if (isset($arrRet['file'])) $strFile = $arrRet['file'];
					if (isset($arrRet['line'])) $intLine = $arrRet['line'];
				}
				$intLogId = self::getLogId();
				return $objLog->log($intLogLevel, $strLog, $strFile, $intLine, $intLogId);
			}
		}
		return false;
	}
	
	protected static function _getFileAndLine($intLevel=0)
	{
		$arrTrace = debug_backtrace();
		$intDepth = 2 + $intLevel;
        $intTraceDepth = count($arrTrace);
        if ($intDepth > $intTraceDepth)
            $intDepth = $intTraceDepth;
        $arrRet = $arrTrace[$intDepth];
        if (isset($arrRet['file'])) $arrRet['file'] = basename($arrRet['file']);
        return $arrRet;
	}
	/**
	 * TODO delete
	 */
	protected static function _getLogId()
	{
		if (empty(self::$_intLogId)) {
			if (defined('REQUEST_ID')) {
				self::$_intLogId = REQUEST_ID;
			} else {
			    $requestTime = gettimeofday();
				self::$_intLogId = intval($requestTime['sec'] * 100000 + $requestTime['usec'] / 10) & 0x7FFFFFFF;
			}
		}
		return self::$_intLogId;
	}
}
