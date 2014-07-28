<?php namespace D3catalyst\Compress;
 
class Compress
{
 
 	/*
 	* Url for compress PNG images
 	*/
 	private $png_compress_url 	= "http://pngcrush.com/crush";

 	/*
 	* Url for compress JPG images
 	*/
 	private $jpg_compress_url 	= "http://jpgoptimiser.com/optimise";

 	/*
 	* Url for compress CSS files
 	*/
 	private $css_compress_url 	= "http://cssminifier.com/raw";

 	/*
 	* Url for compress JavaScript's files
 	*/
 	private $js_compress_url 	= "http://javascript-minifier.com/raw";

 	/*
 	* Absolute path of file to compress
 	*/
 	private $file_base_path 	= NULL;

 	/*
 	* Absolute path of destination to file compressed
 	*/
 	private $file_target_path 	= NULL;

 	/*
 	* Set override existing file
 	*/
 	private $override 			= false;

 	/*
 	* Set curl debug status
 	*/
 	private $debug_enabled 		= true;

 	/*
 	* Debug data
 	*/
 	private $debug_data 		= NULL;

 	/*
 	* Error data
 	*/
 	private $error_data 		= NULL;

 	/*
 	* last css array generated
 	*/
 	private $last_css_array 	= NULL;

 	/*
 	* last js array generated
 	*/
 	private $last_js_array 		= NULL;

 	/*
 	* Contruct
 	* Set default path's for files
 	*/
 	public function __construct() {
 		$this->file_base_path 	= public_path('d3compress/full/');
 		$this->file_target_path = public_path('d3compress/min/');
 	}

 	/*
 	* Set uncompressed resource path
 	* @return void
 	*/
 	public function setUncompressedPath($path) {
 		if(!is_null($path) && !empty($path))
 			$this->file_base_path = $path;
 	}

 	/*
 	* Set compressed resource path
 	* @return void
 	*/
 	public function setCompressedPath($path) {
 		if(!is_null($path) && !empty($path))
 			$this->file_target_path = $path;
 	}

 	/*
 	* Set true when need override existing file
 	* @return void
 	*/
 	public function override($override) {
 		if(is_bool($override))
 			$this->override = $override;
 	}

 	/*
 	* Set true when need debug curl
 	* @return void
 	*/
 	public function debug($status) {
 		if(is_bool($status))
 			$this->debug_enabled = $status;
 	}

 	/*
 	* Get debug curl data
 	* @return array mix information of optimization
 	*/
 	public function getDebugData() {
 		return $this->debug_data;
 	}

 	/*
 	* Get error data
 	* @return string error information
 	*/
 	public function getErrorData() {
 		return $this->error_data;
 	}

 	/*
 	* Image processing optimization
 	* @param string $png_file File to optimization
 	*
 	* @return mixed If debug is false return path of file optimized, else return full optimization info
 	*/
 	public function png($png_file) {

 		$base_file 				= $this->file_base_path . $png_file;

 		if(!file_exists($base_file)) {
 			$this->error_data = "File not found {$base_file}";
 			return false;
 		}

 		$png_info 				= getimagesize($base_file);
 		$path_info 				= pathinfo($base_file);

 		if($jpg_info['mime']!='image/png') {
 			$this->error_data = "Invalid png file, FILE[$png_file] - {$png_info['mime']}";
 			return false;
 		}

 		$target_file = $this->file_target_path . $path_info['filename'] . '_opt.' . $path_info['extension'];

 		$crushed = $this->pngCrush($base_file,$target_file);

 		if($crushed===false) {
 			$this->error_data = "Error Processing Request for PNG optimization";
 			return false;
 		}

 		if($this->debug_enabled) {
	 		
	 		$info['mime_type'] 		= $this->debug_data['content_type'];
	 		$info['original_file']	= $base_file;
	 		$info['optimized_file']	= $target_file;
	 		$info['original_zize'] 	= $this->debug_data['size_upload'];
	 		$info['optimized_zize']	= $this->debug_data['size_download'];

 		} else $info['optimized_file'] = $target_file;

 		return $info;
 	}

