<?php
class Template {
	public $data = array();
	
	public function fetch($filename, $prefix_dir = true) {
		$file = ($prefix_dir ? DIR_TEMPLATE : '') . $filename;
    
		if (file_exists($file)) {
			extract($this->data);
			
      		ob_start();
      
	  		include(VQMod::modCheck($file));
      
	  		$content = ob_get_contents();

      		ob_end_clean();

      		return $content;
    	} else {
			trigger_error('Error: Could not load template ' . $file . '!');
			exit();				
    	}	
	}
}
?>