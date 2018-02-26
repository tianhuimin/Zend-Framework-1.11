<?php
/**
 * Bingo_View_Script
 * @author xuliqiang <xuliqiang@baidu.com>
 * @package bingo
 * @since 2010-04-12
 *
 */
require_once 'Bingo/View/Exception.php';
class Bingo_View_Script
{
	protected $_strBaseDir = '.';
	/**
	 * 
	 * @var array
	 */
	protected $_arrPaths = array(
		'config' => array(),//key=>object
		'helper' => array(),//key=>value
		'template' => array(),//value
		'layout' => array(),//value
		'element' => array(),//value
	);
	/**
	 * UI���ݸ�FE�������ֵ�
	 * @var array
	 */
	protected $_arrVars = array();
	/**
	 * UI���ݸ�FE�Ĵ����
	 * @var int
	 */
	protected $_intErrno = 0;
	/**
	 * ��ǰ����
	 * @var string
	 */
	protected $_strLayout = '';
	/**
	 * Layout�����û��洢Layout��Ҫ�õ����������
	 * @var Object Bingo_View_Layout
	 */
	protected $_objLayout = null;
	/**
	 * ���飬���ڴ洢�Ѿ�ʵ������helper���󡣻���$nameΪkey�ġ�
	 * @var array
	 */
	protected $_arrHelperStore = array();
	
	protected $_strHelperName = 'helper';
	
	protected $_objHelper = null;
	
	protected $_objCache = null;
	
	protected $_arrOutputConfig = array();
	
	/**
	 * ��������
	 * null ������Ӵ�����Ϣ���Ƽ������ϳ���ʹ�á�
	 * 'echo' : ֱ����ҳ��echo��������Ϣ�������и�ʽ��
	 * '__VIEW_LOG__': ��ֱ��log���������־��
	 * Ŀǰ��֧����չ��
	 * @var object
	 */
	protected $_objErrorHandler = null;
	/**
	 * �Ƿ�ֹͣ������Ⱦ����Ҫ��__init.php����ʹ��
	 * @var bool
	 */
	protected $_bolStopRender   = false;
	
