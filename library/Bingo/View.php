<?php
/**
 * Bingo2.0��ͼ
 * @author xuliqiang <xuliqiang@baidu.com>
 * @since 2010-04-25
 * @package bingo
 */
require_once 'Bingo/View/Script.php';
class Bingo_View
{
    /**
     * ��·��
     * @var string
     */
	protected $_strBaseDir = '.';
	/**
	 * ������ͣ�html/json/xml
	 * TODO ���ݸ����ͣ��Զ������ͬ��ͷ��Ϣ
	 * @var string
	 */
	protected $_strOutputType = 'html';
	/**
	 * view�ļ��е�·������
	 * @var string
	 */
	protected $_strScriptPathName = 'control';
	/**
	 * View�ļ���·��������������ͽ���һһ��Ӧ��
	 * @var array
	 */
	protected $_arrScriptPaths = array();
	/**
	 * Ĭ����ͼ�����������Ҳ�����ͼ��������ʱ�򣬾Ͳ���Ĭ�ϵġ�
	 * @var string
	 */
	protected $_strDefaultView = 'index.php';
	/**
	 * ��ͼ��ʼ����Ӧ���ļ���
	 * @var string
	 */
	protected $_strInitView = '__init.php';
	/**
	 * ����ţ�UI���ݸ�FE
	 * @var int
	 */
	protected $_intErrno = 0;
	/**
	 * �Ƿ�����debugģʽ���ڿ���debugģʽ��ʱ�򣬲������ҳ����Ⱦ������ֱ�ӽ������ݵ�var_dump
	 * @var boolean
	 */
	protected $_bolDebug = false;	
	
	protected $_objScript = null;
	
	public function __construct($arrConfig=array())
	{
		if (! empty($arrConfig)){
			$this->setOptions($arrConfig);
		}
		$this->_objScript = Bingo_View_Script::getInstance();
		$this->_objScript->setBaseDir($this->_strBaseDir . DIRECTORY_SEPARATOR . $this->_strOutputType);
	}
	/**
	 * �������������Ϣ
	 * @param array $arrConfig
	 * {
	 * 		baseDir : ��Ŀ¼
	 * 		defaultView �� Ĭ��View��������Ĭ����index.php
	 * 		scriptPathName : script�ļ��д�ŵ��ļ������ơ�Ĭ����script
	 * 		outputType : ������͡�Ĭ����html
	 * 		initView : ��ʼ��View���ļ���Ĭ����__init.php
	 * 		debug : �Ƿ�����debugģʽ
	 * }
	 */
	public function setOptions($arrConfig=array())
	{
		if (isset($arrConfig['baseDir'])) {
    		$this->setBaseDir($arrConfig['baseDir']);
    	}
    	if (isset($arrConfig['defaultView'])) {
    		$this->_strDefaultView = $arrConfig['defaultView'];
    	}
    	if (isset($arrConfig['scriptPathName'])) {
    		$this->_strScriptPathName = $arrConfig['scriptPathName'];
    	}
    	if (isset($arrConfig['outputType'])) {
    		$this->_strOutputType = $arrConfig['outputType'];
    	}
    	if (isset($arrConfig['initView'])) {
    		$this->_strInitView = $arrConfig['initView'];
    	}
    	if (array_key_exists('debug', $arrConfig)) {
    		$this->_bolDebug = (boolean) $arrConfig['debug'];
    	}
	}
	/*
	 * ���ø�Ŀ¼��ע�⣬��FE��ʹ�õ�Ŀ¼��ʱ�򣬶����Զ����ϸ�Ŀ¼����Ҫʹ�þ���·����
	 */
	public function setBaseDir($strBaseDir)
	{
		if (is_dir($strBaseDir) && file_exists($strBaseDir)) {
			$this->_strBaseDir = rtrim($strBaseDir, DIRECTORY_SEPARATOR);
		} else {
			trigger_error('setBaseDir baseDir invalid!baseDir=' . $strBaseDir, E_USER_WARNING);
		}
		return false;
	}
	/**
	 * ����������ͣ�Ĭ����HTML�����ݸ�viewʹ��
	 * @param string $strOutputType
	 */
	public function setOutputType($strOutputType)
	{
		$this->_strOutputType = $strOutputType;
	}
	/**
	 * ���������Ͷ�Ӧ��Ŀ¼�ṹ
	 * @param string $strPath
	 * @param string $strOutputType
	 */
	public function setScriptPath($strPath, $strOutputType = 'html')
	{
		if (! is_dir($strPath)) {
    		trigger_error('setScriptPath path invalid!' . $strPath, E_USER_WARNING);
    	} 
    	$this->_arrScriptPaths[$strType] = rtrim($strPath, DIRECTORY_SEPARATOR);
	}
	/**
	 * ��ȡ��ǰScript�ű��ĸ�Ŀ¼
	 */
	public function getScriptPath()
    {
    	$strPath = '';
    	if (isset($this->_arrScriptPaths[$this->_strOutputType])) {
    		$strPath = $this->_arrScriptPaths[$this->_strOutputType];
    	} else {
    		$strPath = $this->_strBaseDir  .DIRECTORY_SEPARATOR . $this->_strOutputType . DIRECTORY_SEPARATOR . $this->_strScriptPathName;
    	}
    	if (! is_dir($strPath)) {
    		throw new Exception($strPath . ' invalid!');
    	}
    	return $strPath;
    }
	/**
	 * ת����ͼ�㣬������Ⱦ
	 * @param string $strViewName
	 */
	public function render($strViewName)
	{
		set_error_handler(array($this->_objScript, 'errorHandler'));
    	$bolRet = false;
    	try{
    		$bolRet = $this->_render($strViewName);
    	} catch (Exception $e) {
    		$this->_objScript->errorHandler(E_USER_WARNING, $e->getMessage(), $e->getFile(), $e->getLine());
    	}
    	restore_error_handler();
    	return $bolRet;
	}
	/***
	 * ����ģ�����Ⱦ���ʺ��ڲ�����view���ʱ�����
	 */
	public function display($strTemplateName)
	{
		set_error_handler(array($this->_objScript, 'errorHandler'));
    	$bolRet = false;
    	try{
    		require_once 'Bingo/View/Functions.php';
    		$this->_objScript->display($strTemplateName);
    	} catch (Exception $e) {
    		$this->_objScript->errorHandler(E_USER_WARNING, $e->getMessage(), $e->getFile(), $e->getLine());
    	}
    	restore_error_handler();
    	return $bolRet;
	}
	/**
	 * ģ�������ֵ
	 * @param mix(string|array) $mixKey
	 * @param mix(array|string) $mixValue
	 */
	public function assign($mixKey, $mixValue = null)
	{
		return $this->_objScript->assign($mixKey, $mixValue);
	}
	public function getScript()
	{
		return $this->_objScript;
	}
	/**
	 * ��ձ���
	 */
	public function clean()
	{
		$this->_objScript->clean();
	}
	/**
	 * ����debugģʽ
	 * @param boolean $bolDebug
	 */
	public function setDebug($bolDebug = true)
	{
		$this->_bolDebug = (bool)$bolDebug;
	}
	/**
	 * ���ݴ�����Ϣ��view
	 * @param int $intErrno
	 */
	public function error($intErrno)
	{
		$this->_intErrno = intval($intErrno);
		$this->_objScript->setErrno($intErrno);
	}
	