 	/*
 	* Image processing optimization
 	* @param array $files Files to optimization
 	*
 	* @return mixed If debug is false return path's of file's optimized, else return full optimization info
 	*/
 	public function pngLot($files = []) {

 		if(count($files)<1)
 			throw new Exception("Files array empty");

 		$report = array();

 		foreach ($files as $file) {
 			$report[$file] = $this->png($file);
 		}

 		return $report;
 			
 	}

 	/*
 	* Image processing optimization
 	* @param string $jpg_file File to optimization
 	* @param string $jpg_target File optimized (Optional)
 	*
 	* @return mixed If debug is false return path of file optimize, else return full optimization info
 	*/
 	public function jpg($jpg_file) {

 		$base_file 				= $this->file_base_path . $jpg_file;

 		if(!file_exists($base_file)) {
 			$this->error_data = "File not found {$base_file}";
 			return false;
 		}
 		
 		$jpg_info 				= getimagesize($base_file);
 		$path_info 				= pathinfo($base_file);

 		if($jpg_info['mime']!='image/jpg' && $jpg_info['mime']!='image/jpeg') {
 			$this->error_data = "Invalid jpg/jpeg file, FILE[$jpg_file] - {$jpg_info['mime']}";
 			return false;
 		}

 		$target_file 			= $this->file_target_path . $path_info['filename'] . '_opt.' . $path_info['extension'];

 		$optimized 				= $this->jpgOptimize($base_file,$target_file,$jpg_info['mime']);

 		if($optimized===false) {
 			$this->error_data = "Error Processing Request for JPG optimization";
 			return false;
 		}

 		if($this->debug_enabled) {
	 		
	 		$info['mime_type'] 		= $this->debug_data['content_type'];
	 		$info['original_file']	= $base_file;
	 		$info['optimized_file']	= $target_file;
	 		$info['original_size'] 	= $this->debug_data['size_upload'];
	 		$info['optimized_size']	= $this->debug_data['size_download'];

 		} else $info['optimized_file'] = $target_file;

 		return $info;
 	}

 	/*
 	* Image processing optimization
 	* @param array $files Files to optimization
 	*
 	* @return mixed If debug is false return path's of file's optimized, else return full optimization info
 	*/
 	public function jpgLot($files = []) {

 		if(count($files)<1)
 			throw new Exception("Files array empty");

 		$report = array();

 		foreach ($files as $file) {
 			$report[$file] = $this->jpg($file);
 		}

 		return $report;
 			
 	}

 	/*
 	* Css processing optimization
 	* @param string $css_file File to optimization
 	* @param string $css_target File optimized (Optional)
 	*
 	* @return mized If debug is false return path of file optimize, else return full optimization info
 	*/
 	public function css($css_file) {

 		$base_file 				= $this->file_base_path . $css_file;

 		if(!file_exists($base_file)) {
 			$this->error_data = "File not found {$base_file}";
 			return false;
 		}
 		
 		$path_info 				= pathinfo($base_file);

 		if($path_info['extension']!='css') {
 			$this->error_data = "Invalid css file";
 			return false;
 		}

 		$target_file 			= $this->file_target_path . $path_info['filename'] . '.min.' . $path_info['extension'];

 		$optimized = $this->cssMinify($base_file,$target_file);

 		if($optimized===false) {
 			$this->error_data = "Error Processing Request for Css optimization";
 			return false;
 		}

 		if($this->debug_enabled) {
	 		
	 		$info['mime_type'] 		= $this->debug_data['content_type'];
	 		$info['original_file']	= $base_file;
	 		$info['optimized_file']	= $target_file;
	 		$info['original_size'] 	= $this->debug_data['size_upload'];
	 		$info['optimized_size']	= $this->debug_data['size_download'];

 		} else $info['optimized_file'] = $target_file;

 		return $info;
 	}

