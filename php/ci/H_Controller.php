<?
defined('BASEPATH') OR exit('No direct script access allowed');
if (! defined('__DEFINED_WHERE_TYPE__')) {
    // 为了数据库查询的时候写的常量
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

    // 为了设定页面类型时设定的常量,页面类型设置主要为了出错时的展示
    define("VIEW_TYPE_HTML", 1);
    define("VIEW_TYPE_JSON", 2);
    define("VIEW_TYPE_PAGE", 3);
}

class H_Controller extends CI_Controller{
    private $viewType = VIEW_TYPE_HTML;
	public function __construct(){
		parent::__construct();
		$this->controller_name = $this->uri->rsegments[1];
		$this->method_name = $this->uri->rsegments[2];

        // 页面类型默认是html，如果是ajax请求默认改为json，如果是js load一个页面，需要手动设置页面类型
        if(is_ajax_request()){
            $this->setViewType(VIEW_TYPE_JSON);
        }
	}

    final public function setViewType($viewType){
        $this->viewType = $viewType;
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

    function show_error($msg='数据有误',$status=-1){
        switch ($this->viewType) {
            case VIEW_TYPE_HTML:
                $this->topTyp = "gobacktop";
                $this->top_title = $msg;
                ob_start();
                $buffer = $this->template->load('default_page', 'common/404','',TRUE);
                @ob_end_clean();
                echo $buffer;
                break;
            case VIEW_TYPE_JSON:
                $jsonRst = $status;
                $jsonData = array();
                $jsonData['err']['msg'] = $msg;
                echo $this->exportData($jsonData,$jsonRst);  
                break;
            case VIEW_TYPE_PAGE:
                $this->topTyp = "gobacktop";
                $this->top_title = $msg;
                ob_start();
                $buffer = $this->template->load('default_overlay', 'common/404','',TRUE);
                @ob_end_clean();
                echo $buffer;
                break;
            default:
                # code...
                break;
        }
        exit();
    }

    function create(){

    }

    function doCreate(){

    }


    function update(){

    }
    function doUpdate(){

    }


    function doDelete($typ,$id){
        
    }



}

?>