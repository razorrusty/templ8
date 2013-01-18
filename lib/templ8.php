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
		
		private $_template_markup;
		private $_template_upper_markup;
		private $_template_lower_markup;
		
		public $_can_split;	// is true if the split keyword is detected in the template markup after loading the template

        /**
         * Returns a templ8 object from the markup string.
         * @param $markup the markup source.
         * @param $keywords Template keywords.
         */
        static public function from_string($markup, $keywords = array() ) 
        {
            $templ8 = new templ8(NULL, FALSE, $keywords);
            $templ8->_template_markup = $templ8->process_template($markup);
            return $templ8;
        }

        /**
         * Creates a templ8 object from a file.
         */
        static public function from_file($filename, $keywords = array(), $split = FALSE) 
        {
            $templ8 = new templ8($filename, $split, $keywords);
            return $templ8;
        }
		
		public function __construct($filename, $is_split, $keywords)
		{
			// get variables
			$this->_filename =$filename;
			$this->_custom_keywords = $keywords;
			$this->_is_split = $is_split;
			
            if($filename !== NULL) {
                // Load tempate
                $this->load_main_template();
            }
		}
		
		public function addKeyword($key,$val){
			// Add a keyword to the custom keywords
			$this->_custom_keywords[$key] = $val;
		}
		
		public function get_markup(){
			// Returns the template markup
			return $this->_template_markup;
		}
		
		public function output(){
			// outputs the template markup
			if($this->_template_markup != ""){
				echo $this->_template_markup;
			}
			else{
				echo "Templ8 Error: Nothing to output. Template is missing or blank.";
			}
			
		}
		
		public function output_upper(){
			if($this->_is_split && $this->_template_upper_markup != ""){
				echo $this->_template_upper_markup;
			}
			else{
				echo "Templ8 Error: This template is not splittable.";
			}
		}
		
		public function output_lower(){
			if($this->_is_split && $this->_template_lower_markup != ""){
				echo $this->_template_lower_markup;
			}
			else{
				echo "Templ8 Error: This template is not splittable.";
			}
		}
		
		public function split_template(){
			if($this->_can_split ){
				$this->_template_upper_markup = substr($this->_template_markup,0,stripos($this->_template_markup,$this->_split_keyword));
				$this->_template_lower_markup = substr($this->_template_markup,stripos($this->_template_markup,$this->_split_keyword)+strlen($this->_split_keyword));			
				
				return true;
			}
			else{
				return false;
			}
		}

        public function process_template($markup, $specific_keywords = false) 
        {
            // Replace standard keywords
            foreach($this->_standard_keywords as $keyword => $content){
                $markup  = str_replace("[TPL8_". $keyword. "]", $content, $markup);
            }
            
            // Replace custom keywords
            foreach($this->_custom_keywords as $keyword => $content){
                $markup  = str_replace("[TPL8_". $keyword. "]", $content, $markup);
            }
            
            if($specific_keywords)
            {
                // Replace specific keywords
                foreach($specific_keywords as $keyword => $content){
                    $markup  = str_replace("[TPL8_". $keyword. "]", $content, $markup);
                }
            }
            return $markup;
        }
		
		public function load_template($filename, $specific_keywords = false)
		{
			if(file_exists($filename)){
				$markup = $this->process_template(file_get_contents($filename), $specific_keywords);
				
				return $markup;
			}
		}
		
		private function load_main_template(){
					
			// Load template markup
			$markup = $this->load_template($this->_filename);
			
			// Check we have markup
			if($markup)
			{
				// Save markup
				$this->_template_markup = $markup;
				
				// Can we split the template?
				$this->_can_split = !(strpos($this->_template_markup, $this->_split_keyword) === false);
				
				if($this->_is_split && $this->_can_split){
					// Split the template
					$this->split_template();
				}
			}
			else 
			{
				echo "Templ8 Error: Requested template is blank or does not exist.";
			}
		}
	}
	
?>