 	/*
 	* Css processing optimization
 	* @param array $files Files to optimization
 	*
 	* @return mixed If debug is false return path's of file's optimized, else return full optimization info
 	*/
 	public function cssLot($files = []) {

 		if(count($files)<1) {
 			$this->error_data = "Files array empty";
 			return false;
 		}

 		$report = array();

 		foreach ($files as $file) {
 			$report[$file] = $this->css($file);
 		}

 		$this->last_css_array = $report;

 		return $report;
 			
 	}

 	/*
 	* Css merge files
 	* @param array $files Files to merge
 	*
 	* @return mixed If debug is false return path's of file's optimized, else return full optimization info
 	*/
 	public function mergeCssLot($files = [],$name = NULL) {

 		if(count($this->last_css_array)<1 && count($files)<1) {
 			$this->error_data = "No files to merge";
 			return false;
 		}

 		if(is_null($name)) $name = md5("d3catalyst_css");

 		$preCompressed 	= (count($this->last_css_array) > 1);

 		$merge_files 	= $preCompressed ? $this->last_css_array : $files;

 		$buffer 		= "";
 		$path 			= $preCompressed ? '' : $this->file_base_path;

 		foreach ($merge_files as $file) {
 			$ftmn = $preCompressed ? $file['optimized_file'] : $file;
 			if(file_exists($path.$ftmn)) {
 				$buffer .= file_get_contents($path.$ftmn) . ( $preCompressed ? "":"\r\n" );
 			}
 		}

 		if($buffer=="") {
 			$this->error_data = "Buffer empty";
 			return false;
 		}

 		if($preCompressed) {
 			file_put_contents($this->file_target_path . $name . '.min.css', $buffer);
 			$file_merged["optimized_file"] = $this->file_target_path . $name . '.min.css';
 			return $file_merged;
 		} else {
 			$tmp_file = $this->file_base_path . $name . '.css';
 			file_put_contents($tmp_file, $buffer);
 			return $this->css($name . '.css');
 		}

 	}

 	/*
 	* Js processing optimization
 	* @param string $js_file File to optimization
 	* @param string $js_target File optimized (Optional)
 	*
 	* @return mized If debug is false return path of file optimize, else return full optimization info
 	*/
 	public function js($js_file) {

 		$base_file 				= $this->file_base_path . $js_file;

 		if(!file_exists($base_file)) {
 			$this->error_data = "File not found {$base_file}";
 			return false;
 		}
 		
 		$path_info 				= pathinfo($base_file);

 		if($path_info['extension']!='js') {
 			$this->error_data = "Invalid js file";
 			return false;
 		}

 		$target_file 			= $this->file_target_path . $path_info['filename'] . '.min.' . $path_info['extension'];

 		$optimized = $this->jsMinify($base_file,$target_file);

 		if($optimized===false) {
 			$this->error_data = "Error Processing Request for Css optimization";
 			return false;
 		}

 		if($this->debug_enabled) {
	 		
	 		$info['mime_type'] 		= $this->debug_data['content_type'];
	 		$info['original_file']	= $base_file;
	 		$info['optimized_file']	= $target_file;
	 		$info['original_size'] 	= $this->debug_data['size_upload'];
	 		$info['optimized_size']	= $this->debug_data['size_download'];

 		} else $info['optimized_file'] = $target_file;

 		return $info;
 	}

 	/*
 	* Js processing optimization
 	* @param array $files Files to optimization
 	*
 	* @return mixed If debug is false return path's of file's optimized, else return full optimization info
 	*/
 	public function jsLot($files = []) {

 		if(count($files)<1) {
 			$this->error_data = "Files array empty";
 			return false;
 		}

 		$report = array();

 		foreach ($files as $file) {
 			$report[$file] = $this->js($file);
 		}

 		$this->last_js_array = $report;

 		return $report;
 			
 	}

