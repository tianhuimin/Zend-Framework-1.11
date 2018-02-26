<?php
require_once 'Bingo/String.php';
require_once 'Bingo/View/Script.php';
require_once 'Bingo/Http/Request.php';
/**
 * ���º�����Ҫ�Ǹ�FEʹ��
 */
function h($strVar, $strEncode = 'GB18030'/*UTF8DIFF*/)
{
	return Bingo_String::escapeHtml($strVar,$strEncode);
}
function htmlAll($strVar, $strEncode = 'GB18030'/*UTF8DIFF*/)
{
	return Bingo_String::escapeHtmlAll($strVar,$strEncode);
}
function j($strVar, $strEncode = 'GB2312'/*UTF8DIFF*/)
{
	return Bingo_String::escapeJs($strVar,$strEncode);
}
function u($strVar)
{
	return Bingo_String::escapeUrl($strVar);
}
function json($arrVar, $strEncode = 'GBK'/*UTF8DIFF*/)
{
	return Bingo_String::array2json($arrVar, $strEncode);
}
function json2array($strVar, $strToEncode='GBK'/*UTF8DIFF*/)
{
	return Bingo_String::json2array($strVar, $strToEncode);
}
function c($string, $intLen = 80, $strEtc = '...', $strEncode = 'GBK'/*UTF8DIFF*/)
{
	return Bingo_String::truncate($string, $intLen, $strEtc, $strEncode);
}

function CONF($strConfKey, $strTypeKey='', $mixDefaultValue='')
{
	return Bingo_View_Script::getInstance()->conf($strConfKey, $strTypeKey, $mixDefaultValue);
}

function GET($strKey, $mixDefaultValue='')
{
	return Bingo_Http_Request::getGet($strKey, $mixDefaultValue);
}

function POST($strKey, $mixDefaultValue='')
{
	return Bingo_Http_Request::getPost($strKey, $mixDefaultValue);
}

function REQUEST($strKey, $mixDefaultValue='')
{
    return Bingo_Http_Request::get($strKey, $mixDefaultValue);
}

function COOKIE($strKey, $mixDefaultValue='')
{
	return Bingo_Http_Request::getCookie($strKey, $mixDefaultValue);
}

function IFELSE($bolVar, $mixValue, $mixFalseValue)
{
	return ($bolVar)?$mixValue:$mixFalseValue;
}

function helper()
{
	return Bingo_View_Script::getInstance()->getObjHelper();
}

function ContentType($strType, $strCharSet='GBK'/*UTF8DIFF*/)
{
    require_once 'Bingo/Http/Response.php';
    $strContentType = 'text/html';
    switch ($strType) {
        case 'json':
            $strContentType = 'application/json';
            break;
        case 'wml':
            $strContentType = 'text/vnd.wap.wml';
            break;
        case 'xml':
            $strContentType = 'text/xml';
            break;
        case 'xhtml':
            $strContentType = 'application/xhtml+xml';
            break;
        case 'html':
            $strContentType = 'text/html';
            break;
        default:
            $strContentType = $strType;
            break;
    }
    Bingo_Http_Response::contextType($strContentType, $strCharSet);
}
/**
 * �ո�ת����&#160;  or &nbsp;
 * @param $strVar
 * @param $strSpace
 */
function spaceFormat($strVar, $strSpace='&nbsp;')
{
    //TODO
    return mb_ereg_replace(' ', $strSpace, $strVar);
}
function spaceAndDonaFormat($strVar, $strSpace='&nbsp;')
{
    return str_replace(array('$', ' '), array('$$', $strSpace), $strVar);
}
/**
 * xhtml/wml ת�庯��ת��
 * @param $strType
 */
class Bingo_View_Function_Escape
{
    public static $_strType = 'xhtml';
}
function escapeSwitch($strType='xhtml') 
{
    Bingo_View_Function_Escape::$_strType = $strType;
}
/**
 * h(),xhtml���htmlת��
xml��ת�壬����< ��>���ո�&��
w(),wml���htmlת��
��hת�����ƣ��������Ӷ���$���ŵ�ת�壬$ת��Ϊ$$
 * @param $strVar
 * @param $strEncode
 */
function xh($strVar, $strEncode = 'GB18030'/*UTF8DIFF*/)
{
    $strVar = Bingo_String::escapeHtml($strVar,$strEncode);
    if (Bingo_View_Function_Escape::$_strType == 'xhtml') {
        //ת��ո�
        $strVar = spaceFormat($strVar, '&#160;');
    } else {
        //ת��ո�+dona
        $strVar = spaceAndDonaFormat($strVar, '&nbsp;');
    }
    return $strVar;
}
/**
 * m(),xhtml���
n(),wml���
��������h/w��ת�壬��ѿո�ת��Ϊ&nbsp;�����ύ������ᵼ�±������⡣
m/n�Ὣ�ո�ת��Ϊʵ���ַ�������������һ��
 * @param unknown_type $strVar
 * @param unknown_type $strEncode
 */
function xhf($strVar, $strEncode = 'GB18030'/*UTF8DIFF*/)
{
    $strVar = Bingo_String::escapeHtml($strVar,$strEncode);
    if (Bingo_View_Function_Escape::$_strType == 'xhtml') {
        //ת��ո�
        $strVar = spaceFormat($strVar, '&#160;');
    } else {
        //ת��ո�+dona
        $strVar = spaceAndDonaFormat($strVar, '&#160;');
    }
    return $strVar;
}
