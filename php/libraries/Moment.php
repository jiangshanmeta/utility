<?php
class Moment{
	// 主要是字符串转时间戳，时间戳转字符串
	// 返回时间戳的方法一律以TS结尾
	// 返回字符串的方法一律以Str结尾
	// get**Str的和get**TS的第一个参数可以是时间戳、时间字符串
	// get**Str的第二个参数是生成时间字符串是的连接符
	private $_datatime;
	function __construct(){
		$this->set_timezone();
		$this->_datatime = new DateTime();
	}
	private function _ensure_TS_legal($ts){
		if(is_numeric($ts)){
			$ts = (int)$ts;
			if(preg_match('/^\d{6}$/i', $ts)){
				if(in_array(substr($ts,0,2), ['19','20'])){
					return DateTime::createFromFormat('Ym', $ts)->format('U');
				}else{
					return DateTime::createFromFormat('mY', $ts)->format('U');
				}
			}
			if(preg_match('/^\d{8}$/i',$ts)){
				return DateTime::createFromFormat('Ymd', $ts)->format('U');
			}
			return $ts;
		}
		if(is_string($ts)){
			$ts = $this->strtotime($ts);
		}
		if(!is_int($ts) && !is_float($ts)){
			$ts = time();
		}

		return $ts;
	}

	private function _gen_TS_str($fmt,$ts){
		$this->_datatime->setTimestamp($ts);
		return $this->_datatime->format($fmt);
	}

	public function set_timezone($str='Asia/Shanghai'){
		date_default_timezone_set($str);
	}

	public function strtotime($str){
		return (int)(new DateTime($str))->format('U');
	}


	// 获得Str
	// month Str
	public function get_prev_month_str($ts=NULL,$fmt='Y-m'){
		$ts = $this->_ensure_TS_legal($ts);
		return $this->get_cur_month_str(strtotime("-1 month",$ts),$fmt);
	}
	public function get_cur_month_str($ts=NULL,$fmt='Y-m'){
		$ts = $this->_ensure_TS_legal($ts);
		return $this->_gen_TS_str($fmt,$this->get_month_beginTS($ts));
	}
	public function get_next_month_str($ts=NULL,$fmt='Y-m'){
		$ts = $this->_ensure_TS_legal($ts);
		return $this->get_cur_month_str(strtotime("+1 month",$ts),$fmt);
	}

	// week  Str
	public function get_prev_week_str($ts=NULL,$fmt='Y-m-d'){
		$ts = $this->_ensure_TS_legal($ts);
		$ts -= 86400*7;
		return $this->get_cur_week_str($ts,$fmt);
	}
	public function get_cur_week_str($ts=NULL,$fmt='Y-m-d'){
		$ts = $this->_ensure_TS_legal($ts);
		return $this->_gen_TS_str($fmt,$this->get_week_beginTS($ts-(date('N',$ts)-1)*86400));
	}
	public function get_next_week_str($ts=NULL,$fmt='Y-m-d'){
		$ts = $this->_ensure_TS_legal($ts);
		$ts += 86400*7;
		return $this->get_cur_week_str($ts,$fmt);
	}	

	// day  Str
	public function get_prev_day_str($ts=NULL,$fmt='Y-m-d'){
		$ts = $this->_ensure_TS_legal($ts);
		return $this->get_cur_day_str(strtotime("-1 day",$ts),$fmt);
	}
	public function get_cur_day_str($ts=NULL,$fmt='Y-m-d'){
		$ts = $this->_ensure_TS_legal($ts);
		return $this->_gen_TS_str($fmt,$this->get_day_beginTS($ts));
	}
	public function get_next_day_str($ts=NULL,$fmt='Y-m-d'){
		$ts = $this->_ensure_TS_legal($ts);
		return $this->get_cur_day_str(strtotime("+1 day",$ts),$fmt);
	}

	// 获得时间戳
	public function get_curTS(){
		return time();
	}

	public function get_month_beginTS($ts=NULL){
		$ts = $this->_ensure_TS_legal($ts);
		return strtotime(date('Ym01',$ts));
	}
	public function get_month_endTS($ts=NULL){
		$ts = $this->_ensure_TS_legal($ts);
		return mktime(23, 59, 59, date('m',$ts), date('t',$ts), date('Y',$ts));
	}

	public function get_week_beginTS($ts=NULL){
		$ts = $this->_ensure_TS_legal($ts);
		return strtotime(date('Y-m-d',$ts-(date('N',$ts)-1)*86400));
	}
	public function get_week_endTS($ts=NULL){
		return $this->get_week_beginTS($ts) + 86400*7 - 1;
	}

	public function get_day_beginTS($ts=NULL){
		$ts = $this->_ensure_TS_legal($ts);
		return mktime(0, 0, 0, date('m',$ts), date('d',$ts), date('Y',$ts));
	}
	public function get_day_endTS($ts=NULL){
		$ts = $this->_ensure_TS_legal($ts);
		return mktime(23, 59, 59, date('m',$ts), date('d',$ts), date('Y',$ts));
	}

	public function get_days_in_month($ts=NULL){
		$ts = $this->_ensure_TS_legal($ts);
		return (int)date('t',$ts);
	}

	public function get_which_day_of_year($ts=NULL){
		$ts = $this->_ensure_TS_legal($ts);
		return (int)date('z',$ts)+1;
	}
	public function get_which_day_of_month($ts=NULL){
		$ts = $this->_ensure_TS_legal($ts);
		return (int)date('j',$ts);
	}
	public function get_which_day_of_week($ts=NULL){
		$ts = $this->_ensure_TS_legal($ts);
		return (int)date('w',$ts);		
	}

}
?>