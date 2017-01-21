<?
class Utility{
	// 基本上是一些常用的业务逻辑代码
	function __construct(){

	}

	// 检查手机格式
	public function is_mobile($mobile){
		return (bool)preg_match('/^1\d{10}$/', $mobile);
	}

	// 检查密码合法性 字母数字下划线，长度默认6-16位
	public function chk_pwd($pwd){
		return (bool)preg_match("/^[a-zA-Z0-9_]{6,16}$/", $pwd);
	}

	// 检查邮箱合法性
	public function chk_email($email){
		return (bool)preg_match('/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9]+(-[a-zA-Z0-9]+)*(\.[a-zA-Z0-9]+[-a-zA-Z0-9]*)+[a-zA-Z0-9]+$/', $email);
	}

	// 检查邮编合法性
	public function chk_zipcode($zipcode){
		return (bool)preg_match("/^\d{6}$/", $zipcode);
	}

	// 检查身份证号合法性
	public function chk_idno($id){
		return (bool)preg_match('/^\d{17}[0-9X]{1}$/', $id);
	}

	// 从身份证中获得出生时间
	public function get_birthday_from_idno($id){
		if(!$this->chk_idno($id)){
			return false;
		}
		return substr($id,6,8);
	}

	// 从身份证号获取性别，返回0表示男，返回1表示女，和field_sex的约定一致
	public function get_gender_from_idno($id){
		if(!$this->chk_idno($id)){
			return false;
		}
		$gender = (int)substr($id,16,1);
		return $gender%2===1?0:1;
	}

	// 校验车牌号合法性
	public function chk_plateno($plateno){
		$plateno = strtoupper(trim($plateno));
		if($plateno==='临牌'){
			return true;
		}
		$len = mb_strlen($plateno,'UTF8');
		if($len===7||$len===8){
			return true;
		}
		return false;
	}


}
?>