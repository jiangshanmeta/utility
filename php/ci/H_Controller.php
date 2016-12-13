<?
defined('BASEPATH') OR exit('No direct script access allowed');
if (! defined('__DEFINED_WHERE_TYPE__')) {
    define("__DEFINED_WHERE_TYPE__", "__DEFINED_WHERE_TYPE__");
    define("WHERE_TYPE_WHERE", 0);
    define("WHERE_TYPE_IN", 1);
    define("WHERE_TYPE_LIKE", 2);
    define("WHERE_TYPE_NOT_IN", 3);
    define("WHERE_TYPE_WHERE_GT", 21);
    define("WHERE_TYPE_WHERE_LT", 22);
    define("WHERE_TYPE_WHERE_GTE", 23);
    define("WHERE_TYPE_WHERE_LTE", 24);
    define("WHERE_TYPE_WHERE_NE", 25);

}

class H_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->controller_name = $this->uri->rsegments[1];
		$this->method_name = $this->uri->rsegments[2];
	}

    final protected function exportData($data,$rstno){
        $ret = array(
            'data' => $data,
            'rstno' => $rstno,
        );
        return  $this->resultEncode($ret);        	
    }

    final protected function resultEncode($ret){
    	return json_encode($ret);
    }

}

?>