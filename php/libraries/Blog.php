<?
// 借用第三方markdown解析器
include_once('markdown.php');
class Blog{
	protected $_analyzedData = [];
	protected $separator = "+++";
	protected $mdDir = './mds';
	protected $htmlDir = "./htmls";
	static protected $markdown ;
	protected $headerDir = 'header.php';
	protected $footerDir = 'footer.php';

	function __construct(){
		self::$markdown= new Markdown();
	}


	function initialize(array $config = array()){
		foreach ($config as $key => $value) {
			if(isset($this->$key)){
				$this->$key = $value;
			}
		}
	}

	// 传入相对路径
	function analyze($relativeDir=''){
		$absoluteDir = $this->mdDir.$relativeDir;
		if(!is_dir($absoluteDir)){
			return;
		}
		$handle = opendir($absoluteDir);
		while(($file = readdir($handle) )!==false){
			if($file==='.' || $file==='..'){
				continue;
			}
			$fileDir = $absoluteDir.'/'.$file;
			if(is_dir($fileDir)){
				$this->analyze($relativeDir.'/'.$file);
			}
			if(self::get_extension($fileDir)!=='md' ){
				continue;
			}
			// 到这里就是真的md文件了
			$this->analyzeFile($relativeDir.'/'.$file);
		}
		closedir($handle);
	}

	protected function ensureHTMLDir($relativeHTMLDir){
		$arr = explode('/', $relativeHTMLDir);
		array_shift($arr);
		$baseDir = $this->htmlDir;
		foreach ($arr as $value) {
			$baseDir = $baseDir.'/'.$value;
			if(!is_dir($baseDir)){
				mkdir($baseDir);
			}
		}
	}

	protected function genOutputRelativeDir($filename){
		return substr($filename, 0,mb_strlen($filename,'UTF8')-3);
	}

	// 解析文件
	protected function analyzeFile($filename){
		$absoluteDir = $this->mdDir.$filename;

		$relativeHTMLDir = $this->genOutputRelativeDir($filename);

		$this->ensureHTMLDir($relativeHTMLDir);

		$field_list = [];
		$content = '';
		$status = 0;
		$mds = [];
		$handle = fopen($absoluteDir,"r");
		// 逐行处理
		while(!feof($handle)){
			$line = fgets($handle);
			if(!is_string($line)){
				continue;
			}
			if(strpos($line, $this->separator)===0){
				if($status==0){
					// 标记开始进入字段区
					$status = 1;
					continue;
				}else if($status==1){
					$status = 2;
					continue;
				}
			}
			if($status==0){
				continue;
			}else if($status==1){
				// 处理字段
				if(!strpos($line, "=")){
					continue;
				}
				$fields = explode("=", trim($line),2);
				$fieldKey = trim($fields[0]);
				$fieldValue = trim($fields[1]);

				$fieldValue = preg_replace('/\"/', '', $fieldValue);
				// 字段分为三种，array(仅支持一维数组)、时间、字符串

				if(substr_count($fieldValue, '[')>0&&substr_count($fieldValue, '[')==substr_count($fieldValue, ']')   ){
					// 认为是数组
					$fieldValue = self::explode_unempty(',',substr($fieldValue,1,mb_strlen($fieldValue)-2  ));
				}else if(strtotime($fieldValue)>86400){
					// 认为是时间
					$fieldValue = strtotime($fieldValue);
				}
				$field_list[$fieldKey] = $fieldValue;
			}else{
				// 处理md
				$mds[] = $line;
			}
		}
		fclose($handle);

		ob_start();
		include($this->headerDir);
		$header = ob_get_contents();
		@ob_end_clean();

		$content = self::$markdown->Markdown(implode('', $mds));

		ob_start();
		include($this->footerDir);
		$footer = ob_get_contents();
		@ob_end_clean();

		$fielname = self::get_filename($absoluteDir);
		$this->outputFile($relativeHTMLDir,$header.$content.$footer,$fielname);
	}

	// 输出文件
	protected function outputFile($relativeHTMLDir,$content,$filename='index'){
		file_put_contents($this->htmlDir.$relativeHTMLDir.'/'.$filename.'.html', $content);
	}

	static function get_extension($filename){
		return pathinfo($filename,PATHINFO_EXTENSION);
	}
	static function get_filename($filename){
		return pathinfo($filename,PATHINFO_FILENAME);
	}
	static function explode_unempty($delimiter,$string,$limit=NULL){
		$temp = explode($delimiter, $string);
		$rst = [];
		if(is_array($temp)&&count($temp)>0){
			foreach ($temp as $value) {
				if($value!==''){
					$rst[] = $value;
				}
			}
		}
		return array_slice($rst,0,$limit);
	}
}

$blog = new Blog();
$blog->analyze();
?>