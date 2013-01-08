<?
/*
 * 	Index.php
 * 	Example for Templ8 lib
 */

	 // Include the templ8 class
	 require("../lib/templ8.php");
	 
	// Define some custom keywords
	// HINT: You can add other templates as keywords using $other_template->get_markup(); therefore adding subtemplates.
	 $keywords = array(	
	 								'PAGE_TITLE' => 'Hello World',
	 								'EXAMPLE' => 'Hello World',
	 								'FOOTER' => 'This page was generated using Razor-Studios TPL8'
 								);
	 
	 // Create a new template from a html file using new templ8();
 	// 	First param is the template location and filename
	// 	Second param is weather want to split the template's output. TRUE means we want to split this template using the [TPL8_SPLIT] keyword.
	// 	Third param is the keywords we want to use. Keywords are wrapped in [TPL8_xxxx] where xxxx is your keyword. 
	//			For example the first keyword in the array is PAGE_TITLE, so you need to add [TPL8_PAGE_TITLE] to your default.hrml if you want to use it.
	 $main_template = new templ8('templates/default.html',true,$keywords);	

	 // You can output the template 3 ways:
	 //	1, grab the markup and echo/use it yourself:
	 //		$main_template->get_markup();
	 //	2, Output the whole template:
	 //		$main_template->output();
	 //	3, split the template using the [TPL8_SPLIT] keyword and output the top and bottom separately, as in this example....
	 
	 // Output the upper part of the template, before the SPLIT keyword
	 $main_template->output_upper();
	 
	 // Do your output here
	 echo "<h2>This is some custom output</h2><p>Congratulations, you got templ8'd. You are welcome!</p>";
	 
	 // Output the lower part of the template, so everything after the SPLIT keyword
	 $main_template->output_lower();
	 
	 // it's not advisable to output anything below here since it will be outside of the html.
?>