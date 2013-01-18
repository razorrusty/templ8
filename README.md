# Templ8 v0.1
A really simple HTML template class for PHP. Be aware that it's still in development and features are subject to change, no warranty is given or implied.

## What can you do with it?
Basically, this class enables you to load HTML based template markup, replace keywords, split the template, and output the markup


### Define your Keywords
When loading a template, an array of keywords to be replace is passed into the method. The array should look something like this:

```PHP
$keywords = array('THISKEYWORD' => 'This value will be displayed');
```

THISKEYWORD will be usable in your HTML markup as [TPL8_THISKEYWORD].

### Loading from a file 
To load a template from a file, you can use from_file, like so:

```PHP
$split = true;
$main_template = templ8::from_file('templates/default.html', $keywords, $split);	
```

### Loading from a string 
To load a template from a string in memory, you can use from_string, like so:

```PHP
$main_template = templ8::from_string('<h1>[TMPL8_KEYWORD]</h1>', $keywords);	
```

### Split the template
Splitting the template involves splitting the HTML markup into an upper and lower portion using the [TPL8_SPLIT] keyword. 
Typically you would place this keyword in the HTML file where you would like to put the content, then output the upper template portion, your content and then the lower portion of the template.

#### Automatically
You can split the template by specifying $split = true in the constructor.

#### Manually
It's a good idea to check if the current template is splittable, so use this variable to check:

```PHP
$main_template->_can_split;
```

Then you can manually split the template using this function:

```PHP
$main_template->split_template();
```

Once the template has been automatically or manually split, you can output the template as a whole, or by outputing the top and bottom parts separately, as described in the next part.

### Output Markup
You can tell the template to output using this function:

```PHP
$main_template->output();
```

If you want to just get the markup, use:

```PHP
 $markup = $main_template->get_markup();
```

If you've split the template, you can use these functions:

```PHP
 $main_template->output_upper(); // output everything above the split keyword
 // Put your content here
 $main_template->output_lower(); // output everything below the split keyword
```

And there you have it. Simple, quick, fun.
