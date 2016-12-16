<?
defined('BASEPATH') OR exit('No direct script access allowed');
class Record_Model extends H_Model{
	public $is_inited = false;
	public $id = NULL;
	public $delete_trigger = false;
	public $field_list = [];
	public $data = [];
	public $tableName;
	function __construct(){
		parent::__construct();

		// 一个model只对应一张表，实例之间tableName一定是相同的，因而用静态+引用
		// 这里tableName要先声明，然后赋一个引用，否则回报错
		// library里面用&get_instance引CI也会出现同样的问题，切记
		// 未来可能加上 各种查看、查改、删除等的链接
		$subclassName = $this->get_submodel_name();
		$this->tableName = & $subclassName::$tbName;
	}

	final public function genMongoId($id=NULL){
		if($id===NULL || !MongoId::isValid($id) ){
			return new MongoId();
		}
        if (!is_object($id)){
            return new MongoId($id);
        }
        return $id;
	}
	final public function init_with_id($id){
		return $this->init_with_where(['_id'=>$this->genMongoId($id)]);
	}

	final public function init_with_foreignId($field,$value){
		return $this->init_with_where([$field=>$value]);
	}

	final public function init_with_where($whereData){
		$this->is_inited = false;
		$this->id = NULL;
		$query = $this->db->where($whereData)->limit(1)->get($this->tableName);
		if($query->num_rows()>0){
			$result = $query->row_array();
			$this->init_with_data($result['_id'],$result);		
		}
		return $this;		
	}

	final public function init_with_original_where(){
        $this->is_inited = false;
        $this->id = NULL;
        $query = $this->db->where($whereArr,true)->limit(1)->get($this->tableName);
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
            $this->init_with_data($result['_id'],$result);
        }
        return $this;   
	}

	final public function init_with_data($id,array $data){
		$this->id = (string)$id;
		foreach ($this->field_list as $key => $value) {
			if(isset($data[$key])){
				$this->data[$key] = $data[$key];
				$this->field_list[$key]->init($data[$key]);
			}else{
				$this->field_list[$key]->init(NULL);
			}
		}
		$this->is_inited = true;
		$this->do_sth_after_init();
	}

	public function do_sth_after_init(){
		
	}

	final public function init_with_part_data(array $data){
		foreach ($data as $key => $value) {
			$this->data[$key] = $value;
			if(isset($this->field_list[$key])){
				$this->field_list[$key]->init($data[$key]);
			}
		}
	}

	public function do_sth_before_insert(array $data){
		return $data;
	}
	final public function insert_db(array $data){
		if(isset($this->field_list['_id']) && !isset($data['_id'])){
			$data['_id'] = $this->genMongoId();
		}
		$data = $this->do_sth_before_insert($data);
		$this->db->insert($this->tableName,$data);

		$id = $this->db->insert_id();

		$this->id = (string)$id;
		$this->init_with_part_data($data);
		$this->do_sth_after_insert($this->id,$data);
		return $this;
	}
	public function do_sth_after_insert($id,$data){

	}	

	public function do_sth_before_update($data){
		return $data;
	}
	final public function update_db(array $data,$id=NULL){
		if(!is_array($data)){
			return false;
		}
        if ($id === null){
            $id = $this->id;
        }
        $real_id = $this->genMongoId($id);
        $data = $this->do_sth_before_update($data);
        $this->db->where(array('_id'=>$real_id))->update($this->tableName,$data);
        $this->init_with_part_data($data);
        $this->do_sth_after_update($id,$data);
        return $this;		
	}
	public function do_sth_after_update($id,$data){

	}

	public function do_sth_before_delete(){

	}
	final public function delete_db($id){
        if($this->delete_trigger){
            if($this->id!=$id){
                $this->init_with_id($id);
            }
            $this->do_sth_before_delete();
        }
        $effect = 0;
        $this->db->where(array('_id'=>$this->genMongoId($id)))->delete($this->tableName);
        $effect += 1;
        if ($this->delete_trigger && $this->is_inited){
            $this->do_sth_after_delete($id,$this->data);
        }
        return $effect;
	}
	public function do_sth_after_delete($id,$data){

	}

	public function do_sth_before_inc($data){
		return $data;
	}
	final public function inc_db(array $data,$id=NULL){
        if ($id===null){
            $id = $this->id;
        }
        $real_id = $this->genMongoId($id);
        $data = $this->do_sth_before_inc($data,$id);
        $this->db->where(array('_id'=>$real_id))->increment($this->tableName,$data);
        return $this;
	}


	final public function push_db($field,$data,$id=NULL){
		if($id===NULL){
			$id = $this->id;
		}
		$real_id = $this->genMongoId($id);
		$this->db->where(['_id'=>$real_id])->push($field,$data)->update($this->tableName);
		return $this;
	}
	final public function pull_db($field,$data,$id=NULL){
		if($id===NULL){
			$id = $this->id;
		}
		$real_id = $this->genMongoId($id);
		$this->db->where(['_id'=>$real_id])->pull($field,$data)->update($this->tableName);
		return $this;	
	}
	final public function pull_db_id($field,$sub_id,$id=NULL){
		if($id===NULL){
			$id = $this->id;
		}
		return $this->pull_db($field,['_id'=>$this->genMongoId($sub_id)],$id);
	}
	public function check_inited($msg='数据有误',$status=-1){
        if(!$this->is_inited){
        	$CI =& get_instance();
        	switch($CI->viewType){
        		case VIEW_TYPE_HTML:
        			echo $CI->template->load('default_page', 'common/404','',TRUE);
        			break;
        		case VIEW_TYPE_JSON:
		            $jsonRst = $status;
		            $jsonData = array();
		            $jsonData['err']['msg'] = $msg;
		            echo $CI->exportData($jsonData,$jsonRst);   
        			break;
        		case VIEW_TYPE_PAGE:
        			echo $CI->template->load('default_overlay', 'common/404','',TRUE);
        			break;
        	}
        	exit();
        }
        return $this;
	}

	final public function reset(){
		$this->is_inited = false;
		$this->id = NULL;
		$this->data = [];
		foreach ($this->field_list as $value) {
			$value->init($value->default);
		}
		return $this;
	}

	// 作为其他表某个字段的子项插入
	final public function insert_other_db($field,array $data,$otherId,$dbName=NULL){
		if($dbName===NULL){
			$dbName = $this->tableName;
		}
		if(!isset($data['_id'])){
			$data['_id'] = $this->genMongoId();
		}
		$this->db->where(['_id'=>$this->genMongoId($otherId)])->push($field,$data)->update($dbName);
		return $this;
	}

	// 作为其他表某个字段的子项更新
	final public function update_other_db($field,array $data,$otherId,$selfId,$dbName=NULL){
		if($dbName===NULL){
			$dbName = $this->tableName;
		}
		$realData = [];
		foreach ($data as $key => $value) {
			$realData[$field.'.$.'.$key] = $value;
		}
		$this->db->where(['_id'=>$this->genMongoId($otherId),$field.'._id'=>$this->genMongoId($selfId)])->update($dbName,$realData);
		return $this;
	}

	public function check_can_delete(){
		return true;
	}


} 
?>