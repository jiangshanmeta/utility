<?
// 因为业务逻辑逐渐复杂化，controller和model层之间加一个service层
class CI_Service{
	protected $CI;
	static public $_ci_model_paths = [APPPATH];
	static public $_ci_library_paths = [APPPATH];
	protected $_service_models = [];
	protected $_service_libraries = [];

	function __construct(){
		$this->CI = &get_instance();
	}

	public function __get($key){
		return get_instance()->$key;
	}

	final public function model($model,$name=''){
		if (empty($model)){
			return $this;
		}else if (is_array($model)){
			foreach ($model as $key => $value){
				is_int($key) ? $this->model($value, '', $db_conn) : $this->model($key, $value, $db_conn);
			}
			return $this;
		}

		$path = '';
		if (($last_slash = strrpos($model, '/')) !== FALSE){
			$path = substr($model, 0, ++$last_slash);
			$model = substr($model, $last_slash);
		}

		if (empty($name)){
			$name = $model;
		}

		if (in_array($name, $this->_service_models, TRUE)){
			return $this;
		}

		if ( ! class_exists('CI_Model', FALSE)){
			$app_path = APPPATH.'core'.DIRECTORY_SEPARATOR;
			if (file_exists($app_path.'Model.php')){
				require_once($app_path.'Model.php');
				if ( ! class_exists('CI_Model', FALSE)){
					throw new RuntimeException($app_path."Model.php exists, but doesn't declare class CI_Model");
				}
			}else if ( ! class_exists('CI_Model', FALSE)){
				require_once(BASEPATH.'core'.DIRECTORY_SEPARATOR.'Model.php');
			}

			$class = config_item('subclass_prefix').'Model';
			if (file_exists($app_path.$class.'.php')){
				require_once($app_path.$class.'.php');
				if ( ! class_exists($class, FALSE)){
					throw new RuntimeException($app_path.$class.".php exists, but doesn't declare class ".$class);
				}
			}
		}

		$model = ucfirst($model);
		if ( ! class_exists($model, FALSE)){
			foreach (self::$_ci_model_paths as $mod_path){
				if ( ! file_exists($mod_path.'models/'.$path.$model.'.php')){
					continue;
				}

				require_once($mod_path.'models/'.$path.$model.'.php');
				if ( ! class_exists($model, FALSE)){
					throw new RuntimeException($mod_path."models/".$path.$model.".php exists, but doesn't declare class ".$model);
				}

				break;
			}

			if ( ! class_exists($model, FALSE)){
				throw new RuntimeException('Unable to locate the model you have specified: '.$model);
			}
		}else if ( ! is_subclass_of($model, 'CI_Model')){
			throw new RuntimeException("Class ".$model." already exists and doesn't extend CI_Model");
		}
	
		$this->_service_models[] = $name;
		$this->$name = new $model();
		return $this;
	}

	final public function library($library){
		if(empty($library)){
			return $this;
		}else if(is_array($library)){
			foreach ($library as $value) {
				$this->library($value);
			}
			return $this;
		}

		$path = '';
		if (($last_slash = strrpos($library, '/')) !== FALSE){
			$path = substr($library, 0, ++$last_slash);
			$library = substr($library, $last_slash);
		}

		$library = ucfirst($library);
		$name = strtolower($library);
		if (in_array($name, $this->_service_libraries, TRUE)){
			return $this;
		}


		if(!class_exists($library, FALSE)){
			foreach (self::$_ci_library_paths as $lib_path) {
				if(!file_exists($lib_path.'libraries/'.$path.$library.'.php')){
					continue;
				}
				require_once($lib_path.'libraries/'.$path.$library.'.php');
				if(!class_exists($library,FALSE)){
					throw new RuntimeException($lib_path."libraries/".$path.$library.".php exists, but doesn't declare class ".$library);
				}
			}

			if(!class_exists($library,FALSE)){
				if($path===''){
					return $this->library($library.'/'.$library);
				}
				throw new RuntimeException('Unable to locate the library you have specified: '.$library);
			}
		}

		// 到这里就加载到了library

		// 然后加载config文件
		$config_component = $this->CI->config;

		if(is_array($config_component->_config_paths)){
			$found = FALSE;
			foreach ($config_component->_config_paths as $cfg_path) {
				if(file_exists($cfg_path.'config/'.$name.'.php'   )){
					include($cfg_path.'config/'.$name.'.php');
					$found = TRUE;
				}else if(file_exists($cfg_path.'config/'.$library.'.php')){
					include($cfg_path.'config/'.$library.'.php');
					$found = TRUE;
				}

				if(file_exists($cfg_path.'config/'.ENVIRONMENT.'/'.$name.'.php')){
					include($cfg_path.'config/'.ENVIRONMENT.'/'.$name.'.php');
					$found = TRUE;
				}else if(file_exists($cfg_path.'config/'.ENVIRONMENT.'/'.$library.'.php')){
					include($cfg_path.'config/'.ENVIRONMENT.'/'.$library.'.php');
					$found = TRUE;
				}

				if($found){
					break;
				}

			}

		}


		$this->_service_libraries[] = $name;
		$this->$name = isset($config)?new $library($config):new $library();

		return $this;
	}
}
?>