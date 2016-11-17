<?php
class Moment{
	// 主要是字符串转时间戳，时间戳转字符串
	// 返回时间戳的方法一律以TS结尾
	// 返回字符串的方法一律以Str结尾
	// get**Str的和get**TS的第一个参数可以是时间戳、时间字符串
	// get**Str的第二个参数是生成时间字符串是的连接符
	function __construct(){
		$this->setTimeZone();
	}
	private function _ensureTSLegal($ts){
		if(is_numeric($ts)){
			$ts = (int)$ts;
		}
		if(is_string($ts)){
			$ts = $this->strtotime($ts);
		}
		if(!is_int($ts) && !is_float($ts)){
			$ts = time();
		}

		return $ts;
	}
	public function getCurTS(){
		return time();
	}

	public function setTimeZone($str='Asia/Shanghai'){
		date_default_timezone_set($str);
	}

	public function strtotime($str){
		return strtotime($str);
	}


	public function getPrevMonthStr($ts=NULL,$separator='-'){
		$ts = $this->_ensureTSLegal($ts);
		return date('Y'.$separator.'m',strtotime("-1 month",$ts));
	}

	public function getNextMonthStr($ts=NULL,$separator='-'){
		$ts = $this->_ensureTSLegal($ts);	
		return date('Y'.$separator.'m',strtotime("+1 month",$ts));
	}

	public function getPrevDayStr($ts=NULL,$separator='-'){
		$ts = $this->_ensureTSLegal($ts);
		return date('Y'.$separator.'m'.$separator.'d',strtotime("-1 day",$ts));
	}

	public function getNextDayStr($ts=NULL,$separator='-'){
		$ts = $this->_ensureTSLegal($ts);
		return date('Y'.$separator.'m'.$separator.'d',strtotime("+1 day",$ts));
	}

	public function getCurWeekStr($ts=NULL,$separator='-'){
		$ts = $this->_ensureTSLegal($ts);
		return date('Y'.$separator.'m'.$separator.'d',$ts-(date('N',$ts)-1)*86400);
	}

	public function getPrevWeekStr($ts=NULL,$separator='-'){
		$ts = $this->_ensureTSLegal($ts);
		$ts -= 86400*7;
		return date('Y'.$separator.'m'.$separator.'d',$ts-(date('N',$ts)-1)*86400);
	}
	public function getNextWeekStr($ts=NULL,$separator='-'){
		$ts = $this->_ensureTSLegal($ts);
		$ts += 86400*7;
		return date('Y'.$separator.'m'.$separator.'d',$ts-(date('N',$ts)-1)*86400);
	}


	public function getMonthBeginTS($ts=NULL){
		$ts = $this->_ensureTSLegal($ts);
		return strtotime(date('Ym01',$ts));
	}

	public function getMonthEndTS($ts=NULL){
		$ts = $this->_ensureTSLegal($ts);
		return mktime(23, 59, 59, date('m',$ts), date('t',$ts), date('Y',$ts));
	}
	public function getWeekBeginTS($ts=NULL){
		$ts = $this->_ensureTSLegal($ts);
		return strtotime(date('Y-m-d',$ts-(date('N',$ts)-1)*86400));
	}

	public function getWeekEndTS($ts=NULL){
		return $this->getWeekBeginTS($ts) + 86400*7 - 1;
	}

	public function getDayBeginTS($ts=NULL){
		$ts = $this->_ensureTSLegal($ts);
		return mktime(0, 0, 0, date('m',$ts), date('d',$ts), date('Y',$ts));
	}

	public function getDayEndTS($ts=NULL){
		$ts = $this->_ensureTSLegal($ts);
		return mktime(23, 59, 59, date('m',$ts), date('d',$ts), date('Y',$ts));
	}



}
?>