	private static $_instance = null;
	/**
	 * ��������ȡ������
	 */
	public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    protected function __construct()
    {    	
    	//��ֹ���ⲿnew
    	$this->_objHelper = new Bingo_View_Script_Helper();
    }
    public function setContentType($strType, $strCharset='GBK'/*UTF8DIFF*/)
    {
        $this->_arrOutputConfig['type'] = $strType;
        $this->_arrOutputConfig['charset'] = $strCharset;
    }
    /**
     * ���Ǹ�����ƴд���󡣵��Ѿ���ʹ���ˡ�
     * @param $strType
     * @param $strCharset
     */
    public function setContextType($strType, $strCharset='GBK'/*UTF8DIFF*/)
    {
        $this->_arrOutputConfig['type'] = $strType;
        $this->_arrOutputConfig['charset'] = $strCharset;
    }
    /**
     * ���ø�Ŀ¼
     * @param string $strBaseDir
     */
    public function setBaseDir($strBaseDir)
    {
    	if (is_dir($strBaseDir)) {
    		$this->_strBaseDir = rtrim($strBaseDir, DIRECTORY_SEPARATOR);
    	}
    }
    /**
     * ���ô�����Ϣ
     * @param int $intErrno
     */
    public function setErrno($intErrno)
    {
    	$this->_intErrno = $intErrno;
    }
    /**
     * ��ȡ������Ϣ
     */
    public function getErrno()
    {
    	return $this->_intErrno;
    }
    /**
     * ת��view�㴦��ע����Ҫ���ݵ��Ǿ���·��
     * @param string $strViewFile
     * @param string $strInitFile
     */
    public function render($strViewFile, $strInitFile='')
    {
    	${$this->_strHelperName} = $this->_objHelper;
    	if (! empty($strInitFile) && is_file($strInitFile)) {
    		include_once $strInitFile;
    	}
    	if (! $this->_bolStopRender && ! empty($strViewFile) && is_file($strViewFile)) {
    		include $strViewFile;
    	}    	
    	return true;
    }
    /**
     * ֹͣ�Ժ���View����Ⱦ
     */
    public function stopRender()
    {
        $this->_bolStopRender = true;
    }
    /**
     * ����DEBUGģʽ������DEBUGģʽĬ������»�Ѵ�����־echo������
     * ����ͨ�����õڶ����������Ѵ�����Ϣ��ӡ����־��Ĭ����־�����������
     * 'file' => '/../log/view.log',
     * 'level' => 0xFF,
     * @param $bolDebug
     */
    public function setDebug($bolDebug=true, $strType='echo')
    {
    	if (! $bolDebug) {
    		$this->_objErrorHandler = null;
    	} else {
    		if ($strType == 'log') {
    			$strType = array(
    				'file' => '/../log/view.log',
    				'level' => 0xFF,
    			);
    		}
    		$this->setErrorHandler($strType);
    	}
    }
    /**
     * ���ô�����ʽ��$mixValue Ϊ�ַ�������ֱ�����롣
     * ��������飬��log���������ṹ
     * {
     * 		file : log�ļ���·����ע���·�������strBaseDir�ġ�
     * 		level : ���û����д�����ӦΪ0xFF
     * }
     * @param $mixValue
     */	
	public function setErrorHandler($mixValue)
	{
		if (is_string($mixValue)) {
			$this->_objErrorHandler = 'string';
		} elseif (is_array($mixValue) && isset($mixValue['file']) ) {
			$strFile = $this->_strBaseDir . $mixValue['file'];
			require_once 'Bingo/Log.php';
			require_once 'Bingo/Log/File.php';
			$intLevel = 0xFF;
			if (isset($mixValue['level'])) $intLevel = intval($mixValue['level']);
			Bingo_Log::addModule('__VIEW_LOG__', new Bingo_Log_File($strFile, $intLevel));
			$this->_objErrorHandler = '__VIEW_LOG__';
		}
		return true;
	}
	
