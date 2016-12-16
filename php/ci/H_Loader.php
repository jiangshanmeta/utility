<?
defined('BASEPATH') OR exit('No direct script access allowed');
class H_Loader extends CI_Loader{
	protected $_ci_field_paths = array(APPPATH,BASEPATH);
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
		if(!class_exists($class,FALSE)){
			foreach ($this->_ci_field_paths as $field_path) {
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

}
?>