 	/*
 	* Css merge files
 	* @param array $files Files to merge
 	*
 	* @return mixed If debug is false return path's of file's optimized, else return full optimization info
 	*/
 	public function mergeJsLot($files = [],$name = NULL) {

 		if(count($this->last_js_array)<1 && count($files)<1) {
 			$this->error_data = "No files to merge";
 			return false;
 		}

 		if(is_null($name)) $name = md5("d3catalyst_js");

 		$preCompressed 	= (count($this->last_js_array) > 1);

 		$merge_files 	= $preCompressed ? $this->last_js_array : $files;

 		$buffer 		= "";
 		$path 			= $preCompressed ? '' : $this->file_base_path;

 		foreach ($merge_files as $file) {
 			$ftmn = $preCompressed ? $file['optimized_file'] : $file;
 			if(file_exists($path.$ftmn)) {
 				$buffer .= file_get_contents($path.$ftmn) . ( $preCompressed ? "":"\r\n" );
 			}
 		}

 		if($buffer=="") {
 			$this->error_data = "Buffer empty";
 			return false;
 		}

 		if($preCompressed) {
 			file_put_contents($this->file_target_path . $name . '.min.js', $buffer);
 			$file_merged["optimized_file"] = $this->file_target_path . $name . '.min.js';
 			return $file_merged;
 		} else {
 			$tmp_file = $this->file_base_path . $name . '.js';
 			file_put_contents($tmp_file, $buffer);
 			return $this->js($name . '.js');
 		}

 	}

 	/*
    * Config optimization for PNG files
    * @return mix false when error exists or file path when is success
    */
    private function pngCrush($image,$image_target) {

    	$url 			= $this->png_compress_url;
    	$args['input'] 	= curl_file_create($image, 'image/png', $image);

    	return $this->sendRequest($url,$image_target,$args);
    }

    /*
    * Config optimization for JPG/JPEG files
    * @return mix false when error exists or file path when is success
    */
    private function jpgOptimize($image,$image_target,$mime="image/jpg") {

    	$url 			= $this->jpg_compress_url;
    	$args['input'] 	= curl_file_create($image, $mime, $image);

    	return $this->sendRequest($url,$image_target,$args);
    }

    /*
    * Config optimization for CSS files
    * @return mix false when error exists or file path when is success
    */
    private function cssMinify($css,$css_target) {

    	$url 			= $this->css_compress_url;
    	$css_data 		= file_get_contents($css);
    	$args['input'] 	= $css_data;

    	return $this->sendRequest($url,$css_target,$args);
    }

    /*
    * Config optimization for JS files
    * @return mix false when error exists or file path when is success
    */
    private function jsMinify($js,$js_target) {

    	$url 			= $this->js_compress_url;
    	$js_data 		= file_get_contents($js);
    	$args['input'] 	= $js_data;

    	return $this->sendRequest($url,$js_target,$args);
    }

    /*
    * Send to potimize file
    * @param string $url - url to send file
    * @param string $target - file optimized
    * @params array $args - common args
    *
    * @return mix false when error exists or file path when is success
    */
    private function sendRequest($url,$target,$args) {

	    $ch 			= curl_init();
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_URL, $url );
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
	    curl_setopt($ch, CURLOPT_VERBOSE, $this->debug_enabled);

	    $response 	= curl_exec($ch);
	    $info 		= curl_getinfo($ch);
	    $curl_error = curl_error($ch);

	    if($this->debug_enabled)
	    	$this->debug_data = $info;

		if ($info["http_code"] !== 200) {
			$this->debug_data = $info;			
			return false;
		}

		if (!empty($curl_error)) {
			$this->debug_data = $info;
			$this->error_data = $curl_error;	
			return false;
		}

	    $fp = fopen($target,'w');
	    fwrite($fp, $response); 
	    fclose($fp);

	    return $target;
    }
 
}