	protected function _debugOutput($strViewName, $strViewPath, $strInitViewPath)
    {
    	echo '<b>��������</b><br/>';
    	echo '��Ŀ¼��baseDir�� : ' . $this->_strBaseDir . '<br />';
    	echo '������ͣ�outputType�� : ' . $this->_strOutputType . '<br />';
    	echo '��ʼ����ͼ�ļ���' . $strInitViewPath . '<br />';
    	echo '��ͼ�ļ����ƣ�' . $strViewName . '<br />';
    	echo '��ͼ�ļ�·����' . $strViewPath . '<br />';
    	echo '����ţ�' . $this->_intErrno . '<br />';
    	echo '<hr><b>�����ֵ�</b></hr><br/>';
    	echo '<pre>';
    	print_r($this->_objScript->g());
    	echo '</pre>';	
    }
    
    protected function _render($strViewName)
    {
    	//������ͼ��Ҫ�ĺ�����
    	require_once 'Bingo/View/Functions.php';
    	$strViewRootPath = $this->getScriptPath() . DIRECTORY_SEPARATOR;
    	$strViewFilePath = $strViewRootPath . $strViewName;
    	
    	if (! is_file($strViewFilePath)) {
    		$strViewFilePath = $strViewRootPath . $this->_strDefaultView;
    	}  	
    	$strInitViewPath = $strViewRootPath . $this->_strInitView;  
    	if (! is_file($strInitViewPath)) {
    		$strInitViewPath = '';
    	}
    	if ($this->_bolDebug) {
    		$this->_debugOutput($strViewName, $strViewFilePath, $strInitViewPath);
    		return true;
    	}
    	$bolRet = $this->_objScript->render($strViewFilePath, $strInitViewPath);
    	if (! $bolRet) {
    		trigger_error('Bingo_View::render ' . $strViewName . ' ret=' . intval($bolRet), E_USER_WARNING);
    	}
    	return $bolRet;
    }
}