	public function errorHandler($intErrno, $strErrmsg, $strFile, $intLine)
	{
		if (is_null($this->_objErrorHandler)) {
		    //Ĭ���ǲ������κδ�����Ϣ���޸ĳ�Ĭ�ϴ�ӡwarning��־
		    if ($intErrno == E_USER_ERROR || $intErrno == E_USER_WARNING) {
		        $strLog = sprintf('Bingo_View error[%d]![%s]', $intErrno, $strErrmsg);
		        require_once 'Bingo/Log.php';
		        Bingo_Log::warning($strLog, '', $strFile, $intLine);
		    }
			return ;
		}
		if ($this->_objErrorHandler == 'string') {
			//ֱ�������ҳ����
			$this->_errorHandlerEcho($intErrno, $strErrmsg, $strFile, $intLine);
			return;
		}
		if ($this->_objErrorHandler == '__VIEW_LOG__') {
			//��־���
			$this->_errorHandlerLog($intErrno, $strErrmsg, $strFile, $intLine);
			return ;
		}
	}
    /**
     * ���·��������template
     * @param string $strPath
     * @param string $strType
     */
    public function addPath($strPath, $strType='template')
    {
    	$strPath = $this->_strBaseDir . $strPath;
    	if (! file_exists($strPath)) {
    		trigger_error('Bingo_View_Script::addHelperPath path invalid!' . $strPath, E_USER_WARNING);	
    		return $this;	
    	}
    	$this->_arrPaths[$strType][] = rtrim($strPath, DIRECTORY_SEPARATOR);
    	return $this;
    }
    /**
     * ���õ�ǰ���õ�Layout
     * @param string $strName
     */
    public function setLayout($strName)
    {
    	$this->_strLayout = $this->_getPath($strName, 'layout');
    	if ($this->_strLayout === false) return $this;
    	//var_dump($this->_strLayout);
    	require_once 'Bingo/View/Layout.php';
    	$this->_objLayout = new Bingo_View_Layout();
    	return $this;
    }
    /**
     * ��ȡ��ǰ��Layout����
     */
    public function layout()
    {
    	return $this->_objLayout;
    }
	public function assign($mixKey, $mixValue = null)
    {
        if (is_array($mixKey)) {
            foreach ($mixKey as $_key => $_val) {
            	$this->_arrVars[$_key] = $_val;
            }
        } elseif (is_string($mixKey)) {
            $this->_arrVars[$mixKey] = $mixValue;
        } else {
            //notice
            trigger_error('Bingo_View_Script::assign : Type is invalid!', E_USER_WARNING);
        }
        return true;
    }
    public function clean()
    {
    	$this->_arrVars = array();
    }
    /**
     * ����ģ��ҳ����Ⱦ
     * @param string $strTemplate
     * @return true/false/intLength
     */
    public function display($strTemplate, $___bolGetLength=false)
    {
        $this->_outputType();
    	if (empty($this->_strLayout)) {
    	    if ($___bolGetLength) ob_start();
    		$this->_displayTemplate($strTemplate);
    		if ($___bolGetLength) {
    		    $intLength = ob_get_length();
    		    ob_end_flush();
    		    return $intLength;
    		}
    		return true;
    	} else {	
    	    //û��layout	
    		ob_start();
    		$this->_displayTemplate($strTemplate);
    		$_________c = ob_get_clean();
    		//var_dump($_________c);
    		$______ = $this->_objLayout->get();
    		if (is_array($______) && ! empty($______) )extract($______, EXTR_OVERWRITE);
    		$content = $_________c;
    		${$this->_strHelperName} = $this->_objHelper;
    		unset($______);
    		unset($_________c);
    		if ($___bolGetLength) ob_start();
    		include $this->_strLayout;
    		if ($___bolGetLength) {
    		    $intLength = ob_get_length();
    		    ob_end_flush();
    		    return $intLength;
    		}
    		return true;
    	}
    }
    /**
     * ��Ⱦһ��Сģ�壬����ģ�����ݷ���
     * @param string $strTemplate
     */
    public function template($strTemplate)
    {
    	ob_start();
    	$this->_displayTemplate($strTemplate);
    	return ob_get_clean();
    }
    /**
     * elemenet����Ҫ��ģ��ĸ��ã�С����ĳ�ȡ
     * @param string $strName
     * @param array $_____arrVars
     * @param bool $bolG �Ƿ�����ȫ�����ݿɼ�
     */
    public function element($strName, $_____arrVars = array(), $bolG = false)
    {
    	$______ = $this->_getPath($strName, 'element');
    	if ($______ === false) return false;
    	unset($strName);
    	if ($bolG && ! empty($this->_arrVars)) {
    		//��ȡȫ������
    		extract($this->_arrVars, EXTR_OVERWRITE);;
    	}
    	if ( (is_array($_____arrVars)) && ! empty($_____arrVars)) extract($_____arrVars, EXTR_OVERWRITE);
    	unset($_____arrVars);
    	${$this->_strHelperName} = $this->_objHelper;
    	include $______;
    }
    public function elementG($strName, $_____arrVars = array())
    {
    	$this->element($strName, $_____arrVars, true);
    }
    /**
     * ��ȡelement�ķ������ݡ���elment������ͬ���ǣ��÷��������������ֱ�ӷ���html�ַ�����
     * @param string $strName
     * @param array $_____arrVars
     */
    public function getElement($strName, $_____arrVars = array())
    {
    	ob_start();
    	$this->element($strName, $_____arrVars);
    	return ob_get_clean();
    }
    /**
     * ���helper��·������Ҫ�ƶ�helper��ǰ׺��
     * @param string $strPrefix
     * @param string $strPath
     */
    public function addHelperPath($strPrefix, $strPath)
    {
    	$strPath = $this->_strBaseDir . $strPath;
    	$strPath = rtrim($strPath, DIRECTORY_SEPARATOR);
        if (! file_exists($strPath)) {
    		trigger_error('Bingo_View_Script::addHelperPath path invalid!' . $strPath, E_USER_WARNING);	
    		return $this;
    	}
    	$this->_arrPaths['helper'][$strPrefix] = $strPath;
    	return $this;
    }
    /**
     * ��ȡȫ������
     * @param string $strKey
     * @param string $mixDefaultValue
     */
    public function g($strKey='', $mixDefaultValue=null)
    {
    	if (empty($strKey)) {
    		return $this->_arrVars;
    	}
    	if (isset($this->_arrVars[$strKey])) {
    		return $this->_arrVars[$strKey];
    	}
    	return $mixDefaultValue;
    }
    /**
     * 
     * @param array $arrConfig
     * {
     * 		dir : string cache ��Ŀ¼
     * 		lifeTime �� int ��Чʱ������ȷ����
     * }
     * @param $strType : file source eacc apc static
     */
    public function setCache($arrConfig=array(), $strType='source')
    {
    	if (isset($arrConfig['dir'])) {
    		$arrConfig['dir'] = $this->_strBaseDir . $arrConfig['dir'];
    	} else {
    	    //mkdir
    	    if ($this->_strBaseDir{strlen($this->_strBaseDir)-1} == ".") {
    	        //����Ŀ¼���������������ǳ�trick
    	        $arrConfig['dir'] = $this->_strBaseDir . DIRECTORY_SEPARATOR . 'data';
    	    } else {
    		    $arrConfig['dir'] = $this->_strBaseDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data';
    	    }
    	    @mkdir($arrConfig['dir'], 0x755, true);
    	}
    	if (! is_dir($arrConfig['dir'])) {
    		trigger_error('setCache dir is invalid!dir=' . $arrConfig['dir'], E_USER_WARNING);   
    		return false;	
    	}
    	require_once 'Bingo/Cache.php';//$arrConfig['encode'] = 'md5';print_r($arrConfig);
    	$objCache = Bingo_Cache::factory($strType, $arrConfig);
    	if (! $objCache) {
    		trigger_error('factory Bingo_Cache error!type=' . $strType);
    		return false;
    	}
    	$this->_objCache = $objCache;
    	return true;
    }
    /**
     * ��������ļ���Ӧ��ϵ
     * @param $strTypeKey���ؼ��֣����ڼ�Ƹ������ļ�
     * @param $arrConfig����ο�Bingo_Config��
     * @param $strType ��ini array configure
     */
    public function addConfig($strTypeKey, $arrConfig=array(), $strType='ini')
    {
    	if (isset($arrConfig['fileName']) && $strType != 'configure') {
    		$arrConfig['fileName'] = $this->_strBaseDir . $arrConfig['fileName'];
    		if (! is_file($arrConfig['fileName'])) {
    			trigger_error('addConfig error!fileName is invalid!fileName='.$arrConfig['fileName'],
    			    E_USER_WARNING);
    			return false;
    		}
    	}
    	//configure��ʱ�򣬻����dirĿ¼
    	if ( $strType == 'configure' ) {
    		if (isset($arrConfig['dir'])) {
    	        $arrConfig['dir'] = $this->_strBaseDir . $arrConfig['dir'];
    		    $arrConfig['confFileName'] = $arrConfig['fileName'];
    		} else {
    		    //û��Ŀ¼��Ϣ��ֱ�Ӵ�fileName��ȡ
    		    $arrConfig['dir'] = $this->_strBaseDir . dirname($arrConfig['fileName']);
    		    $arrConfig['confFileName'] = basename($arrConfig['fileName']);
    		}
    		if (! is_dir($arrConfig['dir'])) {
    			trigger_error('addConfig dir is invalid!dir=' . $arrConfig['dir'], E_USER_WARNING);
    			return false;   		
    		}
    	}     	
    	//Ĭ�Ͽ����Զ�����
    	if (! array_key_exists('autoRefresh', $arrConfig)) {
    		$arrConfig['autoRefresh'] = true;
    	}
    	//�������Cache��������
    	if (! array_key_exists('cache', $arrConfig)) {
    	    $this->setCache();
    		if (! is_null($this->_objCache)) {
    			$arrConfig['cache'] = $this->_objCache;
    		}
    	}
    	//���Ż��ռ䣬���Ե�ʹ�õ�ʱ���ټ��ء�
    	require_once 'Bingo/Config.php';
    	$objConfig = Bingo_Config::factory($strType, $arrConfig);
    	if ($objConfig) {
    		$this->_arrPaths['config'][$strTypeKey] = $objConfig;
    		return true;
    	}
    	trigger_error('addConfig error!strKey=' . $strTypeKey, E_USER_WARNING);
    }
    /**
     * ��ȡ����
     * @param string $strConfKey
     * @param mix $mixDefaultValue
     * @param string $strTypeKey
     */
    public function conf($strConfKey, $strTypeKey='', $mixDefaultValue='')
    {
    	if (! empty($strTypeKey) && isset($this->_arrPaths['config'][$strTypeKey])) {
		$_mixTmp = $this->_arrPaths['config'][$strTypeKey]->get($strConfKey, NULL);
		if (! is_null($_mixTmp)) return $_mixTmp;
    	} else {
    		//��������������ģ����Ƽ�ʹ��
    		if (! empty($this->_arrPaths['config'])) {
    			foreach ($this->_arrPaths['config'] as $_strKey => $_objConfig) {
    				$_mixTmp = $_objConfig->get($strConfKey, NULL);
    				if (! is_null($_mixTmp)) return $_mixTmp;
    			}
    		}
    	}
    	return $mixDefaultValue;
    }
    /**
     * �û�����helper�����ĵ���
     * @param string $strName
     * @param array $arrArguments
     */
    public function __call($strName, $arrArguments)
    {
    	$helper = $this->getHelper($strName);
    	if (method_exists($helper, $strName)) {
        	return call_user_func_array(array($helper, $strName), $arrArguments);
    	} 
    	return $helper;
    }
    /**
     * ͨ��$this->helper_name�ķ�ʽ��ȡ��һ��Helper����
     * @param string $strName
     */
    public function __get($strName)
    {
    	$helper = $this->getHelper($strName);
    	return $helper;
    }
    
