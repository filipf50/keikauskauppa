<?php
class Language {
	private $default = 'english';
	private $directory;
	private $path = DIR_LANGUAGE; 
	private $data = array();
 
	public function __construct($directory) {
		$this->directory = $directory;
	}
	
   /**
	* Set language directory path
	* - ability to load catalog language from admin
	*/
	public function setPath($path) 
	{
		if(!is_dir($path)){
			trigger_error('Error: check path exists: '.$path);
			exit;
		}
		$this->path = $path;
	} 
	
  	public function get($key) {
   		return (isset($this->data[$key]) ? $this->data[$key] : $key);
  	}
	
		
	/**
	 * Load Language File
	 *
	 * @param string $filename
	 * @param bool $defaultOnly - load underscore language file.
     */
     public function load($filename, $loadOverwrite = true) {
		$file = $this->path . $this->directory . '/' . $filename . '.php';
    	
		if (file_exists($file)) {
			$_ = array();
	  		
			require(VQMod::modCheck($file));
		
			$this->data = array_merge($this->data, $_);
	
            # Overwrite language file with underscore
            if($loadOverwrite){
				$file = $this->path . $this->directory . '/' . $filename . '_.php';
				    	
				if (file_exists($file)) {
					$_ = array();
		  		
					require(VQMod::modCheck($file));
			
					$this->data = array_merge($this->data, $_);
				}
			}
			
			return $this->data;
		}
		
		$file = $this->path . $this->default . '/' . $filename . '.php';
		
		if (file_exists($file)) {
			$_ = array();
	  		
			require(VQMod::modCheck($file));
		
			$this->data = array_merge($this->data, $_);
			
			return $this->data;
		} else {
			trigger_error('Error: Could not load language ' . $filename . '!');
		//	exit();
		}
  	}
}
?>
