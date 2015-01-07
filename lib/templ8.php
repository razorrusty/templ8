<?php
/*
 * 	templ8.php
 * 	Simple template lib
 * 	Copyright (c) 2015 Russell Peterson & Daniel Evans
 */	
namespace helical\templ8;

class parse
{
	private $_split_keyword = '[^split]';
	private $_custom_keyword_prefix = '@';
	private $_custom_keywords = array();
	
	private $_filename;
	private $_is_split;
	private $_template_markup;
	private $_template_upper_markup;
	private $_template_lower_markup;
	
	private $_loaded_templates = array();
	private $_can_split;	// is true if the split keyword is detected in the template markup after loading the template
	
	########## Public static functions ##########

	static public function from_string($markup, $keywords = array(), $prefix = NULL ) 
	{
		//Return a templ8 object from the markup string.
		$templ8 = new templ8(NULL, FALSE, $keywords, $prefix);
		$templ8->_template_markup = $templ8->process_template($markup);
		return $templ8;
	}
	
	
	static public function from_file($filename, $keywords = array(), $split = FALSE, $prefix = NULL) 
	{
		//Create a templ8 object from a file.
		$templ8 = new templ8($filename, $split, $keywords, $prefix);
		return $templ8;
	}
	
	########## Constructor ##########
	
	public function __construct($filename, $is_split, $keywords, $prefix = NULL)
	{
		// get variables
		$this->_filename =$filename;
		$this->_custom_keywords = $keywords;
		$this->_is_split = $is_split;
		if(is_string($prefix)) {
			$this->_custom_keyword_prefix = $prefix;
		}
		if($filename !== NULL) {
			// Load tempate
			$this->load_main_template();
		}
	}
	
	########## Public functions ##########
	
	public function output($return = false){
		// outputs the template markup
		if($this->_template_markup != ""){
			if($return){
				return $this->_template_markup;
			}
			else{
				echo $this->_template_markup;
			}
		}
		else{
			echo "<b>Templ8 Error:</b> Nothing to output. Template is missing or blank! ";
		}
	}
	
	public function output_upper($return = false){
		if($this->_is_split && $this->_template_upper_markup != ""){
			if($return){
				return $this->_template_upper_markup;
			}
			else{	
				echo $this->_template_upper_markup;
			}
		}
		else{
			echo "<b>Templ8 Error:</b> This template is not splittable! ";
		}
	}
	
	public function output_lower($return = false){
		if($this->_is_split && $this->_template_lower_markup != ""){
			if($return){
				return $this->_template_lower_markup;
			}
			else{	
				echo $this->_template_lower_markup;
			}
		}
		else{
			echo "<b>Templ8 Error:</b> This template is not splittable! ";
		}
	}
	
	public function process_template($markup, $specific_keywords = false) 
	{
		// -- For template from string.
		
		$prefix = $this->_custom_keyword_prefix;
		
		// Replace custom keywords
		foreach($this->_custom_keywords as $keyword => $content){
			$markup  = str_replace("[$prefix$keyword]", $content, $markup);
		}
		
		if($specific_keywords)
		{
			// Replace specific keywords
			foreach($specific_keywords as $keyword => $content){
				$markup  = str_replace("[$prefix$keyword]", $content, $markup);
			}
		}
		return $markup;
	}
	
	########## Private functions ##########
	
	private function split_template(){
		if($this->_can_split ){
			$this->_template_upper_markup = substr($this->_template_markup,0,stripos($this->_template_markup,$this->_split_keyword));
			$this->_template_lower_markup = substr($this->_template_markup,stripos($this->_template_markup,$this->_split_keyword)+strlen($this->_split_keyword));			
			return true;
		}
		else{
			return false;
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
			echo "<b>Templ8 Error:</b> Requested template <b>&quot;".$this->_filename."&quot;</b> is blank or does not exist! ";
		}
	}
	
	private function load_template($filename, $specific_keywords = false)
	{
		if(array_key_exists($filename, $this->_loaded_templates)){
			$markup = $this->process_template($this->_loaded_templates[$filename], $specific_keywords);
			return $markup;
		}
		else{
			if(file_exists($filename)){
				$markup = $this->process_template(file_get_contents($filename), $specific_keywords);
				return $markup;
			}
		}
	}
}
?>