    public function getHelper($strName)
    {
    	$objHelper = null;
    	if (! isset($this->_arrHelperStore[$strName])) {
    		$objHelper = $this->_geneHelper($strName);
    		if ($objHelper) {
    		    $this->_arrHelperStore[$strName] = $objHelper;
    		}
    	} else {
    		$objHelper = $this->_arrHelperStore[$strName];
    	}
    	return $objHelper;
    }
    
    public function getObjHelper()
    {
    	return $this->_objHelper;
    }
    
    protected function _geneHelper($strName)
    {
    	if (! empty($this->_arrPaths['helper'])) {
    		$strName = ucfirst($strName);
    		foreach ($this->_arrPaths['helper'] as $_strPrefix => $_strPath) {
    			$_strFilePath = $_strPath . DIRECTORY_SEPARATOR . $strName . '.php';
    			//����ļ��Ƿ����
    			if (is_file($_strFilePath)) {
    				$_strHelperName = $_strPrefix . '_' . $strName;
    				include_once $_strFilePath;
    				//����Ƿ����helper��
    				if (class_exists($_strHelperName)) {
    					$_objHelper = new $_strHelperName();
    					if (method_exists($_objHelper, 'setView')) {
    						$_objHelper->setView($this);
    					}
    					return $_objHelper;
    				}
    			}
    		}
    	}
    	trigger_error('Bingo_View_Script::_geneHelper error!' . $strName . ' invalid!', E_USER_WARNING);
    	return false;
    }
    
