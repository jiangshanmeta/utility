<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login{
	// 可以配置的信息：
	// 在线数据库表名、
	// cookie名、
	// cookie过期时间
	// cookie刷新时间，以秒为单位，更新cookie的同时也更新数据库

	protected $tableName = 'onlineInfo';
	protected $cookieName = 'userInfo';
	protected $loginExpire = 31536000;
	protected $cookieRefresh = 86400;
	protected $uid;
	protected $onlineId;
	protected $CI;
	public function __get($key){
		return $this->$key;
	}

	public function __construct(){
		$this->CI = &get_instance();
	}

	// 对各种配置进行设置
	public function initialize(array $config = array()){
		unset($config['uid'],$config['onlineId'],$config['CI']);
		foreach ($config as $key => $value) {
			if(isset($this->$key)){
				$this->$key = $value;
			}
		}
	}
	// 对外接口
	// doLogin 登录
	// doLogout 登出
	// isLogin 是否登录
	public function isLogin(){
		$cookie = $this->CI->input->cookie($this->cookieName);
		// 检查cookie是否存在
		if(!$cookie){
			return false;
		}
		// 现在有cookie了，需要先校验一下数据
		$this->decodeCookie($cookie);
		$data = $this->getOnlineInfo();
		if(!is_array($data)){

			return false;
		}
		if($data['uid'] != $this->uid){

			return false;
		}
		$zeit = time();
		if($zeit-$data['loginTS']>$this->loginExpire){
			return false;
		}
		// 到这里可以确认登陆了

		// 为了防止像知乎那样登陆一次然后登录信息一直不更新直到过期
		if($zeit-$data['loginTS']>$this->cookieRefresh){
			$this->updateOnlineInfo(['loginTS'=>time()]);
			$cookie = $this->encodeCookie($this->uid,$this->onlineId);
			set_cookie($this->cookieName,$cookie,$this->loginExpire);
		}

		return true;
	}

	// 登录，数据库插入一条记录，设置cookie
	public function doLogin($uid){
		$this->uid = $uid;
		$this->onlineId = $this->insertOnlineInfo($uid);
		$cookie = $this->encodeCookie($this->uid,$this->onlineId);
		set_cookie($this->cookieName,$cookie,$this->loginExpire);
	}

	// 登出，删cookie
	public function doLogout(){
		delete_cookie($this->cookieName);
	}

	// 内部函数
	// cookie加密和解密
	// 数据库增该
	protected function encodeCookie($uid,$onlineId){
		return base64_encode($uid.'|'.$onlineId);
	}

	protected function decodeCookie($cookie){
		$temp = base64_decode($cookie);
		$arr = explode('|', $temp);
		$this->uid = $arr[0];
		$this->onlineId = $arr[1];
	}

	protected function insertOnlineInfo($uid){
		$id = new MongoId();
		$this->CI->db->insert($this->tableName,['_id'=>$id,'uid'=>$uid,'loginTS'=>time()]);
		return (string)$id;
	}

	protected function updateOnlineInfo(array $data){
		unset($data['_id'],$data['uid']);
		$this->CI->db->where(['_id'=>new MongoId($this->onlineId)])->update($this->tableName,$data);
	}

	protected function getOnlineInfo(){
		$query = $this->CI->db->where(['_id'=>new MongoId($this->onlineId)])->get($this->tableName);
		if($query->num_rows()>0){
			return $query->row_array();
		}
		return false;
	}


}



?>