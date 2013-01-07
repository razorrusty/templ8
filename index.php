<?
/*
 * 	Index.php
 * 	Example for Templ8 lib
 */

	 // Include the templ8 class
	 require("lib/templ8.php");
	 
	// Define some custom keywords
	 $keywords = array(	
	 								'PAGE_TITLE' => 'Hello World',
	 								'EXAMPLE' => 'Hello World',
	 								'FOOTER' => 'This page was generated using Razor-Studios TPL8'
 								);
	 
	 // Create a new template from file
	 $main_template = new templ8('templates/default.html',true,$keywords);
	 
	 // Output the upper part of the template
	 $main_template->output_upper();
	 
	 // Do some custom output
	 echo "<h2>This is some custom output</h2><p>Congratulations, you got templ8'd. You are welcome!</p>";
	 
	 // Output the lower part of the template
	 $main_template->output_lower();
	 
	 // it's not advisable to output anything below here since it will be outside of the html.
?>