    protected function _getPath($strFile, $strType='template')
    {
    	$strTemplatePath = '';
    	if (! empty($this->_arrPaths[$strType])) {
    		foreach ($this->_arrPaths[$strType] as $_strRootPath) {
    			$strTemplatePath = $_strRootPath . DIRECTORY_SEPARATOR . $strFile;
    			if (is_file($strTemplatePath)) return $strTemplatePath;
    		} 
    	}
    	//��Ĭ�ϵġ�
    	$strTemplatePath = $this->_strBaseDir . DIRECTORY_SEPARATOR . $strType . DIRECTORY_SEPARATOR . $strFile;
    	if (is_file($strTemplatePath)) return $strTemplatePath;
    	trigger_error('Bingo_View_Script::_getPath failure!' . $strFile . ' invalid!type='.$strType, E_USER_WARNING);
    	return false;
    }
    
    protected function _displayTemplate($strTemplate)
    {
    	$________ = $this->_getPath($strTemplate);
    	if ($________ === false) return false;
    	if ( ! empty($this->_arrVars)) extract($this->_arrVars, EXTR_OVERWRITE);
    	${$this->_strHelperName} = $this->_objHelper;
    	unset($strTemplate);
    	include $________;
    	return true;
    }
    
    protected function _errorHandlerEcho($intErrno, $strErrmsg, $strFile, $intLine)
    {
    	//ֻ���warning��Ϣ
    	if ($intErrno == E_USER_WARNING) {
    		//echo $strFile . ':' . $intLine . ' ' . $strErrmsg . '<br />';
    		echo $strErrmsg . '<br />';
    	}
    }
    
