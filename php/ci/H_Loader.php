<?
defined('BASEPATH') OR exit('No direct script access allowed');
class H_Loader extends CI_Loader{
	protected $_ci_field_paths = array(APPPATH,BASEPATH);
	protected $_ci_service_paths = array(APPPATH,BASEPATH);
	protected $_ci_services = array();
	function __construct(){
		parent::__construct();
	}

	public function field($class,$showName,$name,$is_must_input=FALSE,$tableName=''){
		if(!$class){
			return FALSE;
		}
		$path = '';

		// Is the model in a sub-folder? If so, parse out the filename and path.
		if (($last_slash = strrpos($class, '/')) !== FALSE){
			// The path is in front of the last slash
			$path = substr($class, 0, ++$last_slash);

			// And the model name behind it
			$class = substr($class, $last_slash);
		}
		$class = ucfirst($class);
		// var_dump($class,$path);
		if(!class_exists($class,FALSE)){
			foreach ($this->_ci_field_paths as $field_path) {
				// var_dump($field_path);
				if(!file_exists($field_path.'models/fields/'.$path.$class.'.php')){
					continue;
				}
				require_once($field_path.'models/fields/'.$path.$class.'.php');
				if(!class_exists($class,FALSE)){
					throw new RuntimeException($field_path."models/".$path.$class.".php exists, but doesn't declare class ".$class);
				}
			}
			if(!class_exists($class,FALSE)){
				throw new RuntimeException("Unable to locate the model you have specified: ".$class);
			}
		}
		return new $class($showName,$name,$is_must_input,$tableName);
	}

	public function service($service,$name){
		if(empty($service)){
			return $this;
		}else if(is_array($service)){
			foreach ($service as $key => $value) {
				is_int($key)?$this->service($value,''):$this->service($key,$value);
			}
			return $this;
		}
		$path = '';
		// service 在子目录中
		if (($last_slash = strrpos($service, '/')) !== FALSE){
			$path = substr($service, 0, ++$last_slash);
			$service = substr($service, $last_slash);
		}

		if(empty($name)){
			$name = $service;
		}

		if(in_array($name, $this->_ci_services,TRUE)){
			return $this;
		}

		$CI = & get_instance();
		if(isset($CI->$name)){
			throw new RuntimeException('The service name you are loading is the name of a resource that is already being used: '.$name);
		}

		// 加载基类和扩展的基类
		if(!class_exists('CI_Service',FALSE)){
			$app_path = APPPATH.'core'.DIRECTORY_SEPARATOR;
			if(file_exists($app_path.'Service.php')){
				require_once($app_path.'Service.php');
				if(!class_exists('CI_Service',FALSE)){
					throw new RuntimeException($app_path."Service.php exists, but doesn't declare class CI_Service");
				}
			}else if(!class_exists('CI_Service',FALSE)){
				require_once(BASEPATH.'core'.DIRECTORY_SEPARATOR.'Service.php');
			}

			$class = config_item('subclass_prefix').'Service';
			if(file_exists($app_path.$class.'.php')){
				require_once($app_path.$class.'.php');
				if(!class_exists($class,FALSE)){
					throw new RuntimeException($app_path.$class.".php exists, but doesn't declare class ".$class);
				}
			}
		}

		$service = ucfirst($service);
		if(!class_exists($service,FALSE)){
			foreach ($this->_ci_service_paths as $ser_path) {
				if(!file_exists($ser_path.'services/'.$path.$service.'.php')){
					continue;
				}
				require_once($ser_path.'services/'.$path.$service.'.php');
				if(!class_exists($service,FALSE)){
					throw new RuntimeException($ser_path."models/".$path.$service.".php exists, but doesn't declare class ".$service);
				}
				break;
			}

			if(!class_exists($service,FALSE)){
				throw new RuntimeException('Unable to locate the model you have specified: '.$service);
			}

		}else if(! is_subclass_of($service, 'CI_Service')){
			throw new RuntimeException("Class ".$service." already exists and doesn't extend CI_Service");
		}

		$this->_ci_services[] = $name;
		$CI->$name = new $service();
		return $this;
	}

}
?>