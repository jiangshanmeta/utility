<?
class H_DoublyLinkedList{
	protected $_head;
	protected $_tail;
	protected $_length=0;
	protected $_mode = 1; //默认迭代方式是按照队
	protected $_itIndex = 0;
	protected $_itNode = NULL;
	protected $_isValid = false;
	const IT_MODE_FIFO = 1;
	const IT_MODE_LIFO = 2;
	function __construct(){
		$this->_head = &$this->_genNode();
		$this->_tail = &$this->_head;
	}
	function add($data,$index){
		// $index表示插入的位置，从0开始
		// 最小索引是0（头插），最大索引是length（作为结尾）
		// 检查插入位置合法性
		if($index<0||$index>$this->_length){
			return false;
		}
		$newNode = &$this->_genNode($data);
		$prevNode = &$this->_head;
		$count = 0;
		while($count<$index){
			$prevNode = &$prevNode['next'];
			$count++;
		}
		$newNode['next'] = &$prevNode['next'];
		$newNode['prev'] = &$prevNode;
		if(is_array($prevNode['next'])){
			$prevNode['next']['prev'] = &$newNode;
		}
		$prevNode['next'] = &$newNode;
		if($index==$this->_length){
			$this->_tail = &$newNode;
		}
		$this->_length++;
	}
	protected function &_genNode($data=NULL){
		$node = ['data'=>$data,'prev'=>NULL,'next'=>NULL];
		return $node;
	}
	function count(){
		return $this->_length;
	}
	function isEmpty(){
		return $this->_length==0;
	}
	function offsetExists($index){
		if($index<0||$index>$this->_length-1){
			return false;
		}
		return true;
	}
	function &offsetGet($index,$totalNode=false){
		if(!$this->offsetExists($index)){
			return false;
		}
		$count = 0;
		$node = $this->_head;
		while($count<$index+1){
			$node = &$node['next'];
			$count++;
		}
		if($totalNode){
			return $node;
		}
		return $node['data'];
	}
	function offsetSet($index,$data){
		$node = &$this->offsetGet($index,true);
		if(!is_array($node)){
			return false;
		}
		$node['data'] = $data;
	}
	function offsetUnset($index){
		$node = &$this->offsetGet($index,true);
		if(!is_array($node)){
			return false;
		}

		if($index==$this->_length-1){
			$this->_tail = &$node['prev'];
		}
		$node['prev']['next'] = &$node['next']; 
		$node['next']['prev'] = &$node['prev'];
		$node['prev'] = NULL;
		$node['next'] = NULL;
		$this->_length--;
		return $node['data'];
	}

	function push($data){
		$this->add($data,$this->_length);
	}
	function pop(){
		return $this->offsetUnset($this->_length-1);
	}
	function shift($data){
		$this->add($data,0);
	}
	function unshift(){
		return $this->offsetUnset(0);
	}
	function setIteratorMode($mode){
		$this->_mode = $mode;
	}
	function getIteratorMode(){
		return $this->_mode;
	}
	function rewind(){
		switch($this->_mode){
			case 1:
				//队 
				$this->_itIndex = 0;
				$this->_itNode = &$this->offsetGet($this->_itIndex,true);
				break;
			case 2:
				// 栈
				$this->_itIndex = $this->_length-1;
				$this->_itNode = &$this->offsetGet($this->_itIndex,true);
				break;
		}
		$this->_isValid = true;
	}
	function next(){
		switch($this->_mode){
			case 1:
				if($this->_itIndex<$this->_length-1){
					$this->_itIndex++;
					$this->_itNode = &$this->_itNode['next'];
				}else{
					$this->_isValid = false;
				}
				break;
			case 2:
				if($this->_itIndex>0){
					$this->_itIndex--;
					$this->_itNode = &$this->_itNode['prev'];
				}else{
					$this->_isValid = false;
				}
				break;
		}
	}
	function prev(){
		switch($this->_mode){
			case 1:
				if($this->_itIndex>0){
					$this->_itIndex--;
					$this->_itNode = &$this->_itNode['prev'];
				}else{
					$this->_isValid = false;
				}
				break;
			case 2:
				if($this->_itIndex<$this->_length-1){
					$this->_itIndex++;
					$this->_itNode = &$this->_itNode['next'];
				}else{
					$this->_isValid = false;
				}
				break;
		}
	}
	function key(){
		return $this->_itIndex;
	}
	function current(){
		return $this->_itNode['data'];
	}
	function valid(){
		return $this->_isValid;
	}
}
?>