    protected function _errorHandlerLog($intErrno, $strErrmsg, $strFile, $intLine)
    {
    	//log���
    	switch ($intErrno)
    	{
    		case E_USER_ERROR:
    			Bingo_Log::fatal($strErrmsg, $this->_objErrorHandler, $strFile, $intLine);
    			return ;
    		case E_USER_WARNING:
    			Bingo_Log::warning($strErrmsg, $this->_objErrorHandler, $strFile, $intLine);
    			return ;
    		case E_USER_NOTICE:
    			Bingo_Log::notice($strErrmsg, $this->_objErrorHandler, $strFile, $intLine);
    			return ;
    		default:
    			Bingo_Log::debug($strErrmsg, $this->_objErrorHandler, $strFile, $intLine);
    			return ;
    	}
    }
    
    protected function _outputType()
    {
        $strType = 'html';
        $strCharset = 'GBK'/*UTF8DIFF*/;
        if (isset($this->_arrOutputConfig['type'])) $strType = $this->_arrOutputConfig['type'];
        if (isset($this->_arrOutputConfig['charset'])) $strCharset = $this->_arrOutputConfig['charset'];
        ContentType($strType, $strCharset);
    }
}

class Bingo_View_Script_Helper
{
	/**
     * �û�����helper�����ĵ���
     * @param string $strName
     * @param array $arrArguments
     */
    public function __call($strName, $arrArguments)
    {
    	$helper = Bingo_View_Script::getInstance()->getHelper($strName);
    	if (method_exists($helper, $strName)) {
        	return call_user_func_array(array($helper, $strName), $arrArguments);
    	} 
    	return $helper;
    }
    /**
     * ͨ��$this->helper_name�ķ�ʽ��ȡ��һ��Helper����
     * @param string $strName
     */
    public function __get($strName)
    {
    	return Bingo_View_Script::getInstance()->getHelper($strName);
    }
}
