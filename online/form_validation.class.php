<?php
                              /************************
                              *******表单验证类********
                              *************************/
/*非空验证*/
function isEmpty($val)
{
if (!is_string($val)) return false; //是否是字符串类型
if (empty($val)) return false; //是否已设定
if ($val=='') return false; //是否为空
return true;
}

//去除字符串空格
function strTrim($str)
{
  return preg_replace("/\s/","",$str);
}

/*
函数名称：isNumber
简要描述：检查输入的是否为数字
输入：string
输出：boolean
*/
function isNumber($val)
{
if(ereg("^[0-9]+$", $val))
  return true;
return false;
}

/*
函数名称：isPhone
简要描述：检查输入的是否为电话
输入：string
输出：boolean
*/
function isPhone($val)
{
//eg: xxx-xxxxxxxx-xxx | xxxx-xxxxxxx-xxx ...
if(ereg("^((0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$",$val))
  return true;
return false;
}

/*
函数名称：isPostcode
简要描述：检查输入的是否为邮编
输入：string
输出：boolean
*/
function isPostcode($val)
{
if(ereg("^[0-9]{4,6}$",$val))
  return true;
return false;
}

/*
函数名称：isEmail
简要描述：邮箱地址合法性检查
输入：string
输出：boolean
*/
function isEmail($val,$domain="")
{
if(!$domain)
{
  if( preg_match("/^[a-z0-9-_.]+@[\da-z][\.\w-]+\.[a-z]{2,4}$/i", $val) )
  {
    return true;
  }
  else
    return false;
}
else
{
  if( preg_match("/^[a-z0-9-_.]+@".$domain."$/i", $val) )
  {
    return true;
  }
  else
    return false;
}
}//end func

/*
函数名称：isName
简要描述：姓名昵称合法性检查，只能输入中文英文
输入：string
输出：boolean
*/
function isName($val)
{
if( preg_match("/^[\x80-\xffa-zA-Z0-9]{3,60}$/", $val) )//2008-7-24
{
  return true;
}
return false;
}//end func

/*
函数名称:isStrLength($theelement, $min, $max)
简要描述:检查字符串长度是否符合要求
输入:mixed (字符串，最小长度，最大长度)
输出:boolean
*/
function isStrLength($val, $min, $max)
{
$theelement= trim($val);
if(ereg("^[a-zA-Z0-9]{".$min.",".$max."}$",$val))
  return true;
return false;
}

/*
函数名称:isNumberLength($theelement, $min, $max)
简要描述:检查字符串长度是否符合要求
输入:mixed (字符串，最小长度，最大长度)
输出:boolean
*/
function isEngLength($val, $min, $max)
{
$theelement= trim($val);
if(ereg("^[a-zA-Z]{".$min.",".$max."}$",$val))
  return true;
return false;
}

/*
函数名称：isEnglish
简要描述：检查输入是否为英文
输入：string
输出：boolean
作者：------
*/
function isEnglish($theelement)
{
if( ereg("[\x80-\xff].",$theelement) )
{
  Return false;
}
Return true;
}

/*
函数名称：isChinese
简要描述：检查是否输入为汉字
输入：string
输出：boolean
*/
function isChinese($sInBuf)//正确的函数
{
  if (preg_match("/^[\x7f-\xff]+$/", $sInBuf)) { //兼容gb2312,utf-8

    return true;
  }
  else
  {
    return false;
  }
}

  /**
   * 验证是否日期的函数
   * @param unknown_type $date
   * @param unknown_type $format
   * @throws Exception
   * @return boolean
   */
  function validateDate( $date, $format='YYYY-MM-DD')
  {
    switch( $format )
    {
      case 'YYYY/MM/DD':
      case 'YYYY-MM-DD':
        list( $y, $m, $d ) = preg_split( '/[-./ ]/', $date );
        break;

      case 'YYYY/DD/MM':
      case 'YYYY-DD-MM':
        list( $y, $d, $m ) = preg_split( '/[-./ ]/', $date );
        break;

      case 'DD-MM-YYYY':
      case 'DD/MM/YYYY':
        list( $d, $m, $y ) = preg_split( '/[-./ ]/', $date );
        break;

      case 'MM-DD-YYYY':
      case 'MM/DD/YYYY':
        list( $m, $d, $y ) = preg_split( '/[-./ ]/', $date );
        break;

      case 'YYYYMMDD':
        $y = substr( $date, 0, 4 );
        $m = substr( $date, 4, 2 );
        $d = substr( $date, 6, 2 );
        break;

      case 'YYYYDDMM':
        $y = substr( $date, 0, 4 );
        $d = substr( $date, 4, 2 );
        $m = substr( $date, 6, 2 );
        break;

      default:
        throw new Exception( "Invalid Date Format" );
    }
    return checkdate( $m, $d, $y );
  }


/*
函数名称：isDate
简要描述：检查日期是否符合0000-00-00
输入：string
输出：boolean
*/
function isDate($sDate)
    {
        if( ereg("^[0-9]{4}\-[][0-9]{2}\-[0-9]{2}$",$sDate) )
        {
        Return true;
  }
  else
  {
  Return false;
}
}

 /*
 函数名称：isTime
 简要描述：检查日期是否符合0000-00-00 00:00:00
 输入：string
 输出：boolean
 */
 function isTime($sTime)
 {
 if( ereg("^[0-9]{4}\-[][0-9]{2}\-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$",$sTime) )
  {
    Return true;
 }
  else
  {
  Return false;
 }
 }

/**
 * 验证手机号
 * @param int $mobile
 */
function valid_mobile($mobile){
  if(strlen($mobile)!=11) return false;
  if(preg_match('/13[0-9]\d{8}|15[0|1|2|3|5|6|7|8|9]\d{8}|18[0|5|6|7|8|9]\d{8}/',$mobile)){
    return true;
  }else{
    return false;
  }
}


?>