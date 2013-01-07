<?php
/*
 * 	templ8.php
 * 	Simple template lib
 * 	Copyright (c) 2013 Razor Studios
 */	
	class templ8
	{
		private $_filename;
		private $_standard_keywords = array('COPYRIGHT' => 'Templ8 - Copyright (c) 2013 Razor Studios');
		private $_custom_keywords = array();
		private $_split_keyword = '[TPL8_SPLIT]';
		private $_is_split;
		
		private $_template_content;
		private $_template_upper_content;
		private $_template_lower_content;
		
		public $_can_split;
		
		public function __construct($filename, $is_split, $keywords)
		{
			// get variables
			$this->_filename =$filename;
			$this->_custom_keywords = $keywords;
			$this->_is_split = $is_split;
			
			// Load tempate
			$this->load_template();
		}
		
		public function output(){
			if($this->_template_content != ""){
				echo $this->_template_content;
			}
			else{
				echo "Templ8 Error: Nothing to output. Template is missing or blank.";
			}
			
		}
		
		public function output_upper(){
			if($this->_is_split && $this->_template_upper_content != ""){
				echo $this->_template_upper_content;
			}
			else{
				echo "Templ8 Error: This template is not splittable.";
			}
		}
		
		public function output_lower(){
			if($this->_is_split && $this->_template_lower_content != ""){
				echo $this->_template_lower_content;
			}
			else{
				echo "Templ8 Error: This template is not splittable.";
			}
		}
		
		public function split_template(){
			if($this->_can_split ){
				$this->_template_upper_content = substr($this->_template_content,0,stripos($this->_template_content,$this->_split_keyword));
				$this->_template_lower_content = substr($this->_template_content,stripos($this->_template_content,$this->_split_keyword)+strlen($this->_split_keyword));			
			}
		}
		
		private function load_template(){
			if(file_exists($this->_filename)){
				// Load template
				$this->_template_content = file_get_contents($this->_filename);
				
				// Replace standard keywords
				foreach($this->_standard_keywords as $keyword => $content){
					$this->_template_content  = str_replace("[TPL8_". $keyword. "]", $content, $this->_template_content);
				}
				
				// Replace custom keywords
				foreach($this->_custom_keywords as $keyword => $content){
					$this->_template_content  = str_replace("[TPL8_". $keyword. "]", $content, $this->_template_content);
				}
				
				// Can we split the template?
				$this->_can_split = !(strpos($this->_template_content, $this->_split_keyword) === false);
				
				if($this->_is_split && $this->_can_split){
					// Split the template
					$this->split_template();
				}

			}
			else{
				echo "Templ8 Error: Template not found.";
			}
		}
	}
	
?>