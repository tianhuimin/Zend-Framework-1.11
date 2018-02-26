<?php
/**
 * �ַ���������װ����Ҫ�Ǹ�ģ��ʹ�á�
 * @author xuliqiang <xuliqiang@baidu.com>
 * @since 2010-04-07
 * @package bingo
 *
 */
require_once 'Bingo/Encode.php';
class Bingo_String
{
	/**
     * ����ת����json���
     *
     * @param array $arrVar
     * @param string $strEncode
     * @return string
     */
	public static function array2json($arrVar, $strFromEncode='GBK'/*UTF8DIFF*/)
	{
		if (! function_exists('json_encode')) {
            throw new Exception('function json_encode is not found!');
        }
        if ($strFromEncode != Bingo_Encode::ENCODE_UTF8) {
            $arrVar = Bingo_Encode::convert($arrVar, Bingo_Encode::ENCODE_UTF8, $strFromEncode, Bingo_Encode::ENCODE_TYPE_MB_STRING);
            return Bingo_Encode::convert(json_encode($arrVar), $strFromEncode, Bingo_Encode::ENCODE_UTF8, Bingo_Encode::ENCODE_TYPE_MB_STRING);
        } else {
            return json_encode($arrVar);
        }
	}
	/**
	 * JSONת��������
	 * @param string $strJson
	 * @param string $strToEncode
	 */	
	public static function json2array($strJson, $strToEncode='GBK'/*UTF8DIFF*/, $bolAssoc=true, $intDepth=NULL)
	{
		if (! function_exists('json_decode')) {
			throw new Exception('function json_decode is not found!');
		}
		if (is_null($intDepth)) {
		    //ע�⣬ֻ��5.3���ϵ�PHP�汾��֧�ֵ�3������
		    $arrVar = json_decode($strJson, $bolAssoc);
		} else {
		    $arrVar = json_decode($strJson, $bolAssoc, $intDepth);
		}
		if (! $arrVar) {
			return false;
		}
		if ($strToEncode != Bingo_Encode::ENCODE_UTF8) {
			$arrVar = Bingo_Encode::convert($arrVar, $strToEncode, Bingo_Encode::ENCODE_UTF8, Bingo_Encode::ENCODE_TYPE_MB_STRING);
		}
		return $arrVar;
	}
	/**
     * �ַ�����ȡ
     *
     * @param string $string
     * @param int $intLen
     * @param string $strEtc
     * @param string $strEncode
     * @return string
     */
	public static function truncate($string, $intLen = 80, $strEtc = '...', $strEncode = 'GBK'/*UTF8DIFF*/)
	{
		if ( $strEncode != Bingo_Encode::ENCODE_GBK && function_exists('mb_strimwidth')) {
            return self::_mbCutStr($string, $intLen, $strEtc, $strEncode);
        } else {
            return self::_cutStrForGbk($string, $intLen, $strEtc);
        }
	}
	/**
	 * HTML���밲ȫת����ֻת��& ' " < >
	 * @param $strVar
	 * @param $strEncode
	 */
	public static function escapeHtml($strVar, $strEncode = 'GB18030'/*UTF8DIFF*/)
	{
		return htmlspecialchars($strVar, ENT_QUOTES, $strEncode);
	}
	/**
	 * HTMLת����ת�����е�HTML��ǩ�Ͳ��Ϸ��ı����ַ�
	 * @param string $strVar
	 * @param string $strEncode
	 */
	public static function escapeHtmlAll($strVar, $strEncode = 'GB18030'/*UTF8DIFF*/)
	{
		return htmlentities($strVar, ENT_QUOTES, $strEncode);
	}
	/**
	 * ת��JS����ȫ�ַ�
	 * @param string $strVar
	 * @param string $strEncode
	 */
	public static function escapeJs($strVar, $strEncode = 'GBK'/*UTF8DIFF*/)
	{
		if ( $strEncode == Bingo_Encode::ENCODE_GB2312 || $strEncode == Bingo_Encode::ENCODE_GBK ) {
			return self::_escapeJsForGbk($strVar);
		} else {
			return strtr($strVar, array('\\'=>'\\\\',"'"=>"\\'",'"'=>'\\"',"\r"=>'\\r',"\n"=>'\\n','</'=>'<\/', '/'=>'\/'));
    	}
	}
	/**
	 * URLת��
	 * @param string $strVar
	 */
	public static function escapeUrl($strVar)
	{
		return rawurlencode($strVar);
	}
	
	private static function _cutStrForGbk($string, $len = 100, $etc = '...')
    {        
    	$string = strval($string);
        if (strlen($string) <= $len) {
            return $string;
        }
        $strCut = '';
        for ($i=0; $i < $len; $i++) {
            if ( ord($string{$i}) > 0x80 ) {
                ++ $i;
                if ($i >= $len) break;
                $strCut .= $string{$i - 1} . $string{$i};
            } else {
                $strCut .= $string{$i};
            }
        }
        return $strCut . $etc;
    }
    
    private static function _mbCutStr($string, $length = 100, $etc = '...', $encoding = 'GBK'/*UTF8DIFF*/)
    {
        if(mb_strwidth($string,$encoding)> $length){
            return mb_strimwidth($string, 0, ($length + strlen($etc)), $etc, $encoding);
        } 
        else {
            return $string;    
        }
    }
    
	/**
     * ����JS��һЩ����ȫ���ַ���ֻ֧��GBK�ַ�
     * �԰�����ֵĴ���������⡣
     *
     * @param string $str
     * @return string
     */
    private static function _escapeJsForGbk($str)
    {
    	$str = strval($str);
        $_intStrlen = strlen($str);
        $_intPos = 0;
        $_strRet = ''; 
        $_arrEscapeChrs = array(
        	"'"    => "\'",
        	'"'    => '\"',
        	"\\"   => "\\\\",
        	"\n"   => "\\n",
        	"\r"   => "\\r",
        	'</'   => '<\/',
            '/'	   => '\/',
        );  
        while($_intPos < $_intStrlen){
            if(ord($str{$_intPos}) > 0x80){
                $_strRet .= $str{$_intPos++} . $str{$_intPos++};
            } else {
                if(! empty($_arrEscapeChrs[$str{$_intPos}])){
                    $_strRet .= $_arrEscapeChrs[$str{$_intPos++}];
                } else {
                    $_strRet .= $str{$_intPos++};
                }
            } 
        }
        return $_strRet;
    }
}