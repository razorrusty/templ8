# Templ8 v0.2.0
A really simple HTML template class for PHP. Be aware that it's still in development and features are subject to change, no warranty is given or implied.

## What can you do with it?
Basically, this class enables you to load HTML based template markup, replace keywords, split the template, and output the markup


### Define your Keywords
When loading a template, an array of keywords to be replace is passed into the method. The array should look something like this:

```PHP
$keywords = array('THISKEYWORD' => 'This value will be displayed');
```

THISKEYWORD will be usable in your HTML markup as [@THISKEYWORD].

### Load the Template
You can either load your markup from a file or by passing in a string from memory.

#### Loading from a file 
To load a template from a file, you can use from_file, like so:

```PHP
$split = true;
$main_template = \helical\templ8\parse::from_file('templates/default.html', $keywords, $split);	
```

#### Loading from a string 
To load a template from a string in memory, you can use from_string, like so:

```PHP
$main_template = \helical\templ8\parse::from_string('<h1>[@THISKEYWORD]</h1>', $keywords);	
```

### Overide Prefix
If you'd like to use a prefix other than @, you can specify a different prefix like so:
```PHP
 $template = \helical\templ8\parse::from_file('template.html', $keywords, $split, 'keyword_');
 // or 
 $template = \helical\templ8\parse::from_string('...', $keywords, 'keyword_');
```

This will use 'keyword_' as the prefix for each keyword.

### Split the template (optional)
Splitting the template involves splitting the HTML markup into an upper and lower portion using the [^split] keyword. 
Typically you would place this keyword in the HTML file where you would like to put the content, then output the upper template portion, your content and then the lower portion of the template.

### Output or fetch markup
You can tell the template to output using this function:

```PHP
 $main_template->output();
```

If you want to just get the markup, use:

```PHP
 $main_template->output(true);
```

If you've split the template, you can use these functions:

```PHP
 $main_template->output_upper(); // output everything above the split keyword
 // Put your content here
 $main_template->output_lower(); // output everything below the split keyword
```

And there you have it. Simple, quick, fun.
